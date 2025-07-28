<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutStat extends Model
{
    protected $fillable = [
        'about_page_id', 'stat_name', 'stat_value', 'stat_desc'
    ];

    public function aboutPage()
    {
        return $this->belongsTo(AboutPage::class);
    }
}
