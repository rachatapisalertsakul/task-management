<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Mail\MeetingNotificationMail;
use Illuminate\Support\Facades\Mail;

class MeetController extends Controller
{
    public function meet_list()
    {
        $project = DB::table('project')->get();
        $meet = DB::table('meeting_event')->get();
        $user = DB::table('user')->get();
        foreach ($meet as $key => $m) {
            $m->member = DB::table('meeting_member')->where('ref_id_meeting', $m->id_meeting)
                ->leftjoin('user', 'user.id_user', '=', 'meeting_member.ref_id_user')
                ->get();
            $m->member_arr = DB::table('meeting_member')->where('ref_id_meeting', $m->id_meeting)->pluck('ref_id_user')->toArray();
        }
        // dd($meet);

        return view('Meet.MeetList', compact('meet', 'project', 'user'));
    }

    public function insert_meeting(Request $request)
    {
        // dd($request->all());

        DB::table('meeting_event')->insert([
            'title' => $request->title,
            'link' => $request->link,
            'description' => $request->description,
            'date_start' => $request->date_start,
            'ref_id_project' => $request->ref_id_project,
        ]);

        for ($i = 0; $i < count($request->meeting_member); $i++) {
            DB::table('meeting_member')->insert([
                'ref_id_meeting' => (DB::table('meeting_event')->orderBy('id_meeting', 'DESC')->first())->id_meeting,
                'ref_id_user' => $request->meeting_member[$i],
            ]);

            $user = DB::table('user')->where('id_user', $request->meeting_member[$i])->first();
            Mail::to($user->email)->send(new MeetingNotificationMail($request->title, $request->link, $request->description, $request->date_start));
        }
        return redirect()->back()->with('success', 'เพิ่มการประชุมเรียบร้อย');
    }

    public function update_meeting(Request $request, $id)
    {
        // dd($request->all());

        DB::table('meeting_event')->where('id_meeting', $id)->update([
            'title' => $request->title,
            'link' => $request->link,
            'description' => $request->description,
            'date_start' => $request->date_start,
            'ref_id_project' => $request->ref_id_project,
        ]);

        DB::table('meeting_member')->where('ref_id_meeting', $id)->delete();
        for ($i = 0; $i < count($request->meeting_member); $i++) {
            DB::table('meeting_member')->insert([
                'ref_id_meeting' => $id,
                'ref_id_user' => $request->meeting_member[$i],
            ]);
        }

        return redirect()->back()->with('success', 'แก้ไขข้อมูลการประชุมเรียบร้อย');
    }
}
