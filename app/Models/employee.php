<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    protected $fillable = ['fullName','email','id_position',
                           'id_head','date_of_employment',
                           'phone_number','salary','photo',
                           'admin_created_id','admin_updated_id'
                          ];
}
