<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'phone',
        'role',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
    ];

    public $with = ['school'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'id' => "integer",
            'school_id' => "integer",
        ];
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
