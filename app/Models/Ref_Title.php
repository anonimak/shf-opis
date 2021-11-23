<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ref_Title extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ref_titles';

    protected $fillable = [
        "title_name"
    ];

    use SoftDeletes;


    public function employee()
    {
        return $this->hasMany(Employee::class);
    }

    public static function getRef_Titles($search = null)
    {
        $title = Self::select('*')
            ->orderBy('id', 'desc');

        if ($search) {
            $title->where('title_name', 'LIKE', '%' . $search . '%');
        }
        return $title;
    }
}
