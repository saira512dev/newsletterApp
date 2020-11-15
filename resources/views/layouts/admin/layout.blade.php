<!doctype html>
<html>
<head>
   @include('partials.admin.head')
</head>
<body>
<div class="container">
   <header class="row">
       @include('partials.admin.header')
   </header>
   <div id="main" class="row" style ="margin-bottom: 50px">
           @yield('content')
   </div>
   <div>
       @include('partials.admin.footer')
   </div>
</div>
@include('partials.admin.footerScripts')
</body>
</html>