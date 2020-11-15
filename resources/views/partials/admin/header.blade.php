<div class="container-fluid d-flex justify-content-center">    
    <div class="jumbotron my-auto" style="height:200px">
    <a href="{{ url('/admin') }}" style="display:inline-block; width:200px;"><h4>Home</h4></a>
      <a href="{{ url('admin/newsletter/create') }}" style="display:inline-block; width:200px"><h4>Newsletter</h4></a>
      <h1 class="display-4">{{ env('APP_NAME')}}-  Admin</h1>
      
    </div>
</div>