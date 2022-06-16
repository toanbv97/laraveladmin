<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Models\Post;
use App\Models\Vote;
use App\Policies\PostPolicy;
use App\Policies\VotePolicy;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Policies\catepolicy;
use App\Policies\CustomerPolicy;
use App\Policies\OrderPolicy;
use App\Models\Products;
use App\Policies\ProductsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',

        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Post::class => PostPolicy::class,
        Vote::class => VotePolicy::class,
        Category::class => catepolicy::class,
        Customer::class => CustomerPolicy::class,
        Order::class => OrderPolicy::class,
        Products::class => ProductsPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
