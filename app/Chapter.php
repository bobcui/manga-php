<?php

namespace App;

class Chapter extends Model
{
    protected $table = 'wp_wpm_mng_chp';

    public static $attrToSelect = [
        'mng_id',
        'slg',
        'ttl',
    ];

    protected $hidden = [
        'mng_id'
    ];

    public function manga()
    {
        return $this->belongsTo('App\Manga', 'mng_id');
    }
}
