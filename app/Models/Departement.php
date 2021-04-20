<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_departements';

    use SoftDeletes;
}
