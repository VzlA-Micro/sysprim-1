<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\user;

class Payments extends Notification
{
    use Queueable;
    public $fromUser;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->fromUser=$user;
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
    /*public function toMail($notifiable)
    {
        /*header('Content-type', 'application/pdf');
        $pdf=\PDF::loadView('modules.payments.receipt');
        $pdfOutput=$pdf->stream();*/

  //  }*/


    public function toMail($notifiable)
    {

        $subject = sprintf('%s: Pago Verificado!', config('app.name'), $this->fromUser->name);
        $greeting = sprintf('Hola %s!', $notifiable->name);
        $line = sprintf('%s Tu pago ha sido verificado con exito',$this->fromUser->name);

        return (new MailMessage)
            ->theme('default')
            ->subject($subject)
            ->greeting($greeting)
            ->line($line)
            ->attachData();
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
            //
        ];
    }
}
