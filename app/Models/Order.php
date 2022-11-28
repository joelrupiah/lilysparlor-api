<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mail;
use Illuminate\Support\Facades\Storage;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setServiceAttribute($value)
    {
        $this->attributes['service'] = serialize($value);
    }
    public function getServiceAttribute($value)
    {
        return unserialize($value);
    }

    public function setShippingAttribute($value)
    {
        $this->attributes['shipping'] = serialize($value);
    }
    public function getShippingAttribute($value)
    {
        return unserialize($value);
    }

    public static function sendCustomerEmail($order, $pdf)
    {
        $path = Storage::put('public/storage/uploads/pdf/orders/'.'-'.rand().'_'.time().'.'.'pdf', $pdf->output());
        Storage::put($path, $pdf->output());

        $viewData['name'] = $order->user->name;
        $viewData['email'] = $order->user->email;
        $viewData['order_id'] = $order->user->order_id;

        Mail::send('mail.order_mail', $viewData, function ($message) use($order, $pdf, $path) {
            $message->from('rupiahjoeljeremiah@gmail.com', env('APP_NAME'));
            $message->to($order->user->email)
                ->subject($order->user->name)
                ->attachData($pdf->output(), $path, [
                    'mime' => 'application/pdf',
                    'as' => 'order-'. $order->_order_id.'.'.'pdf'
                ]);
        });

        Mail::send('mail.order_mail', $viewData, function ($message) use($order, $pdf, $path) {
            $message->from('rupiahjoeljeremiah@gmail.com', env('APP_NAME'));
            $message->to('rupiahjoeljeremiah@gmail.com', env('APP_NAME'))
                ->subject($order->user->name)
                ->attachData($pdf->output(), $path, [
                    'mime' => 'application/pdf',
                    'as' => 'order-'. $order->_order_id.'.'.'pdf'
                ]);
        });
    }
}
