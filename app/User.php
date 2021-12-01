<?php

namespace App;

use App\Models\Employee;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'id_employee', 'role', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id');
    }

    public static function getUsersEmployeeInfo()
    {
        return Self::with(['employee' => function ($query) {
            return $query->with(['position_now' => function ($position_now) {
                return $position_now->with(['position' => function ($position) {
                    return $position->with('department')->first();
                }])->with('branch')->first();
            }])->with('overtake')->first();
        }])->where('id', auth()->id())->first();
    }

    public static function getUsers($id = null, $search = null)
    {
        $user = Self::select('*')
            ->orderBy('id', 'desc');

        if ($id) {
            $user->where('email', '!=', $id);
        }

        if ($search) {
            $user->where('name', 'LIKE', '%' . $search . '%')->orWhere('email', 'LIKE', '%' . $search . '%');
        }
        return $user;
    }
}
