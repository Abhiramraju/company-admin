@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Employees 
                        <a href="{{ route('employees.create') }}" class="btn btn-sm btn-primary float-right">Create Employee</a> 
                        @if(Session::get('success'))
            <div class="alert alert-success text-center">
              {{Session::get('success')}}
            </div>
            @endif
        </div>

                    <div class="card-body">
                        <div class="mb-3">
                            
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Gender</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Company</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $key => $employee)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $employee->first_name }}</td>
                                        <td>{{ $employee->last_name }}</td>
                                        <td>{{ $employee->gender }}</td>
                                        <td>{{ $employee->mobile }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->company->name }}</td>
                                        <td>
                                                @if($employee->status == 0)
                                                    Active
                                                @elseif($employee->status == 1)
                                                    Resigned
                                                @elseif($employee->status == 2)
                                                    Suspended
                                                @else
                                                    Unknown
                                                @endif
                                            </td>
                                        <td>
                                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $employees->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
