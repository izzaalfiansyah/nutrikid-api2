<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['nisn', 'name', 'birth_date', 'gender', 'deleted_at', 'school_id'];

    public $timestamps = false;

    public $with = ['school'];

    public $appends = ['age', 'age_month_total', 'age_month'];

    public function age(): Attribute
    {
        return Attribute::make(get: function () {
            return Carbon::parse($this->birth_date)->age;
        });
    }

    public function ageMonthTotal(): Attribute
    {
        return Attribute::make(get: function () {
            return $this->age_month + $this->age * 12;
        });
    }

    public function ageMonth(): Attribute
    {
        return Attribute::make(get: function () {
            return Carbon::now()->diff(Carbon::parse($this->birth_date))->months;
        });
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
