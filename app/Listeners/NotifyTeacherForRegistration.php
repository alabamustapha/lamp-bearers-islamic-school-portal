<?php

namespace App\Listeners;


use Illuminate\Support\Facades\Mail;
use App\Mail\NewTeacherRegistration;
use App\Events\TeacherRegistration;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyTeacherForRegistration implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TeacherRegistration  $event
     * @return void
     */
    public function handle(TeacherRegistration $event)
    {
        Mail::to($event->teacher)->send(new NewTeacherRegistration($event->teacher, $event->user));
    }
}
