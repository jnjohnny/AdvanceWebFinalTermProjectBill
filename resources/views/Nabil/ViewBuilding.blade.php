@extends('Nabil.app')
@section('ViewBuilding')
<div class="container">
    @if(Session::get('msg'))
    <div class="alert alert-success" role="alert">
    {{Session::get('msg')}}
    </div>
    @endif
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Building Number</th>
                <th>Floor Details</th>
                <th>Flat Numbers</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($building as $b)
            <tr>
                <td><a href="{{route('Flats.List',['buildingCode'=>encrypt($b->buildingCode)])}}">{{$b->buildingCode}}</a></td>
                <td>{{$b->floorDetails}}</td>
                <td>{{$b->flatNo}}</td>
                <td><a href="{{ route('employee.EditBuilding',['buildingCode'=>encrypt($b->buildingCode)]) }}" class="btn btn-success">Edit</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
