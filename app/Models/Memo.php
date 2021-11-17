<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Memo extends Model
{
    protected $table = 'm_memos';
    protected $guarded = [];

    public function approvers()
    {
        return $this->hasMany(D_Memo_Approver::class, 'id_memo', 'id');
    }

    public function approver()
    {
        return $this->hasOne(D_Memo_Approver::class, 'id_memo', 'id');
    }

    public function approversPayment()
    {
        return $this->hasMany(D_Payment_Approver::class, 'id_memo', 'id');
    }

    public function approverPayment()
    {
        return $this->hasOne(D_Payment_Approver::class, 'id_memo', 'id');
    }

    public function payments(){
        return $this->hasMany(D_Memo_Payments::class, 'id_memo', 'id');
    }

    public function proposeemployee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id');
    }

    public function acknowledges()
    {
        return $this->hasMany(D_Memo_Acknowledge::class, 'id_memo', 'id');
    }

    public function attachment()
    {
        return $this->hasMany(D_Memo_Attachment::class, 'id_memo', 'id');
    }

    public function histories()
    {
        return $this->hasMany(D_Memo_History::class, 'id_memo', 'id');
    }

    public function latestHistory()
    {
        return $this->hasOne(D_Memo_History::class, 'id_memo', 'id')->latest('id');
    }

    public function ref_table() {
        return $this->hasOne(Ref_Type_Memo::class, 'id','id_type');
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
        }])->with(['acknowledges' => function ($approver) {
            return $approver->with(['employee' => function ($employee) {
                return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch');
                }]);
            }])->orderBy('id', 'asc');
        }])->with(['histories' => function ($history) {
            return $history->orderBy('id', 'DESC');
        }])
            ->where('id', $id)->first();
    }

    public static function getPaymentDetail($id)
    {
        return Self::with(['approversPayment' => function ($approver) {
            return $approver->with(['employee' => function ($employee) {
                return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch');
                }]);
            }])->orderBy('idx', 'asc');
        }])->with(['acknowledges' => function ($approver) {
            return $approver->with(['employee' => function ($employee) {
                return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch');
                }]);
            }])->orderBy('id', 'asc');
        }])->with(['histories' => function ($history) {
            return $history->orderBy('id', 'DESC');
        }])
            ->where('id', $id)->first();
    }

    public static function getMemoDetailWithCurrentApprover($id, $id_current_approver)
    {
        return Self::with(['approvers' => function ($approver) {
            return $approver->with(['employee' => function ($employee) {
                return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch');
                }]);
            }])->orderBy('idx', 'asc');
        }])->with(['acknowledges' => function ($approver) {
            return $approver->with(['employee' => function ($employee) {
                return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch');
                }]);
            }])->orderBy('id', 'asc');
        }])->with(['histories' => function ($history) {
            return $history->orderBy('id', 'DESC');
        }])->with(['approver' => function ($approver) use ($id_current_approver) {
            return $approver->where('id_employee', $id_current_approver);
        }])
            ->where('id', $id)->first();
    }

    public static function getPaymentDetailWithCurrentApprover($id, $id_current_approver)
    {
        return Self::with(['approversPayment' => function ($approver) {
            return $approver->with(['employee' => function ($employee) {
                return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch');
                }]);
            }])->orderBy('idx', 'asc');
        }])->with(['acknowledges' => function ($approver) {
            return $approver->with(['employee' => function ($employee) {
                return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch');
                }]);
            }])->orderBy('id', 'asc');
        }])->with(['histories' => function ($history) {
            return $history->orderBy('id', 'DESC');
        }])->with(['approverPayment' => function ($approver) use ($id_current_approver) {
            return $approver->where('id_employee', $id_current_approver);
        }])
            ->where('id', $id)->first();
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

    public static function getPayment($id_employee, $status, $search = null)
    {
        $memo = Self::select('*')
            ->orderBy('created_at', 'desc')
            ->where('status_payment', '=', $status)
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

    public static function getMemoWithLastApprover($id_employee, $status, $search = null)
    {
        $memo = Self::select('*')
            ->orderBy('created_at', 'desc')
            ->where('status', '=', $status)
            ->with(['approver' => function ($approver) {
                return $approver->orderBy('idx', "ASC")->first();
            }])
            ->whereHas(
                'approvers',
                function (Builder $query) use ($id_employee, $status) {
                    $query->where('id_employee', $id_employee)->where('status', '=', $status);
                }
            );
        // ->with(['approvers' => function ($approver) {
        //     return $approver->where('id_employee', "ASC");
        // }]);

        if ($search) {
            $memo->where(function ($query) use ($search) {
                $query->where('doc_no', 'LIKE', '%' . $search . '%');
                $query->orWhere('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
        return $memo;
    }

    public static function getMemoWithLastApproverRawQuery($id_employee)
    {

        $memo = DB::select(
            DB::raw("select a.*,c.id id_approver, c.type_approver from m_memos a join
            (
            select min(idx) as min_idx, id_memo from d_memo_approvers where status = 'submit' group by id_memo
            ) b on a.id = b.id_memo
            join d_memo_approvers c on a.id = c.id_memo
            where b.min_idx = c.idx
            and a.status = 'submit'
            and c.id_employee = $id_employee")
        );
        return $memo;
    }

    public static function getMemoPaymentWithLastApproverRawQuery($id_employee)
    {

        $memo = DB::select(
            DB::raw("select a.*,c.id id_approver, c.type_approver from m_memos a join
            (
            select min(idx) as min_idx, id_memo from d_payment_approver where status = 'submit' group by id_memo
            ) b on a.id = b.id_memo
            join d_payment_approver c on a.id = c.id_memo
            where b.min_idx = c.idx
            and a.status_payment = 'submit'
            and c.id_employee = $id_employee")
        );
        return $memo;
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($memo) { // before delete() method call this
            $memo->approvers()->each(function ($approver) {
                $approver->delete(); // <-- direct deletion
            });
            $memo->acknowledges()->each(function ($acknowledge) {
                $acknowledge->delete(); // <-- direct deletion
            });
            $memo->attachment()->each(function ($attachment) {
                $attachment->delete(); // <-- direct deletion
            });
        });
    }
}
