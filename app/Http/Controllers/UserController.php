<?php

namespace App\Http\Controllers;

use App\Classes\Bridge\Bridge;
use App\Events\UserCreatedEvent;
use App\Models\Country;
use App\Models\File;
use App\Models\Userright;
use App\Models\Userrole;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Writer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('throttle:6,1')
            ->only('profileUpdatePassword');
    }

    public function index()
    {
        $rights = Userright::all();
        $roles = Userrole::all();
        return Bridge::view('user.index', compact(["rights", "roles"]));
    }

    public function deactivatedIndex()
    {
        $rights = Userright::all();
        $roles = Userrole::all();
        return Bridge::view('user.deactivated', compact(["rights", "roles"]));
    }


    public function tableDataProvider(Request $request)
    {
        $pass = 'Admin@123';
        return User::definition()
            ->listAll()
            ->withColumns(['employee_no','name', 'email', 'created_at'])
            ->beforeCreate(function (&$data, &$model) use ($pass){
                $model->password = Hash::make($pass);
                $model->created_at = now()->toDateTimeString();
            })
            ->afterCreate(function (&$data, &$model) use ($pass){
                $model->fresh();
                event(new UserCreatedEvent($model,$model->email,$pass));
            })
            ->serve($request);
        }

    public function extractusers()
    {

        $users = User::withTrashed()->select(['name', 'email', 'employee_no'])->get();
        $headers = array_keys($users->first()->getAttributes(['name', 'email']));

        $headersArray = json_decode(json_encode($headers), true);


        $allowed = ['name' => 'User Name', 'email' => 'User Email'];

        $csv = Writer::createFromString();
        //$csv->setEnclosure('"');
        $csv->setDelimiter(",");
        $csv->insertOne((array)"SEP=,");
        $line = preg_replace('/^\s+|\s+$|\s+(?=\s)/',' ',$allowed);
        $csv->insertOne($line);

        foreach ($users as $user){
            $userline = [];
            $userline['name'] = $user->name;
            $userline['email'] = $user->email;


            $line = preg_replace("/^\s+|\s+$|\s+(?=\s)/",'$1',$userline);
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
            'users.csv'
        );

        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Description', 'File Transfer');
        $response->setCallback($content_callback);
        $response->send();

        return $response;
    }

    public function getUserRights(User $user): array
    {
        return $user->rights()
            ->get()
            ->pluck('userrightid')
            ->toArray();
    }

    public function updateUserRights(Request $request, User $user): array
    {
        if ($request->has('data')) {
            $user->rights()->sync($request->data);
            $user->save();
        }

        return [];
    }

    public function getUserRoles(User $user): array
    {
        return $user->roles()->get()->pluck('userroleid')->toArray();
    }

    public function updateUserRoles(Request $request, User $user): array
    {
        if ($request->has('data')) {
            $user->roles()->sync($request->data);
            $user->save();
        }

        return [];
    }

    // public function profile()
    // {
    //     //Override incoming user to logged in user
    //     $user = Auth::user();

    //     return Bridge::view('profile.index', compact('user'));
    // }


    // public function profileUpdateDetails(User $user, Request $request)
    // {
    //     //Override incoming user to logged in user
    //     $user = Auth::user();

    //     Validator::make($request->all(), [
    //         'email' => Rule::unique('user')->ignore($user->userid, 'userid'),
    //         'name' => 'required|max:255'
    //     ])->validate();

    //     $user->email = $request->get('email');
    //     $user->name = $request->get('name');

    //     $user->save();

    //     return response($user, 200);
    // }

    // public function profileUpdatePassword(User $user, Request $request)
    // {
    //     //Override incoming user to logged in user
    //     $user = Auth::user();

    //     Validator::make($request->all(), [
    //         'password' => 'required',
    //         'new_password' => 'required'
    //     ])->validate();

    //     if (!Hash::check($request->get('password'), $user->password))
    //         return response('Password does not match', 401);
    //     else {
    //         $user->password = Hash::make($request->get('new_password'));
    //         $user->save();
    //     }

    //     return response($user, 200);
    // }

}
