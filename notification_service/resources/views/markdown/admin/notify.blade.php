@component('mail::message')
# Error Notification

@component('mail::panel')
Error message: <b>{{ $data['message'] }}</b><br/>
Code: <b>{{ $data['code'] }}</b><br/>
File: <b>{{ $data['file'] }}</b><br/>
Line: <b>{{ $data['line'] }}</b><br/>
Url: <b>{{ $data['url'] }}</b><br/>
Data: <br/>
{{ json_encode($data['data'], JSON_PRETTY_PRINT) }}<br/>
@endcomponent


@component('mail::button', ['url' => 'http://localhost'])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent