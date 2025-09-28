<?php
namespace App\Http\Controllers\Auth\Social;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Carbon\Carbon;
use App\Providers\RouteServiceProvider;

class InstagramController extends Controller
{
    public function index()
    {
        $appId = config('services.instagram.client_id');
        $redirectUri = urlencode(config('services.instagram.redirect'));
        // return redirect()->to("https://api.instagram.com/oauth/authorize?app_id={$appId}&redirect_uri={$redirectUri}&scope=basic&response_type=code");
        return redirect()->to("https://api.instagram.com/oauth/authorize?client_id={$appId}&redirect_uri={$redirectUri}&scope=user_profile,user_media&response_type=code");
    }
    public function callback()
    {
        $code = $request->code;
        if (empty($code)) return redirect()->route('home')->with('error', 'Failed to login with Instagram.');

        $appId = config('services.instagram.client_id');
        $secret = config('services.instagram.client_secret');
        $redirectUri = config('services.instagram.redirect');    

        $client = new Client();

        // Get access token
        $response = $client->request('POST', 'https://api.instagram.com/oauth/access_token', [
            'form_params' => [
                'app_id' => $appId,
                'app_secret' => $secret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
                'code' => $code,
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            return redirect()->route('home')->with('error', 'Unauthorized login to Instagram.');
        }

        $content = $response->getBody()->getContents();
        $content = json_decode($content);

        $accessToken = $content->access_token;
        $userId = $content->user_id;

        // Get user info
        $response = $client->request('GET', "https://graph.instagram.com/me?fields=id,username,account_type&access_token={$accessToken}");

        $content = $response->getBody()->getContents();
        $oAuth = json_decode($content);
        dd($oAuth);
        // Get instagram user name 
        $username = $oAuth->username;

        // do your code here
    }
    // public function index()
    // {
    //     return Socialite::driver('instagram')->redirect();
    // }
    // public function callback()
    // {
    //     try {
    //         $user = Socialite::driver('instagram')->user();
    //         dd($user);
    //         if($user->email != null) {
    //             $existing_user = User::where('email',$user->email)->first();
    //             if($existing_user) {
    //                 $existing_user->update(['twitter_id' => $user->id]);
    //                 Auth::login($existing_user);
    //                 return redirect(RouteServiceProvider::HOME);
    //             } else {
    //                 $createUser = User::create([
    //                     'name' => $user->name != null || $user->name != '' ? $user->name : $user->email,
    //                     'email' => $user->email,
    //                     'twitter_id' => $user->id,
    //                     'password' => encrypt('Pass@123'),
    //                     'email_verified_at'=> Carbon::now()->toDateTimeString()
    //                 ]);
    //                 Auth::login($createUser);
    //                 return redirect(RouteServiceProvider::HOME);
    //             }
    //         }
    //         return redirect()->route('login')->with('error', 'Can\'t login, You have not linked your email address with twitter. So please use our alternative login method.')->withInput();
    //     } catch (Exception $exception) {
    //         return redirect()->route('login')->with('error', 'Can\'t login, please try again')->withInput();
    //     }
    // }
}