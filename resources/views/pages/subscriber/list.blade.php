@extends('layouts.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3 ">
        
            <h3 style="text-align:center">All Newsletters</h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover mx-auto w-auto" >
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col" class="col-sm-3">Description</th>
                    </tr>
                    @foreach($newsletters as $newsletter)
                        <tr>
                            <td>{{$newsletter->title}}</td>
                            <td>{{$newsletter->description}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
