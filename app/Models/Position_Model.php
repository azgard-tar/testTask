<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position_Model extends Model
{
    protected $fillable = ['title','admin_created_id',
                           'admin_updated_id',"created_at",
                           "updated_at"
                          ];
    protected $table = 'positions_model';
}
