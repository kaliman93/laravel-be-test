@extends('layout', ['title' => 'Customers'])

@section('content')

<h1>Customers <small class="text-muted font-weight-light">({{ number_format($customers->total()) }} found)</small></h1>

<table class="table my-4">
    <tr>
        <th>Name</th>
        <th>Birthday</th>
        <th>Company</th>
        <th>Last Interaction</th>
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
