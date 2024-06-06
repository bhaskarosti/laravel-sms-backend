<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $Class)
    {
        //
        // All Students
        // $students = Student::all();
        // $students= Student::where('class', $Class);
        $students = DB::table('students')->where('class', $Class)->orderBy('rollno', 'asc')->get();

        // Return Json Response
        return response()->json([
            'students' => $students
        ], 200);
    }
    public function classes()
    {
        //
        // All Students
        // $students = Student::all();
        // $students= Student::where('class', $Class);
        // $students = DB::table('students')->where('class', $Class)->get();
        $classes = DB::table('students')->select('class')->groupBy('class')->get();
        // Return Json Response
        return response()->json([
            'classes' => $classes
        ], 200);
    }
    public function dashboard()
    {
        //
        // All Students
        // $students = Student::all();
        // $students= Student::where('class', $Class);
        // $students = DB::table('students')->where('class', $Class)->get();
        // $classes = DB::table('students')->select('class')->groupBy('class')->get();
        $stats = DB::table('students')->select(DB::raw('count(id) as nos, sum(fee) as rf'))->get();
        // $query = DB::table('students')->select('name','id')->count();
 
        // $stats = $query->addSelect('age')->get();
        // Return Json Response
        return response()->json([
            'stats' => $stats
        ], 200);
    }
    public function rollnos(string $Class)
    {
        //
        // All Students
        // $students = Student::all();
        // $students= Student::where('class', $Class);
        // $students = DB::table('students')->where('class', $Class)->get();
        $rollnos = DB::table('students')->select('rollno')->where('class', $Class)->orderBy('rollno', 'asc')->get();
        // Return Json Response
        return response()->json([
            'rollnos' => $rollnos
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $id=$request->class . $request->rollno;
            $student = Student::where('sid', $id)->first();
            if (!$student) {
               
                if ($request->image) {
                    $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();
                } else {
                    $imageName = "Default1.jpg";
                }
                // Create Student
                Student::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'sid' => $request->sid,
                'guardian' => $request->guardian,
                'email' => $request->email,
                'rollno' => $request->rollno,
                'contact' => $request->contact,
                'gender' => $request->gender,
                'address' => $request->address,
                'class' => $request->class,
                'fee' => $request->fee,
                'image' => $imageName,
            ]);
            
            // Save Image in Storage folder
            if ($request->image) {
                Storage::disk('public')->put($imageName, file_get_contents($request->image));
            }
            // Return Json Response
            return response()->json([
                'message' => "Student successfully created."
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'Error'
            ], 200);
        }
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        // $student = Student::find($id);
        $student = Student::where('sid', $id)->first();
        if (!$student) {
            return response()->json([
                'message' => 'student Not Found.'
            ], 200);
        }

        // Return Json Response
        return response()->json([
            'student' => $student
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            // Find student
            // $student = Student::find($id);
            $student = Student::where('sid', $id)->first();

            if (!$student) {
                return response()->json([
                    'message' => 'Student Not Found.'
                ], 404);
            }

            //echo "request : $request->image";
            $student->firstName = $request->firstName;
            $student->lastName = $request->lastName;
            $student->sid = $request->sid;
            $student->guardian = $request->guardian;
            $student->email = $request->email;
            $student->rollno = $request->rollno;
            $student->contact = $request->contact;
            $student->gender = $request->gender;
            $student->address = $request->address;
            $student->class = $request->class;
            $student->fee = $request->fee;
            // $student->description = $request->description;

            if ($request->image) {

                // Public storage
                $storage = Storage::disk('public');

                // Old iamge delete
                if ($storage->exists($student->image))
                
                    $storage->delete($student->image);

                // Image name
                $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();
                $student->image = $imageName;

                // Image save in public folder
                $storage->put($imageName, file_get_contents($request->image));
            }

            // Update Student
            $student->save();

            // Return Json Response
            return response()->json([
                'message' => "Student successfully updated."
            ], 200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        // $student = Student::find($id);
        $student = Student::where('sid', $id)->first();

        if (!$student) {
            return response()->json([
                'message' => 'Student Not Found.'
            ], 404);
        }

        // Public storage
        $storage = Storage::disk('public');

        // Iamge delete
        if ($storage->exists($student->image))
            $storage->delete($student->image);

        // Delete Student
        $student->delete();

        // Return Json Response
        return response()->json([
            'message' => "Student successfully deleted."
        ], 200);

    }
}
