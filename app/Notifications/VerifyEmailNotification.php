<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends Notification
{
    use Queueable;
    protected $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        //
        $this->token = $token;
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
        return (new MailMessage)
                    ->theme('default')
                    ->subject('Confirmar E-mail')
                    ->greeting('Confirma tu correo electrónico')
                    ->line('Muchas gracias por registrarte en SEMAT - Iribarren!')
                    ->line('Para completar su registro,confirma tu dirección de correo electrónico haciendo clic en el siguiente botón')
                    ->greeting('Por favor, confirma tu correo electrónico.')
                    ->action('Verificar Cuenta', url('/users/verify/'.$this->token))
                    ->line('Saludos cordiales, el equipo SEMAT - Iribarren.');
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
