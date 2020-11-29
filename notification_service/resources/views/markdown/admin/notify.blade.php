@component('mail::message')
# Admin Notify

Your order has been shipped!

@component('mail::button', ['url' => 'http://localhost'])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent