<?php

namespace App\Http\Controllers;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\EmployeeResource;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class APIController extends Controller
{
    public function companies()
    {
        $companies = Company::all();

        return response()->json([
            'data' => CompanyResource::collection($companies),
            'status' => Response::HTTP_OK,
        ]);
    }

    public function employees()
    {
        $employees = Employee::all();

        return response()->json([
            'data' => EmployeeResource::collection($employees),
            'status' => Response::HTTP_OK,
        ]);
    }

    public function showCompany($id)
    {
        $company = Company::findOrFail($id);
        return new CompanyResource($company);
    }

    public function showEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        return new EmployeeResource($employee);
    }
    
}
