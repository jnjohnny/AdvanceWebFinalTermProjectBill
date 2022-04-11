@extends('Nabil.app')
@section('dashboard')
<div class="container">
  @if(Session::get('msg'))
  <div class="alert alert-success" role="alert">
    {{Session::get('msg')}}
  </div>
 @endif
<div class="d-flex p-2">
  
<div class="card" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Colonies</h5>
      <p class="card-text">{{ $colonies }}</p>
      {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
    </div>
  </div>
<div class="card" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Buildings</h5>
      <p class="card-text">{{ $buildings }}</p>
      {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
    </div>
  </div>
  <div class="card" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Flats</h5>
      <p class="card-text">{{ $flats }}</p>
      {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
    </div>
  </div>
</div>
</div>
@endsection