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

    public static function getEmployees($search = null)
    {
        $news = Self::select('*')
            ->orderBy('created_at', 'desc')->with('branch')->with('title');

        if ($search) {
            $news->where('firstname', 'LIKE', '%' . $search . '%');
            $news->orWhere('lastname', 'LIKE', '%' . $search . '%');
            $news->orWhere('nik', 'LIKE', '%' . $search . '%');
        }
        return $news->paginate(10);
    }
}
