<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'province';
    protected $guarded = ['deleted_at', 'created_at', 'updated_at'];
}
