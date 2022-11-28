<?php

namespace App\Http\Livewire;

use App\Events\NotificationEvent;
use Livewire\Component;

class SendNotificationLivewire extends Component
{
    public function render()
    {
        return view('livewire.send-notification-livewire');
    }

    public function sendNotification(){
        event(new NotificationEvent(1, "Nuevo documento notarial"));
    }
}
