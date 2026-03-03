<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $payment = Payment::first();

        if (!$request->isMethod('post')) {
            return view('payment/config', compact('payment'));
        }

          // Validate input
          $request->validate(
            [
                'agent'  => 'required|regex:/^[A-Za-z. ]+$/',
                'merchant_id'     => 'required|regex:/^(?!.*<\s*script\b[^>]*>).*$/i',
                'api_key'     => 'required|regex:/^(?!.*<\s*script\b[^>]*>).*$/i',
                'status'   => 'required',
            ],
            [
                'agent.regex' => 'This field is an invalid format',
                'merchant_id.regex' => 'This field is an invalid format',
                'api_key.integer' => 'This field is an invalid format',
            ]
        );
        if (!$payment) {
            $payment = new Payment();
        }
        // Assign values and encrypt the password
        $payment->agent  = $request->agent;
        $payment->merchant_id   = $request->merchant_id; // Encrypt password
        $payment->api_key     = $request->api_key;
        $payment->status    = $request->status;
        $payment->save(); // Save the record

        session()->flash('success', 'Updated successfully');
        return redirect('payment_gateway_setting');

    }
}
