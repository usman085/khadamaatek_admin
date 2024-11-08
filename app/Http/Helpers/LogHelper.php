<?php

namespace App\Http\Helpers;

use App\Log;
use App\Logo;
use App\UserNotification; 
use Illuminate\Support\Facades\Log as LaravelLog;

class LogHelper
{
    public static function store($user_id, $action, $user_type = 'customer')
    {
        $log = new Log();
        $log->user_id = $user_id;
        $log->user_type = ($user_type === 'customer') ? "App\Customer" : "App\User";
        $log->action = $action;

        $reponse = $log->save();

        return $reponse;
    }

    public static function send_notification_FCM($user, $title, $message, $id, $type, $user_type = 'admin')
    {
        LaravelLog::debug('----------------------------------------------------------------------------------------');
        $result_noti = 0;
        $accesstoken = config('app.fcm_key',"AAAAan_vK-g:APA91bEDur0GeafW96KwMUfdvEFf6ZaP5zv42YYXhEdmLLM-TR_hZhAun0I3QxoP4Nu9aRvQfcfHU3qpEIX0Clv4_F614BDxDcGM-LjbtKPLC7x-PFaFQGzWjDzmwn8b_vMiZYXLuzwW");
        LaravelLog::debug('$accesstoken=>'.$accesstoken);
        $URL = 'https://fcm.googleapis.com/fcm/send';

        $main_notification = [
            "body"          => $message,
            "title"         => $title,
            "type"          => $type,
            "id"            => $id,
            "message"       => $message,
            "icon"          => "new",
            "sound"         => "default"
        ];
        $extraNotificationData = ["message" => $main_notification, "moredata" => 'dd'];

        if ($user->device_token) {
            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to'                => $user->device_token, //single token
                'notification'      => $main_notification,
                'data'              => $extraNotificationData
            ];

            $headers = [
                'Authorization: key=' . $accesstoken,
                'Content-Type: application/json'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $URL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            curl_close($ch);

            if ($result === false) {
                // throw new Exception('Curl error: ' . curl_error($crl));
                //print_r('Curl error: ' . curl_error($crl));
                $result_noti = 0;
            } else {
                $result_noti = 1;
            }
            LaravelLog::debug('FCM-Response=>'.json_encode($result));
        }

        $notification               = new UserNotification();
        $notification->user_type    = ($user_type === 'admin') ? "App\User" : 'App\Customer';
        $notification->user_id      = $user->id;
        $notification->device_token = ($user->device_token) ? $user->device_token : "web";
        $notification->json_data    = json_encode($main_notification);
        $notification->save();
        
        LaravelLog::debug('----------------------------------------------------------------------------------------');
        LaravelLog::debug('notification Send Successfully');
        LaravelLog::debug('notification object => ' . json_encode($notification));
        LaravelLog::debug('----------------------------------------------------------------------------------------');
        
        //print_r($result_noti);die;
        return $result_noti;
    }

    public static function uploadLogo($model_type, $model_id, $file_name)
    {
        $old_logo = Logo::where('model_type', $model_type)->where('model_id', $model_id)->first();
        if ($old_logo) {
            $logo = $old_logo;
        } else {
            $logo = new Logo();
        }
        $logo->name = $file_name;
        $logo->model_type = $model_type;
        $logo->model_id = $model_id;
        $logo->save();

        if ($logo) {
            return true;
        } else {
            return false;
        }
    }
}
