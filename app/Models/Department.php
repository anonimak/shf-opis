<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_departments';

    protected $fillable = ['department_name'];
    use SoftDeletes;

    public static function getDepartments($search = null)
    {
        $news = Self::select('*')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $news->where('department_name', 'LIKE', '%' . $search . '%');
        }
        return $news->paginate(10);
    }
}
