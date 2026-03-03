<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailConfig;
use Illuminate\Support\Facades\Crypt;

class EmailConfigController extends Controller
{
    public function email_config(Request $request)
    {
        $Config = EmailConfig::first();
        if (!$request->isMethod('post')) {
            return view('smtp_email/email_config', compact('Config'));
        }

          // Validate input
          $request->validate(
            [
                'protocol'  => 'required|regex:/^[A-Za-z. ]+$/',
                'mailtype_id'   => 'required',
                'smtp_host' => [
                        'required',
                        'min:10',
                        'max:50',
                        'regex:/^(?=.*[a-zA-Z])(?!.*<script>)[a-zA-Z0-9\s!@#$%^&*()_+{}\[\]:;\"\'<>,.?\/\\\\|-]+$/i',
                        ],
                'smtp_port'    => 'required|integer',
                'sender_email'     => 'required|email|regex:/^[a-z0-9.]+@[a-z]+\.[a-z]{2,}$/',
                'smtp_pwd'   => 'required',
            ],
            [
                'protocol.regex' => 'This field is an invalid format',
                'smtp_host.regex' => 'This field is an invalid format',
                'smtp_port.integer' => 'This field is an invalid format',
                'smtp_host.min' => 'Smtp Host range from 10 to 50 characters',
                'smtp_host.max' => 'Smtp Host range from 10 to 50 characters',
                'sender_email.regex' => 'Enter a valid email address (e.g., example@domain.com)',
            ]
        );
        if (!$Config) {
            $Config = new EmailConfig();
        }
        // Assign values and encrypt the password
        $Config->protocol  = $request->protocol;
        $Config->mailtype   = $request->mailtype_id; // Encrypt password
        $Config->smtp_host     = $request->smtp_host;
        $Config->smtp_port    = $request->smtp_port;
        $Config->sender_email   = $request->sender_email;
        $Config->password      = Crypt::encryptString($request->smtp_pwd);
        $Config->save(); // Save the record

        session()->flash('success', 'Updated successfully');
        return redirect('email_configuration');

    }
}
