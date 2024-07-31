<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotificationRequest;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::select('id', 'text', 'type', 'expiration', 'notification_for')
        ->with('user:id,name')
        ->get()
        ->map(function ($notification) {
            $notification->status = $notification->expiration && Carbon::parse($notification->expiration)->isPast()
                ? 'expired'
                : 'live';

            if ($notification->notification_for === 'all') {
                $notification->display_name = 'All Users';
            } elseif ($notification->user) {
                $notification->display_name = 'Name: ' . $notification->user->name;
            } else {
                $notification->display_name = 'Unknown User';
            }

            return $notification;
        });

        $notifications->makeHidden(['user']); // Hide the 'user' relationship from the final output

        return view('notifications.index', compact('notifications'));
    }

    public function create()
    {
        $users = User::withNotificationsEnabled()
            ->where('is_admin', false)
            ->get(['id', 'name']);
        return view('notifications.create', compact('users'));
    }

    public function store(StoreNotificationRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            // Create the notification
            $notification = Notification::create([
                'type' => $validatedData['type'],
                'text' => $validatedData['text'],
                'expiration' => $validatedData['expiration'],
                'notification_for' => $validatedData['user_id'] === null ? 'all' : $validatedData['user_id']
            ]);

            // Attach the notification to users
            if ($validatedData['user_id'] === null) {
                User::withNotificationsEnabled()->chunkById(100, function ($users) use ($notification) {
                    foreach ($users as $user) {
                        $user->notifications()->attach($notification->id, ['is_read' => false]);
                    }
                });
            } else {
                $user = User::withNotificationsEnabled()->find($validatedData['user_id']);
                if ($user) {
                    $user->notifications()->attach($notification->id, ['is_read' => false]);
                }
            }

            DB::commit();

            return redirect()->route('notifications.index')->with('status', 'Notification created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            // Log the error or handle it as needed
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to create notification. Please try again.');
        }
    }

    public function destroy(Notification $notification)
    {
        DB::beginTransaction();

        try {
            $notification->users()->detach();

            $notification->delete();

            DB::commit();

            return back()->with('status', 'Notification deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error or handle it as needed
            Log::error($e->getMessage());
            return back()->with('error', 'Failed to delete notification. Please try again.');
        }
    }

    public function fetchNotifications()
    {
        $user = auth()->user();
        $notifications = DB::table('notifications')
        ->join('notification_user', 'notification_user.notification_id', '=', 'notifications.id')
        ->where('notification_user.user_id', $user->id)
        ->where(function ($query) {
            $query->whereNull('notifications.expiration')
                ->orWhere('notifications.expiration', '>', Carbon::now());
        })
        ->where('notification_user.is_read', false)
        ->select(
            'notifications.*',
            'notification_user.is_read',
        )
        ->get();

        $unreadNotificationsCount = $notifications->count();

        return response()->json([
            'html' => view('notifications.partials.list', compact('notifications'))->render(),
            'unreadCount' => $unreadNotificationsCount
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        $user = auth()->user();
        $user->notifications()->updateExistingPivot($notification->id, ['is_read' => true]);

        return response()->json(['status' => 'success']);
    }

    public function markAllRead()
    {
        $user = auth()->user();
        $user->notifications()->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
    }

}
