<?php

namespace App\Http\Controllers;

use App\Enums\RoleType;
use App\Http\Requests\Login;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('platform.auth.login');
    }

    public function login(Login $request)
    {
        try {
            $data  = $this->processLoginCycle($request);
            if ($data['key'] == 'fail')
                return back()->with('msg' , $data['msg']);
            else{
                return redirect()->route('platform.index')->with(['msg' => $data['msg']]);
            }
        } catch (\Exception $e){
            $this->log($e);
            return redirect()->route('login')->with('msg' , 'يوجد خطأ ما');
        }
    }

    private function processLoginCycle($request)
    {
        $user = User::where([
            'phone' => $request['phone'],
        ])->first();

        if (!$user) {
            return [
                'key' => 'fail',
                'msg' => 'هذا الرقم غير مسجل',
                'user' => []
            ];
        }

        if (!Hash::check($request['password'], $user->password)) {
            return [
                'key' => 'fail',
                'msg' => 'البيانات المدخلة غير صحيحة',
                'user' => []
            ];
        }

        if ($user->is_blocked) {
            return [
                'key' => 'fail',
                'msg' => 'لقد تم حظر حسابك من قبل الإدارة',
                'user' => $user
            ];
        }

        $sessionToken = session('device_token');

        if ($user->device_token && $user->device_token != $sessionToken) {
            return [
                'key'   => 'fail',
                'msg'   => 'لفد قمت بتسجيل الدخول بالفعل من جهاز اخر',
                'data'  =>[],
            ];
//            return redirect('/login')->withErrors(['session_error' => 'You have been logged out because your account is active on another device.']);
        }

        $credentials = ['phone' => $request->phone, 'password' => $request->password ];

        if(auth()->attempt($credentials, $remember = true)){
            $token = Str::random(60);
            if ($user->role == RoleType::STUDENT){
                $user->update(['session_id' => session()->getId()]);
                $user->update(['device_token' => $token]);
                session(['device_token' => $token]);
            }

            return [
                'key' => 'success',
                'msg' => 'تم تسجيل الدخول بنجاح',
                'user' => $user
            ];
        }
        else
            return ['key' => 'fail' , 'msg' => 'error'];
    }
}
