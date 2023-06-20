<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        if (Auth::guard('api')->check()) {

            $students = Student::all();
            return Response(['data' => $students], 200);
        }
        return Response(['data' => 'unauthorized'], 401);
    }
    public function create(Request $request)
    {
       
    }

    
    public function store(Request $request): Response
    {
        if (Auth::guard('api')->check()) {
            //$user = Auth::guard('api')->user();
            $students = new Student;
            $students->name = $request->name;
            $students->course = $request->course;
            
            $students->save();
            return response(['message'=>'Student created successfully.'],201);
        }
        return Response(['data' => 'unauthorized'], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id): Response
    {
        if (Auth::guard('api')->check()){
        //$user = Auth::guard('api')->user(); 
            $student = Student::find($id);
            if (is_null($student)) {
                return $this->sendError('No found record.');
            }            
            return Response(['data' => $student], 200);
        }
        return Response(['data' => 'unauthorized'], 401);
    }       

       

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): Response
    {
        // $data=Student::where('id', $id)->first();
        // echo "<pre>";
        // print_r($data);
        // "</pre>";
        if (Auth::guard('api')->check()) {
            //$user = Auth::guard('api')->user(); 
            $students = Student::where('id', $id)->first();
            if (is_null($students)) {
                return $this->sendError('No found record.');
            }            
            $students->name = $request->name;
            $students->course = $request->course;

            $students->save();
            return response(['message' => 'Student updated successfully.']);
        }
        return Response(['data' => 'unauthorized'], 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            Student::where('id',$id)->delete();
            return response(['message' => 'Student deleted successfully.']);
        }
        return Response(['data' => 'unauthorized'], 401);
    }
}
