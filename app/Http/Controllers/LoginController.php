<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle account login request
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email','password');
        $credentials['status']=1;
        if(!Auth::validate($credentials)) {
            return redirect()->route('login')
                ->withErrors(__('Invalid credential'));
        }
        $user = Auth::getProvider()
            ->retrieveByCredentials($credentials);
        Auth::login($user);
//        if($user->user_type!='admin'){
//            $websites = $user->websites
//                ->pluck('id')
//                ->implode(',');
//            if(!empty($websites))
//                $request->session()->put('user.website_ids', $websites);
//        }
        return $this->authenticated($request, $user);
    }

    /**
     * Handle response after user authenticated
     *
     * @param Request $request
     * @param Auth $user
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('dashboard');
    }
}
