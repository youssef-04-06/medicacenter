<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PatientPaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['appointment', 'doctor'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('portal.payments', compact('payments'));
    }
}
