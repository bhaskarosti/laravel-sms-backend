<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName', 
        'lastName', 
        'sid', 
        'guardian', 
        'email', 
        'rollno', 
        'contact', 
        'gender', 
        'address', 
        'class', 
        'fee', 
        'image'
    ];
}
