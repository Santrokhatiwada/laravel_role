<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskNotification extends Notification 
{
   
    public $status;
    public $taskName;
   

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($status,$taskName)
    {
        $this->status=$status;
        $this->taskName=$taskName;
    
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $statusMessage = json_encode($this->status);
        return (new MailMessage)
                    ->line('The task '. $this->taskName .' has been '.$statusMessage)
                    ->action('Notification Action', url('http://127.0.0.1:8000/tasks'))
                    ->line('Thank you for using our application!');
                    
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            
        ];
    }
}
