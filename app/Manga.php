<?php

namespace App;

use Illuminate\Support\Facades\Config;

class Manga extends Model
{
    protected $table = 'wp_wpm_mng';
    
    protected $primaryKey = 'id';
    
    public $timestamps = false;

    public static $briefAttrToSelect = [
        'id',
        'nme',
        'slg',
    ];

    public static $briefAttrToOutput = [
        'id',
        'nme',
        'tbn'
    ];

    public static $detailAttrToSelect = [
        'id',
        'nme',
        'slg',
        'cat',
        'dsc',
        'rnk',
        'mng_chp_cnt',
        'dte_upd',
    ];

    public static $detailAttrToOutput = [
        'cat',
        'dsc',
        'rnk',
        'chps',
        'updts',
    ];

    protected $hidden = [
        'slg',
        'mng_chp_cnt',
        'dte_upd',
    ];

    protected $appends = [
        'tbn',
        'chps',
        'updts'
    ];

    public function getDscAttribute($value)
    {
        return trim(str_replace("<br/>", "\n", $value));
    }

    public function getCatAttribute($value)
    {
        return explode(",", trim($value, ","));
    }

    public function getTbnAttribute()
    {
        $urlPartials = [
            Config::get('manga.thumbnail_url'),
            $this->slg,
            '_144x0.jpg'
        ];

        return implode('', $urlPartials);
    }

    public function getChpsAttribute()
    {
        return $this->mng_chp_cnt;
    }

    public function getUpdtsAttribute()
    {
        return strtotime($this->dte_upd);
    }
}
