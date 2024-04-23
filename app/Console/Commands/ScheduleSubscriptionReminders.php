<?php

namespace App\Console\Commands;

use App\Jobs\SubscriptionReminderJob;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleSubscriptionReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:schedule-subscription-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dd("here");
        $test = Subscription::where('ends_at', '!=', NULL)->get();
        foreach ($test as $t) {
            $currentDate = Carbon::now();
            $expiredDate = Carbon::parse($t->ends_at);
            $days = $expiredDate->diffInDays($currentDate);

            $user_id = $t->user_id;
            $user = User::where('id',$user_id)->first();
            $email = $user->email;

            if($days <= 5)
            {
                dispatch(new SubscriptionReminderJob($email));
            }
        }
    }
}
