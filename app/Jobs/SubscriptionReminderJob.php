<?php

namespace App\Jobs;

use App\Mail\SubscriptionReminderEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SubscriptionReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $name;
    protected $user_id;
    protected $stripe_plan;
    protected $expire_at;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $name, $user_id, $stripe_plan, $expire_at)
    {
        $this->email = $email;
        $this->name = $name;
        $this->user_id = $user_id;
        $this->stripe_plan = $stripe_plan;
        $this->expire_at = $expire_at;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sendEmail = new SubscriptionReminderEmail($this->name, $this->user_id, $this->stripe_plan, $this->expire_at);
        Mail::to($this->email)->send($sendEmail);
    }
}
