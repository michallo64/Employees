<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    private $id;
    private $name;
    private $sex;
    private $age;

    protected $fillable = ['id', 'name', 'sex', 'age'];
}
