<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee_Model extends Model
{
    protected $fillable = ['full_name','email','id_position',
                           'id_head','date_of_employment',
                           'phone_number','salary','photo',
                           'admin_created_id','admin_updated_id'
                          ];
    protected $dates = ['date_of_employment','created_at','updated_at'];
    protected $table = 'employees_model';
}
