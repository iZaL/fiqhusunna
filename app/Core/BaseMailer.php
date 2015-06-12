<?php
namespace App\Core;

use App\Core\Contracts\MailerContract;
use Config;
use Illuminate\Mail\Mailer;

class BaseMailer implements MailerContract
{

    private $mailer;
    public $toEmail;
    public $toName;
    public $fromEmail;
    public $fromName;
    public $subject;
    public $view;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->toEmail = env('MAIL_RECEPIENTNAME');
        $this->toName = env('MAIL_RECEPIENTEMAIL');
        $this->view = 'emails.contact';
    }

    public function fire($data)
    {
        try {
            $this->mailer->send($this->view, $data, function ($message) {
                $message
                    ->from($this->fromEmail, $this->fromName)
                    ->sender($this->fromEmail, $this->fromName)
                    ->to($this->toEmail, $this->toName)
                    ->subject($this->subject);
            });
        } catch (\Exception $e) {
        }
    }
}