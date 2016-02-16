<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentsList extends Model
{
 	protected $table = 'studentslist';
 	protected $fillable = [
 	'ClassID',
 	'UserID'
 	];
}
