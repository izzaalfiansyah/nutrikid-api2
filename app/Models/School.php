<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ["name", "deleted_at"];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id' => "integer",
        ];
    }
}
