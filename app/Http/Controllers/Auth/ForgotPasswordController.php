<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Traits\PasswordResetTrait;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails,PasswordResetTrait;

    public function showLinkRequestForm()
    {
        $data['user_verify'] = Content::with('contentDetails')->where('name','user_verify')
            ->where('type', 'single')->first();
        return view(template().'auth.passwords.email',$data);
    }

    public function sendResetLinkEmail(Request $request)
    {
        return $this->resetLinkEmail($request, false);
    }

}
