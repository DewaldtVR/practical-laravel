<?php

namespace App\Http\Controllers;

use App\Classes\Bridge\Bridge;
use App\Models\Client;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use League\Csv\Reader;
use League\Csv\Writer;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ClientController extends Controller
{
    //
    public function index()
    {
        return Bridge::view("client.index");
    }
    public function tableDataProvider(Request $request)
    {
        return Client::definition()
            ->listAll()
            ->beforeCreate(function (&$data, Client &$model) {
                $model->userid = Auth::id();
                $model->clientCode = $this->generateClientCode($data['name']);
            })
            ->withColumns([
                "user",
                "name",
                "clientCode",
                "contacts_count",
            ])
            ->serve($request);
    }
   public function generateClientCode($clientName)
   {
        $alphaPart = substr(preg_replace('/[^a-zA-Z]/', '', $clientName), 0, 3);
        $numericPart = substr(preg_replace('/[^0-9]/', '', $clientName), 0, 3);
        $numericPart = str_pad($numericPart, 3, '0', STR_PAD_LEFT);
        return strtoupper($alphaPart . $numericPart);
   }
    
}
