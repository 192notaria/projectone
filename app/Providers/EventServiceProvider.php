<?php

namespace App\Providers;

use App\Listeners\LoginListener;
use App\Models\AvanceProyecto;
use App\Models\Clientes;
use App\Models\Proyectos;
use App\Models\User;
use App\Observers\AvanceProyectosObserver;
use App\Observers\ClientesObserver;
use App\Observers\ProyectosObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            LoginListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Clientes::observe(ClientesObserver::class);
        Proyectos::observe(ProyectosObserver::class);
        AvanceProyecto::observe(AvanceProyectosObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
