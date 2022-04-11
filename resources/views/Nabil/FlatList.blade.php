@extends('Nabil.app')
@section('ViewFlats')
<div class="container">
    @if(Session::get('msg'))
    <div class="alert alert-success" role="alert">
    {{Session::get('msg')}}
    </div>
    @endif
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Buildiing Code</th>
                <th>Flat Renter Name</th>
                <th>Flat Number</th>
                <th>Mobile</th>
                <th>Flat Size</th>
                <th>Rent Status</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($FlatList as $fl)
            <tr>
                <td>{{$fl->buildingCode}}</td>
                <td>{{$fl->flatRenterName}}</td>
                <td>{{$fl->flatNumber}}</td>
                <td>{{$fl->mobile}}</td>
                <td>{{$fl->flatSize}}</td>
                <td>{{$fl->rentStatus}}</td>
                <td>
                <a href="{{route('buildingRent.print',['buildingCode'=>encrypt($fl->buildingCode)])}}" class="btn btn-warning">Rent Bill</a>
                </td>
                <td>
                <a href="{{route('buildingElec.print',['buildingCode'=>encrypt($fl->buildingCode)])}}" class="btn btn-primary">Electricity Bill</a>
                </td>
                <td>
                <a href="{{route('buildingWasa.print',['buildingCode'=>encrypt($fl->buildingCode)])}}" class="btn btn-secondary">Wasa Bill</a>
                </td>
                <td><a href="{{route('employee.EditFlat',['buildingCode'=>encrypt($fl->buildingCode)])}}" class="btn btn-success">Edit</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
