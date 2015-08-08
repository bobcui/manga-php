<?php

namespace App;

class Category extends Model
{
    protected $table = 'wp_wpm_mng_cat';
    
    public $timestamps = false;

    protected $visible = [
        'id',
        'nme'
    ];
}
