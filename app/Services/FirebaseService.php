<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    public function sendNotification($title, $message)
    {
        try {
            $serverKey = 'AAAACoDQsOk:APA91bHAHZRoItnZKVnkL1AIwut46-Ok0Vfj2lxWkWp3GOklzGWX_78bX-OJpTHdfhDF32phCtXNBf7ka9e5KDHisR2ZSJQixv45p2XgatY3frFJtduHXwrg8CEjGgUJ43wV7sUfMkWG'; // Replace with your Firebase Server Key
            $fcmToken = Auth::user()->fcm_id; // Replace with the recipient's FCM token

            $client = new Client();

            $response = $client->post('https://fcm.googleapis.com/fcm/send', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $serverKey,
                    'Content-MD5' => 'application/json',
                ],
                'json' => [
                    'to' => $fcmToken,
                    'notification' => [
                        'title' => '"'.$title.'"',
                        'body' => '"'.$message.'"',
                    ],
                ],
            ]);

            // Check the response for errors or success
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                Log::debug('Success code: ' . $statusCode);
                return true;
            } else {
                Log::error('Status code error: ' . $statusCode);
                return throw new \Exception('Notification failed to send');
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
