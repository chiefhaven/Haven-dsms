<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\District;
use App\Models\Lesson;
use App\Http\Requests\StoreInstructorRequest;
use App\Http\Requests\UpdateInstructorRequest;
use Session;
use Illuminate\Support\Str;
use PDF;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instructor = Instructor::with('User', 'Lesson')->get();
        return view('instructors.instructors', compact('instructor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $district = District::get();
        $lesson = Lesson::get();
        return view('instructors.addinstructor', compact('district', 'lesson'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInstructorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInstructorRequest $request)
    {
        $messages = [
            'fname.required' => 'The "First name" field is required!',
            'sname.required'   => 'The "Sir name" field is should be unique!',
            'email.required' => 'The "Email" is required!',            
            'email.unique' => 'The "Email" is already in use',
            'gender.required'   => 'The "Gender" field required!',
            'date_of_birth.required' => 'Date of birth is required',
        ];

        // Validate the request
        $this->validate($request, [
            'first_name'  =>'required',
            'sir_name' =>'required',
            'email'   =>'required | unique:users',
            'address' =>'required',
            'gender'  =>'required',
            'date_of_birth' =>'required',
            'district' =>'required',
            'phone' =>'required'

        ], $messages);

        $post = $request->All();

        $district = havenUtils::selectDistrict($post['district']);

        $instructor = new instructor;
 
        $instructor->fname = $post['first_name'];
        $instructor->sname = $post['sir_name'];
        $instructor->gender = $post['gender'];
        $instructor->phone = $post['phone'];
        $instructor->address = $post['address'];
        $instructor->date_of_birth = $post['date_of_birth'];
        $instructor->district_id = $district;

        $instructor->save();


        $user = new User;
        $user->name = Str::random(10);
        $user->instructor_id = $instructor->id;
        $user->email = $post['email'];
        $user->password = Str::random(10);

        $user->save();

        return redirect('/instructors')->with('message', 'Instructor added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function show(Instructor $instructor)
    {
        return view('instructors.viewinstructor', compact('instructor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $instructor = Instructor::with('User')->find($id);
        $district = district::get();
        $lesson = Lesson::get();
        return view('instructors.editinstructor', [ 'instructor' => $instructor ], compact('instructor', 'district', 'lesson'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInstructorRequest  $request
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstructorRequest $request, Instructor $instructor)
    {
        $messages = [
            'fname.required' => 'Firstname is required',
            'sname.required'   => 'Sirname is required',
            'email.required' => 'Email is required',            
            'email.unique' => 'Email is already in use',
            'gender.required'   => 'The "Gender" field required',
            'date_of_birth.required' => 'Date of birth is required',
        ];

        // Validate the request
        $this->validate($request, [
            'first_name'  =>'required',
            'sir_name' =>'required',
            'email'   =>'required',
            'address' =>'required',
            'gender'  =>'required',
            'date_of_birth' =>'required',
            'district' =>'required',
            'phone' =>'required'

        ], $messages);

        $post = $request->All();

        $district = havenUtils::selectDistrict($post['district']);

        $instructor = Instructor::find($post['instructor_id']);
 
        $instructor->fname = $post['first_name'];
        $instructor->sname = $post['sir_name'];
        $instructor->gender = $post['gender'];
        $instructor->phone = $post['phone'];
        $instructor->address = $post['address'];
        $instructor->date_of_birth = $post['date_of_birth'];
        $instructor->district_id = $district;

        $user = User::where('instructor_id', $post['instructor_id'])->firstOrFail();

        $user->email = $post['email'];

        $instructor->save();
        $user->save();

        return redirect('/instructors')->with('message', 'Instructor updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

            $instructor = Instructor::find($id);

            $instructor->delete();

            $instructorName = $instructor->fname." ". $instructor->sname;

            User::where('instructor_id', $id)->delete();

            $message ="Instructor ".$instructorName." deleted";

            return redirect('/instructors')->with('message', $message);

    }
}
