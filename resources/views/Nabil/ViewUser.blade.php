@extends('Nabil.app')
@section('ViewUser')
<div class="container">
    @if(Session::get('msg'))
    <div class="alert alert-success" role="alert">
    {{Session::get('msg')}}
    </div>
    @endif
    @if(Session::get('err_msg'))
    <div class="alert alert-danger" role="alert">
    {{Session::get('err_msg')}}
    </div>
    @endif
    @if(Session::get('del_msg'))
    <div class="alert alert-success" role="alert">
    {{Session::get('del_msg')}}
    </div>
    @endif
    <a href="{{ route('employee.CreateUser') }}" class="btn btn-primary">Create User</a>
    <br><br>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile Number</th>
                <th>Address</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($registration as $reg)
            <tr>
                <td>{{$reg->name}}</td>
                <td>{{$reg->mobilenumber}}</td>
                <td>{{$reg->address}}</td>
                <td>{{$reg->email}}</td>
                <td>
                <a href="{{route('employee.EditUser',['email'=>encrypt($reg->email)])}}" class="btn btn-success">Edit</a>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
