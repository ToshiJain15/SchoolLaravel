<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    public function nav(){
        return view('nav_head');
    }
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
//     protected function authenticated(Request $request, $user) {
//         if ($user->role_id == 1) {
//             return redirect('/dashboard');
//         } else if ($user->role_id == 2) {
//             return redirect('/chart_list');
//         } else {
//             return redirect('/exam');
//         }
//    }

    // use AuthenticatesUsers;

    // /**
    //  * Where to redirect users after login.
    //  *
    //  * @var string
    //  */

    // protected function authenticated(Request $request, $user)
    // {
    //     if($user->hasRole('superadministrator')){
    //     return redirect('/admin');
    //     }
        
    //     if($user->hasRole('user')){
    //         return redirect('/user');
    //     }

    // }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout () {
        //logout user
        auth()->logout();
        // redirect to homepage
        return redirect('/login');
    }
}
