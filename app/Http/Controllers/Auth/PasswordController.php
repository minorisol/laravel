<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Support\Facades\Lang;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('confirm', ['only' => 'postEmail']);
        
        // $this->subject = Lang::get('passwords.send_reset');
    }
    
    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return property_exists($this, 'subject') ? $this->subject : Lang::get('passwords.send_reset');
    }
}
