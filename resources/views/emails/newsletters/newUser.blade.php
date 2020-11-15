@component('mail::message')
# {{ $title }}



{{$user_name}}

{{ $description }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent