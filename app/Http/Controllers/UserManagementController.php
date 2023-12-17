<?php

namespace App\Http\Controllers;

use \Auth;
use Redirect;
use Response;
use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\UserManagement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        // dd($officeInfo);
        // All user list
        // $users = UserManagement::latest()->paginate(5);
        if ($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4) {
            $users = DB::table('users')
                ->orderBy('id', 'DESC')
                ->leftJoin('role', 'users.role_id', '=', 'role.id')
                ->leftJoin('court', 'users.court_id', '=', 'court.id')
                ->leftJoin('district', 'court.district_id', '=', 'district.id')
                ->select('users.*', 'role.role_name', 'court.court_name', 'district.district_name_bn')
                ->paginate(10);
                
        } elseif ($roleID == 37) {
            $users = DB::table('users')
                ->orderBy('id', 'DESC')
                ->join('role', 'users.role_id', '=', 'role.id')
                ->whereIn('role.id', array(27, 38, 39))
                ->leftJoin('office', 'users.office_id', '=', 'office.id')
                ->leftJoin('court', 'users.court_id', '=', 'court.id')
                ->leftJoin('district', 'court.district_id', '=', 'district.id')
                ->select('users.*', 'role.role_name', 'court.court_name', 'district.district_name_bn')
                ->where('office.district_id', $officeInfo->district_id)
                ->paginate(10);
        } else {
            $users = DB::table('users')
                ->orderBy('id', 'DESC')
                ->join('role', 'users.role_id', '=', 'role.id')
                ->join('court', 'users.office_id', '=', 'court.id')
                ->leftJoin('district', 'court.district_id', '=', 'district.id')
                ->select('users.*', 'role.role_name', 'court.court_name', 'district.district_name_bn')
                ->where('court.district_id', $officeInfo->district_id)
                ->paginate(10);
        }
        $page_title = 'ইউজার ম্যানেজমেন্ট তালিকা';

        return view('user_manage.index', compact('page_title', 'users'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();

        if ($roleID == 37) {

            $data['roles'] = DB::table('role')
                ->where('is_gcc', 1)
                ->whereIn('id', array(27, 28, 38, 39))
                ->select('id', 'role_name')
                ->get();
        } else {
            $data['roles'] = DB::table('role')
                ->where('is_gcc', 1)
                ->select('id', 'role_name')
                ->get();
        }

        if ($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4) {
            $data['courts'] = DB::table('court')
                ->leftJoin('district', 'court.district_id', '=', 'district.id')
                ->select('court.id', 'court.court_name', 'district.district_name_bn')
                ->get();
        } else {
            $data['courts'] = DB::table('court')
                ->leftJoin('district', 'court.district_id', '=', 'district.id')
                ->select('court.id', 'court.court_name', 'district.district_name_bn')
                ->where('court.district_id', $officeInfo->district_id)
                ->get();
            $data['offices'] = DB::table('office')
                ->leftJoin('district', 'office.district_id', '=', 'district.id')
                ->select('office.id', 'office.office_name_bn', 'district.district_name_bn')
                ->where('office.district_id', $officeInfo->district_id)
                ->get();
        }

        // return $data['offices'];
        // $data['subcategories'] = DB::table("mouja")->where("upazila_id",38)->pluck("mouja_name_bn","id");

        $data['page_title'] = 'নতুন ইউজার এন্ট্রি ফরম';

        return view('user_manage.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required', 'unique:users', 'max:100',
                'role_id' => 'required',
                'office_id' => 'required',
                /*'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'mobile_no' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users', */
                'password' => 'required',
            ],
            [
                'name.required' => 'পুরো নাম লিখুন',
                'username.required' => 'ইউজার নাম লিখুন',
                'role_id.required' => 'ভূমিকা নির্বাচন করুন',
                'office_id.required' => 'অফিস নির্বাচন করুন',
                'password.required' => 'পাসওয়ার্ড লিখুন',
            ]
        );

        DB::table('users')->insert([
            'name' => $request->name,
            'username' => $request->username,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'office_id' => $request->office_id,
            'password' => Hash::make($request->password),

        ]);

        return redirect()->route('user-management.index')->with('success', 'সাফল্যের সাথে সংযুক্তি সম্পন্ন হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserManagement  $userManagement
     * @return \Illuminate\Http\Response
     */
    // public function show(UserManagement $userManagement)
    public function show($id = '')
    {
        $userManagement = DB::table('users')
            ->join('role', 'users.role_id', '=', 'role.id')
            ->leftjoin('office', 'users.office_id', '=', 'office.id')
            ->leftJoin('district', 'office.district_id', '=', 'district.id')
            ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
            ->select(
                'users.*',
                'role.role_name',
                'office.office_name_bn',
                'district.district_name_bn',
                'upazila.upazila_name_bn'
            )
            ->where('users.id', $id)
            ->get()->first();
        // dd($userManagement);

        return view('user_manage.show', compact('userManagement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserManagement  $userManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userData=User::find($id);
        
        
        $officeInfo = user_office_info();
        if ($roleID == 37) {

            $data['roles'] = DB::table('role')
                ->where('is_gcc', 1)
                ->whereIn('id', array(27, 38))
                ->select('id', 'role_name')
                ->get();
        } else {
            $data['roles'] = DB::table('role')
                ->where('is_gcc', 1)
                ->select('id', 'role_name')
                ->get();
        }

        $data['userManagement'] = DB::table('users')
            ->join('role', 'users.role_id', '=', 'role.id')
            ->leftjoin('office', 'users.office_id', '=', 'office.id')
            ->leftJoin('district', 'office.district_id', '=', 'district.id')
            ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
            ->select(
                'users.*',
                'role.role_name',
                'office.office_name_bn',
                'district.district_name_bn',
                'upazila.upazila_name_bn',
            )
            ->where('users.id', $id)
            ->get()->first();
        // dd($userManagement);
        if(globalUserInfo()->role_id != 1 && globalUserInfo()->role_id != 2){
            $data['offices'] = DB::table('office')
                ->leftJoin('district', 'office.district_id', '=', 'district.id')
                ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                ->select('office.id', 'office.office_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'office.is_dm_adm_em')
                ->where('office.district_id', $officeInfo->district_id)
                ->get();

            $data['courts'] = DB::table('court')
                    ->leftJoin('district', 'court.district_id', '=', 'district.id')
                    ->select('court.id', 'court.court_name', 'district.district_name_bn')
                    ->where('court.district_id', $officeInfo->district_id)
                    ->get();
        }
        $data['page_title'] = 'ইউজার ইনফর্মেশন সংশোধন ফরম';
        // return $data;
        return view('user_manage.edit')->with($data);
        // return view('user_manage.edit', compact('userManagement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserManagement  $userManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = '')
    {
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required', 'unique:users', 'max:100',
                'role_id' => 'required',
                'office_id' => 'required',
                'court_id' => 'required',
                // 'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users',
                // 'mobile_no' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users',
                'signature' => 'max:10240',
            ],
            [
                'name.required' => 'পুরো নাম লিখুন',
                'username.required' => 'ইউজার নাম লিখুন',
                'role_id.required' => 'ভূমিকা নির্বাচন করুন',
                'office_id.required' => 'অফিস নির্বাচন করুন',
                'court_id.required' => 'আদালত নির্বাচন করুন',

            ]
        );

        // File upload
        if ($file = $request->file('signature')) {
            $fileName = $id . '_' . time() . '.' . $request->signature->extension();
            $request->signature->move(public_path('/uploads/signature'), $fileName);
            $fileName = '/uploads/signature/' . $fileName;
        } else {
            $fileName = null;
        }
        if ($file = $request->file('pro_pic')) {
            $profilePic = $id . '_' . time() . '.' . $request->pro_pic->extension();
            $request->pro_pic->move(public_path('/uploads/profile'), $profilePic);
            $profilePic = '/uploads/profile/' . $profilePic;
        } else {
            $profilePic = null;
        }

        DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'username' => $request->username,
                'mobile_no' => $request->mobile_no,
                'signature' => $fileName,
                'profile_pic' => $profilePic,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'office_id' => $request->office_id,
                'court_id' => $request->court_id,
            ]);
        return redirect()->route('user-management.index')
            ->with('success', 'ইউজার ডাটা সফলভাবে আপডেট হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserManagement  $userManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserManagement $userManagement)
    {
        //
    }

    public function em_case_mapping($id = ' ')
    {
        $userManagement = DB::table('users')
            ->join('role', 'users.role_id', '=', 'role.id')
            ->join('office', 'users.office_id', '=', 'office.id')
            ->leftJoin('district', 'office.district_id', '=', 'district.id')
            ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
            ->select(
                'users.*',
                'role.role_name',
                'office.office_name_bn',
                'district.district_name_bn',
                'upazila.upazila_name_bn',
                'office.district_id'
            )
            ->where('users.id', $id)
            ->get()->first();
        // dd($userManagement);
        $officeInfo = user_office_info();
        $upzillas = DB::table('upazila')->where('district_id', $officeInfo->district_id)->select('id', 'upazila_name_bn')->get();

        $assignedupzilla = DB::table('case_mapping')->where('user_id', $id)->where('district_id', $officeInfo->district_id)->where('status', 1)->select('upazilla_id')->get();

        return view('user_manage.em_case_mapping', compact(['userManagement', 'upzillas', 'assignedupzilla']));
    }

    public function em_case_mapping_store(Request $request)
    {
        //return $request;
        
        $officeInfo = user_office_info();
        $assignedupzilla = DB::table('case_mapping')->where('user_id', $request->user_id)->where('district_id', $officeInfo->district_id)->where('status', 1)->select('upazilla_id')->get();
        $assignedipzilla = array();
        foreach ($assignedupzilla as $assignedupzilla) {
            array_push($assignedipzilla, $assignedupzilla->upazilla_id);
        }
        //var_dump($request->upzilla_case_mapping);
        //dd($assignedipzilla);
        $requestupzill=array();
        if(!empty($request->upzilla_case_mapping)){
            
            foreach ($request->upzilla_case_mapping as $up_id) {
                array_push($requestupzill, $up_id);

                if (!in_array($up_id, $assignedipzilla)) {

                    $active_em=DB::table('case_mapping')->select('user_id')->where('district_id',$request->district_id)->where('upazilla_id',$up_id)->where('status',1)->first();
                    $upname=DB::table('upazila')->select('upazila_name_bn')->where('id',$up_id)->first();
                    if($active_em)
                    {
                        // dd($upname->upazila_name_bn);
                        return back()->with('danger', 'ইতিমধ্যে একজন এক্সিকিউটিভ ম্যাজিস্ট্রেট কে '.$upname->upazila_name_bn.' উপজেলার দায়িত্ব দেয়া হয়েছে');
                    }

                    DB::table('case_mapping')->insert([
                        'user_id' => $request->user_id,
                        'district_id' => $request->district_id,
                        'upazilla_id' => $up_id,
                        'status' => 1,
                    ]);
                    $new_em_id = $request->user_id;
                    // dd($new_em_id);

                    $case_id=DB::table('em_appeals')->where('upazila_id',$up_id)->where('district_id',$request->district_id)
                    ->select('id')->first();
                    // dd($previous_em_id);
                    if(!empty($case_id))
                    {
                                
                        DB::table('em_appeals')
                        ->where('id',$case_id->id)
                        ->update(
                            array(
                            'em_user_id' =>$new_em_id,
                            ));
                    }

                }

            }
        }
        //dd($requestupzill);
        foreach ($assignedipzilla as $up_id) {


            if (!in_array($up_id, $requestupzill)) {
                DB::table('case_mapping')->where('upazilla_id', $up_id)
                ->where('user_id',$request->user_id)
                ->where('district_id',$request->district_id)
                ->update(array('status' => 0));

                $previous_em_id=DB::table('em_appeals')->where('upazila_id',$up_id)->where('district_id',$request->district_id)
                ->select('em_user_id')->first();
                if(!empty($previous_em_id))
                {
                        
                DB::table('em_appeals')->where('upazila_id', $up_id)
                ->where('district_id',$request->district_id)
                ->update(
                    array(
                    'em_user_id' =>NULL,
                    'previous_em_user_id'=>$previous_em_id->em_user_id
                    ));
                }
                
            }
           
        }

        return back()->with('success', 'ইউজার ডাটা সফলভাবে আপডেট হয়েছে');
    }
}
