<?php

namespace App\Http\Controllers;

use App\Classes\Bridge\Bridge;
use App\Models\Contact;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index(Client $client)
    {
        return Bridge::view("contact.index", get_defined_vars());
    }
    public function tableDataProvider(Request $request, Client $client)
    {
        return Contact::definition()      
            ->listQueriedBy(function ($query) use ($client) {
                $query->where("clientid", "=", $client->clientid);
            })
            ->beforeCreate(function (&$data, Contact &$model) use ($client) {
                $model->clientid = $client->clientid;
                $model->userid = Auth::id();
            })
            ->afterCreate(function (&$data, Contact &$model){                
                $model->save();
            })
            ->withColumns([
                "user",
                "client",                          
                "name",
                "surname",
                "email",
                ])
            ->serve($request);
    }
   
}
