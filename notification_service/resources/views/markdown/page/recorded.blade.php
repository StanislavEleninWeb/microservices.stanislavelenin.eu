@component('mail::message')
# Нова оферта

Имаме нова оферта, която Ви препоръчваме.

@component('mail::panel')

@if(isset($page['title']))
<b>{{ $page['title'] }}</b><br/>
@endif

@if(isset($page['price']))
Цена: <b>{{ $page['price'] }}</b><br/>
@endif

@if(isset($page['price_per_square']))
Цена кв.м: <b>{{ $page['price_per_square'] }} {{ $page['currency']['title'] }}/кв.</b><br/>
@endif

@if(isset($page['space']))
Квадратура: <b>{{ $page['space'] }} кв.м</b><br/>
@endif

@if(isset($page['building_type']))
Тип: <b>{{ $page['building_type']['title'] }}</b><br/>
@endif

@if(isset($page['build_type']))
Строителство: <b>{{ $page['build_type']['title'] }}</b><br/>
@endif

@if(isset($page['currency']))
Валута: <b>{{ $page['currency']['title'] }}</b><br/>
@endif

@if(isset($page['keywords']))
Ключови думи: <b>{{ $page['keywords'] }}</b><br/>
@endif

@endcomponent

@component('mail::button', ['url' => env('API_GATEWAY') . '/page/' . $page['page_id']])
Виж офертата
@endcomponent

Благодарим Ви,<br>
{{ config('app.name') }}
@endcomponent