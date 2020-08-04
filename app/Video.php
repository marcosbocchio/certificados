<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public function videoCategory()
    {
        return $this->belongsTo('App\VideoCategory');
    }
}
