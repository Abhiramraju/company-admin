@extends('layouts.app')

@section('content')


                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Companies</h5>
                                <p class="card-text">{{ $companyCount }}</p>
                                <a href="{{ route('companies.index') }}" class="btn btn-primary">View Companies</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Employees</h5>
                                <p class="card-text">{{ $employeeCount }}</p>
                                <a href="{{ route('employees.index') }}" class="btn btn-primary">View Employees</a>
                            </div>
                        </div>
                    </div>
                </div>
          
    
@endsection
