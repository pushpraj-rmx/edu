<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'stat_1_label',
        'stat_1_value',
        'stat_2_label',
        'stat_2_value',
        'stat_3_label',
        'stat_3_value',
    ];
}
