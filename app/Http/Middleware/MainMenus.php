<?php

namespace App\Http\Middleware;

use App\Classes\Menu\MenuBuilder;
use Closure;
use App\Traits\MenuExpose;
use Illuminate\Support\Facades\Auth;

class MainMenus
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        MenuBuilder::menu("main")
            ->route("Home", "home", null, 'house');

        MenuBuilder::menu("main")
            ->group("User Management", "person")
            ->subMenu()
            ->route("Users", "users.list", null, null, 'user_management')
            ->route("Roles", "roles.list", null, null, 'user_management');

        MenuBuilder::menu("main")
            ->group("Client Management", "business")
            ->subMenu()
            ->route("Manage Clients", "clients.list", [], null, 'client_management');

        MenuBuilder::menu("main")
            ->group("Contact Management", "group")
            ->subMenu()
            ->route("Manage Contacts", "contacts.list", [], null, 'contact_management');

        MenuExpose::exposeMenus();
        return $next($request);
    }
}
