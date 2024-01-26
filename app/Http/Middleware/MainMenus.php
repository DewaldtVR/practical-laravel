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
//        MenuBuilder::menu("main")
//            ->route("Submissions Portal", "user.evaluation.submit", null, 'assignment_turned_in', "submit_evaluations");
        MenuBuilder::menu("main")
            ->route("Home", "home", null, 'house');
       /* MenuBuilder::menu("main")
            ->group("Submission Management", "rate_review")
            ->subMenu()
            ->route("Inbox", "user.evaluation.review", null, null, "review_evaluations")
            ->route("Complete & Archived", "user.evaluation.archived", null, null, "view_archived_evaluations")
            ->route("Terminated", "user.evaluation.terminated", null, null, "view_archived_evaluations");

        MenuBuilder::menu("main")
            ->group("Organisation Management", "business")
            ->subMenu()
            ->route("Pending Organisations", "companies.pending.list", null, null, 'company_management')
            ->route("Verified Organisations", "companies.verified.list", null, null, 'company_management')
            ->route("Pending Users", "companies.users.pending.list", null, null, function () {
                return Auth::user()->ownercompanies()->exists();
            });*/

        MenuBuilder::menu("main")
            ->group("User Management", "person")
            ->subMenu()
            ->route("Users", "users.list", null, null, 'user_management')
            ->route("Deactivated Users", "users.deactivated.list",null, null, "user_management")
            ->route("Roles", "roles.list", null, null, 'user_management');

        MenuBuilder::menu("main")
            ->group("Client Management", "business")
            ->subMenu()
            ->route("Manage Clients", "clients.list", [], null, 'client_management')
            ->route("Pending Clients", "clients.pending.list", null, null, 'client_verify_management')
            ->route("Verified Clients", "clients.verified.list", null, null, 'client_verify_management')
            ->route("Declined Clients", "clients.declined.list", null, null, 'client_verify_management')
            ->route("Rework Clients", "clients.reworked.list", [], null, 'client_verify_management');

        MenuBuilder::menu("main")
            ->group("Related Party Management", "group")
            ->subMenu()
            ->route("Pending Related Party", "relatedparties.pending.data", null, null, 'relatedparty_verify_management')
            ->route("Verified Related Party", "relatedparties.verified.data", null, null, 'relatedparty_verify_management')
            ->route("Declined Related Party", "relatedparties.declined.data", null, null, 'relatedparty_verify_management')
            ->route("Rework Related Party", "relatedparties.reworked.list", [], null, 'relatedparty_verify_management');
        MenuBuilder::menu("main")
            ->group("KYC Management", "rate_review")
            ->subMenu()
            ->route("Pending KYC", "kycfiles.pending.data", null, null, 'kycfile_verify_management')
            ->route("Verified KYC", "kycfiles.verified.data", null, null, 'kycfile_verify_management')
            ->route("Declined KYC", "kycfiles.declined.data", null, null, 'kycfile_verify_management')
            ->route("Rework KYC", "kycfiles.reworked.list", [], null, 'kycfile_verify_management')
            ->route("Expired KYC", "kycfiles.declined.data", null, null, 'kycfile_verify_management');

        MenuBuilder::menu("main")
            ->group("Application Management", "list")
            ->subMenu()
            ->route("Pending BDO Applications", "applications.pendingbdo.data", null, null, 'application_verify_management')
            ->route("Pending HC Applications", "applications.pendinghc.data", null, null, 'application_verify_management')
            ->route("Pending Board Applications", "applications.pendingboard.data", null, null, 'application_verify_management')
            ->route("Verified Applications", "applications.verified.data", null, null, 'application_verify_management')
            ->route("Declined Applications", "applications.declined.data", null, null, 'application_verify_management')
            ->route("Rework Applications", "applications.reworked.list", null, null, 'application_verify_management')
            ->route("Expired Applications", "applications.declined.data", null, null, 'application_verify_management');


        MenuBuilder::menu("main")
            ->group("Legal Management", "cached")
            ->subMenu()
            ->route("Pending Legal", "kycfiles.pending.data", null, null, 'kycfile_verify_management')
            ->route("Verified Legal", "kycfiles.verified.data", null, null, 'kycfile_verify_management')
            ->route("Declined Legal", "kycfiles.declined.data", null, null, 'kycfile_verify_management')
            ->route("Rework Legal", "kycfiles.reworked.list", [], null, 'kycfile_verify_management');
        /*MenuBuilder::menu("main")
            ->route("Applications", "template.index", null, 'file_download', "submit_evaluations");*/

        MenuBuilder::menu("main")
            ->group("Setup", "build")
            ->subMenu()
            ->route("KYC Type Management", "kyctypes.list", null, null, 'setup')
            ->route("Facility Type Management", "facilitytypes.list", null, null, 'setup')
            ->route("Incorporation Management", "incorporations.list", null, null, 'setup')
            ->route("Industry Management", "industries.list", null, null, 'setup')
            ->route("Region Management", "regions.list", null, null, 'setup');

        /*MenuBuilder::menu("main")
            ->route("Web Content", "content.list", null, 'public', 'web_content_management');*/


        MenuBuilder::menu("main")
            ->route("Settings", "settings.list", null, 'settings', 'setting_management')
            /*->route("Quickstart", "webcontents.get", ["quickstart"], 'play_arrow', 'setting_management')
            ->route("Help", "webcontents.get", ["help"], 'help', 'setting_management')
            ->route("Contact Us", "webcontents.get", ["contact_us"], 'call', 'setting_management')
            ->route("Pricing", "webcontents.get", ["pricing"], 'payment', 'setting_management')*/;



        MenuExpose::exposeMenus();
        return $next($request);
    }
}
