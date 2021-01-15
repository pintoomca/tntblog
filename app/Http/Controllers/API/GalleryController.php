<?php


namespace App\Http\Controllers\API;

use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Gallery;
use Validator;


class GalleryController extends BaseController
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



       $galleries = Gallery::all();


        return $this->sendResponse($galleries->toArray(), 'Jobseekers retrieved successfully.');
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
            'jobseeker_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if($request->hasFile('image'))
        {
            $input['image'] = $request->file('image')->store('gallery','public');
        }
        $jobseeker = Gallery::create($input);


        return $this->sendResponse($jobseeker->toArray(), 'Gallery created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jobseeker = Gallery::find($id);


        if (is_null($jobseeker)) {
            return $this->sendError('Gallery not found.');
        }


        return $this->sendResponse($jobseeker->toArray(), 'Gallery retrieved successfully.');
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
        $jobseeker = Gallery::find($id);
        $input = $request->all();


        $validator = Validator::make($input, [
            'jobseeker_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if($request->hasFile('image'))
        {
            $input['image'] = $request->file('image')->store('gallery','public');
        }
        $jobseeker->image = $input['image'];
        $jobseeker->jobseeker_id = $input['jobseeker_id'];
        $jobseeker->save();


        return $this->sendResponse($jobseeker->toArray(), 'Gallery updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $jobseeker)
    {
        $jobseeker->delete();


        return $this->sendResponse($jobseeker->toArray(), 'Gallery deleted successfully.');
    }
}
