<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BudgetAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $status;

    public function __construct($message, $status)
    {
        $this->message = $message;
        $this->status = $status;
    }

    public function build()
    {
        return $this->view('emails.budget-alert')
                    ->subject('Budget Alert Notification')
                    ->with([
                        'message' => $this->message,
                        'status' => $this->status,
                    ]);
    }
}

