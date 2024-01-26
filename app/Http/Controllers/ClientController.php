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
                $model->client_status = 'waiting';
            })
            ->withColumns([
                "name",
                "clientCode",
                "contacts",
            ])
            ->serve($request);
    }
   
    public function extractClients(){
        $clients = Client::query()->select(['name','clientCode',"contacts"])->get();
        $headers = array_keys($clients->first()->getAttributes(['name','clientCode',"contacts"]));

        $headersArray = json_decode(json_encode($headers), true);
        $allowed = ['name' => 'Client Name', 'clientCode' => 'Client Code', 'contacts' => 'No Of Contacts'];

        $csv = Writer::createFromString();
        $csv->setDelimiter(';');
        $csv->insertOne((array)'sep=;');
        $line = preg_replace('/^\s+|\s+$|\s+(?=\s)/',' ',$allowed);
        $csv->insertOne($line);

        foreach ($clients as $client){
            $clientline = [];
            $clientline['name'] = $client->name;
            $clientline['clientCode'] = $client->clientCode;
            $clientline['contacts'] = $client->contacts;

            $line = preg_replace("/^\s+|\s+$|\s+(?=\s)/",'$1',$clientline);
            // Remove end of line character to ensure data is imported correctly
            $line = str_replace(PHP_EOL, '', $line);
            $csv->insertOne($line);

        }
        $string = file_get_contents($csv->getPathname());
        $stripquotes = str_replace(' ', "", $string);
        file_put_contents($csv->getPathname(), $stripquotes);

        $reader = Reader::createFromString($csv);
        $response = new StreamedResponse();
        $response->headers->set('Content-Encoding', 'none');
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');

        $flush_threshold = 1000;
        $content_callback = function () use ($csv, $flush_threshold) {
            foreach ($csv->chunk(1024) as $offset => $chunk) {
                echo $chunk;
                if ($offset % $flush_threshold === 0) {
                    flush();
                }
            }
        };

        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'Clients.csv'
        );

        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Description', 'File Transfer');
        $response->setCallback($content_callback);
        $response->send();

        return $response;
    }
}
