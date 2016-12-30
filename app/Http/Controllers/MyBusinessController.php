<?php

namespace app\Http\Controllers;

/*
 * Antvel - Free Products Participants Controller
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Http\Controllers\Controller;
use App\User;
use App\Business;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
class MyBusinessController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Business::where('user_id','=',Auth::user()->id)->first();
        
        return view('user.business.mybusiness', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('user.set.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $form_rule = [
            'business_name'         => 'required|max:50|unique:businesses,business_name,'.$id.',user_id',
            'email'                 => 'email|max:50',
            'range'                 => 'max:255',
            'person'                => 'max:50',
            'address'               => 'max:200',
            'phone'                 => 'max:50',
            'fax'                   => 'max:50',
            'qq'                    => 'max:255',
            'referral'              => 'max:2000',
            'pay'                   => 'max:2000',
            'delivery'              => 'max:2000',
        ];

        $business = Business::where('user_id','=',$id)->first();

        $v = \Validator::make($request->all(), $form_rule);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $business->business_name = $request->input('business_name');
        $business->email = $request->input('email');
        $business->range = $request->input('range');
        $business->person = $request->input('person');
        $business->address = $request->input('address');
        $business->phone = $request->input('phone');
        $business->fax = $request->input('fax');
        $business->qq = $request->input('qq');
        $business->referral = $request->input('referral');
        $business->pay = $request->input('pay');
        $business->delivery = $request->input('delivery');

        $business->save();

        return $this->index();
    }
    //图片异步上传
    public function upload(Request $request)
    {   

        $file = $request->file('path');

        if ($request->hasFile('path')) {

            $path = config('app.image_path').'/grow/';
            $Extension = $file->getClientOriginalExtension();
            $filename = 'SZGC_'.time().'.'. $Extension;
            $check = $file->move($path, $filename);
            $filePath = $path.$filename; //原图路径加名称
            $newfilePath = $path.'SZGC_S_'.time().'.'. $Extension;//缩略图路径名称
            $this->img_create_small($filePath,60,40,$newfilePath);  //生成缩略图
            $pic=array();
            $pic['pic']= $filePath;//原图
            $pic['pic_thumb']= $newfilePath;//缩略图
            return $pic;//返回原图 缩略图 的路径 数组
        }else{
            return 'false';
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


}
