<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Gallery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jobseeker_id', 'image'
    ];
}
