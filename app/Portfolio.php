<?php

namespace Corp;

use Corp\Traits\DronTrait;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use DronTrait;

    protected $fillable = ['id', 'title', 'text', 'customer', 'alias', 'date', 'img', 'filter_alias', 'meta_desc', 'keywords'];

    public function filter()
    {
        return $this->belongsTo('Corp\Filter', 'filter_alias', 'alias');
    }

/*    public function getTextAttribute($value)
    {
        return str_replace(["\\r\\n", "\\r", "\\n"], " ", $value);
    }*/
}
