<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee_History extends Model
{
    protected $table = 'emp_history';
    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'id_branch', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Ref_Position::class, 'id_position', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id');
    }
}
