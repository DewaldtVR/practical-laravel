<?php

namespace App\Http\Controllers;

use App\Classes\Bridge\Bridge;
use App\Events\WorkshopCreatedEvent;
use App\Models\Client;
use App\Models\RelatedParty;
use App\Notifications\UserInviteNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Csv\Reader;
use League\Csv\Writer;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
            ->afterCreate(function (&$data, Contact &$model) {
                $model->save();
            })
            ->withColumns([
                "user",
                "name",
                "surname",
                "email"])
            ->serve($request);
    }

   
    public function extractRelatedParty(){
        $rps = RelatedParty::query()->select(['name','surname',"email"])->get();
        $headers = array_keys($rps->first()->getAttributes(['name','surname',"email"]));

        $headersArray = json_decode(json_encode($headers), true);
        $allowed = ['name' => 'Contact Name', 'surname' => 'Contact Surname', 'email' => 'Email'];

        $csv = Writer::createFromString();
        $csv->setDelimiter(';');
        $csv->insertOne((array)'sep=;');
        $line = preg_replace('/^\s+|\s+$|\s+(?=\s)/',' ',$allowed);
        $csv->insertOne($line);

        foreach ($rps as $relatedparty){
            $rpline = [];
            $rpline['name'] = $relatedparty->name;
            $rpline['surname'] = $relatedparty->surname;
            $rpline['email'] = $relatedparty->email;

            $line = preg_replace("/^\s+|\s+$|\s+(?=\s)/",'$1',$rpline);
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
            'RelatedParty.csv'
        );

        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Description', 'File Transfer');
        $response->setCallback($content_callback);
        $response->send();

        return $response;
    }
}
