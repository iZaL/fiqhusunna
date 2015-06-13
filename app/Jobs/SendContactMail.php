<?php

namespace App\Jobs;

use App\Core\BaseMailer;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;

class SendContactMail extends Job implements SelfHandling
{
    /**
     * @var Request
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @param BaseMailer $mailer
     */
    public function handle(BaseMailer $mailer)
    {
        $mailer->view = 'emails.contact';
        $mailer->fromName = $this->request->name;
        $mailer->fromEmail = $this->request->email;
        $mailer->subject = $this->request->name . ' has contacted you';

        // Send Email

        $mailer->fire($this->request);

    }
}
