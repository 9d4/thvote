<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_id',
        'candidate_id',
    ];

    public function voterUsername() {
        return $this->belongsTo(User::class,'user_id', 'id')->first()->username;
    }
}
