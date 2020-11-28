@component('mail::message')
# User Successfully Created

Your account has been created!

@component('mail::button', ['url' => {{ env('APP_URL') . '/user/profile' }}])
View Profile
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent