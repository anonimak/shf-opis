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

    // public function acknowledges()
    // {
    //     return $this->hasMany(D_Memo_Acknowledge::class, 'id_memo', 'id');
    // }

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

    public static function getMemoDetailDraftEdit($id)
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
            // ->with(['acknowledges' => function ($approver) {
            //     return $approver->with(['employee' => function ($employee) {
            //         return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
            //             return $position_now->with(['position' => function ($position) {
            //                 return $position->with('department');
            //             }])->with('branch');
            //         }]);
            //     }])->orderBy('id', 'asc');
            // }])
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

    public static function getPaymentDetailApprovers($id)
    {
        return Self::with(['approversPayment' => function ($approver) {
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
                        ->where(function ($query) use ($memo) {
                            $query->where('year_started', '<', $memo->propose_at)
                                ->where('year_finished', '>', $memo->propose_at);
                        })
                        ->orWhere(function ($query) use ($memo) {
                            $query->where('year_started', '<', $memo->propose_at)
                                ->orWhere('year_finished', null);
                        });
                }]);
            }])->orderBy('idx', 'asc');
        }])
            // ->with(['acknowledges' => function ($approver) {
            //     return $approver->with(['employee' => function ($employee) {
            //         return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
            //             return $position_now->with(['position' => function ($position) {
            //                 return $position->with('department');
            //             }])->with('branch');
            //         }]);
            //     }])->orderBy('id', 'asc');
            // }])
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
                        ->where(function ($query) use ($memo) {
                            $query->where('year_started', '<', $memo->propose_at)
                                ->where('year_finished', '>', $memo->propose_at);
                        })
                        ->orWhere(function ($query) use ($memo) {
                            $query->where('year_started', '<', $memo->propose_at)
                                ->orWhere('year_finished', null);
                        });
                }]);
            }])->orderBy('idx', 'asc');
        }])
            // ->with(['acknowledges' => function ($approver) {
            //     return $approver->with(['employee' => function ($employee) {
            //         return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
            //             return $position_now->with(['position' => function ($position) {
            //                 return $position->with('department');
            //             }])->with('branch');
            //         }]);
            //     }])->orderBy('id', 'asc');
            // }])
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
                        ->where(function ($query) use ($memo) {
                            $query->where('year_started', '<', $memo->propose_at)
                                ->where('year_finished', '>', $memo->propose_at);
                        })
                        ->orWhere(function ($query) use ($memo) {
                            $query->where('year_started', '<', $memo->propose_at)
                                ->orWhere('year_finished', null);
                        });
                }]);
            }])->orderBy('idx', 'asc');
        }])
            // ->with(['acknowledges' => function ($approver) {
            //     return $approver->with(['employee' => function ($employee) {
            //         return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
            //             return $position_now->with(['position' => function ($position) {
            //                 return $position->with('department');
            //             }])->with('branch');
            //         }]);
            //     }])->orderBy('id', 'asc');
            // }])
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
                        ->where(function ($query) use ($memo) {
                            $query->where('year_started', '<', $memo->propose_at)
                                ->where('year_finished', '>', $memo->propose_at);
                        })
                        ->orWhere(function ($query) use ($memo) {
                            $query->where('year_started', '<', $memo->propose_at)
                                ->orWhere('year_finished', null);
                        });
                }]);
            }])->orderBy('idx', 'asc');
        }])
            // ->with(['acknowledges' => function ($approver) {
            //     return $approver->with(['employee' => function ($employee) {
            //         return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
            //             return $position_now->with(['position' => function ($position) {
            //                 return $position->with('department');
            //             }])->with('branch');
            //         }]);
            //     }])->orderBy('id', 'asc');
            // }])
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
                        ->where(function ($query) use ($memo) {
                            $query->where('year_started', '<', $memo->propose_at)
                                ->where('year_finished', '>', $memo->propose_at);
                        })
                        ->orWhere(function ($query) use ($memo) {
                            $query->where('year_started', '<', $memo->propose_at)
                                ->orWhere('year_finished', null);
                        });
                }]);
            }])->orderBy('idx', 'asc');
        }])
            // ->with(['acknowledges' => function ($approver) {
            //     return $approver->with(['employee' => function ($employee) {
            //         return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
            //             return $position_now->with(['position' => function ($position) {
            //                 return $position->with('department');
            //             }])->with('branch');
            //         }]);
            //     }])->orderBy('id', 'asc');
            // }])
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
                        ->where(function ($query) use ($memo) {
                            $query->where('year_started', '<', $memo->propose_at)
                                ->where('year_finished', '>', $memo->propose_at);
                        })
                        ->orWhere(function ($query) use ($memo) {
                            $query->where('year_started', '<', $memo->propose_at)
                                ->orWhere('year_finished', null);
                        });
                }]);
            }])->orderBy('idx', 'asc');
        }])
            // ->with(['acknowledges' => function ($approver) {
            //     return $approver->with(['employee' => function ($employee) {
            //         return $employee->select('id', 'firstname', 'lastname')->with(['position_now' => function ($position_now) {
            //             return $position_now->with(['position' => function ($position) {
            //                 return $position->with('department');
            //             }])->with('branch');
            //         }]);
            //     }])->orderBy('id', 'asc');
            // }])
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
        $memo = Self::select('*')
            ->orderBy('id', 'desc')
            ->where('status', '=', $status)
            ->where('id_employee', '=', $id_employee);
        if ($status != 'approve') {
            // $memo->whereNull('id_employee2');
        }

        if ($search) {
            $memo->where(function ($query) use ($search) {
                $query->where('doc_no', 'LIKE', '%' . $search . '%');
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
            ->orderBy('id', 'desc')
            ->where('status', '=', 'approve')
            ->where('id_employee2', '=', $id_employee);

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
            ->orderBy('id', 'desc')
            ->where('status_payment', '=', $status)
            ->where('id_employee', '=', $id_employee)
            ->whereNull('id_employee2');

        if ($search) {
            $memo->where(function ($query) use ($search) {
                $query->where('doc_no', 'LIKE', '%' . $search . '%');
                $query->orWhere('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
        return $memo;
    }

    public static function getPaymentTakeoverBranch($id_employee2, $status, $search = null)
    {
        $memo = Self::select('*')
            ->orderBy('id', 'desc')
            ->where('status_payment', '=', $status)
            ->where('id_employee2', '=', $id_employee2);

        if ($search) {
            $memo->where(function ($query) use ($search) {
                $query->where('doc_no', 'LIKE', '%' . $search . '%');
                $query->orWhere('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
        return $memo;
    }

    public static function getPo($id_employee, $status, $search = null)
    {
        $memo = Self::select('*')
            ->orderBy('id', 'desc')
            ->where('status_po', '=', $status)
            ->where('id_employee', '=', $id_employee)
            ->whereNull('id_employee2');

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
            ->orderBy('id', 'desc')
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

    public static function getMemoPoWithLastApproverRawQuery($id_employee)
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
            // $memo->acknowledges()->each(function ($acknowledge) {
            //     $acknowledge->delete(); // <-- direct deletion
            // });
            $memo->attachment()->each(function ($attachment) {
                $attachment->delete(); // <-- direct deletion
            });
        });
    }
}
