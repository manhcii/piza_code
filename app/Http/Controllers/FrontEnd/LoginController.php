<?php

namespace App\Http\Controllers\FrontEnd;

use App\Consts;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


class LoginController extends Controller
{

    public function index()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('frontend.home');
        }
        return $this->responseView('frontend.pages.user.login');
    }

    public function login(LoginRequest $request)
    {
        $url = $request->input('url') ?? route('home.default');

        if (Auth::guard('web')->check()) {
            return redirect()->route('home.default');
        }
        // dd($request->all());
        try {
            $email = $request->email;
            $password = $request->password;

            $attempt = Auth::guard('web')->attempt([
                'email' => $email,
                'password' => $password,
                'status' => Consts::USER_STATUS['active']
            ]);

            if (!$attempt) {
                abort(401, __('Login failed!'));
            }

            session()->flash('successMessage', 'Login successfully!');
            return $this->sendResponse(['url' => $url], 'success');
        } catch (Exception $ex) {
            abort(422, __($ex->getMessage()));
        }
    }



    public function logout()
    {

        Auth::guard('web')->logout();
        return redirect()->back();
    }
}
