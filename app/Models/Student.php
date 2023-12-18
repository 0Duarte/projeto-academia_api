<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'date_birth',
        'cpf',
        'contact',
        'user_id',
        'city',
        'neighborhood',
        'number',
        'street',
        'state',
        'cep'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id'
    ];
}
