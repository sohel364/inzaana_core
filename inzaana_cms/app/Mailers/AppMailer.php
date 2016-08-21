<?php

namespace Inzaana\Mailers;

use Inzaana\User;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer
{

    /**
     * The Laravel Mailer instance.
     *
     * @var Mailer
     */
    protected $mailer;

    /**
     * The subject of the email.
     *
     * @var string
     */
    protected $subject;

    /**
     * The name for the email.
     *
     * @var string
     */
    protected $name;

    /**
     * The sender of the email.
     *
     * @var string
     */
    protected $from;

    /**
     * The recipient of the email.
     *
     * @var string
     */
    protected $to;

    /**
     * The view for the email.
     *
     * @var string
     */
    protected $view;

    /**
     * The data associated with the view for the email.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create a new app mailer instance.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Deliver the email confirmation.
     *
     * @param  User $user
     * @param  array $data
     * @return void
     */
    public function sendEmailConfirmationTo(User $user, array $data)
    {
        $this->from = config('mail.from.address');
        $this->to = $user->email;
        $this->view = 'auth.emails.confirm';
        $this->data = compact('user', 'data');
        $this->subject = 'Inzaana - Email verification!';
        $this->name = config('mail.from.name');

        $this->deliver();
    }

    /**
     * Delivers an email to admin for special login url.
     *
     * @return void
     */
    public function sendEmailToAdminForSignupUrl()
    {
        $original = str_random(10);
        $token = bcrypt($original);

        $this->from = config('mail.from.address');
        $this->to = config('mail.admin.address');
        $this->view = 'vendor.emails.admin-login-secured-url';
        $this->data = compact('token', 'original');
        $this->subject = 'Inzaana - Secured Login For Admin!';
        $this->name = config('mail.admin.name');
        
        $this->deliver();
    }

    /**
     * Deliver the email.
     *
     * @return void
     */
    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->from, $this->name)
                    ->to($this->to)->subject($this->subject);
        });
    }
}
