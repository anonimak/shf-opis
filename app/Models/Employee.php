<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    protected $table = 'm_employees';
    protected $guarded = [];
    use SoftDeletes;

    public function title()
    {
        return $this->belongsTo(Ref_Title::class, 'id_title', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'id_branch', 'id');
    }

    public function emp_history()
    {
        return $this->morphMany(Employee_History::class, 'id_employee', 'id');
    }

    public function position()
    {
        return $this->hasManyThrough(
            Ref_Position::class,
            Employeel_History::class,
            'id_employee', // Foreign key on the environments table...
            'id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
        );
    }

    public static function getEmployees($search = null)
    {
        $employee = Self::select('*')
            ->orderBy('created_at', 'desc')->with('branch')->with('title');

        if ($search) {
            $employee->where('firstname', 'LIKE', '%' . $search . '%');
            $employee->orWhere('lastname', 'LIKE', '%' . $search . '%');
            $employee->orWhere('nik', 'LIKE', '%' . $search . '%');
        }
        return $employee;
    }
}
