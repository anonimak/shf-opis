<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Ref_Type_Memo extends Model
{
    protected $table = 'ref_type_memo';

    use SoftDeletes;
    protected $guarded = [];

    protected $hidden = [
        'laravel_through_key'
    ];


    public function department()
    {
        return $this->belongsTo(Department::class, 'id_department', 'id');
    }

    public function ref_module_approver()
    {
        return $this->belongsTo(Ref_Module_Approver::class, 'id_ref_module_approver', 'id');
    }

    public function ref_module_approver_detail()
    {
        return $this->hasManyThrough(
            Ref_Module_Approver_Detail::class,
            Ref_Module_Approver::class,
            'id', // Local key on the ref_module_approver table...
            'id_ref_module_approver', // Foreign key on the ref_module_approver table...
            'id_ref_module_approver', // Foreign key on the ref_type_memo table...
            'id' // Local key on the ref_module_approver table...
        );
    }

    public static function getRef_Type_Memo($search = null)
    {
        $typememo = Self::select('*')
            ->with(['department' => function ($query) {
                return $query->select('id', 'department_name')->orderBy('id', 'ASC');
            }])
            ->with(['ref_module_approver' => function ($query) {
                return $query->select('id', 'name')->orderBy('id', 'ASC');
            }])
            ->orderBy('created_at', 'desc');

        if ($search) {
            $typememo->where('name', 'LIKE', '%' . $search . '%');
        }
        return $typememo;
    }

    public static function get_ref_module_approver_detail_by_id($memo)
    {
        return Self::where('id', (int) $memo->id_type)->with(['ref_module_approver_detail' => function ($detail) use ($memo) {
            $detail->select(DB::raw("$memo->id as id_memo"), "emp_history.id_employee", DB::raw("'edit' AS status"), "idx")
                ->leftJoin('emp_history', 'd_module_approvers.id_ref_position', '=', 'emp_history.id_position')
                ->where('emp_history.year_started', '<', Carbon::now())
                ->where('emp_history.year_finished', '>', Carbon::now())
                ->orWhere('emp_history.year_finished', null);
            return $detail;
        }])->first();
    }
}
