<?php

namespace App\Http\Controllers;

use App\Classes\Bridge\Bridge;
use App\Models\Userright;
use App\Models\Userrole;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $rights = Userright::all();
        return Bridge::view('role.index', compact("rights"));
    }

    public function tableDataProvider(Request $request)
    {
        return Userrole::definition()
            ->listAll()
            ->withColumns("rolename")
            ->serve($request);
    }

    public function getRights(Userrole $userrole)
    {
        return $userrole->rights()->get()->pluck('userrightid')->toArray();
    }

    public function updateRoleRights(Request $request, Userrole $userrole)
    {
        if ($request->has('data')) {
            $userrole->rights()->sync($request->data);
            $userrole->save();
        }
        return [];
    }
}
