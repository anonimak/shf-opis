<?php

namespace App\Models;

use Carbon\Carbon;
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
        return $this->belongsTo(Branch::class, 'id_branch', 'id')->select('id', 'branch_name');
    }

    public function position_now()
    {
        return $this->hasOne(Employee_History::class, 'id_employee', 'id')->select('id', 'id_employee', 'id_branch', 'id_position', 'year_started', 'year_finished')
            ->where(function ($query) {
                $query->where('year_started', '<', Carbon::now())
                      ->where('year_finished', '>', Carbon::now());
            })
            ->orWhere(function ($query) {
                $query->where('year_started', '<', Carbon::now())
                      ->where('year_finished', null);
            });
    }

    public function emp_history()
    {
        return $this->hasOne(Employee_History::class, 'id_employee', 'id');
    }

    public function overtake()
    {
        return $this->hasOne(Ref_Type_Memo::class, 'id_overtake_memo', 'id')->select('id', 'id_overtake_memo');
    }

    public function confirmedPayment()
    {
        return $this->hasOne(Ref_Type_Memo::class, 'id_confirmed_payment_by', 'id')->select('id', 'id_confirmed_payment_by');
    }

    public function position()
    {
        return $this->hasManyThrough(
            Ref_Position::class,
            Employee_History::class,
            'id_employee', // Foreign key on the environments table...
            'id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
        );
    }

    public static function getWithPositionNowById($memo, $isPaymentBranch = false)
    {
        $id_employee = ($isPaymentBranch) ? $memo->id_employee2 : $memo->id_employee;

        return Self::where('id', $id_employee)->with(['emp_history' => function ($emp_history) use ($memo) {
            return $emp_history->where('year_started', '<', $memo->created_at)->where('year_finished', '>', $memo->created_at)->orWhere('year_finished', null)->with(['position' => function ($position) {
                return $position->with('department');
            }])->with('branch');
        }])->first();
    }

    public static function getAllWithPositionNow()
    {
        return Self::select('firstname', 'lastname', 'id', 'nik')->with(['emp_history' => function ($emp_history) {
            return $emp_history->where('year_started', '<', Carbon::now())->where('year_finished', '>', Carbon::now())->orWhere('year_finished', null)->with(['position' => function ($position) {
                return $position->with('department');
            }])->with('branch');
        }])->get();
    }

    public static function getEmployees($search = null)
    {
        $employee = Self::select('*')
            ->orderBy('id', 'desc')->with('branch')->with('title');

        if ($search) {
            $employee->where('firstname', 'LIKE', '%' . $search . '%');
            $employee->orWhere('lastname', 'LIKE', '%' . $search . '%');
            $employee->orWhere('nik', 'LIKE', '%' . $search . '%');
        }
        return $employee;
    }
}
