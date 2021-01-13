<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Jobseeker extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'location', 'description', 'profile_pic'
    ];
}
