<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    protected $table = 'm_memos';
    protected $guarded = [];

    public function approvers()
    {
        return $this->hasMany(D_Memo_Approver::class, 'id_memo', 'id');
    }

    public static function getMemoDetail($id)
    {
        return Self::with(['approvers' => function ($approver) {
            return $approver->with(['employee' => function ($employee) {
                return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch');
                }]);
            }])->orderBy('idx', 'asc');
        }])->where('id', $id)->first();
    }

    public static function getMemo($id_employee, $status, $search = null)
    {
        $memo = Self::select('*')
            ->orderBy('created_at', 'desc')
            ->where('status', '=', $status)
            ->where('id_employee', '=', $id_employee);

        if ($search) {
            $memo->where(function ($query) use ($search) {
                $query->where('doc_no', 'LIKE', '%' . $search . '%');
                $query->orWhere('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
        return $memo;
    }
}
