<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Comment;
use Tests\Unit\SerieTest;

class Serie extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function testedBy()
    {
        return SerieTest::class;
    }

    public function getFormatedCreatedAtAttribute(){
        if (!$this->created_at) return '';
        //PHP carbon
        $locale_date = $this->created_at->locale(config('app.locale'));
        return $locale_date->day . ' de ' . $locale_date->monthName . ' de ' . $locale_date->year;
    }

    public function getFormatedForHumansCreatedAtAttribute()
    {
        return optional($this->created_at)->diffForHumans(Carbon::now());
    }

    public function videos(){
        return $this -> hasMany(Video::class);
    }

    protected function imageUrl(): Attribute
    {
        return new Attribute(
            get: fn ($value) => is_null($this->image) ? 'series/placeholder.png':$this->image,
        );
    }
}
