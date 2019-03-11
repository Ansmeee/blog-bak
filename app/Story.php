<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $table = 'story';
    public $timestamps = false;

    const Blog = 1;
    const TRIP = 2;
}
