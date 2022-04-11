@extends('Nabil.app')
@section('content')
<div class="container">
<form action="{{ route('employee.EditSubscriptionConfirm') }}" method="post">
  {{@csrf_field()}}
    <input type="text" class="form-control" name="s_id" value={{ $sub->s_id }} hidden>
<div class="mb-3">
    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="paymentstatus">
        <option selected></option>
        <option value="paid">paid</option>
        <option value="pending">pending</option>
      </select>
    @error('paymentstatus')
    <span>{{$message}}</span>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Date of Payment</label>
    <input type="date" class="form-control" name="DOP" value={{ $sub->DOP }}>
    @error('flatNo')
    <span>{{$message}}</span>
    @enderror
  </div>
  <input type="submit" value="Update" class="btn btn-primary">
</form>
</div>
@endsection