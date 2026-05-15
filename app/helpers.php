<?php

/**
 * Generate Cloudinary URL directly without making API calls.
 * This avoids hitting the 500 API calls/hour rate limit.
 */
function cloudinary_url($path) {
    if (!$path) return null;
    // If already a full URL, return as-is
    if (str_starts_with($path, 'http')) return $path;
    $cloudName = config('cloudinary.cloud_name', env('CLOUDINARY_CLOUD_NAME'));
    return 'https://res.cloudinary.com/' . $cloudName . '/image/upload/' . $path;
}
