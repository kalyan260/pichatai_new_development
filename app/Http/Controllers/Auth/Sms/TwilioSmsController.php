<?php
namespace App\Http\Controllers\Auth\Sms;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use Exception;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Stevebauman\Location\Facades\Location;

class TwilioSmsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->mobile != null):
            return redirect()->route('dashboard');
        else: 
            $clientIP = request()->ip();
            $data = Location::get($clientIP);
            $user_country = Country::where('name',$data->countryName)->first();
            $countries = Country::get();
            return view('auth.verify-phone',compact('countries','user_country'));
        endif;
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function send(Request $request)
    {
        $response = [ 'status' => false, 'msg' => 'Something Went Wrong Please Try Again', ];
        $errMsgs = [
            'mobile.required' => 'Please your mobile number'
        ];
        $validation_expression = [
            'mobile' => ['required', 'string', 'max:20', 'unique:users']
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if (!$validator->fails()) :
            $data = $validator->validate();
            $random_otp = rand(1000,9999);
            $message = 'Your OTP for PiChatAI is '.$random_otp;
            $user = Auth::user();
            try {
                $account_sid = env('TWILIO_SID');
                $auth_token = env('TWILIO_TOKEN');
                $twilio_number = env('TWILIO_FROM');
                $client = new Client($account_sid, $auth_token);
                $client->messages->create($data['mobile'], [ 'from' => $twilio_number, 'body' => $message]);
                User::find($user->id)->update(['mobile_otp' => $random_otp,'otp_send_time' => Carbon::now()->toDateTimeString()]);
                $response['status'] = true;
                $response['msg'] = 'Otp Send Successfully';
                return response()->json($response);
            } catch (Exception $e) {
                return response()->json($response);
            }
        else :
            $response['msg'] = $validator->errors();
            return response()->json($response);
        endif;
    }
    public function verifyOtp(Request $request)
    {
        $response = [ 'status' => false, 'msg' => 'Something Went Wrong Please Try Again', ];
        $errMsgs = [
            'otp.required' => 'Please your otp',
            'mobile.required' => 'Something Went Wrong Please Try Again',
            'country_code.required' => 'Something Went Wrong Please Try Again',
        ];
        $validation_expression = [
            'otp' => ['required'],
            'mobile' => ['required'],
            'country_code' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if (!$validator->fails()) :
            $data = $validator->validate();
            $user = Auth::user();

            $to = Carbon::createFromFormat('Y-m-d H:s:i', $user->otp_send_time);
            $from = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now()->toDateTimeString());
            $diff_in_minutes = $to->diffInMinutes($from);
            if($user->mobile_otp == $data['otp']) :
                $data['mobile'] = $data['country_code'].' '.$data['mobile'];
                User::find($user->id)->update(['mobile'=>$data['mobile']]);
                $response['status'] = true;
                $response['msg'] = 'Otp Verified Successfully';
                return response()->json($response);
            endif;
            $response['msg'] = 'Please Enter A Valid Otp';
            return response()->json($response);
        else :
            $response['msg'] = $validator->errors();
            return response()->json($response);
        endif;
    }
}
