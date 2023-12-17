<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator,Redirect,Response;


class MyprofileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;

        $userManagement = DB::table('users')
                        ->join('role', 'users.role_id', '=', 'role.id')
                        ->leftJoin('office', 'users.office_id', '=', 'office.id')
                        ->leftJoin('district', 'office.district_id', '=', 'district.id')
                        ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                        ->leftJoin('em_citizens', 'users.citizen_id', '=', 'em_citizens.id')
                        ->select('users.*', 'role.role_name', 'office.office_name_bn', 
                            'district.district_name_bn', 'upazila.upazila_name_bn', 'em_citizens.present_address', 'em_citizens.permanent_address')
                        ->where('users.id',$user_id)
                        ->get()->first();
        $page_title = "মাই প্রোফাইল";
        //dd($userManagement);     

        return view('myprofile.show', compact('userManagement','page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function basic_edit()
    {   
        $user_id = Auth::user()->id;

        $data['userManagement'] = DB::table('users')
                        ->join('role', 'users.role_id', '=', 'role.id')
                        ->leftJoin('office', 'users.office_id', '=', 'office.id')
                        ->leftJoin('district', 'office.district_id', '=', 'district.id')
                        ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                        ->select('users.*', 'role.role_name', 'office.office_name_bn', 
                            'district.district_name_bn', 'upazila.upazila_name_bn')
                        ->where('users.id',$user_id)
                        ->get()->first();
        $data['roles'] = DB::table('role')
        ->select('id', 'role_name')
        ->get(); 

        $data['offices'] = DB::table('office')
        ->leftJoin('district', 'office.district_id', '=', 'district.id')
        ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
        ->select('office.id', 'office.office_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn')
        ->get();
        $data['page_title'] = 'প্রোফাইল ইনফর্মেশন সংশোধন ফরম';
                   
        return view('myprofile.edit')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function basic_update(Request $request)
    {
        $user_id = Auth::user()->id;

        $request->validate([
            'name' => 'required',           
            'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',            
            'mobile_no' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users',            
            'signature' => 'max:10240',             
            ],
            [
            'name.required' => 'পুরো নাম লিখুন',
            /*'mobile_no' => 'পুরো নাম লিখুন',*/
            ]);

         DB::table('users')
            ->where('id', $user_id)
            ->update(['name'=>$request->name,
            'mobile_no' =>$request->mobile_no,
            'email' =>$request->email,
            ]);
        return redirect()->route('my-profile.index')
            ->with('success', 'প্রোফাইলের বেসিক ইনফরমেশন সফলভাবে আপডেট হয়েছে');
    }



    public function imageUpload()
    {
        $user_id = Auth::user()->id;

        $data['userManagement'] = DB::table('users')
                                ->select('users.*')
                                ->where('users.id',$user_id)
                                ->get()->first();
        return view('myprofile.imageUpload')->with($data);
    }

     public function image_update(Request $request)
    {  
        $user_id = Auth::user()->id;
        $request->validate([
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if($file = $request->file('image')){
            $profilePic = $user_id.'_'.time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/profile'), $profilePic);
        }else{
            $profilePic = NULL;
        }

        DB::table('users')
            ->where('id', $user_id)
            ->update(['profile_pic' =>$profilePic,]);
        return redirect()->route('my-profile.index')
            ->with('success', 'ইউজার ডাটা সফলভাবে আপডেট হয়েছে');
    }




    public function change_password()
    {
        return view('myprofile.changePassword');
    }
    public function new_change_password()
    {
        
         

        return view('myprofile.new_changePassword');

    } 

     public function update_password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

         return redirect()->route('my-profile.index')
            ->with('success', 'পাসওয়ার্ড সফলভাবে হালনাগাদ করা হয়েছে');
   
        // dd('Password change successfully.');
    }
    public function new_update_password(Request $request)
    {
        //dd($request);

        $request->validate([
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

         return redirect()->route('my-profile.index')
            ->with('success', 'পাসওয়ার্ড সফলভাবে হালনাগাদ করা হয়েছে');
   
        // dd('Password change successfully.');
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
