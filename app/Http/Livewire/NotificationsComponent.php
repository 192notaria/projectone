<?php

namespace App\Http\Livewire;

use App\Events\NotificationEvent;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsComponent extends Component
{
    public $notificationsData;
    protected $listeners = ['listenNotify' => 'refreshNotify'];

    public function render()
    {
        return view('livewire.notifications-component',[
            // $this->notificationsData = Auth::user()->getNotifications()->where('viewed', 0)->orderBy('created_at','desc')->get()
            $this->notificationsData = Notifications::orderBy('created_at','desc')
                ->where("viewed", 0)
                ->where("user_id", auth()->user()->id)
                ->get()
        ]);
    }

    public function refreshNotify(){
        $this->notificationsData = Notifications::orderBy('created_at','desc')
            ->where("viewed", 0)
            ->where("user_id", auth()->user()->id)
            ->get();
    }

    public function deleteNotification($id){
        Notifications::find($id)->delete();
    }

    public function deleteAllNotification($id){
        Notifications::where("user_id", $id)->delete();
    }
}
