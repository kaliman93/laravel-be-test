@extends('layout', ['title' => 'Customers'])

@section('content')

@if(count($errors) > 0)
  <ul class="list-group">
    @foreach($errors->all() as $error)
    <li class="list-group text-danger">
      {{ $error }}
    </li>
    @endforeach
  </ul>
@endif
    <div class="panel panel-default">
       <div class="panel-heading">
           Add Customer
       </div> 
       <div class="panel-body">
           <form action="{{ route('customers.store') }}" method="post">
               <div class="form-group">
                   <label for="first_name">First Name</label>
                   <input type="text" name="first_name" class="form-control">
               </div>
               {{ csrf_field() }}
               <div class="form-group">
                   <label for="last_name">Last Name</label>
                   <input type="text" name="last_name" class="form-control">
               </div>
               <div class="form-group">
                   <label for="company">Select a Company</label>
                   <select name="company_id" id="company" class="form-control">
                     @foreach($companies as $company)
                     <option value="{{ $company->id}}">{{ $company->name }}</option>
                     @endforeach
                   </select>
               </div>
               <div class="form-group">
                   <label for="birth_date">Birth Date</label>
                   <input type="Date" name="birth_date" class="form-control" value="2017-07-25">
               </div>
               <div class="form-group">
                   <div class="text-center">
                       <button class="btn btn-success"
                        type="submit">Add Customer</button>
                   </div>
               </div>
           </form>
       </div>
    </div>
@endsection
