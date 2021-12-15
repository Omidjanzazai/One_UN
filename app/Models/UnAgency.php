<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnAgency extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'un_agencies';
    protected $guarded = ['deleted_at', 'created_at', 'updated_at'];
}
