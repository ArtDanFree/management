<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\NotificationRequest;

class NotificationController extends Controller
{
    public function toggleNotification(Request $request, $id)
    {
        if (\Request::user()->id == $id) {
            $user = User::find($id);
            $user->notification()->updateExistingPivot($request->notification_id, ['confirmed' => $request->confirmed]);
            return back()->with('message', [__('message.data_changed')]);
        }
        return back()->with('message', [__('message.no_rights')]);
    }

    public function ChangeTelegramId(NotificationRequest $request)
    {
        $users = User::find($request->id);
        $users->update(['telegram' => $request->telegram]);
        return response()->json(array('message' => 'ok'), 200);
    }

    public function notificationAjax(Request $request)
    {
        if (\Request::user()->id == $request->id) {
            $user = User::find($request->id);
            $user->notification()->updateExistingPivot($request->notification_id, ['confirmed' => $request->confirmed]);
            return response()->json(array('message' => 'ok'), 200);
        }
    }
}
