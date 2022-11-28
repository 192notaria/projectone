<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roleshaspermissions extends Model
{
    use HasFactory;
    public $table = "role_has_permissions";
    public $timestamps = false;
    protected $fillable = [
        "permission_id",
        "role_id",
    ];
}
