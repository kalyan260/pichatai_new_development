<?php
namespace App\Http\Controllers\Auth\Social;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Carbon\Carbon;
use App\Providers\RouteServiceProvider;

class TwitterController extends Controller
{
    public function index()
    {
        return Socialite::driver('twitter')->redirect();
    }
    public function callback()
    {
        try {
            $user = Socialite::driver('twitter')->user();
            if($user->email != null) {
                $existing_user = User::where('email',$user->email)->first();
                if($existing_user) {
                    $existing_user->update(['twitter_id' => $user->id]);
                    Auth::login($existing_user);
                    return redirect(RouteServiceProvider::HOME);
                } else {
                    $createUser = User::create([
                        'name' => $user->name != null || $user->name != '' ? $user->name : $user->email,
                        'email' => $user->email,
                        'twitter_id' => $user->id,
                        'password' => encrypt('Pass@123'),
                        'email_verified_at'=> Carbon::now()->toDateTimeString()
                    ]);
                    Auth::login($createUser);
                    return redirect(RouteServiceProvider::HOME);
                }
            }
            return redirect()->route('login')->with('error', 'Can\'t login, You have not linked your email address with twitter. So please use our alternative login method.')->withInput();
        } catch (Exception $exception) {
            return redirect()->route('login')->with('error', 'Can\'t login, please try again')->withInput();
        }
    }
}