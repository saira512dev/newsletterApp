<meta charset="utf-8">
<meta name="description" content="">
<meta name="saira" content="Blade">
<title>{{ env('APP_NAME') }}</title>
 <!-- Scripts -->
 <script src="{{ asset('js/app.js') }}" defer></script>
   
<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

@if(Session::has('message'))
 <p class="alert alert-info">{{ Session::get('message') }}</p>
@endif