<?php


namespace App\Http\Controllers\API;

use JWTAuth;
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
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    public function index(Request $request)
    {
        if(!empty($request->name))
        {
            $params[] = ['name', 'like', '%'.$request->name.'%'];
        }
        if(!empty($request->location))
        {
            $params[] = ['location', 'like', '%'.$request->location.'%'];
        }
        if(!empty($request->email))
        {
            $params[] = ['email', 'like', '%'.$request->email.'%'];
        }
        if(!empty($request->desciption))
        {
            $params[] = ['desciption', 'like', '%'.$request->desciption.'%'];
        }
        $skip = ($request->skip != '')? $request->skip:'0';
        $limit = ($request->limit != '')? $request->limit:'10000';
        $jobseekers = Jobseeker::where($params)->skip($skip)->take($limit)->get();


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
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = JWTAuth::user();
        $input['user_id'] = $user['id'];
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if($request->hasFile('profile_pic'))
        {
            $input['profile_pic'] = $request->file('profile_pic')->store('images','public');
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
    public function update($id=null, Request $request)
    {
        $jobseeker = Jobseeker::find($id);
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'location' => 'required',
            'description' => 'required',
            'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if($request->hasFile('profile_pic'))
        {
            $input['profile_pic'] = $request->file('profile_pic')->store('images','public');
        }
        $jobseeker->profile_pic = $input['profile_pic'];
        $jobseeker->name = $input['name'];
        $jobseeker->email = $input['email'];
        $jobseeker->location = $input['location'];
        $jobseeker->description = $input['description'];
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
