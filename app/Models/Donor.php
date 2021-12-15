<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'donor';
    protected $guarded = ['deleted_at', 'created_at', 'updated_at'];
}
