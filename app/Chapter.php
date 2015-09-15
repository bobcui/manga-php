<?php

namespace App;

class Chapter extends Model
{
    protected $table = 'wp_wpm_mng_chp';

    public $timestamps = false;

    public static $attrToSelect = [
        'mng_id',
        'dir_pth',
        'ttl',
        'pageCount',
    ];

    protected $hidden = [
        'mng_id',
        'dir_pth',
        'pageCount', 
    ];

    protected $appends = [
        'idx',
        'cnt'
    ];

    public function getIdxAttribute()
    {
        return $this->dir_pth;
    }

    public function getCntAttribute()
    {
        return $this->pageCount;
    }

    public function manga()
    {
        return $this->belongsTo('App\Manga', 'mng_id');
    }
}
