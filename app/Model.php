<?php

namespace App;

class Model extends \Illuminate\Database\Eloquent\Model
{
    public function toArray($outputAttributes=null)
    {
        $attributes = parent::toArray();
        if (is_array($outputAttributes)) {
            $attributes = array_intersect_key($attributes, array_flip($outputAttributes));
        }
        return $attributes;
    }
}
