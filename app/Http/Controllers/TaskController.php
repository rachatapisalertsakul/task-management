<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Mail\TaskNotificationMail;
use App\Mail\ProjectNotificationMail;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{

    public function project_list(Request $request)
    {
        // หน้ารวม Project
        $filter_id = $request->filter;
        if($filter_id) {
            $check_user = [$_SESSION['id_user']];
            $filter_person = DB::table('project')->where('id_project', $filter_id)->first();
        } else {
            $check_user = [$_SESSION['id_user']];
            $filter_person = [];
        }

        $user = DB::table('user')->get();
        $project = DB::table('project')->where('is_deleted', 0)->get();
        $member = [];

        foreach ($project as $key => $p) {
            // เช็คว่าเป็น user นั้นอยู่ใน task ไหม
            if($filter_id && $_SESSION['role'] != 'Chief') {
                $p->is_myproject = DB::table('project_team')->whereIn('ref_id_user', $check_user)->where('ref_id_project', $p->id_project)->where('ref_id_project', $filter_id)->get();
            } elseif($filter_id && $_SESSION['role'] == 'Chief') {
                $p->is_myproject = DB::table('project_team')->where('ref_id_project', $p->id_project)->where('ref_id_project', $filter_id)->get();
            } else {
                $p->is_myproject = DB::table('project_team')->whereIn('ref_id_user', $check_user)->where('ref_id_project', $p->id_project)->get();
            }

            $p->task = DB::table('task')->where('is_deleted', 0)->where('ref_id_project', $p->id_project)->get();
            $p->team = DB::table('project_team')
                ->where('ref_id_project', $p->id_project)
                ->leftjoin('user', 'user.id_user', '=', 'project_team.ref_id_user')
                ->get();

            foreach ($p->team as $key => $person) {
                if($person->ref_id_user != $_SESSION['id_user']) {
                    $member[$person->ref_id_user] = $person->role.' - '.$person->firstname.' '.$person->lastname;
                }
            }
        }

        $member = array_unique($member);

        // dd($project);

        return view('Project.ProjectList', compact('user', 'project', 'member', 'filter_id', 'filter_person'));
    }

    public function insert_project(Request $request)
    {
        // ฟังก์ชั่นเพิ่ม Project
        DB::table('project')->insert([
            'name_project' => $request->name_project,
            'desciption_project' => $request->desciption_project,
        ]);

        // เพิ่มสมาชิกในโปรเจคนั้น ใน table project_team
        for ($i = 0; $i < count($request->project_team); $i++) {
            DB::table('project_team')->insert([
                'ref_id_user' => $request->project_team[$i],
                'ref_id_project' => (DB::table('project')->orderBy('id_project', 'DESC')->first())->id_project,
            ]);
            
            //ส่งเมล์หลังจากสร้าง Project
            $user = DB::table('user')->where('id_user', $request->project_team[$i])->first();
            Mail::to($user->email)->send(new ProjectNotificationMail($request->name_project, $request->desciption_project));
        }

        return redirect()->back()->with('success', 'Add New Project Successfully!');
    }

    
    public function update_project(Request $request, $id)
    {
        // แก้ไขข้อมูล Project
        try {
            DB::table('project')->where('id_project', $id)->update([
                'name_project' => $request->name_project,
                'desciption_project' => $request->desciption_project
            ]);

            // เคลียร์สมาชิกใน project นั้นก่อน
            DB::table('project_team')->where('ref_id_project', $id)->delete();

            // เพิ่มสมาชิกในโปรเจคนั้น ใน table project_team
            for ($i = 0; $i < count($request->project_team); $i++) {
                DB::table('project_team')->insert([
                    'ref_id_user' => $request->project_team[$i],
                    'ref_id_project' => $id,
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Update Project Successfully!');
    }

    public function remove_project($id)
    {
        // ลบ Project
        try {
            DB::table('project')->where('id_project', $id)->update([
                'is_deleted' => 1
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Remove Project Successfully!');
    }

    public function task_list($id)
    {
        // หน้าจอ Task Board
        $project = DB::table('project')->where('id_project', $id)->first();

        // ดึงสมาชิกในโปรเจคนั้น ใน table project_team
        $team = DB::table('project_team')->where('ref_id_project', $project->id_project)->leftjoin('user', 'user.id_user', '=', 'project_team.ref_id_user')->get();

        // ดึง task ในแต่ละ status
        $status_todo = DB::table('task')->where('ref_id_project', $id)->where('status', 0)->where('is_deleted', 0)->orderBy('index', 'ASC')->orderBy('updated_at', 'ASC')->get();
        $status_doing = DB::table('task')->where('ref_id_project', $id)->where('status', 1)->where('is_deleted', 0)->orderBy('index', 'ASC')->orderBy('updated_at', 'ASC')->get();
        $status_done = DB::table('task')->where('ref_id_project', $id)->where('status', 2)->where('is_deleted', 0)->orderBy('index', 'ASC')->orderBy('updated_at', 'ASC')->get();
        $status_reject = DB::table('task')->where('ref_id_project', $id)->where('status', 3)->where('is_deleted', 0)->orderBy('index', 'ASC')->orderBy('updated_at', 'ASC')->get();
        
        // วนลูปดึงไฟล์แนบและ member ในแต่ละ task
        foreach ($status_todo as $key => $task) {
            $task->file = DB::table('task_file')->where('is_deleted', 0)->where('ref_id_task', $task->id_task)->get();
            $members = explode(",", $task->assign_to);
            $task->members = DB::table('user')->whereIn('id_user', $members)->get();
            $task->checklist = DB::table('task_checklist')->where('ref_id_task', $task->id_task)->where('is_deleted', 0)->get();
            $all_checklist = DB::table('task_checklist')->where('ref_id_task', $task->id_task)->where('is_deleted', 0)->count();
            $checked_checklist = DB::table('task_checklist')->where('ref_id_task', $task->id_task)->where('is_checked', 1)->where('is_deleted', 0)->count();
            $task->created_name = DB::table('user')->where('id_user', $task->created_by)->first();
            if($all_checklist) {
                $task->percents = number_format(($checked_checklist/$all_checklist)*100, 2, '.', '');
            } else {
                $task->percents = 0;
            }
        }
        foreach ($status_doing as $key => $task) {
            $task->file = DB::table('task_file')->where('is_deleted', 0)->where('ref_id_task', $task->id_task)->get();
            $members = explode(",", $task->assign_to);
            $task->members = DB::table('user')->whereIn('id_user', $members)->get();
            $task->checklist = DB::table('task_checklist')->where('ref_id_task', $task->id_task)->where('is_deleted', 0)->get();
            $all_checklist = DB::table('task_checklist')->where('ref_id_task', $task->id_task)->where('is_deleted', 0)->count();
            $checked_checklist = DB::table('task_checklist')->where('ref_id_task', $task->id_task)->where('is_checked', 1)->where('is_deleted', 0)->count();
            $task->created_name = DB::table('user')->where('id_user', $task->created_by)->first();
            if($all_checklist) {
                $task->percents = number_format(($checked_checklist/$all_checklist)*100, 2, '.', '');
            } else {
                $task->percents = 0;
            }
        }
        foreach ($status_done as $key => $task) {
            $task->file = DB::table('task_file')->where('is_deleted', 0)->where('ref_id_task', $task->id_task)->get();
            $members = explode(",", $task->assign_to);
            $task->members = DB::table('user')->whereIn('id_user', $members)->get();
            $task->checklist = DB::table('task_checklist')->where('ref_id_task', $task->id_task)->where('is_deleted', 0)->get();
            $all_checklist = DB::table('task_checklist')->where('ref_id_task', $task->id_task)->where('is_deleted', 0)->count();
            $checked_checklist = DB::table('task_checklist')->where('ref_id_task', $task->id_task)->where('is_checked', 1)->where('is_deleted', 0)->count();
            $task->created_name = DB::table('user')->where('id_user', $task->created_by)->first();
            if($all_checklist) {
                $task->percents = number_format(($checked_checklist/$all_checklist)*100, 2, '.', '');
            } else {
                $task->percents = 0;
            }
        }
        foreach ($status_reject as $key => $task) {
            $task->file = DB::table('task_file')->where('is_deleted', 0)->where('ref_id_task', $task->id_task)->get();
            $members = explode(",", $task->assign_to);
            $task->members = DB::table('user')->whereIn('id_user', $members)->get();
            $task->checklist = DB::table('task_checklist')->where('ref_id_task', $task->id_task)->where('is_deleted', 0)->get();
            $all_checklist = DB::table('task_checklist')->where('ref_id_task', $task->id_task)->where('is_deleted', 0)->count();
            $checked_checklist = DB::table('task_checklist')->where('ref_id_task', $task->id_task)->where('is_checked', 1)->where('is_deleted', 0)->count();
            $task->created_name = DB::table('user')->where('id_user', $task->created_by)->first();
            if($all_checklist) {
                $task->percents = number_format(($checked_checklist/$all_checklist)*100, 2, '.', '');
            } else {
                $task->percents = 0;
            }
        }

        return view('Task.TaskList', compact('project', 'status_todo', 'status_doing', 'status_done', 'status_reject', 'team'));
    }

    public function add_tasks(Request $request)
    {
        // เพิ่ม task
        try {
            // เพิ่มใน table task 
            $id = DB::table('task')
                ->insertGetId(
                    [
                        'title' => $request->title,
                        'note' => $request->note,
                        'link' => $request->link,
                        'ref_id_project' => $request->ref_id_project,
                        'due_date' => $request->duedate,
                        'priority' => $request->priority,
                        'assign_to' => $request->task_team ? implode(",", $request->task_team) : '',
                        'status' => 0,
                        'created_by' => $_SESSION['id_user'],
                        'created_at' => now()
                    ]
                );
            
            // เช็คว่าหากมีการแนบไฟล์ ให้ทำการเพิ่มไฟล์แนบ
            if ($request->file('files')){
                foreach($request->file('files') as $key => $file) {
                    $image_filename = $file->getClientOriginalName();
                    $image_name = date("Ymd-His").'-'.$image_filename;
                    $public_path = "task_file/";
                    $destination = base_path() . "/public/" . $public_path;
                    $file->move($destination, $image_name);
                    $file = $image_name;

                    $insert_file = DB::table('task_file')
                            ->insert(
                                [
                                    'ref_id_task' => $id,
                                    'file_name' => $image_filename,
                                    'file_path' => $public_path . $image_name,
                                    'is_deleted' => 0,
                                    'created_at' => now()
                                ]
                            );
                }
            }

            //ส่งเมล์หลังจากสร้าง Task
            if($request->task_team) {
                $project = DB::table('project')->where('id_project', $request->ref_id_project)->first();
                foreach ($request->task_team as $key => $userid) {
                    // วนลูปส่ง email ให้คนที่ได้รับ task
                    $user = DB::table('user')->where('id_user', $userid)->first();
                    Mail::to($user->email)->send(new TaskNotificationMail($request->title, $request->note, $project->name_project));
                }
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Add New Task Successfully !!');
    }

    public function move_tasks($id, $status, $bottomId)
    {
        // ย้าย task
        if ($bottomId) {
            // กรณีย้ายไปแทรกระหว่าง task
            $bottomTask = DB::table('task')->where('id_task', $bottomId)->first('index');
            DB::table('task')->where('id_task', $id)->update([
                'status' => $status,
                'index' => $bottomTask->index - 0.01
            ]);
        } else {
            // กรณีย้าย task ไว้ล่างสุด
            DB::table('task')->where('id_task', $id)->update([
                'status' => $status,
                'index' => 100,
                'updated_at' => now()
            ]);
        }

        // ดึงค่า count ไป update หน้า view
        $task = DB::table('task')->where('id_task', $id)->first();
        $task_count = DB::table('task')->select(DB::raw('count(IF(status = 0,1,NULL)) status0'), DB::raw('count(IF(status = 1,1,NULL)) status1'), DB::raw('count(IF(status = 2,1,NULL)) status2'), DB::raw('count(IF(status = 3,1,NULL)) status3'))
            ->where('ref_id_project', $task->ref_id_project)
            ->where('is_deleted', 0)
            ->first();

        return $task_count;
    }

    public function update_tasks(Request $request, $id)
    {
        // แก้ไขข้อมูล Task
        try {
            // update ข้อมูล
            DB::table('task')->where('id_task', $id)
                ->update(
                    [
                        'title' => $request->title,
                        'note' => $request->note,
                        'link' => $request->link,
                        'ref_id_project' => $request->ref_id_project,
                        'due_date' => $request->duedate,
                        'priority' => $request->priority,
                        'assign_to' => $request->task_team ? implode(",", $request->task_team) : ''
                    ]
                );
            
            // เช็คว่าหากมีการแนบไฟล์ ให้ทำการเพิ่มไฟล์แนบ
            if ($request->file('files')){
                foreach($request->file('files') as $key => $file) {
                    $image_filename = $file->getClientOriginalName();
                    $image_name = date("Ymd-His").'-'.$image_filename;
                    $public_path = "task_file/";
                    $destination = base_path() . "/public/" . $public_path;
                    $file->move($destination, $image_name);
                    $file = $image_name;

                    $insert_file = DB::table('task_file')
                            ->insert(
                                [
                                    'ref_id_task' => $id,
                                    'file_name' => $image_filename,
                                    'file_path' => $public_path . $image_name,
                                    'is_deleted' => 0,
                                    'created_at' => now()
                                ]
                            );
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Update Task Information Successfully!');
    }

    public function sort_tasks($id_project, $type)
    {
        try {
            if($type == 'priority') { // sort by priority
                $tasks = DB::table('task')->where('ref_id_project', $id_project)->where('is_deleted', 0)->orderBy('priority', 'asc')->orderBy('created_at', 'desc')->get();
            } else if ($type == 'due_date') { // sort by due date
                $tasks = DB::table('task')->where('ref_id_project', $id_project)->where('is_deleted', 0)->orderBy('due_date', 'desc')->orderBy('created_at', 'desc')->get();
            }
            
            $index = 100;
            foreach($tasks as $key => $item) {
                // update ข้อมูล
                DB::table('task')->where('id_task', $item->id_task)
                    ->update(
                        [
                            'index' => $index
                        ]
                    );

                $index--;
            }
            
            
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Sorted Successfully!');
    }

    public function remove_tasks($id)
    {
        // ลบ task
        try {
            DB::table('task')->where('id_task', $id)->update([
                'is_deleted' => 1
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Remove Task Successfully!');
    }

    public function remove_task_file($id)
    {
        // ลบ task file
        try {
            DB::table('task_file')->where('id_file', $id)->update([
                'is_deleted' => 1
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Remove Task File Successfully!');
    }

    public function task_detail($id)
    {
        $task = DB::table('task')->where('id_task', $id)->where('is_deleted', 0)->orderBy('index', 'ASC')->orderBy('updated_at', 'ASC')->first();
        $checklist = DB::table('task_checklist')->where('ref_id_task', $id)->where('is_deleted', 0)->orderBy('updated_at', 'ASC')->get();

        // หน้าจอ Task Board
        $project = DB::table('project')->where('id_project', $task->ref_id_project)->first();

        $task->file = DB::table('task_file')->where('is_deleted', 0)->where('ref_id_task', $task->id_task)->get();
        $members = explode(",", $task->assign_to);
        $task->members = DB::table('user')->whereIn('id_user', $members)->get();

        // ดึงค่าไป update หน้า view
        $all_checklist = DB::table('task_checklist')->where('ref_id_task', $id)->where('is_deleted', 0)->count();
        $checked_checklist = DB::table('task_checklist')->where('ref_id_task', $id)->where('is_checked', 1)->where('is_deleted', 0)->count();
        if($all_checklist) {
            $percents = number_format(($checked_checklist/$all_checklist)*100, 2, '.', '');
        } else {
            $percents = 0;
        }

        return view('Task.TaskDetail', compact('project', 'task', 'checklist', 'percents'));
    }

    public function insert_checklist(Request $request)
    {
        // เพิ่ม checklist
        try {
            // เพิ่มใน task_checklist
            $id = DB::table('task_checklist')
                ->insertGetId(
                    [
                        'ref_id_task' => $request->ref_id_task,
                        'checklist_title' => $request->title,
                        'is_checked' => 0,
                        'is_deleted' => 0,
                        'created_by' => $_SESSION['id_user'],
                        'created_at' => now()
                    ]
                );

        } catch (\Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Add New Checklist Successfully !!');
    }

    
    public function update_checklist($id_task, $id, $value)
    {
        DB::table('task_checklist')->where('id_checklist', $id)->update([
            'is_checked' => $value,
            'updated_at' => now()
        ]);

        // ดึงค่าไป update หน้า view
        $all_checklist = DB::table('task_checklist')->where('ref_id_task', $id_task)->where('is_deleted', 0)->count();
        $checked_checklist = DB::table('task_checklist')->where('ref_id_task', $id_task)->where('is_checked', 1)->where('is_deleted', 0)->count();
        if($all_checklist) {
            $percents = number_format(($checked_checklist/$all_checklist)*100, 2, '.', '');
        } else {
            $percents = 0;
        }

        return $percents;
    }

    public function remove_checklist($id_task, $id)
    {
        DB::table('task_checklist')->where('id_checklist', $id)->update([
            'is_deleted' => 1,
            'updated_at' => now()
        ]);

        // ดึงค่าไป update หน้า view
        $all_checklist = DB::table('task_checklist')->where('ref_id_task', $id_task)->where('is_deleted', 0)->count();
        $checked_checklist = DB::table('task_checklist')->where('ref_id_task', $id_task)->where('is_checked', 1)->where('is_deleted', 0)->count();
        if($all_checklist) {
            $percents = number_format(($checked_checklist/$all_checklist)*100, 2, '.', '');
        } else {
            $percents = 0;
        }

        return redirect()->back()->with('success', 'Remove Checklist Successfully !!');
    }
}
