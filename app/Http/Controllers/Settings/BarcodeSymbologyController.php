<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarcodeSymbology;

class BarcodeSymbologyController extends Controller
{
    public function index()
    {
        $barcodeSymbologies = BarcodeSymbology::latest()->paginate(10);
        return view('Pages.Settings.BarcodeSymbologies.index', compact('barcodeSymbologies'));
    }

    public function create()
    {
        return view('Pages.Settings.BarcodeSymbologies.create');
    }

    public function store(Request $request)
    {
        $userId = \Illuminate\Support\Facades\Auth::user()->admin_id ?? \Illuminate\Support\Facades\Auth::id();
        $request->validate([
            'name' => [
                'required',
                \Illuminate\Validation\Rule::unique('barcode_symbologies')->where('user_id', $userId)
            ],
        ]);

        BarcodeSymbology::create($request->all());
        return redirect()->route('barcode-symbology.index')->with('success', 'Barcode Symbology added successfully!');
    }

    public function edit($id)
    {
        $barcodeSymbology = BarcodeSymbology::findOrFail($id);
        return view('Pages.Settings.BarcodeSymbologies.edit', compact('barcodeSymbology'));
    }

    public function update(Request $request, $id)
    {
        $barcodeSymbology = BarcodeSymbology::findOrFail($id);
        $userId = \Illuminate\Support\Facades\Auth::user()->admin_id ?? \Illuminate\Support\Facades\Auth::id();
        $request->validate([
            'name' => [
                'required',
                \Illuminate\Validation\Rule::unique('barcode_symbologies')->where('user_id', $userId)->ignore($barcodeSymbology->id)
            ],
        ]);

        $barcodeSymbology->update($request->all());
        return redirect()->route('barcode-symbology.index')->with('success', 'Barcode Symbology updated successfully!');
    }

    public function destroy($id)
    {
        $barcodeSymbology = BarcodeSymbology::findOrFail($id);
        $barcodeSymbology->delete();
        return redirect()->route('barcode-symbology.index')->with('success', 'Barcode Symbology deleted successfully!');
    }
}
