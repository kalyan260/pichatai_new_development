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
use App\Models\Blog;
use Illuminate\Support\Carbon;


class BlogController extends Home
{
    public function __construct()
    {
        $this->set_global_userdata(true,['Admin','Member'],['Manager']);
    }

    public function index()
    {
        $payment_config = $this->get_payment_config();
        $has_team_access = has_module_access($this->module_id_team_member, $this->module_ids, $this->is_admin);
        $items = Blog::orderBy('id', 'desc')->paginate(20);
        $data = array(
            'body'=>'subscription/blog/index',
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
        $data['body'] = 'subscription/blog/add';
        $data['modules'] = $this->get_modules($team_package);
        $data['payment_config'] = $this->get_payment_config();
        $data['validity_types'] = $this->get_validity_types();
        return $this->viewcontroller($data);
    }
    public function save(Request $request){
        $errMsgs = [
            'name.required' => 'Please Enter Name',
            'photo.required' => 'Please Select Image',
            'description.required' => 'Please Select Image',
        ];
        $validation_expression = [
            'name' => ['required', 'max:190'],
            'photo' => ['required'],
            'description' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if (!$validator->fails()) :
            $data = $validator->validate();
            if($request->photo) {
                $filename = 'img_' . rand(0, 99999) . Carbon::now()->timestamp . "." . $request->photo->extension();
                $request->photo->storeAs('public', $filename);
            }
            $data['photo'] = $filename;
            $item = Blog::create($data);
            if ($item) :
                return redirect()->route('blog.view')->with('success', 'Successfully Created!');
            endif;
            return redirect()->back()->with('error', 'Can\'t Create, Please Try Again!')->withInput();
        else :
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
    public function edit($id){
        $team_package = isset(request()->type) && request()->type=='team';
        $data['has_team_access'] = has_module_access($this->module_id_team_member, $this->module_ids, $this->is_admin);
        $data['body'] = 'subscription/blog/edit';
        $data['modules'] = $this->get_modules($team_package);
        $data['payment_config'] = $this->get_payment_config();
        $data['validity_types'] = $this->get_validity_types();
        $data['item'] = Blog::find($id);
        return $this->viewcontroller($data);
    }
    public function update(Request $request,$id){
        $errMsgs = [
            'name.required' => 'Please Enter Name',
            'description.required' => 'Please Select Image',
        ];
        $validation_expression = [
            'name' => ['required', 'max:190'],
            'description' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validation_expression, $errMsgs);
        if (!$validator->fails()) :
            $data = $validator->validate();
            if($request->photo) {
                $filename = 'img_' . rand(0, 99999) . Carbon::now()->timestamp . "." . $request->photo->extension();
                $request->photo->storeAs('public', $filename);
                $data['photo'] = $filename;
            }
            $item = Blog::find($id)->update($data);
            if ($item) :
                return redirect()->route('blog.view')->with('success', 'Successfully Updated!');
            endif;
            return redirect()->back()->with('error', 'Can\'t Updated, Please Try Again!')->withInput();
        else :
            return redirect()->back()->withErrors($validator->errors())->withInput();
        endif;
    }
    public function delete($id) {
        $item = Blog::where('id', $id)->first();
        if ($item) :
            if ($item->delete()) :
                return redirect()->back()->with('success', 'Blog Successfully Deleted!');
            else :
                return redirect()->back()->with('error', 'Can\'t Deleted Blog Anyway, Please try again!');
            endif;
        endif;
        return redirect()->back()->with('error', 'Blog Not Found!');
    }
}
