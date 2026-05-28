<?php
namespace App\Http\Controllers\People;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupplierAddedMail;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('Pages.People.List_Suppliers', compact('suppliers'));
    }

    public function create() { return view('Pages.People.Add_Supplier'); }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $supplier = Supplier::create($request->all());

        // Email notification to admin and managers
        try {
            $actor = Auth::user();
            $adminId = $actor->admin_id ?? $actor->id;
            $recipients = User::where(function($q) use ($adminId) {
                    $q->where('id', $adminId)
                      ->orWhere(function($q2) use ($adminId) {
                          $q2->where('admin_id', $adminId)->where('role', 'manager');
                      });
                })
                ->pluck('email')
                ->toArray();

            if (!empty($recipients)) {
                Mail::to($recipients)->send(new SupplierAddedMail($supplier, $actor));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Supplier added email failed: ' . $e->getMessage());
        }

        return redirect()->route('supplier.index')->with('success', 'Supplier added!');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('Pages.People.Edit_Supplier', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        Supplier::findOrFail($id)->update($request->all());
        return redirect()->route('supplier.index')->with('success', 'Supplier updated!');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();
        return redirect()->route('supplier.index')->with('success', 'Supplier deleted!');
    }
}
