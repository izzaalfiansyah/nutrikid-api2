<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $fillable = ["student_id", "student_height", "student_weight", "student_bmi", "student_age", "student_age_month", "deleted_at", 'creator_id', 'created_at'];

    public $with = ['student', 'creator'];

    public $appends = ['student_age_month_total', 'z_score', 'status', 'suggestion_advices'];

    public function studentAgeMonthTotal(): Attribute
    {
        return Attribute::make(get: function () {
            return $this->student_age * 12 + $this->student_age_month;
        });
    }

    public function zScore(): Attribute
    {
        return Attribute::make(get: function () {
            return calculateZScore($this->student_bmi, $this->student_age_month_total, $this->student?->gender ?? "l");
        });
    }

    public function status(): Attribute
    {
        return Attribute::make(get: function () {
            return calculateStatus($this->z_score);
        });
    }

    public function suggestionAdvices(): Attribute
    {
        return Attribute::make(get: function () {
            return getSuggestionAdvices($this->z_score);
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    protected function casts(): array
    {
        return [
            'id' => "integer",
            'student_id' => "integer",
            'creator_id' => "integer",
            'student_height' => "float",
            'student_weight' => "float",
            'student_bmi' => "float",
            'student_age' => "integer",
            'student_age_month' => "integer",
        ];
    }
}
