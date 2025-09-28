<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Home;
use App\Jobs\SendEmailJob;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Form;
use App\Models\Package;
use App\Models\Policy;
use Illuminate\Support\Carbon;


class PolicyController extends Home
{
    public function __construct()
    {
        $this->set_global_userdata(true,['Admin','Member'],['Manager']);
    }

    public function index()
    {
        $payment_config = $this->get_payment_config();
        $has_team_access = has_module_access($this->module_id_team_member, $this->module_ids, $this->is_admin);
        $items = Policy::orderBy('id', 'desc')->paginate(20);
        $data = array(
            'body'=>'subscription/policy/index',
            'payment_config'=>$payment_config,
            'load_datatable'=>true,
            'has_team_access'=>$has_team_access,
            'items' => $items
        );
        return $this->viewcontroller($data);
    }
    public function add(){
        $team_package = isset(request()->type) && request()->type=='team';
        $data['has_team_access'] = has_module_access($this->module_id_team_member, $this->module_ids, $this->is_admin);
        $data['body'] = 'subscription/policy/add';
        $data['modules'] = $this->get_modules($team_package);
        $data['payment_config'] = $this->get_payment_config();
        $data['validity_types'] = $this->get_validity_types();
        return $this->viewcontroller($data);
    }
    public function save(Request $request){
        $errMsgs = [
            'name.required' => 'Please Enter Name',
            'url.required' => 'Please Enter Url',
            'content.required' => 'Please Enter Content',
        ];
        $validation_expression = [
            'name' => ['required', 'max:190'],
            'url' => ['required', 'max:190', 'unique:policies'],
            'content' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if (!$validator->fails()) :
            $data = $validator->validate();
            $item = Policy::create($data);
            if ($item) :
                return redirect()->route('policy.view')->with('success', 'Successfully Created!');
            endif;
            return redirect()->back()->with('error', 'Can\'t Create, Please Try Again!')->withInput();
        else :
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
    public function edit($id){
        $team_package = isset(request()->type) && request()->type=='team';
        $data['has_team_access'] = has_module_access($this->module_id_team_member, $this->module_ids, $this->is_admin);
        $data['body'] = 'subscription/policy/edit';
        $data['modules'] = $this->get_modules($team_package);
        $data['payment_config'] = $this->get_payment_config();
        $data['validity_types'] = $this->get_validity_types();
        $data['item'] = Policy::find($id);
        return $this->viewcontroller($data);
    }
    public function update(Request $request,$id){
        $errMsgs = [
            'name.required' => 'Please Enter Name',
            'content.required' => 'Please Enter Content',
        ];
        $validation_expression = [
            'name' => ['required', 'max:190'],
            'content' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if (!$validator->fails()) :
            $data = $validator->validate();
            $item = Policy::find($id)->update($data);
            if ($item) :
                return redirect()->route('policy.view')->with('success', 'Successfully Updated!');
            endif;
            return redirect()->back()->with('error', 'Can\'t Updated, Please Try Again!')->withInput();
        else :
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
    public function delete($id) {
        $item = Policy::where('id', $id)->first();
        if ($item) :
            if ($item->delete()) :
                return redirect()->back()->with('success', 'policy Successfully Deleted!');
            else :
                return redirect()->back()->with('error', 'Can\'t Deleted policy Anyway, Please try again!');
            endif;
        endif;
        return redirect()->back()->with('error', 'policy Not Found!');
    }
}
