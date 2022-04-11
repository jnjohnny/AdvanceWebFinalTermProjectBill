@extends('Nabil.app')
@section('content')
<div class="container">
<form action="{{ route('employee.EditFlatSubmit') }}" method="post">
  {{@csrf_field()}}
    <input type="text" class="form-control" name="buildingCode" value={{ $flat->buildingCode }} hidden>
<div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Flat Size</label>
    <input type="text" class="form-control" name="flatSize" value={{ $flat->flatSize }}>
    @error('flatSize')
    <span>{{$message}}</span>
    @enderror
  </div>
  <div class="mb-3">
    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="rentStatus">
        <option selected></option>
        <option value="paid">paid</option>
        <option value="pending">pending</option>
      </select>
    @error('rentStatus')
    <span>{{$message}}</span>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Flat Renter Name</label>
    <input type="text" class="form-control" name="flatRenterName" value={{ $flat->flatRenterName }}>
    @error('flatRenterName')
    <span>{{$message}}</span>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Mobile</label>
    <input type="text" class="form-control" name="mobile" value={{ $flat->mobile }}>
    @error('mobile')
    <span>{{$message}}</span>
    @enderror
  </div>
  <input type="submit" value="Update" class="btn btn-primary">
</form>
</div>
@endsection