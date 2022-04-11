@extends('Nabil.app')
@section('content')
<div class="container">
<form action="{{ route('employee.EditBuildingSubmit') }}" method="post">
  {{@csrf_field()}}
    <input type="text" class="form-control" name="buildingCode" value={{ $building->buildingCode }} hidden>
<div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Number of Floors</label>
    <input type="text" class="form-control" name="floorDetails" value={{ $building->floorDetails }}>
    @error('floorDetails')
    <span>{{$message}}</span>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Number of Flats</label>
    <input type="number" class="form-control" name="flatNo" value={{ $building->flatNo }}>
    @error('flatNo')
    <span>{{$message}}</span>
    @enderror
  </div>
  <input type="submit" value="Update" class="btn btn-primary">
</form>
</div>
@endsection