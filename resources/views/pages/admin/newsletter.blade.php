@extends('layouts.admin.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-md-3 ">
            <div class="panel panel-default">
                <h3 style="text-align:center">Create a new newsletter</h3>
                <div class="panel-body">
                    <div class="row justify-content-center">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/newsletter/store') }}">
                        {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-lg-6  control-label">Title </label>

                                <div class="col-lg-15 ">
                                    <input id="title" type="title" class="form-control" size ="50" name="title" value="{{ old('title') }}" required autofocus>

                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-lg-6  control-label">Description</label>

                                <div class="col-lg-15">
                                    <textarea id="description" rows="5" columns="60" class="form-control" name="description" value="" required autofocus>
                                    </textarea>
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md">
                                    <button type="submit" class="btn btn-primary">
                                        Publish
                                    </button>
                                    <a href="{{url('/admin/newsletter/create')}}" role="button" class="btn btn-info"> Cancel </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection