<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        //
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */

    //  لتحديد العنوان والمستلمين.
    public function envelope()
    {
        return new Envelope(

            // الى اسم العميل المرسل اليه ثم الايميل 
            to: [  $this->order->billing_name=>$this->order->billing_email],
            bcc: ['another@another.com'],
            subject: 'Order for Laravel Ecommerce Example',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */

    //  هون بتحدد المحتوى 
    public function content()
    {
        return new Content(
            // view: 'view.name',
            markdown: 'emails.orders.placed',
            with: ['order' => $this->order],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    // لإضافة المرفقات
    public function attachments()
    {
        return [];
    }
}
