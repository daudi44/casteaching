<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tests\Unit\VideoTest;

class Video extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['published_at'];

    public static function testedBy()
    {
        return VideoTest::class;
    }

    //formated_published_at accesor
    public function getFormatedPublishedAtAttribute(){
        if (!$this->published_at) return '';
        //PHP carbon
        $locale_date = $this->published_at->locale(config('app.locale'));
        return $locale_date->day . ' de ' . $locale_date->monthName . ' de ' . $locale_date->year;
    }

    public function getFormatedForHumansPublishedAtAttribute()
    {
        return optional($this->published_at)->diffForHumans(Carbon::now());
    }

    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }

    public function setSerie(Serie $serie){
        $this->serie_id = $serie->id;
        $this->save();
        return $this;
    }

    public function setOwner(User $user)
    {
        $this->user_id = $user->id;
        $this->save();
        return $this;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
