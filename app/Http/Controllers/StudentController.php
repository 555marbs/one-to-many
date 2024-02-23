<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){
        return Student::with('subject')->get();
    }

    public function store(Request $request){
        $student = Student::create($request->all());
        if($request->has('subject')){
            $student->subject()->createMany($request->input('subject'));
        }
        return response()->json($student,201);
    }

    public function update(Request $request, $id){
        $student = Student::find($id);
        $student -> update($request->all());
        return response()->json(['student' => $student]);
    }

    public function destroy($id){
        $student = Student::find($id);
        $student->subject()->delete();
        $student->delete();
        return response()->json(['message' => 'succesffully deleted data']);
    }
}
