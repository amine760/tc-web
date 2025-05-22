<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('addresses.index', compact('addresses'));
    }
    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $validated = $request->validate([
            'address' => 'required|string|max:500',
        ]);

        $address->update($validated);
        
        return redirect()->route('addresses.index')
            ->with('success', 'Address updated successfully');
    }

    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);
        $address->delete();
        return redirect()->route('addresses.index')
            ->with('success', 'Address removed');
    }

}