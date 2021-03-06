<?php

namespace App\Http\Middleware;

use App\Models\Memo;
use App\Providers\RouteServiceProvider;
use App\User;
use Closure;
use Inertia\Inertia;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (auth()->user()->role == 0) {
            $user = User::getUsersEmployeeInfo();
            Inertia::share('userinfo', $user);

            // share notif
            Inertia::share('notif', function () {
                $user = User::find(auth()->user()->id);
                return [
                    'approval_memo' => count(Memo::getMemoWithLastApproverRawQueryNotif(auth()->user()->id_employee)),
                    'approval_memo_payment' => count(Memo::getMemoPaymentWithLastApproverRawQueryNotif(auth()->user()->id_employee)),
                    'approval_memo_po' => count(Memo::getMemoPoWithLastApproverRawQueryNotif(auth()->user()->id_employee)),
                    'memo_branch' => Memo::getMemoTakeoverBranchNotif(auth()->user()->id_employee)->count(),
                    'confirmed_paymentmemo' => Memo::getAllMemoPayment(auth()->user()->id_employee, 'unpaid')->count(),
                    'notification' => $user->unreadNotifications->take(5),
                    'unreadNotification' => $user->unreadNotifications->count(),

                ];
            });
            return $next($request);
        } else if (auth()->user()->role == 1) {
            return Redirect()->route(RouteServiceProvider::HOMEADMIN)->with('error', "You don't have access.");
        }

        return redirect(RouteServiceProvider::HOMESUPER)->with('error', "You don't have admin access.");
    }
}
