<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class ApiNotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = DatabaseNotification::find($id);
        $isRead = true;
        if (!$notification->read_at) {
            $isRead = false;
            $notification->read_at = now();
            $notification->save();

            // delete notification
            $notification->delete();
        }

        return response()->json([
            'status' => 200,
            'is_read' => $isRead,
            'message' => 'Successfull mark as read notification.'
        ]);
    }
}
