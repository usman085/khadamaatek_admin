<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data = "";
    public $type = "order";
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $type = 'order')
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = config('mail.from.address');
        $name = config('mail.from.name');
        if ($this->type === 'order') {
            $subject = 'Service Order';
            return $this->view('emails.order', ['data' => $this->data])
                ->from($address, $name)
                ->subject($subject);
        } else if ($this->type === 'change_number') {
            $subject = 'Change Phone Number Request';
            return $this->view('emails.changenumber', ['data' => $this->data])
                ->from($address, $name)
                ->subject($subject);
        } else {
            $subject = 'Balance Deposit';
            return $this->view('emails.deposit', ['data' => $this->data])
                ->from($address, $name)
                ->subject($subject);
        }
    }
}
