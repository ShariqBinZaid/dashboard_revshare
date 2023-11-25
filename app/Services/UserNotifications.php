<?php

namespace App\Services;

use App\Models\UserNotification;
use mysql_xdevapi\Exception;

class UserNotifications
{
    public function notify($data)
    {
        try {
            if(!is_array($data)){
                throw new Exception('Data should be in array format');
            }
            $userNotify = UserNotification::create([
                ''
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
