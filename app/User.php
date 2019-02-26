<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    const PRIVACY = 0;
    const MALE    = 1;
    const FEMALE  = 2;
    public static $sexTitle = [
        self::PRIVACY => '保密',
        self::MALE    => '男',
        self::FEMALE  => '女'
    ];

    const BLOGGER = 1;

    public function getTrips()
    {
        $trips = [];
        $myTrips = \App\Story::where('user_id', $this->id);
        foreach ($myTrips as $myTrip) {
            $trips[] = $this->_getTripData($myTrip);
        }

        return $trips;
    }

    private function _getTripData($trip)
    {
        $data =  [
            'id'        =>  $trip->id,
            'title'     =>  $trip->title,
            'summary'   =>  $trip->summary,
            'content'   =>  $trip->content,
            'banner'    =>  $trip->banner,
            'label'     =>  $trip->label,
            'date'      =>  $trip->date,
            'location'  =>  $trip->location
        ];

        return $data;
    }

    public function getBlogSummary()
    {
        $blogs = [
            [
                'title'  => '博客',
                'total' => self::getBlogCount(\App\Story::Blog),
                'url'   => 'myblog',
            ],
            [
                'title'  => '日志',
                'total' => self::getBlogCount(\App\Story::TRIP),
                'url'   => 'mytrip',
            ]
        ];

        return $blogs;
    }

    public static function getBlogCount($type = '')
    {
        if ($type) {
            $count = \App\Story::where('type', $type)->count();
        } else {

        }

        $count = $type ? \App\Story::where('type', $type)->count() : \App\Story::count();
        return $count;
    }
}
