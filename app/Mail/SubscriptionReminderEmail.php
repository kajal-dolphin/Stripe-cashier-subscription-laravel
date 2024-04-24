<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $user_id;
    protected $stripe_plan;
    protected $expire_at;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $user_id, $stripe_plan, $expire_at)
    {
        $this->name = $name;
        $this->user_id = $user_id;
        $this->stripe_plan = $stripe_plan;
        $this->expire_at = $expire_at;
    }

    public function build()
    {
        return $this->view('subscription-reminder-email')->with(['name' => $this->name, 'user_id' => $this->user_id, 'stripe_plan' => $this->stripe_plan, 'expire_at' => $this->expire_at]);
    }
}
