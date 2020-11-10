@component('mail::message')
# Invoice Paid

Your invoice has been paid!

@component('mail::button', ['url' => 'http://127.0.1.1'])
View Invoice
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent