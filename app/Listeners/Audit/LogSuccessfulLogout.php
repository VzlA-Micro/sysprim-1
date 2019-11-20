<?php

namespace App\Listeners\Audit;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use OwenIt\Auditing\Models\Audit;
use Carbon\Carbon;
use Illuminate\Auth\Events\Logout; // importar esta classe


class LogSuccessfulLogout
{
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)

    {

        $data = [
            'auditable_id' => auth()->user()->id,
            'auditable_type' => "Logout",
            'event'      => "Logout",
            'url'        => request()->fullUrl(),
            'ip_address' => request()->getClientIp(),
            'user_agent' => request()->userAgent(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id'  => auth()->user()->id,
        ];
        return  Audit::create($data);
    }
}
