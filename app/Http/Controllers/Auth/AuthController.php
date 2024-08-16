<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\LoginFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct(User $user)
    {
    $this->user = $user;
    }

    /**
     * @return View
     */
    public function showLogin(){
        return view('login.login_form');

    }
    /**
     * @param App\Http\Requests\LoginFormRequest
     * $request
     */

    public function Login(LoginFormRequest $request){
        $credentials = $request->only('email','password');

        //アカウントがロックされていたら弾く
        $user = $this->user->getUserByEmail($credentials['email']);

        if(!is_null($user)){
            if($this->user->isAccountLocked($user)){
                return back()->withErrors([
                    'danger' => 'アカウントがロックされています。',
                 ]);           
            }

            if(Auth::attempt($credentials)){
                $request->session()->regenerate();
                //ログイン成功したらエラーカウントを0にする
                $this->user->resetErrorCount($user);

                return redirect()->route('home')->with('success','ログインが成功しました。');
            }

        //ログイン失敗したらエラーカウントを1増やす
        $user->error_count = $this->user->addErrorCount($user->error_count);
        //エラーカウントが6以上の場合はアカウントをロックする
        if($this->user->lockAccount($user)){
            return back()->withErrors([
                'danger' => 'アカウントがロックされました。解除したい場合、運営に連絡してください。',
            ]);   
        }
        $user->save();
        }


         return back()->withErrors([
            'danger' => 'メールアドレスかパスワードが間違っています。',
         ]);
    }

    /**
     * ユーザーをアプリケーションからログアウトさせる
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('danger','ログアウトしました。');
    }
}
