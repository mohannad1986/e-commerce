@component('mail::message')
# Order Received

Thank you for your order.

**Order ID:** {{ $order->id }}

**Order Email:** {{ $order->billing_email }}

**Order Name:** {{ $order->billing_name }}

**Order Total:** ${{ round($order->billing_total / 100, 2) }}

**Items Ordered**

@foreach ($order->products as $product)
- **Name:** {{ $product->name }}  
- **Price:** ${{ round($product->price / 100, 2) }}  
- **Quantity:** {{ $product->pivot->quantity }}  
@endforeach

You can get further details about your order by logging into our website.

@component('mail::button', ['url' => config('app.url'), 'color' => 'green'])
Go to Website
@endcomponent

Thank you again for choosing us.

Regards,  
{{ config('app.name') }}
@endcomponent
