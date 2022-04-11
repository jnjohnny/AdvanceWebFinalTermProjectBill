@extends('Nabil.app')
@section('content')
<div class="container">
<form action="{{ route('create_user.add') }}" method="post">
  {{@csrf_field()}}
<div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Name</label>
    <input type="text" class="form-control"  placeholder="Name" name="name" value={{old('name')}}>
    @error('name')
    <span>{{$message}}</span>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Mobile</label>
    <input type="text" class="form-control"  placeholder="+8801777777777" name="mobilenumber" value={{old('mobilenumber')}}>
    @error('mobilenumber')
    <span>{{$message}}</span>
    @enderror
  </div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
  <textarea class="form-control"  rows="3" name="address" value={{old('address')}}></textarea>
  @error('address')
  <span>{{$message}}</span>
  @enderror
</div>
<div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Division</label>
    <input type="text" class="form-control"  placeholder="e.g Dhaka" name="division" value={{old('division')}}>
    @error('division')
    <span>{{$message}}</span>
    @enderror
  </div>
<div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Email address</label>
    <input type="email" class="form-control"  placeholder="name@example.com" name="email" value={{old('email')}}>
    @error('email')
    <span>{{$message}}</span>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Password</label>
    <input type="password" class="form-control"  placeholder="Password" name="password" value={{old('password')}}>
    @error('password')
    <span>{{$message}}</span>
    @enderror
  </div>
  <input type="submit" value="Add" class="btn btn-primary">
</form>
</div>
@endsection