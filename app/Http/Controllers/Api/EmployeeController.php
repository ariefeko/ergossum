<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeItem;
use App\Models\Employee;
use Illuminate\Http\Request;
use Storage;

class EmployeeController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new EmployeeCollection(Employee::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\EmployeeRequest  $EmployeeRequest
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        if ($data = Employee::create($request->all())) {
            return response()->json([
                'message' => 'OK',
                'data' => $data,
            ], 200);
        }

        return response()->json([
            'message' => 'Bad Request',
            'data' => [],
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return new EmployeeItem($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\EmployeeRequest  $EmployeeRequest
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        if ($employee->update($request->all())) {
            return response()->json([
                'message' => 'OK',
                'data' => $employee,
            ], 201);
        }

        return response()->json([
            'message' => 'Bad Request',
            'data' => [],
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $data = $employee;
        if ($employee->delete()) {
            return response()->json([
                'message' => 'OK',
                'data' => $data,
            ], 200);
        }

        return response()->json([
            'message' => 'Bad Request',
            'data' => [],
        ], 400);
    }
}
