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
   <div id="main" class="row">
           @yield('content')
   </div>
   <footer class="row">
       @include('partials.admin.footer')
   </footer>
</div>
@include('partials.admin.footerScripts')
</body>
</html>