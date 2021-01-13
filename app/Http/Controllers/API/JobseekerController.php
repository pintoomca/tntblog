<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Jobseeker;
use Validator;


class JobseekerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobseekers = Jobseeker::all();


        return $this->sendResponse($jobseekers->toArray(), 'Jobseekers retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'location' => 'required',
            'description' => 'required',
            'profile_pic' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }


        $jobseeker = Jobseeker::create($input);


        return $this->sendResponse($jobseeker->toArray(), 'Jobseeker created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jobseeker = Jobseeker::find($id);


        if (is_null($jobseeker)) {
            return $this->sendError('Jobseeker not found.');
        }


        return $this->sendResponse($jobseeker->toArray(), 'Jobseeker retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jobseeker $jobseeker)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'location' => 'required',
            'description' => 'required',
            'profile_pic' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }


        $jobseeker->name = $input['name'];
        $jobseeker->email = $input['email'];
        $jobseeker->location = $input['location'];
        $jobseeker->description = $input['description'];
        $jobseeker->profile_pic = $input['profile_pic'];
        $jobseeker->save();


        return $this->sendResponse($jobseeker->toArray(), 'Jobseeker updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jobseeker $jobseeker)
    {
        $jobseeker->delete();


        return $this->sendResponse($jobseeker->toArray(), 'Jobseeker deleted successfully.');
    }
}
