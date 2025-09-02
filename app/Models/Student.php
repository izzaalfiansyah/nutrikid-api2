<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['nisn', 'nisn', 'birth_date', 'gender', 'deleted_at',];

    public $with = ['school'];

    public $appends = ['age', 'age_month_total', 'age_month'];

    public function age(): Attribute
    {
        return Attribute::make(get: function () {
            return Carbon::parse($this->birth_date)->age;
        });
    }

    public function age_month_total(): Attribute
    {
        return Attribute::make(get: function () {
            return Carbon::parse($this->birth_date)->diff(Carbon::now())->m;
        });
    }

    public function age_month(): Attribute
    {
        return Attribute::make(get: function () {
            return $this->age_month_total - ($this->age * 12);
        });
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
