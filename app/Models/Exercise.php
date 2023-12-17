<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model
{
    use SoftDeletes;

    use HasFactory;
    protected $fillable = [
        'user_id',
        'description'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id'
    ];
}
