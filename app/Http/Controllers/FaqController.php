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
use App\Models\Faq;
use Illuminate\Support\Carbon;


class FaqController extends Home
{
    public function __construct()
    {
        $this->set_global_userdata(true,['Admin','Member'],['Manager']);
    }

    public function index()
    {
        $payment_config = $this->get_payment_config();
        $has_team_access = has_module_access($this->module_id_team_member, $this->module_ids, $this->is_admin);
        $items = Faq::orderBy('id', 'desc')->paginate(20);
        $data = array(
            'body'=>'subscription/faq/index',
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
        $data['body'] = 'subscription/faq/add';
        $data['modules'] = $this->get_modules($team_package);
        $data['payment_config'] = $this->get_payment_config();
        $data['validity_types'] = $this->get_validity_types();
        return $this->viewcontroller($data);
    }
    public function save(Request $request){
        $errMsgs = [
            'question.required' => 'Please Enter Question',
            'answar.required' => 'Please Enter Answar',
        ];
        $validation_expression = [
            'question' => ['required', 'max:190'],
            'answar' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if (!$validator->fails()) :
            $data = $validator->validate();
            $item = Faq::create($data);
            if ($item) :
                return redirect()->route('faq.view')->with('success', 'Successfully Created!');
            endif;
            return redirect()->back()->with('error', 'Can\'t Create, Please Try Again!')->withInput();
        else :
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
    public function edit($id){
        $team_package = isset(request()->type) && request()->type=='team';
        $data['has_team_access'] = has_module_access($this->module_id_team_member, $this->module_ids, $this->is_admin);
        $data['body'] = 'subscription/faq/edit';
        $data['modules'] = $this->get_modules($team_package);
        $data['payment_config'] = $this->get_payment_config();
        $data['validity_types'] = $this->get_validity_types();
        $data['item'] = Faq::find($id);
        return $this->viewcontroller($data);
    }
    public function update(Request $request,$id){
        $errMsgs = [
            'question.required' => 'Please Enter Question',
            'answar.required' => 'Please Enter Answar',
        ];
        $validation_expression = [
            'question' => ['required', 'max:190'],
            'answar' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if (!$validator->fails()) :
            $data = $validator->validate();
            $item = Faq::find($id)->update($data);
            if ($item) :
                return redirect()->route('faq.view')->with('success', 'Successfully Updated!');
            endif;
            return redirect()->back()->with('error', 'Can\'t Updated, Please Try Again!')->withInput();
        else :
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
    public function delete($id) {
        $item = Faq::where('id', $id)->first();
        if ($item) :
            if ($item->delete()) :
                return redirect()->back()->with('success', 'Faq Successfully Deleted!');
            else :
                return redirect()->back()->with('error', 'Can\'t Deleted Faq Anyway, Please try again!');
            endif;
        endif;
        return redirect()->back()->with('error', 'Faq Not Found!');
    }
}
