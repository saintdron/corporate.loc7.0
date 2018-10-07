<?php

namespace Corp;

use Corp\Traits\DronTrait;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use DronTrait;

    protected $fillable = ['title', 'img', 'alias', 'text', 'desc', 'keywords', 'meta_desc', 'category_id', 'fixed'];

    public function user()
    {
        return $this->belongsTo('Corp\User');
    }

    public function category()
    {
        return $this->belongsTo('Corp\Category');
    }

    public function comments()
    {
        return $this->hasMany('Corp\Comment');
    }

/*    public function getTextAttribute($value)
    {
        return str_replace(["\\r\\n", "\\r", "\\n"], " ", $value);
    }*/

}
