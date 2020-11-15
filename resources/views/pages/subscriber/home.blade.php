@extends('layouts.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3 ">
            <div class="panel panel-default">
                <h3 style="text-align:center">Subscribe to our newsletter</h3>
                <div class="panel-body">
                    <div class="row justify-content-center">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('subscribe') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-lg-6  control-label">E-Mail </label>
                                <div class="col-lg-12 ">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-lg-6  control-label">Name</label>
                                <div class="col-lg-12">
                                    <input id="name" type="string" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md">
                                    <a class="btn btn-link" href="{{ url('/getByUser') }}">
                                        already subscribed?click here                               
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        Subscribe
                                    </button>
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