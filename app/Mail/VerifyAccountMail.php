<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class VerifyAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // harus public agar bisa diakses di Blade

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Kode Verifikasi Akun Anda')
                    ->view('emails.verify-account');
    }
}