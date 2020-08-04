<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{

    public function scopeCategoriasSuperiores($query)
    {
        return $query->where('parent_id', null);
    }

    public function scopeAcotadas($query)
    {
        return $query->where('acotado_sn', 0);
    }

    public function parent()
    {
        return $this->belongsTo('App\VideoCategory');
    }

    public function scopeSecciones($query)
    {
        return $this->hasMany('App\VideoCategory', 'parent_id');
    }

    public function videos_categories()
    {
        return $this->hasMany('App\VideoCategory', 'parent_id');
    }

    public function videos()
    {
        return $this->hasMany('App\Video');
    }
}
