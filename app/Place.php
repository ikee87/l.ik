<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'data'
    ];

    protected $casts = [
        'data' => 'json',
    ];

//    public function setDataAttribute($value)
//    {
//        $this->attributes['data'] = json_decode($value, true);
//    }

    public function scopeMoscow($query)
    {
        return $query->whereRaw("data->>'name' = :name ", ['name' => 'moscow']);
    }

    public function scopeOfType($query, $type)
    {
        return $query->whereRaw("jsonb_exists(data->'types', :type)", ['type' => $type]);
    }


}
