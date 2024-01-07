<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    protected $fillable = [
        'people_id',
        'specialty',
        'register',
    ];

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }
}
