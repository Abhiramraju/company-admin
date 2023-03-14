<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::with('company')->paginate(10);
        return view('employees.index', compact('employees'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        return view('employees.create', compact('companies'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'nullable|in:male,female,other',
            'mobile' => 'required|unique:employees,mobile',
            'email' => 'nullable|email|unique:employees,email',
            'company_id' => 'required|exists:companies,id',
            'status' => 'nullable|in:0,1,2',
        ]);
    
        // Create a new employee instance with the validated data
        $employee = new Employee();
        $employee->first_name = $validatedData['first_name'];
        $employee->last_name = $validatedData['last_name'];
        $employee->gender = $validatedData['gender'];
        $employee->mobile = $validatedData['mobile'];
        $employee->email = $validatedData['email'];
        $employee->status = $validatedData['status'];
        $employee->company_id = $validatedData['company_id'];
    
        // Save the new employee to the database
        $employee->save();
    
        // Redirect the user to the index page with a success message
        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }
    
    
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $employee = Employee::findOrFail($id);
    $companies = Company::all();
    return view('employees.edit', compact('employee', 'companies'));
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    // Validate the form data
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'gender' => 'required|in:male,female,other',
        'mobile' => 'required',
    'email' => 'nullable|email',
        'company_id' => 'nullable|exists:companies,id',
         'status' => 'required|in:0,1,2',
    ]);

    // Find the employee with the given ID
    $employee = Employee::findOrFail($id);

    // Update the employee data
    $employee->first_name = $validatedData['first_name'];
    $employee->last_name = $validatedData['last_name'];
    $employee->gender = $validatedData['gender'];
    $employee->mobile = $validatedData['mobile'];
    $employee->email = $validatedData['email'];
    $employee->status = $validatedData['status'];
    $employee->company_id = $validatedData['company_id'];

    // Save the updated employee
    $employee->save();

    // Redirect back to the employee list with a success message
    return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
}

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
    
}
