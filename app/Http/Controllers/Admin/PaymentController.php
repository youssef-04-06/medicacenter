<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['patient', 'doctor', 'appointment'])->latest()->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate(['status' => ['required', 'in:pending,verified,rejected']]);
        $payment->update($validated);

        return back()->with('success', 'Payment status updated.');
    }
}
