<?php

namespace App\Providers;
use DB;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        $menu = DB::table('menu')->get();
        $host = $request->getSchemeAndHttpHost();
        
        View::share(['menu'=> $menu,'host'=>$host]);
        $this->app['request']->server->set('HTTPS', true);
    }

    
}
