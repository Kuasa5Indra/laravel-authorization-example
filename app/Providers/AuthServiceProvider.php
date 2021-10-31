<?php

namespace App\Providers;

use App\Models\Order;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use App\Models\User;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Order::class => OrderPolicy::class,
        Product::class => ProductPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        Gate::define('admin-only', function(User $user){
            return $user->role == 'ADMIN';
        });
        Gate::define('user-only', function(User $user){
            return $user->role == 'USER';
        });
        Gate::define('view-order', function(User $user, Order $order){
            return $user->id == $order->user_id;
        });
    }
}
