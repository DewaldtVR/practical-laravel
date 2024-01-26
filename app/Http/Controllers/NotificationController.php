<?php

namespace App\Http\Controllers;

use App\Classes\Bridge\Bridge;
use App\Models\Appuser;
use App\Models\Notification;
use App\Models\Userrole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        if(Auth::user()->isInfluencer() && Auth::user()->isNotSuperUser())
//            return redirect()->route("influencers.list");

//        $users = Appuser::all(Appuser::condensedGridFields());
//        return Bridge::view("notifications.index", compact("users"));
        return Bridge::view("notifications.index");
    }

    public function getColumns() : array {
        return [
            "_id",
            "_created",
            "message",
            "title",
            "messageSent",
            "dataSent",
            "dateToBeSent",
            "acknowledged",
            "recipient",
            "type",
            "details"
        ];
    }

    public function tableDataProvider(Request $request)
    {
        return Notification::definition()
            ->listAll()
            ->withColumns(self::getColumns())
            ->afterCreate(function (Notification $model) {
                $model->updateRecipient();
            })
//            ->afterUpdate(function (Notification $model) {
//                $model->updateRecipient();
//            })
            ->serve($request);
    }

//    public function exportTableData()
//    {
//        $request["command"] = "export";
//
//        return Notification::definition()
//            ->listAll()
//            ->withColumns(self::getColumns())
//            ->serve($request);
//    }
//
//    public function createNotification($user, $data)
//    {
//        $timezone = "Africa/Johannesburg";
//        date_default_timezone_set($timezone);
//        $date = date("Y-m-d H:i:s");
//
//        $selectedUser = Appuser::where("_id", $user)->get();
//        foreach ($selectedUser as $key => $value) {
//            $firebaseToken = $value->firebase_devicetoken;
//        }
//        $notification = new Notification();
//        $notification->message = $data['message'];
//        $notification->title = $data['title'];
//        $notification->messageSent = 0;
//        $notification->dateSent = null;
//        $notification->dateToBeSent = $date;
//        $notification->acknowledged = [
//            "date" => null,
//            "read" => 0
//        ];
//        $notification->recipient = [
//            "id" => $user,
//            "firebaseTokenId" => $firebaseToken ?? null
//        ];
//        $notification->type = "CustomNotification";
//        $notification->save();
//    }
//
//    public function submitUsers(Request $request)
//    {
//        $data = $request->get("data");
//        foreach ($data["users"] as $user) {
//            $this->createNotification($user, $data);
//        }
//
//        return response()->json([
//            "success" => true,
//            "message" => "Successfully added notifications"
//        ]);
//    }
}
