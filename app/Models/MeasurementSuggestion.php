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

    protected function casts(): array
    {
        return [
            'id' => "integer",
            'creator_id' => "integer",
        ];
    }
}
