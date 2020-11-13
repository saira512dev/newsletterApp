@extends('layouts.admin.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3 ">
        
            <h3 style="text-align:center">All Subscribers</h3>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addModal" id="open">Add New Subscriber</button>
            <div class="table-responsive">
                <table class="table table-striped table-hover mx-auto w-auto" id="allUsers">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col" class="col-sm-3">Actions</th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td class="text-nowrap" >
                                <form class="destroy-form" action="{{route('admin.user.delete',['id' => $user->id])}}" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="_method" value="delete">
                                    <button class="btn btn-danger float-left" type="submit" style="margin:10px"> Delete</button>
                                </form>                            
                                <button type="button" class="btn btn-success" style="margin:10px" data-id ="{{ $user->id}}"  data-name ="{{ $user->name}}" data-email ="{{ $user->email}}"data-toggle="modal" data-target="#editModal" id="editOpen">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

<!--Add User Modal Box-->
<form method="post" action="{{url('admin/subscriber/create')}}" id="form">
        @csrf
    <div class="modal" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="alert alert-danger alert-dismissable" id="addFail" style="display:none"></div>
                <div class="alert alert-success alert-dismissable" id="addSuccess" style="display:none"></div>
                <div class="modal-header">
      	            <h5 class="modal-title">Add New Subscriber</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-8">
                        <label for="Name">Name:</label>
                        <input type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-8">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button  class="btn btn-success" id="addSubscriber">Add</button>
                </div>
            </div>
        </div>
    </div>
</form>



<!--Edit User Modal Box-->
<form method="put"  id="editForm">
        @csrf
    <div class="modal" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="alert alert-danger alert-dismissable" id="editFail" style="display:none"></div>
                <div class="alert alert-success alert-dismissable" id="editSuccess" style="display:none"></div>
                <div class="modal-header">
      	            <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-8">
                        <label for="Name">Name:</label>
                        <input type="text" class="form-control" name="editName" id="editName">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-8">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="editEmail" id="editEmail">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button  class="btn btn-success" id="editSubscriber">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>





         

@endsection
@push('footerScripts')
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
</script>


      <!-- Latest compiled and minified JavaScript -->
<script>
jQuery(document).ready(function(){
    jQuery('#addSubscriber').click(function(e){
        e.preventDefault();
        $('#addsuccess').hide();
        $('#addFail').hide();
        $('#addsuccess').html('');
        $('#addFail').html('');

        
        $.ajaxSetup({
            headers: {
            }
        });
        jQuery.ajax({
            url: "{{ url('/admin/subscriber/create') }}",
            method: 'post',
            data: {
                _token: '{!! csrf_token() !!}',
                name: jQuery('#name').val(),
                email: jQuery('#email').val(),
            },
            error:function( err){
                if(err.status === 422){
                   var e = err.responseJSON;
                   if(e.errors.name){
                    $('#addFail').append('*'+e.errors.name);
                   }
                   if(e.errors.email){
                    $('#addFail').append('*'+e.errors.email);
                   }
                   $('#addFail').show();
                }
                //console.log(error.message)
            },
            success: function(data) {
                var newUser = data.responseJSON;
                console.log(newUser);
                $('#addSuccess').append('subscriber '+name+' added');
                $('#addSuccess').show();
                
            }
        });
    });


    jQuery('#editOpen').click(function(e){
        e.preventDefault();
        $('#editsuccess').hide();
        $('#editFail').hide();
        $('#editsuccess').html('');
        $('#editFail').html('');
        $("#editName").val('');
        $("#editEmail").val('');
        

        var userId = $(this).data('id');
        var userName = $(this).data('name');
        var userEmail = $(this).data('email');
        console.log(userId);
        $("#editName").val(userName);
        $("#editEmail").val(userEmail);
        
        $.ajaxSetup({
            headers: {
            }
        });
        jQuery.ajax({
            url: "/admin/user/edit/"+userId,
            method: 'put',
            data: {
                _token: '{!! csrf_token() !!}',
                name: jQuery('#editName').val(),
                email: jQuery('#editEmail').val(),
            },
            error:function( err){
                if(err.status === 422){
                   var e = err.responseJSON;
                   if(e.errors.name){
                    $('#editFail').append('*'+e.errors.name);
                   }
                   if(e.errors.email){
                    $('#editFail').append('*'+e.errors.email);
                   }
                   $('#editFail').show();
                }
                //console.log(error.message)
            },
            success: function(data) {
                var newUser = data.responseJSON;
                console.log(newUser);
                $('#editSuccess').append('changes to subscriber '+name+' saved');
                $('#editSuccess').show();
                
            }
        });
    });
});

</script>
@endpush

