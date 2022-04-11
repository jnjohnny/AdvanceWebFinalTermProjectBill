@extends('Nabil.app')
@section('ViewSubscription')
<div class="container">
    @if(Session::get('msg'))
    <div class="alert alert-primary" role="alert">
    {{Session::get('msg')}}
    </div>
    @endif
    <br><br>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Username</th>
                <th>Payment Status</th>
                <th>Paid at</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($sub as $s)
            <tr>
                <td>{{$s->username}}</td>
                <td>{{$s->paymentstatus}}</td>
                <td>{{$s->DOP}}</td>
                <td><a href="{{ route('employee.SubNotify' ,['username'=>encrypt($s->username)]) }}" class="btn btn-danger">Notify</a></td>
                <td><a href="{{ route('employee.EditSubscription' ,['username'=>encrypt($s->username)]) }}" class="btn btn-success">Edit</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
