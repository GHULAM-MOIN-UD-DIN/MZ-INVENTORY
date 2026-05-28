<?php

namespace App\Mail\Transports;

use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Mime\Email;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoApiTransport implements TransportInterface
{
    protected $apiKey;
    protected $fromEmail;
    protected $fromName;

    public function __construct(?string $apiKey, ?string $fromEmail, ?string $fromName)
    {
        $this->apiKey = $apiKey;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }

    public function send(RawMessage $message, Envelope $envelope = null): ?SentMessage
    {
        if (empty($this->apiKey)) {
            throw new \Exception('Brevo API Key is missing. Please set MAIL_PASSWORD or BREVO_API_KEY in Render environment variables.');
        }

        if (empty($this->fromEmail)) {
            throw new \Exception('Sender email is missing. Please set MAIL_FROM_ADDRESS in Render environment variables.');
        }

        if (!$message instanceof Email) {
            return null;
        }

        $to = [];
        foreach ($message->getTo() as $address) {
            $to[] = [
                'email' => $address->getAddress(),
                'name' => $address->getName() ?: null,
            ];
        }

        $sender = [
            'email' => $this->fromEmail,
            'name' => $this->fromName,
        ];

        // Override sender if specified in the message
        $fromAddresses = $message->getFrom();
        if (!empty($fromAddresses)) {
            $sender = [
                'email' => $fromAddresses[0]->getAddress(),
                'name' => $fromAddresses[0]->getName() ?: $this->fromName,
            ];
        }

        $payload = [
            'sender' => $sender,
            'to' => $to,
            'subject' => $message->getSubject(),
            'htmlContent' => $message->getHtmlBody() ?: $message->getTextBody(),
        ];

        // Handle CC
        $ccAddresses = $message->getCc();
        if (!empty($ccAddresses)) {
            $cc = [];
            foreach ($ccAddresses as $address) {
                $cc[] = [
                    'email' => $address->getAddress(),
                    'name' => $address->getName() ?: null,
                ];
            }
            $payload['cc'] = $cc;
        }

        // Handle BCC
        $bccAddresses = $message->getBcc();
        if (!empty($bccAddresses)) {
            $bcc = [];
            foreach ($bccAddresses as $address) {
                $bcc[] = [
                    'email' => $address->getAddress(),
                    'name' => $address->getName() ?: null,
                ];
            }
            $payload['bcc'] = $bcc;
        }

        // Send REST request to Brevo API over HTTPS port 443
        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', $payload);

        if (!$response->successful()) {
            Log::error('Brevo API Mail delivery failed: ' . $response->body());
            throw new \Exception('Brevo API Mail delivery failed: ' . $response->body());
        }

        return new SentMessage($message, $envelope ?: Envelope::create($message));
    }

    public function __toString(): string
    {
        return 'brevo-api';
    }
}
