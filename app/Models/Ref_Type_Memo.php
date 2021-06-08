<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ref_Type_Memo extends Model
{
    protected $table = 'ref_type_memo';

    use SoftDeletes;
    protected $guarded = [];


    public function department()
    {
        return $this->belongsTo(Department::class, 'id_department', 'id');
    }

    public function ref_module_approver()
    {
        return $this->belongsTo(Ref_Module_Approver::class, 'id_ref_module_approver', 'id');
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
}
