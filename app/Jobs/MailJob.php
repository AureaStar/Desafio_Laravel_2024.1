<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\MailToPatient;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $message;
    protected $subject;
    public $timeout = 7200;


    /**
     * Create a new job instance.
     */
    public function __construct($email, $message, $subject)
    {
        $this->message = $message;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = User::where('user_type', 'patient')->get();

        $subject = $this->subject;
        $message = $this->message;

        foreach ($data as $patient) {
            $email = $patient->email;

            Mail::to($email)->queue(new MailToPatient($subject, $message, $email));
        }
    }
}
