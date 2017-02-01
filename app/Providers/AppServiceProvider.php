<?php

namespace App\Providers;

use App\Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {



       if(Schema::hasTable('sessions') && $session = Session::where('status', 'active')->first()) {
           View::share('session', Session::where('status', 'active')->first());
       }else{
           View::share('session', null);
       }


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        require_once __DIR__ . '/../Http/Helpers/Navigation.php';
        require_once __DIR__ . '/../Http/Helpers/GradingPosition.php';
        require_once __DIR__ . '/../Http/Helpers/PaymentStatistics.php';
        require_once __DIR__ . '/../Http/Helpers/Registration.php';
        require_once __DIR__ . '/../Http/Helpers/SessionStatistics.php';
        require_once __DIR__ . '/../Http/Helpers/Licence.php';
        require_once __DIR__ . '/../Http/Helpers/Profile.php';
        require_once __DIR__ . '/../Http/Helpers/PaystackPayment.php';

    }
}
