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

    public function check_terminate_approver()
    {
        return $this->hasMany(D_Memo_Approver::class, 'id_memo', 'id')->with(['employee_history' => function ($history) {
            $history->withCount(['position' => function ($position) {
                $position->where('position_name', 'TERMINATE');
            }]);
        }]);
    }

    public function approversPayment()
    {
        return $this->hasMany(D_Payment_Approver::class, 'id_memo', 'id');
    }

    public function approverPayment()
    {
        return $this->hasOne(D_Payment_Approver::class, 'id_memo', 'id');
    }

    public function approversPo()
    {
        return $this->hasMany(D_Po_Approver::class, 'id_memo', 'id');
    }

    public function approverPo()
    {
        return $this->hasOne(D_Po_Approver::class, 'id_memo', 'id');
    }

    public function payments()
    {
        return $this->hasMany(D_Memo_Payments::class, 'id_memo', 'id');
    }

    public function proposeemployee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id');
    }

    public function proposeemployee2()
    {
        return $this->belongsTo(Employee::class, 'id_employee2', 'id');
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

    public function ref_table()
    {
        return $this->hasOne(Ref_Type_Memo::class, 'id', 'id_type');
    }

    public static function getAllMemo( $search = null)
    {
        $memo = Self::select('*')
            ->where('doc_no','<>', null)
            ->orderBy('id', 'desc');

        if ($search) {
            $memo->where(function ($query) use ($search) {
                $query->where('doc_no', 'LIKE', '%' . $search . '%');
                $query->orWhere('background', 'LIKE', '%' . $search . '%');
                $query->orWhere('information', 'LIKE', '%' . $search . '%');
                $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                $query->orWhere('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('status', 'LIKE', '%' . $search . '%');
        });
    }
        return $memo;
    }

    public static function getMemoDetailDraftEdit($id, $formType = 'memo')
    {
        return Self::with(['approvers' => function ($approver) {
            return $approver->with(['employee' => function ($employee) {
                return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch');
                }]);
            }])->orderBy('idx', 'asc');
        }])
            ->with(['acknowledges' => function ($approver) use ($formType) {
                return $approver->with(['position_now' => function ($position_now) {
                    $position_now->with(['employee' => function ($employee) {
                        return $employee->select('id', 'firstname', 'lastname');
                    }])->with('position')->get();
                }])
                    ->where('type', $formType)
                    ->orderBy('id', 'asc');
                // return $approver->with(['employee' => function ($employee) {
                //     return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                //         return $position_now->with(['position' => function ($position) {
                //             return $position->with('department');
                //         }])->with('branch');
                //     }]);
                // }])->orderBy('id', 'asc');
            }])
            ->with(['histories' => function ($history) {
                return $history->orderBy('id', 'DESC');
            }])
            ->where('id', $id)->first();
    }

    public static function getMemoDetailEmployeePropose($id, $isTakeoverBranch = false)
    {
        $proposeEmployee = 'proposeemployee';
        if ($isTakeoverBranch) {
            $proposeEmployee = 'proposeemployee2';
        }
        return Self::with([$proposeEmployee => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                return $position_now->with(['position' => function ($position) {
                    return $position->with('department');
                }])->with('branch');
            }]);
        }])
            ->where('id', $id)->first();
    }

    public static function getPaymentDetailApprovers($id, $formType = 'payment')
    {
        return Self::with(['approversPayment' => function ($approver) {
            return $approver->with(['employee' => function ($employee) {
                return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch');
                }]);
            }])->orderBy('idx', 'asc');
        }])
            ->with(['acknowledges' => function ($approver) use ($formType) {
                return $approver->with(['position_now' => function ($position_now) {
                    $position_now->with(['employee' => function ($employee) {
                        return $employee->select('id', 'firstname', 'lastname');
                    }])->with('position')->get();
                }])
                    ->where('type', $formType)
                    ->orderBy('id', 'asc');
                // return $approver->with(['employee' => function ($employee) {
                //     return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                //         return $position_now->with(['position' => function ($position) {
                //             return $position->with('department');
                //         }])->with('branch');
                //     }]);
                // }])->orderBy('id', 'asc');
            }])
            ->with(['histories' => function ($history) {
                return $history->orderBy('id', 'DESC');
            }])->where('id', $id)->first();
    }

    public static function getPoDetailApprovers($id)
    {
        return Self::with(['approversPo' => function ($approver) {
            return $approver->with(['employee' => function ($employee) {
                return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch');
                }]);
            }])->orderBy('idx', 'asc');
        }])->with(['histories' => function ($history) {
            return $history->orderBy('id', 'DESC');
        }])->where('id', $id)->first();
    }

    public static function getMemoDetail($id)
    {
        $memo = Self::find($id);
        return Self::with(['approvers' => function ($approver) use ($memo) {
            return $approver->with(['employee' => function ($employee) use ($memo) {
                return $employee->select('id', 'firstname', 'lastname')->with(['emp_history' => function ($position_now) use ($memo) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch')
                        ->where('year_started', '<', $memo->propose_at)
                        ->where(function ($sub) use ($memo) {
                            $sub->where('year_finished', '>', $memo->propose_at)
                                ->orWhere('year_finished', null);
                        });
                    // ->orWhere(function ($query) use ($memo) {
                    //     $query->where('year_started', '<', $memo->propose_at)
                    //         ->orWhere('year_finished', null);
                    // });
                }]);
            }])->orderBy('idx', 'asc');
        }])
            ->with(['acknowledges' => function ($acknowledge) {
                return $acknowledge->with(['employee' => function ($employee) {
                    return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                        return $position_now->with(['position' => function ($position) {
                            return $position->with('department');
                        }])->with('branch');
                    }]);
                }])
                    ->where('type', 'memo')
                    ->orderBy('id', 'asc');
            }])
            ->with(['histories' => function ($history) {
                return $history->orderBy('id', 'DESC');
            }])
            ->with(['ref_table' => function ($reftable) {
                return $reftable;
            }])
            ->where('id', $id)->first();
    }

    public static function getPaymentDetail($id)
    {
        $memo = Self::find($id);
        return Self::with(['approversPayment' => function ($approver) use ($memo) {
            return $approver->with(['employee' => function ($employee) use ($memo) {
                return $employee->select('id', 'firstname', 'lastname')->with(['emp_history' => function ($emp_history) use ($memo) {
                    return $emp_history->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch')
                        ->where('year_started', '<', $memo->propose_payment_at)
                        ->where(function ($sub) use ($memo) {
                            $sub->where('year_finished', '>', $memo->propose_payment_at)
                                ->orWhere('year_finished', null);
                        });
                    // ->where(function ($query) use ($memo) {
                    //     $query->where('year_started', '<', $memo->propose_at)
                    //         ->where('year_finished', '>', $memo->propose_at);
                    // })
                    // ->orWhere(function ($query) use ($memo) {
                    //     $query->where('year_started', '<', $memo->propose_at)
                    //         ->orWhere('year_finished', null);
                    // });
                }]);
            }])->orderBy('idx', 'asc');
        }])
            ->with(['acknowledges' => function ($approver) {
                return $approver->with(['employee' => function ($employee) {
                    return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                        return $position_now->with(['position' => function ($position) {
                            return $position->with('department');
                        }])->with('branch');
                    }]);
                }])
                    ->where('type', 'payment')
                    ->orderBy('id', 'asc');
            }])
            ->with(['histories' => function ($history) {
                return $history->orderBy('id', 'DESC');
            }])
            ->with(['ref_table' => function ($reftable) {
                return $reftable;
            }])
            ->where('id', $id)->first();
    }

    public static function getPoDetail($id)
    {
        $memo = Self::find($id);
        return Self::with(['approversPo' => function ($approver) use ($memo) {
            return $approver->with(['employee' => function ($employee) use ($memo) {
                return $employee->select('id', 'firstname', 'lastname')->with(['emp_history' => function ($position_now) use ($memo) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch')
                        ->where('year_started', '<', $memo->propose_at)
                        ->where(function ($sub) use ($memo) {
                            $sub->where('year_finished', '>', $memo->propose_at)
                                ->orWhere('year_finished', null);
                        });
                    // ->where(function ($query) use ($memo) {
                    //     $query->where('year_started', '<', $memo->propose_at)
                    //         ->where('year_finished', '>', $memo->propose_at);
                    // })
                    // ->orWhere(function ($query) use ($memo) {
                    //     $query->where('year_started', '<', $memo->propose_at)
                    //         ->orWhere('year_finished', null);
                    // });
                }]);
            }])->orderBy('idx', 'asc');
        }])
            ->with(['acknowledges' => function ($approver) {
                return $approver->with(['employee' => function ($employee) {
                    return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                        return $position_now->with(['position' => function ($position) {
                            return $position->with('department');
                        }])->with('branch');
                    }]);
                }])
                    ->where('type', 'po')
                    ->orderBy('id', 'asc');
            }])
            ->with(['histories' => function ($history) {
                return $history->orderBy('id', 'DESC');
            }])
            ->with(['ref_table' => function ($reftable) {
                return $reftable;
            }])
            ->where('id', $id)->first();
    }

    public static function getMemoDetailWithCurrentApprover($id, $id_current_approver)
    {
        $memo = Self::find($id);
        return Self::with(['approvers' => function ($approver) use ($memo) {
            return $approver->with(['employee' => function ($employee) use ($memo) {
                return $employee->select('id', 'firstname', 'lastname')->with(['emp_history' => function ($position_now) use ($memo) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch')
                        ->where('year_started', '<', $memo->propose_at)
                        ->where(function ($sub) use ($memo) {
                            $sub->where('year_finished', '>', $memo->propose_at)
                                ->orWhere('year_finished', null);
                        });
                    // ->where(function ($query) use ($memo) {
                    //     $query->where('year_started', '<', $memo->propose_at)
                    //         ->where('year_finished', '>', $memo->propose_at);
                    // })
                    // ->orWhere(function ($query) use ($memo) {
                    //     $query->where('year_started', '<', $memo->propose_at)
                    //         ->orWhere('year_finished', null);
                    // });
                }]);
            }])->orderBy('idx', 'asc');
        }])
            ->with(['acknowledges' => function ($approver) {
                return $approver->with(['employee' => function ($employee) {
                    return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                        return $position_now->with(['position' => function ($position) {
                            return $position->with('department');
                        }])->with('branch');
                    }]);
                }])
                    ->where('type', 'memo')
                    ->orderBy('id', 'asc');
            }])
            ->with(['histories' => function ($history) {
                return $history->orderBy('id', 'DESC');
            }])->with(['approver' => function ($approver) use ($id_current_approver) {
                return $approver->where('id_employee', $id_current_approver);
            }])
            ->with(['ref_table' => function ($reftable) {
                return $reftable;
            }])
            ->where('id', $id)->first();
    }

    public static function getPaymentDetailWithCurrentApprover($id, $id_current_approver)
    {
        $memo = Self::find($id);
        return Self::with(['approversPayment' => function ($approver) use ($memo) {
            return $approver->with(['employee' => function ($employee) use ($memo) {
                return $employee->select('id', 'firstname', 'lastname')->with(['emp_history' => function ($position_now) use ($memo) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch')
                        ->where('year_started', '<', $memo->propose_payment_at)
                        ->where(function ($sub) use ($memo) {
                            $sub->where('year_finished', '>', $memo->propose_payment_at)
                                ->orWhere('year_finished', null);
                        });
                    // ->where(function ($query) use ($memo) {
                    //     $query->where('year_started', '<', $memo->propose_at)
                    //         ->where('year_finished', '>', $memo->propose_at);
                    // })
                    // ->orWhere(function ($query) use ($memo) {
                    //     $query->where('year_started', '<', $memo->propose_at)
                    //         ->orWhere('year_finished', null);
                    // });
                }]);
            }])->orderBy('idx', 'asc');
        }])
            ->with(['acknowledges' => function ($approver) {
                return $approver->with(['employee' => function ($employee) {
                    return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                        return $position_now->with(['position' => function ($position) {
                            return $position->with('department');
                        }])->with('branch');
                    }]);
                }])
                    ->where('type', 'payment')
                    ->orderBy('id', 'asc');
            }])
            ->with(['histories' => function ($history) {
                return $history->orderBy('id', 'DESC');
            }])->with(['approverPayment' => function ($approver) use ($id_current_approver) {
                return $approver->where('id_employee', $id_current_approver);
            }])
            ->with(['ref_table' => function ($reftable) {
                return $reftable;
            }])
            ->where('id', $id)->first();
    }

    public static function getPoDetailWithCurrentApprover($id, $id_current_approver)
    {
        $memo = Self::find($id);
        return Self::with(['approversPo' => function ($approver) use ($memo) {
            return $approver->with(['employee' => function ($employee) use ($memo) {
                return $employee->select('id', 'firstname', 'lastname')->with(['emp_history' => function ($position_now) use ($memo) {
                    return $position_now->with(['position' => function ($position) {
                        return $position->with('department');
                    }])->with('branch')
                        ->where('year_started', '<', $memo->propose_at)
                        ->where(function ($sub) use ($memo) {
                            $sub->where('year_finished', '>', $memo->propose_at)
                                ->orWhere('year_finished', null);
                        });
                    // ->where(function ($query) use ($memo) {
                    //     $query->where('year_started', '<', $memo->propose_at)
                    //         ->where('year_finished', '>', $memo->propose_at);
                    // })
                    // ->orWhere(function ($query) use ($memo) {
                    //     $query->where('year_started', '<', $memo->propose_at)
                    //         ->orWhere('year_finished', null);
                    // });
                }]);
            }])->orderBy('idx', 'asc');
        }])
            ->with(['acknowledges' => function ($approver) {
                return $approver->with(['employee' => function ($employee) {
                    return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                        return $position_now->with(['position' => function ($position) {
                            return $position->with('department');
                        }])->with('branch');
                    }]);
                }])
                    ->where('type', 'po')
                    ->orderBy('id', 'asc');
            }])
            ->with(['histories' => function ($history) {
                return $history->orderBy('id', 'DESC');
            }])->with(['approverPo' => function ($approver) use ($id_current_approver) {
                return $approver->where('id_employee', $id_current_approver);
            }])
            ->with(['ref_table' => function ($reftable) {
                return $reftable;
            }])
            ->where('id', $id)->first();
    }

    public static function getMemo($id_employee, $status, $search = null)
    {
        $memo = Self::select('*')->with(['proposeemployee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                return $position_now->with(['position' => function ($position) {
                    return $position->with('department');
                }])->with('branch');
            }]);
        }])
            ->orderBy('id', 'desc')
            ->where('status', '=', $status)
            ->where(function ($query) {
                $query->where('payment', '=', false);
                $query->orWhere('payment', '=', null);
            })
            ->where('id_employee', '=', $id_employee);
        if ($status != 'approve') {
            // $memo->whereNull('id_employee2');
        }

        if ($search) {
            $memo->where(function ($query) use ($search) {
                $query->where('doc_no', 'LIKE', '%' . $search . '%');
                $query->orWhere('background', 'LIKE', '%' . $search . '%');
                $query->orWhere('information', 'LIKE', '%' . $search . '%');
                $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                $query->orWhere('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
        return $memo;
    }

    public static function getMemoDraft($id_employee, $status, $search = null)
    {

        $memo = Self::select('*')
            ->orderBy('id', 'desc')
            ->where('status', '=', $status)
            ->where('status_payment', '=', $status)
            ->where('id_employee', '=', $id_employee);
        if ($status != 'approve') {
            // $memo->whereNull('id_employee2');
        }

        if ($search) {
            $memo->where(function ($query) use ($search) {
                $query->where('doc_no', 'LIKE', '%' . $search . '%');
                $query->orWhere('background', 'LIKE', '%' . $search . '%');
                $query->orWhere('information', 'LIKE', '%' . $search . '%');
                $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                $query->orWhere('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
        return $memo;
    }

    public static function getMemoTakeoverBranch($id_employee, $search = null)
    {
        $memo = Self::select('*')->with(['proposeemployee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                return $position_now->with(['position' => function ($position) {
                    return $position->with('department');
                }])->with('branch');
            }]);
        }])
            ->orderByRaw("FIELD(status_payment,'edit','submit','approve','reject','revisi')")
            ->where('status', '=', 'approve')
            ->where('id_employee2', '=', $id_employee);

        if ($search) {
            $memo->where(function ($query) use ($search) {
                $query->where('doc_no', 'LIKE', '%' . $search . '%');
                $query->orWhere('background', 'LIKE', '%' . $search . '%');
                $query->orWhere('information', 'LIKE', '%' . $search . '%');
                $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                $query->orWhere('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
        return $memo;
    }

    public static function getMemoTakeoverBranchNotif($id_employee)
    {
        $memo = Self::select('*')
            ->orderBy('id', 'desc')
            ->where('status', '=', 'approve')
            ->where('status_payment', '=', 'edit')
            ->where('id_employee2', '=', $id_employee);

        return $memo;
    }

    public static function getAllMemoPayment($id_employee, $tab, $search = null)
    {
        if ($tab == 'paid') {
            $memo = Self::select('*')
                ->orderBy('id', 'desc')
                ->where('status_payment', '=', 'approve')
                ->where('confirmed_payment_by', '=', $id_employee)
                ->whereNotNull('payment_at');

            if ($search) {
                $memo->where(function ($query) use ($search) {
                    $query->where('doc_no', 'LIKE', '%' . $search . '%');
                    $query->orWhere('background', 'LIKE', '%' . $search . '%');
                    $query->orWhere('information', 'LIKE', '%' . $search . '%');
                    $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                    $query->orWhere('title', 'LIKE', '%' . $search . '%');
                    $query->orWhere('status', 'LIKE', '%' . $search . '%');
                });
            }
            return $memo;
        } else {
            $memo = Self::select('*')->orderBy('id', 'desc')
                ->where('status_payment', '=', 'approve')
                ->where('confirmed_payment_by', '=', $id_employee)
                ->whereNull('payment_at');

            if ($search) {
                $memo->where(function ($query) use ($search) {
                    $query->where('doc_no', 'LIKE', '%' . $search . '%');
                    $query->orWhere('background', 'LIKE', '%' . $search . '%');
                    $query->orWhere('information', 'LIKE', '%' . $search . '%');
                    $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                    $query->orWhere('title', 'LIKE', '%' . $search . '%');
                    $query->orWhere('status', 'LIKE', '%' . $search . '%');
                });
            }
            return $memo;
        }
    }

    public static function getPayment($id_employee, $status, $search = null)
    {
        $memo = Self::select('*')->with(['proposeemployee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                return $position_now->with(['position' => function ($position) {
                    return $position->with('department');
                }])->with('branch');
            }]);
        }])
            ->orderBy('id', 'desc')
            ->where('status_payment', '=', $status)
            ->where('id_employee', '=', $id_employee)
            ->whereNull('id_employee2');

        if ($search) {
            $memo->where(function ($query) use ($search) {
                $query->where('doc_no', 'LIKE', '%' . $search . '%');
                $query->orWhere('background', 'LIKE', '%' . $search . '%');
                $query->orWhere('information', 'LIKE', '%' . $search . '%');
                $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                $query->orWhere('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
        return $memo;
    }

    public static function getPaymentTakeoverBranch($id_employee2, $status, $search = null)
    {
        $memo = Self::select('*')->with(['proposeemployee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                return $position_now->with(['position' => function ($position) {
                    return $position->with('department');
                }])->with('branch');
            }]);
        }])
            ->orderBy('id', 'desc')
            ->where('status_payment', '=', $status)
            ->where('id_employee2', '=', $id_employee2);

        if ($search) {
            $memo->where(function ($query) use ($search) {
                $query->where('doc_no', 'LIKE', '%' . $search . '%');
                $query->orWhere('background', 'LIKE', '%' . $search . '%');
                $query->orWhere('information', 'LIKE', '%' . $search . '%');
                $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                $query->orWhere('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
        return $memo;
    }

    public static function getPo($id_employee, $status, $search = null)
    {
        $memo = Self::select('*')->with(['proposeemployee' => function ($employee) {
            return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
                return $position_now->with(['position' => function ($position) {
                    return $position->with('department');
                }])->with('branch');
            }]);
        }])
            ->orderBy('id', 'desc')
            ->where('status_po', '=', $status)
            ->where('id_employee', '=', $id_employee)
            ->whereNull('id_employee2');

        if ($search) {
            $memo->where(function ($query) use ($search) {
                $query->where('doc_no', 'LIKE', '%' . $search . '%');
                $query->orWhere('background', 'LIKE', '%' . $search . '%');
                $query->orWhere('information', 'LIKE', '%' . $search . '%');
                $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                $query->orWhere('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
        return $memo;
    }

    public static function getMemoWithLastApprover($id_employee, $status, $search = null)
    {
        if ($status == 'approve') {
            // $memo = Self::select('*')->with(['proposeemployee' => function ($employee) {
            //     return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
            //         return $position_now->with(['position' => function ($position) {
            //             return $position->with('department');
            //         }])->with('branch');
            //     }]);
            // }])
            //     ->orderBy('id', 'desc')
            //     ->with(['approver' => function ($approver) use ($id_employee, $status) {
            //         return $approver->orderBy('idx', 'asc')->where('id_employee', $id_employee)->where('status', $status);
            //     }])
            //     ->whereHas(
            //         'approvers',
            //         function (Builder $query) use ($id_employee, $status) {
            //             $query->where('id_employee', $id_employee)->where('status', '=', $status);
            //         }
            //     );
            $proposeEmployee = DB::table(DB::raw('m_employees a'))
                ->select(DB::raw('a.id, a.firstname, a.lastname, b.year_started, b.year_finished, c.branch_name'))
                ->join(DB::raw('emp_history as b'), 'a.id', '=', 'b.id_employee')
                ->join(DB::raw('m_branches as c'), 'c.id', '=', 'b.id_branch');

            $memo =  DB::table(DB::raw('m_memos a'))
                ->selectRaw('a.*,c.id id_approver, c.type_approver, c.status status_approver, d.firstname, d.lastname, d.branch_name, d.year_started, d.year_finished')
                ->joinSub($proposeEmployee, 'd', function ($join) {
                    $join->on('a.id_employee', '=', 'd.id')
                        ->whereRaw('d.year_started < a.propose_at')
                        ->where(function ($sub) {
                            $sub->whereRaw('d.year_finished > a.propose_at')
                                ->orWhere('d.year_finished', null);
                        });
                })
                ->join(DB::raw('d_memo_approvers as c'), 'a.id', '=', 'c.id_memo')
                ->where('c.status', '=', $status)
                ->where('c.id_employee', $id_employee)
                ->orderBy('a.id', 'desc');

            if ($search) {
                $memo->where(function ($query) use ($search) {
                    $query->where('doc_no', 'LIKE', '%' . $search . '%');
                    $query->orWhere('background', 'LIKE', '%' . $search . '%');
                    $query->orWhere('information', 'LIKE', '%' . $search . '%');
                    $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                    $query->orWhere('title', 'LIKE', '%' . $search . '%');
                    $query->orWhere('a.status', 'LIKE', '%' . $search . '%');
                });
            }
            return $memo;
        } else {
            $lastApprover = DB::table('d_memo_approvers')
                ->select(DB::raw('MIN(idx) as min_idx, id_memo'))
                ->where('status', $status)
                ->groupBy('id_memo');

            $proposeEmployee = DB::table(DB::raw('m_employees a'))
                ->select(DB::raw('a.id, a.firstname, a.lastname, b.year_started, b.year_finished, c.branch_name'))
                ->join(DB::raw('emp_history as b'), 'a.id', '=', 'b.id_employee')
                ->join(DB::raw('m_branches as c'), 'c.id', '=', 'b.id_branch');

            $memo =  DB::table(DB::raw('m_memos a'))
                ->selectRaw('a.*,c.id id_approver, c.type_approver, c.status status_approver , d.firstname, d.lastname, d.branch_name, d.year_started, d.year_finished')
                // ->orderBy('id', 'desc')
                // ->with(['approver' => function ($approver) {
                //     return $approver->orderBy('idx', "ASC")->first();
                // }])
                ->joinSub($lastApprover, 'b', function ($join) {
                    $join->on('a.id', '=', 'b.id_memo');
                })
                ->joinSub($proposeEmployee, 'd', function ($join) {
                    $join->on('a.id_employee', '=', 'd.id')
                        ->whereRaw('d.year_started < a.propose_at')
                        ->where(function ($sub) {
                            $sub->whereRaw('d.year_finished > a.propose_at')
                                ->orWhere('d.year_finished', null);
                        });
                })
                ->join(DB::raw('d_memo_approvers as c'), 'a.id', '=', 'c.id_memo')
                ->whereColumn('b.min_idx', '=', 'c.idx')
                ->where('a.status', '=', $status)
                ->where('c.id_employee', $id_employee)
                ->orderBy('a.id', 'desc');

            if ($search) {
                $memo->where(function ($query) use ($search) {
                    $query->where('doc_no', 'LIKE', '%' . $search . '%');
                    $query->orWhere('background', 'LIKE', '%' . $search . '%');
                    $query->orWhere('information', 'LIKE', '%' . $search . '%');
                    $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                    $query->orWhere('title', 'LIKE', '%' . $search . '%');
                    $query->orWhere('a.status', 'LIKE', '%' . $search . '%');
                });
            }

            return $memo;
        }
    }
    // public static function getMemoWithLastApprover($id_employee, $status)
    // {
    //     if ($status == 'approve') {
    //         $memo = Self::select('*')
    //             ->orderBy('id', 'desc')
    //             // ->where('status', '=', 'submit')
    //             // ->orWhere('status', '=', $status)
    //             ->with(['approver' => function ($approver) use ($id_employee,$status) {
    //                 return $approver->orderBy('idx','asc')->where('id_employee', $id_employee)->where('status',$status);
    //             }])
    //             ->whereHas(
    //                 'approvers',
    //                 function (Builder $query) use ($id_employee, $status) {
    //                     $query->where('id_employee', $id_employee)->where('status', '=', $status);
    //                 }
    //             );
    //         return $memo;
    //     } else {
    //         $memo = Self::select('*')
    //             ->orderBy('id', 'desc')
    //             ->where('status', '=', $status)
    //             ->with(['approver' => function ($approver) use ($status) {
    //                 return $approver->orderBy('idx','asc')->where('status',$status)->min('idx');
    //             }])
    //             ->whereHas(
    //                 'approvers',
    //                 function (Builder $query) use ($id_employee, $status) {
    //                     $query->where('id_employee', $id_employee)->where('status', $status);
    //                 }
    //             );
    //     // ->with(['approvers' => function ($approver) {
    //     //     return $approver->where('id_employee', "ASC");
    //     // }]);

    //     // if ($search) {
    //     //     $memo->where(function ($query) use ($search) {
    //     //         $query->where('doc_no', 'LIKE', '%' . $search . '%');
    //     //         $query->orWhere('title', 'LIKE', '%' . $search . '%');
    //     //         $query->orWhere('status', 'LIKE', '%' . $search . '%');
    //     //     });
    //     // }
    //     return $memo;
    //     }
    // }

    public static function getMemoWithLastApproverRawQuery($id_employee, $status)
    {
        if ($status == 'approve') {
            $memo = Self::select('*')
                ->orderBy('id', 'desc')
                // ->where('status', '=', 'submit')
                // ->orWhere('status', '=', $status)
                ->with(['approver' => function ($approver) {
                    return $approver;
                }])
                ->whereHas(
                    'approvers',
                    function (Builder $query) use ($id_employee, $status) {
                        $query->where('id_employee', $id_employee)->where('status', '=', $status);
                    }
                )->get();
            return $memo;
        } else {
            $memo = DB::select(
                DB::raw("select a.*,c.id id_approver, c.type_approver from m_memos a join
            (
            select min(idx) as min_idx, id_memo from d_memo_approvers where status = '$status' group by id_memo
            ) b on a.id = b.id_memo
            join d_memo_approvers c on a.id = c.id_memo
            where b.min_idx = c.idx
            and a.status = '$status'
            and c.id_employee = $id_employee")
            );
            return $memo;
        }
    }

    public static function getMemoWithLastApproverRawQueryNotif($id_employee)
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

    public static function getMemoPaymentWithLastApprover($id_employee, $status, $search = null)
    {
        if ($status == 'approve') {
            // $memo = Self::select('*')->with(['proposeemployee' => function ($employee) {
            //     return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
            //         return $position_now->with(['position' => function ($position) {
            //             return $position->with('department');
            //         }])->with('branch');
            //     }]);
            // }])
            //     ->orderBy('id', 'desc')
            //     ->with(['approverPayment' => function ($approver) use ($id_employee, $status) {
            //         return $approver->orderBy('idx', 'asc')->where('id_employee', $id_employee)->where('status', $status);
            //     }])
            //     ->whereHas(
            //         'approversPayment',
            //         function (Builder $query) use ($id_employee, $status) {
            //             $query->where('id_employee', $id_employee)->where('status', '=', $status);
            //         }
            //     );
            $proposeEmployee = DB::table(DB::raw('m_employees a'))
                ->select(DB::raw('a.id, a.firstname, a.lastname, b.year_started, b.year_finished, c.branch_name'))
                ->join(DB::raw('emp_history as b'), 'a.id', '=', 'b.id_employee')
                ->join(DB::raw('m_branches as c'), 'c.id', '=', 'b.id_branch');

            $memo =  DB::table(DB::raw('m_memos a'))
            ->selectRaw('a.*,c.id id_approver, c.type_approver, c.status status_approver, d.firstname, d.lastname, d.branch_name,d.year_started, d.year_finished')
                ->joinSub($proposeEmployee, 'd', function ($join) {
                    $join->on('a.id_employee', '=', 'd.id')
                        ->whereRaw('d.year_started < a.propose_payment_at')
                        ->where(function ($sub) {
                            $sub->whereRaw('d.year_finished > a.propose_payment_at')
                                ->orWhere('d.year_finished', null);
                        });
                })
                ->join(DB::raw('d_payment_approver as c'), 'a.id', '=', 'c.id_memo')
                ->where('c.status', '=', $status)
                ->where('c.id_employee', $id_employee)
                ->orderBy('a.id', 'desc');

            if ($search) {
                $memo->where(function ($query) use ($search) {
                    $query->where('doc_no', 'LIKE', '%' . $search . '%');
                    $query->orWhere('background', 'LIKE', '%' . $search . '%');
                    $query->orWhere('information', 'LIKE', '%' . $search . '%');
                    $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                    $query->orWhere('title', 'LIKE', '%' . $search . '%');
                    $query->orWhere('a.status', 'LIKE', '%' . $search . '%');
                });
            }
            return $memo;
        } else {
            $lastApprover = DB::table('d_payment_approver')
                ->select(DB::raw('MIN(idx) as min_idx, id_memo'))
                ->where('status', $status)
                ->groupBy('id_memo');

            $proposeEmployee = DB::table(DB::raw('m_employees a'))
                ->select(DB::raw('a.id, a.firstname, a.lastname, b.year_started, b.year_finished, c.branch_name'))
                ->join(DB::raw('emp_history as b'), 'a.id', '=', 'b.id_employee')
                ->join(DB::raw('m_branches as c'), 'c.id', '=', 'b.id_branch');

            $memo =  DB::table(DB::raw('m_memos a'))
                ->selectRaw('a.*,c.id id_approver, c.type_approver, c.status status_approver, d.firstname, d.lastname, d.branch_name,
                d.year_started, d.year_finished')
                // ->orderBy('id', 'desc')
                // ->with(['approver' => function ($approver) {
                //     return $approver->orderBy('idx', "ASC")->first();
                // }])
                ->joinSub($lastApprover, 'b', function ($join) {
                    $join->on('a.id', '=', 'b.id_memo');
                })
                ->joinSub($proposeEmployee, 'd', function ($join) {
                    $join->on('a.id_employee', '=', 'd.id')
                        ->whereRaw('d.year_started < a.propose_payment_at')
                        ->where(function ($sub) {
                            $sub->whereRaw('d.year_finished > a.propose_payment_at')
                                ->orWhere('d.year_finished', null);
                        });
                })
                ->join(DB::raw('d_payment_approver as c'), 'a.id', '=', 'c.id_memo')
                ->whereColumn('b.min_idx', '=', 'c.idx')
                ->where('a.status_payment', '=', $status)
                ->where('c.id_employee', $id_employee)
                ->orderBy('a.id', 'desc');

            if ($search) {
                $memo->where(function ($query) use ($search) {
                    $query->where('doc_no', 'LIKE', '%' . $search . '%');
                    $query->orWhere('background', 'LIKE', '%' . $search . '%');
                    $query->orWhere('information', 'LIKE', '%' . $search . '%');
                    $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                    $query->orWhere('title', 'LIKE', '%' . $search . '%');
                    $query->orWhere('a.status', 'LIKE', '%' . $search . '%');
                });
            }

            return $memo;
        }
    }

    // public static function getMemoPaymentWithLastApprover($id_employee, $status)
    // {
    //     if ($status == 'approve') {
    //         $memo = Self::select('*')
    //             ->orderBy('id', 'desc')
    //             // ->where('status', '=', 'submit')
    //             // ->orWhere('status', '=', $status)
    //             ->with(['approverPayment' => function ($approver) use ($id_employee, $status) {
    //                 return $approver->orderBy('idx', 'asc')->where('id_employee', $id_employee)->where('status', $status);
    //             }])
    //             ->whereHas(
    //                 'approversPayment',
    //                 function (Builder $query) use ($id_employee, $status) {
    //                     $query->where('id_employee', $id_employee)->where('status', '=', $status);
    //                 }
    //             );
    //         return $memo;
    //     } else {
    //         $memo = Self::select('*')
    //             ->orderBy('id', 'desc')
    //             ->where('status_payment', '=', $status)
    //             ->with(['approverPayment' => function ($approver) use ($status) {
    //                 return $approver->orderBy('idx', 'asc')->where('status', $status)->min('idx');
    //             }])
    //             ->whereHas(
    //                 'approversPayment',
    //                 function (Builder $query) use ($id_employee, $status) {
    //                     $query->where('id_employee', $id_employee)->where('status', $status);
    //                 }
    //             );
    //         // ->with(['approvers' => function ($approver) {
    //         //     return $approver->where('id_employee', "ASC");
    //         // }]);

    //         // if ($search) {
    //         //     $memo->where(function ($query) use ($search) {
    //         //         $query->where('doc_no', 'LIKE', '%' . $search . '%');
    //         //         $query->orWhere('title', 'LIKE', '%' . $search . '%');
    //         //         $query->orWhere('status', 'LIKE', '%' . $search . '%');
    //         //     });
    //         // }
    //         return $memo;
    //     }
    // }

    public static function getMemoPaymentWithLastApproverRawQuery($id_employee, $status)
    {
        if ($status == 'approve') {
            $memo = Self::select('*')
                ->orderBy('id', 'desc')
                // ->where('status_payment','=','submit')
                // ->orWhere('status_payment', '=', $status)
                ->with(['approverPayment' => function ($approver) {
                    return $approver;
                }])
                ->whereHas(
                    'approversPayment',
                    function (Builder $query) use ($id_employee, $status) {
                        $query->where('id_employee', $id_employee)->where('status', '=', $status);
                    }
                )->get();
            return $memo;
        } else {
            $memo = DB::select(
                DB::raw("select a.*,c.id id_approver, c.type_approver from m_memos a join
            (
            select min(idx) as min_idx, id_memo from d_payment_approver where status = '$status' group by id_memo
            ) b on a.id = b.id_memo
            join d_payment_approver c on a.id = c.id_memo
            where b.min_idx = c.idx
            and a.status_payment = '$status'
            and c.id_employee = $id_employee")
            );
            return $memo;
        }
    }

    public static function getMemoPaymentWithLastApproverRawQueryNotif($id_employee)
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

    public static function getMemoPoWithLastApprover($id_employee, $status, $search = null)
    {
        if ($status == 'approve') {
            // $memo = Self::select('*')->with(['proposeemployee' => function ($employee) {
            //     return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
            //         return $position_now->with(['position' => function ($position) {
            //             return $position->with('department');
            //         }])->with('branch');
            //     }]);
            // }])
            //     ->orderBy('id', 'desc')
            //     ->with(['approverPo' => function ($approver) use ($id_employee, $status) {
            //         return $approver->orderBy('idx', 'asc')->where('id_employee', $id_employee)->where('status', $status);
            //     }])
            //     ->whereHas(
            //         'approversPo',
            //         function (Builder $query) use ($id_employee, $status) {
            //             $query->where('id_employee', $id_employee)->where('status', '=', $status);
            //         }
            //     );

            $proposeEmployee = DB::table(DB::raw('m_employees a'))
                ->select(DB::raw('a.id, a.firstname, a.lastname, b.year_started, b.year_finished, c.branch_name'))
                ->join(DB::raw('emp_history as b'), 'a.id', '=', 'b.id_employee')
                ->join(DB::raw('m_branches as c'), 'c.id', '=', 'b.id_branch');

            $memo =  DB::table(DB::raw('m_memos a'))
                ->selectRaw('a.*,c.id id_approver, c.type_approver, c.status status_approver, d.firstname, d.lastname, d.branch_name, d.year_started, d.year_finished')
                ->joinSub($proposeEmployee, 'd', function ($join) {
                    $join->on('a.id_employee', '=', 'd.id')
                        ->whereRaw('d.year_started < a.propose_at')
                        ->where(function ($sub) {
                            $sub->whereRaw('d.year_finished > a.propose_at')
                                ->orWhere('d.year_finished', null);
                        });
                })
                ->join(DB::raw('d_po_approver as c'), 'a.id', '=', 'c.id_memo')
                ->where('c.status', '=', $status)
                ->where('c.id_employee', $id_employee)
                ->orderBy('a.id', 'desc');

            if ($search) {
                $memo->where(function ($query) use ($search) {
                    $query->where('doc_no', 'LIKE', '%' . $search . '%');
                    $query->orWhere('background', 'LIKE', '%' . $search . '%');
                    $query->orWhere('information', 'LIKE', '%' . $search . '%');
                    $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                    $query->orWhere('title', 'LIKE', '%' . $search . '%');
                    $query->orWhere('a.status', 'LIKE', '%' . $search . '%');
                });
            }
            return $memo;
        } else {
            $lastApprover = DB::table('d_po_approver')
                ->select(DB::raw('MIN(idx) as min_idx, id_memo'))
                ->where('status', $status)
                ->groupBy('id_memo');

            $proposeEmployee = DB::table(DB::raw('m_employees a'))
                ->select(DB::raw('a.id, a.firstname, a.lastname, b.year_started, b.year_finished, c.branch_name'))
                ->join(DB::raw('emp_history as b'), 'a.id', '=', 'b.id_employee')
                ->join(DB::raw('m_branches as c'), 'c.id', '=', 'b.id_branch');

            $memo =  DB::table(DB::raw('m_memos a'))
                ->selectRaw('a.*,c.id id_approver, c.type_approver, c.status status_approver , d.firstname, d.lastname, d.branch_name, d.year_started, d.year_finished')
                // ->orderBy('id', 'desc')
                // ->with(['approver' => function ($approver) {
                //     return $approver->orderBy('idx', "ASC")->first();
                // }])
                ->joinSub($lastApprover, 'b', function ($join) {
                    $join->on('a.id', '=', 'b.id_memo');
                })
                ->joinSub($proposeEmployee, 'd', function ($join) {
                    $join->on('a.id_employee', '=', 'd.id')
                        ->whereRaw('d.year_started < a.propose_at')
                        ->where(function ($sub) {
                            $sub->whereRaw('d.year_finished > a.propose_at')
                                ->orWhere('d.year_finished', null);
                        });
                })
                ->join(DB::raw('d_po_approver as c'), 'a.id', '=', 'c.id_memo')
                ->whereColumn('b.min_idx', '=', 'c.idx')
                ->where('a.status_po', '=', $status)
                ->where('c.id_employee', $id_employee)
                ->orderBy('a.id', 'desc');

            if ($search) {
                $memo->where(function ($query) use ($search) {
                    $query->where('doc_no', 'LIKE', '%' . $search . '%');
                    $query->orWhere('background', 'LIKE', '%' . $search . '%');
                    $query->orWhere('information', 'LIKE', '%' . $search . '%');
                    $query->orWhere('conclusion', 'LIKE', '%' . $search . '%');
                    $query->orWhere('title', 'LIKE', '%' . $search . '%');
                    $query->orWhere('a.status', 'LIKE', '%' . $search . '%');
                });
            }

            return $memo;
        }
    }

    // public static function getMemoPoWithLastApprover($id_employee, $status)
    // {
    //     if ($status == 'approve') {
    //         $memo = Self::select('*')
    //             ->orderBy('id', 'desc')
    //             // ->where('status', '=', 'submit')
    //             // ->orWhere('status', '=', $status)
    //             ->with(['approverPo' => function ($approver) use ($id_employee, $status) {
    //                 return $approver->orderBy('idx', 'asc')->where('id_employee', $id_employee)->where('status', $status);
    //             }])
    //             ->whereHas(
    //                 'approversPo',
    //                 function (Builder $query) use ($id_employee, $status) {
    //                     $query->where('id_employee', $id_employee)->where('status', '=', $status);
    //                 }
    //             );
    //         return $memo;
    //     } else {
    //         $memo = Self::select('*')
    //             ->orderBy('id', 'desc')
    //             ->where('status_po', '=', $status)
    //             ->with(['approverPo' => function ($approver) use ($status) {
    //                 return $approver->orderBy('idx', 'asc')->where('status', $status)->min('idx');
    //             }])
    //             ->whereHas(
    //                 'approversPo',
    //                 function (Builder $query) use ($id_employee, $status) {
    //                     $query->where('id_employee', $id_employee)->where('status', $status);
    //                 }
    //             );
    //         // ->with(['approvers' => function ($approver) {
    //         //     return $approver->where('id_employee', "ASC");
    //         // }]);

    //         // if ($search) {
    //         //     $memo->where(function ($query) use ($search) {
    //         //         $query->where('doc_no', 'LIKE', '%' . $search . '%');
    //         //         $query->orWhere('title', 'LIKE', '%' . $search . '%');
    //         //         $query->orWhere('status', 'LIKE', '%' . $search . '%');
    //         //     });
    //         // }
    //         return $memo;
    //     }
    // }

    public static function getMemoPoWithLastApproverRawQuery($id_employee, $status)
    {
        if ($status == 'approve') {
            $memo = Self::select('*')
                ->orderBy('id', 'desc')
                // ->where('status_po', '=', 'submit')
                // ->orWhere('status_po', '=', $status)
                ->with(['approverPo' => function ($approver) {
                    return $approver;
                }])
                ->whereHas(
                    'approversPo',
                    function (Builder $query) use ($id_employee, $status) {
                        $query->where('id_employee', $id_employee)->where('status', '=', $status);
                    }
                )->get();
            return $memo;
        } else {
            $memo = DB::select(
                DB::raw("select a.*,c.id id_approver, c.type_approver from m_memos a join
            (
            select min(idx) as min_idx, id_memo from d_po_approver where status = '$status' group by id_memo
            ) b on a.id = b.id_memo
            join d_po_approver c on a.id = c.id_memo
            where b.min_idx = c.idx
            and a.status_po = '$status'
            and c.id_employee = $id_employee")
            );
            return $memo;
        }
    }

    public static function getMemoPoWithLastApproverRawQueryNotif($id_employee)
    {

        $memo = DB::select(
            DB::raw("select a.*,c.id id_approver, c.type_approver from m_memos a join
            (
            select min(idx) as min_idx, id_memo from d_po_approver where status = 'submit' group by id_memo
            ) b on a.id = b.id_memo
            join d_po_approver c on a.id = c.id_memo
            where b.min_idx = c.idx
            and a.status_po = 'submit'
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
