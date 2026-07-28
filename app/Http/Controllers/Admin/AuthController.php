<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AuthOtpMail;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        if($request->reset == true){
            $request->session()->forget([
                'attempt-login-user-id',
                'otp',
                'otp-expires-at',
                'otp-form'
            ]);
        }
        return view('admin.login');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email|between:10,100',
            'password' => 'required|between:8,100'
        ]);

        $user = User::firstWhere('email',$credentials['email']);

        if($user && Hash::check($credentials['password'] , $user->password)){
            if(! $request->session()->has('otp')){
                $otp = random_int(100000,999999);
                try{
                    Mail::to($credentials['email'])->send(
                        new AuthOtpMail(
                            name : $user->name,
                            email : $user->email,
                            otp : $otp
                        )
                    );
                }catch (\Throwable $e) {
                    return back()->with('error',"Impossible d'envoyer le code OTP. Veuillez réessayer.");
                }
                $request->session()->put([
                    'attempt-login-user-id' => $user->id,
                    'otp' => Hash::make($otp),
                    'otp-expires-at' => now()->addMinutes(10),
                    'otp-form' => true, // UI
                ]);
            }
            return to_route('admin.login'); 
        }

        return back()->with('error','Email ou mot de passe incorrect.');
    }

    public function verification(Request $request)
    {
        // Security check if someone sent request directly to this endpoint
        if( ! $request->session()->has('attempt-login-user-id')) {
            return to_route('admin.login');
        }

        $validated = $request->validate([
            'otp' => 'required|string|min:6|max:6',
        ]);

        if( now()->gt($request->session()->get('otp-expires-at') )){
            return to_route('admin.login',['reset' => true]);
        }
        if( ! Hash::check($validated['otp'], $request->session()->get('otp'))){
            return back()->with("error",'Le code OTP est invalide.');
        }

        $request->session()->regenerate();

        $user = User::find( $request->session()->get('attempt-login-user-id') );
        Auth::login($user);

        $request->session()->forget([
            'attempt-login-user-id',
            'otp',
            'otp-expires-at',
            'otp-form'
        ]);

        return redirect()->intended('admin/dashboard');
    }


    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('admin.login')->with('success','Vous avez été déconnecté avec succès.');
    }
}
