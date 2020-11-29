@component('mail::message')
# User Created

Your user account has been created!

@component('mail::button', ['url' => 'http://localhost'])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent