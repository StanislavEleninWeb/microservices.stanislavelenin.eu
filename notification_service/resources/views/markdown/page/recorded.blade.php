@component('mail::message')
# Нова оферта

Имаме нова оферта, която Ви препоръчваме.

@component('mail::panel')
<b>{{ $page['title'] }}</b><br/>
Цена: <b>{{ $page['price'] }}</b><br/>
Цена кв.м: <b>{{ $page['price_per_square'] }} кв.м</b><br/>
Квадратура: <b>{{ $page['space'] }}</b><br/>
Тип: <b>{{ $page['building_type']['title'] }}</b><br/>
Строителство: <b>{{ $page['build_type']['title'] }}</b><br/>
Валута: <b>{{ $page['currency']['title'] }}</b><br/>
Ключови думи: <b>{{ $page['keywords'] }}</b><br/>
@endcomponent

@component('mail::button', ['url' => env('API_GATEWAY') . '/page/' . $page['page_id']])
Виж офертата
@endcomponent

Благодарим Ви,<br>
{{ config('app.name') }}
@endcomponent