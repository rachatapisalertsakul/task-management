<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    public function user_list()
    {
        // dd($_SESSION);
        $user = DB::table('user')
            ->where('is_delete', 'N')
            ->get();
        return view('User.UserList', compact('user'));
    }

    public function insert_user(Request $request)
    {
        // dd($request->all());

        if (isset($request->img)) {
            if ($request->hasFile('img')) {
                $image_filename = $request->file('img')->getClientOriginalName();
                $image_name = date("Ymd-His-") . $image_filename;
                $public_path = '/images/profile/';
                $destination = base_path() . "/public/" . $public_path;
                $request->file('img')->move($destination, $image_name);
                $img = $public_path . $image_name;
            }
        } else {
            $img = null;
        }

        DB::table('user')->insert([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'password' => $request->password,
            'birth' => $request->birth,
            'tel' => $request->tel,
            'position' => $request->position,
            'role' => $request->role,
            'email' => $request->email,
            'img' => $img,
        ]);


        return redirect()->back()->with('success', 'เพิ่มผู้ใช้งานเรียบร้อย');
    }

    public function update_user(Request $request, $id)
    {
        // dd($request->all());

        if (isset($request->img)) {
            if ($request->hasFile('img')) {
                $image_filename = $request->file('img')->getClientOriginalName();
                $image_name = date("Ymd-His-") . $image_filename;
                $public_path = '/images/profile/';
                $destination = base_path() . "/public/" . $public_path;
                $request->file('img')->move($destination, $image_name);
                $img = $public_path . $image_name;
            }
        } else {
            $img = (DB::table('user')->where('id_user', $id)->first())->img;
        }

        if($request->is_block == null){ $request->is_block = 'N'; }

        DB::table('user')->where('id_user', $id)->update([
            'is_block' => $request->is_block,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'password' => $request->password,
            'birth' => $request->birth,
            'tel' => $request->tel,
            'position' => $request->position,
            'role' => $request->role,
            'email' => $request->email,
            'img' => $img,
        ]);

        return redirect()->back()->with('success', 'อัพเดทข้อมูลเรียบร้อย');
    }

    public function rm_user($id)
    {
        DB::table('user')->where('id_user', $id)->update(['is_delete' => 'Y']);
        return redirect()->back()->with('danger', 'ลบผู้ใช้เรียบร้อย');
    }


    public function edit_profile(){

        $user = DB::table('user')->where('id_user',$_SESSION['id_user'])->first();
        // dd($user);
        return view('User.EditProfile',compact('user'));
    }
}
