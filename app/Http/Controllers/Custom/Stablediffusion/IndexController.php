<?php

namespace App\Http\Controllers\Custom\Stablediffusion;

use App\Http\Controllers\Home;
use App\Services\OpenAiServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class IndexController extends Home
{
    public function __construct(OpenAiServiceInterface $openai_service){
        $this->set_global_userdata(true);
        $this->key = '4vx7YQi1knUPGnszIIpexJ2tDyaD7R5sX5fEyEMhjnBXbSOm6hRLZIY8wM91';
    }
	public function index() {
        $data = array('body' => 'stablediffusion/image/index','load_datatable'=>true);
        $data['search_data'] = null;
        $data['load_footer']=false;
        $data['title'] = 'Image Generator';
        return $this->viewcontroller($data);
    }
    public function genareteImage(Request $request) {
        $errMsgs = [
            'document_name.required' => 'Please enter document name',
            'promt.required' => 'Please enter your promt',
            'width.required' => 'Please enter width',
            'height.required' => 'Please enter width',
            'url.required' => 'Someting went wrong please try again',
        ];
        $validation_expression = [
            'document_name' => ['required'],
            'promt' => ['required'],
            'width' => ['required'],
            'height' => ['required'],
            'url' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if (!$validator->fails()) :
            $data = $validator->validate();
            $data['samples'] = $request->variation;
            $url = $request->url;
            $data['num_inference_steps'] = 20;
            $data['safety_checker'] = "no";
            $data['enhance_prompt'] = "yes";
            $data['seed'] = null;
            $data['guidance_scale'] = 7;
            $data['multi_lingual'] = 'no';
            $data['panorama'] = 'no';
            $data['self_attention'] = 'no';
            $data['upscale'] = "2048 × 3072";
            $data['embeddings_model'] = "embeddings_model_id";
            $data['webhook'] = null;
            $data['track_id'] = null;
            unset($data['document_name']);
            $response = $this->api_call($url,$data);
            $response_decoded = json_decode($response);
            dd($response_decoded);
        else :
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
    function api_call($endpoint,$post_data,$version='v3',$json_param=true,$content_type='application/json') {
        $url = "https://stablediffusionapi.com/api/".$version."/".$endpoint;
        $header=array("Content-Type: application/json");
        $agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:64.0) Gecko/20100101 Firefox/64.0';
        $post_data['key'] = $this->key;
        $post_data = $json_param ? json_encode($post_data) : $post_data;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, $agent);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        $st = curl_exec($curl);
        return $st;
    }

}
