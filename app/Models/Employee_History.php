<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee_History extends Model
{
    protected $table = 'emp_history';
    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'id_branch', 'id')->select('id', 'branch_name', 'is_head');
    }

    public function position()
    {
        return $this->belongsTo(Ref_Position::class, 'id_position', 'id')->select('id', 'id_department', 'position_name');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id');
    }

    public static function position_now()
    {
        return Self::select('id', 'id_employee', 'id_branch', 'id_position', 'year_started', 'year_finished')->where('year_started', '<', Carbon::now())->where('year_finished', '>', Carbon::now())->orWhere('year_finished', null);
    }
}
