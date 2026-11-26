<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['patient', 'appointment'])
            ->where('doctor_id', $request->user()->doctor->id)
            ->latest()
            ->paginate(15);

        return view('portal.doctor-payments', compact('payments'));
    }
}
