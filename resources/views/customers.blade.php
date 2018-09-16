@extends('layout', ['title' => 'Customers'])

@section('content')

<h1>Customers <small class="text-muted font-weight-light">({{ number_format($customers->total()) }} found)</small></h1>
<form class="input-group my-4" action="{{ route('customers') }}" method="get">
    <input type="hidden" name="order" value="{{ request('order') }}">
    <input type="hidden" name="orderBy" value="{{ request('orderBy') }}">
    <input type="text" class="w-45 form-control"  name="search" value="{{ request('search') }}">
    <div class="input-group-append">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
</form>
<table class="table my-4">
    <tr>
        <th><a class="{{ request('orderBy') === 'name' ? 'text-dark' : '' }}" href="{{ route('customers', ['orderBy' => 'name', 'order' => request('order') === 'asc' ? 'desc' : 'asc' ] + request()->except('page')) }}">Name</a></th>
        <th><a class="{{ request('orderBy') === 'birthday' ? 'text-dark' : '' }}" href="{{ route('customers', ['orderBy' => 'birthday', 'order' => request('order') === 'asc' ? 'desc' : 'asc' ] + request()->except('page')) }}">Birthday</a></th>
        <th><a class="{{ request('orderBy') === 'company' ? 'text-dark' : '' }}" href="{{ route('customers', ['orderBy' => 'company', 'order' => request('order') === 'asc' ? 'desc' : 'asc' ] + request()->except('page')) }}">Company</a></th>
        <th><a class="{{ request('orderBy') === 'last_interaction' ? 'text-dark' : '' }}" href="{{ route('customers', ['orderBy' => 'last_interaction', 'order' => request('order') === 'asc' ? 'desc' : 'asc' ] + request()->except('page')) }}">Last Interaction</a></th>
    </tr>
    @foreach ($customers as $customer)
        <tr>
            <td><a href="{{ route('customers.edit', $customer) }}">{{ $customer->last_name }}, {{ $customer->first_name }}</a></td>
            <td>{{ $customer->birth_date->format('F j') }}</td>
            <td>{{ $customer->company->name }}</td>
            <td>{{ $customer->interactions()->latest()->first()->created_at->diffForHumans() }} / 
                {{ $customer->last_interaction_type }}
            </td>
        </tr>
    @endforeach
</table>

{{ $customers->appends(request()->all())->links() }}

@endsection
