<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeasurementSuggestion extends Model
{
    protected $fillable = ['advice', 'creator_id'];

    public $with = ['creator'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
