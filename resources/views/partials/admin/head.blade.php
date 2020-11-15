<meta charset="utf-8">
<meta name="description" content="">
<meta name="saira" content="Blade">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ env('APP_NAME') }}- Admin</title>

 <!-- Scripts -->
 <script src="{{ asset('js/app.js') }}" defer></script>
    
<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

@if(Session::has('message'))
 <p class="alert alert-info">{{ Session::get('message') }}</p>
@endif    

