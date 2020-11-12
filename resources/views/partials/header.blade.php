<div class="container h-100 d-flex justify-content-center">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="jumbotron my-auto">
      <h1 class="display-4">{{ env('APP_NAME')}}</h1>
      <a href="{{ url('/') }}" style="text-align:center;display:block;"><h4>Home</h4></a>
    </div>
</div>