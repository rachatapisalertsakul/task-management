<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function dashboard_index()
    {

        if ($_SESSION['role'] == 'Chief' ) {
            $task = DB::table('task')
                ->leftjoin('project', 'project.id_project', '=', 'task.ref_id_project')
                ->get();
            $meeting_event = DB::table('meeting_event')->get();
        } else {
            $in_project = DB::table('project_team')
                ->leftjoin('project', 'project.id_project', '=', 'project_team.ref_id_project')
                ->where('project.is_deleted', '0')
                ->where('ref_id_user', $_SESSION['id_user'])
                ->pluck('ref_id_project')->toarray();
            $task = DB::table('task')
                ->whereIn('ref_id_project', $in_project)
                ->leftjoin('project', 'project.id_project', '=', 'task.ref_id_project')
                ->get();
            $meeting_event = DB::table('meeting_event')->whereIn('ref_id_project', $in_project)->get();
            // dd($task);
        }


        $project = DB::table('project')->get();
        $user = DB::table('user')->get();


        foreach ($meeting_event as $key => $m) {
            $m->start = date('Y-m-d H:i:s', strtotime("$m->date_start"));
        }
        $count_task = [0, 0, 0, 0];

        foreach ($task as $t) {
            if ($t->status == '0') {
                $t->color = '#f4bd0e';
                $t->status = "To Do";
                $count_task[0]++;
            } else if ($t->status == '1') {
                $t->color = '#09c2de';
                $t->status = "Doing";
                $count_task[1]++;
            } else if ($t->status == '2') {
                $t->color = '#1ee0ac';
                $t->status = "Done";
                $count_task[2]++;
            } else {
                $t->color = '#e85347';
                $t->status = "Reject";
                $count_task[3]++;
            }
            $t->title = $t->title;
            $t->description = $t->note;
            $t->start = date('Y-m-d', strtotime("$t->due_date"));
            $t->url = "/request_car_edit/" . $t->id_task;
        }

        // dd($count_task);
        return view('Dashboard.DashboardIndex', compact('task', 'count_task', 'user', 'project', 'meeting_event'));
    }
}
