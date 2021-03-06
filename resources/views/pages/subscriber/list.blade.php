@extends('layouts.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3 ">
            <h3 style="text-align:center">All Newsletters</h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover mx-auto w-auto" >
                    <tr>
                        <th scope="col" class="">Title</th>
                        <th scope="col" class="col-sm-2">Description</th>
                        <th scope="col" >Published On</th>
                    </tr>
                    @foreach($newsletters as $newsletter)
                        <tr>
                            <td>{{$newsletter->title}}</td>
                            <td>{{$newsletter->description}}</td>
                            <td>{{$newsletter->created_at->format('Y-m-d')}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            @if($newsletters->total() == 0)
                <br><br>
                <h4 class="text-center">No Newsletters yet!!</h4>
                <br>
            @endif
            <div class="d-flex justify-content-center">
                {{ $newsletters->links() }}  
            </div>
        </div>
    </div>
</div>
@endsection
