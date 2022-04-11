@extends('Nabil.app')
@section('content')
<div class="container">
<form action="{{ route('employee.EditUserSubmit') }}" method="post">
  {{@csrf_field()}}
<div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Name</label>
    <input type="text" class="form-control"  placeholder="Name" name="name" value={{ $registration->name }}>
    @error('name')
    <span>{{$message}}</span>
    @enderror
  </div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Address</label>
  <textarea class="form-control"  rows="3" name="address" value={{ $registration->address }}></textarea>
  @error('address')
  <span>{{$message}}</span>
  @enderror
</div>
<div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Division</label>
    <input type="text" class="form-control"  placeholder="e.g Dhaka" name="division" value={{ $registration->division }}>
    @error('division')
    <span>{{$message}}</span>
    @enderror
  </div>
<div class="mb-3" hidden>
    <label for="exampleFormControlInput1" class="form-label">Email address</label>
    <input type="email" class="form-control"  placeholder="name@example.com" name="email" value={{ $registration->email }}>
    @error('email')
    <span>{{$message}}</span>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Password</label>
    <input type="password" class="form-control"  placeholder="Password" name="password" value={{ $registration->password }}>
    @error('password')
    <span>{{$message}}</span>
    @enderror
  </div>
  <input type="submit" value="Update" class="btn btn-primary">
</form>
</div>
@endsection