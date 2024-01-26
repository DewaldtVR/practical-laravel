<?php

namespace App\Http\Controllers;

use App\Classes\Bridge\Bridge;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return Bridge::view("setting.index");
    }

    public function tableDataProvider(Request $request)
    {
        return Setting::definition()
            ->listAll()
            ->withColumns(["settingname", "settingvalue"])
            ->serve($request);
    }
}
