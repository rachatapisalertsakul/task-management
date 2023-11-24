@extends('layout')
@section('content')

<!-- <div class="nk-block nk-block-lg">
    <div class="card card-bordered card-preview">

    </div>
</div> -->

<link rel="stylesheet" href="{{ asset('assets/css/kanban.css') }}">

<div class="d-flex ">
    <div class="p-2 flex-grow-1 ">
        <h1 class="nk-block-title page-title">
            <b> <a href="{{ route('project_list') }}"><u class="text-info">Projects</u></a> / <span class="project-name">{{ $project->name_project }}</span></b>
        </h1>
    </div>
    <div class="p-2">
        <!-- ปุ่มเพิ่ม Task และ Modal -->
        <a data-bs-toggle="modal" href="#newtask" class="btn btn-primary btn-sm" style="border-radius: 10px;"><span class="ms-1">+ New Task</span></a>
        <div class="modal fade" tabindex="-1" role="dialog" id="newtask">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                    <div class="modal-body modal-body-md">
                        <form action="{{ route('add_tasks') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control form-control-sm" id="ref_id_project" name="ref_id_project" placeholder="" value="{{ $project->id_project }}">
                            <div class="form-group row pt-2">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Title :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Note :</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" id="message-text" name="note"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Link :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="link" name="link" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">File :</label>                               
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <div class="form-file" style="font-size: 12px;">
                                                <input type="file" class="form-file-input" id="customFile" name="files[]" multiple />
                                                <label class="form-file-label" for="customFile">Choose File</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Due date :</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control form-control-sm" id="duedate" name="duedate">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Priority :</label>
                                <div class="col-sm-10">
                                    <ul class="custom-control-group">
                                        <li>
                                            <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control">
                                                <input type="radio" class="custom-control-input" name="priority" id="high" value="2">
                                                <label class="custom-control-label no-control" style="background-color: indianred;color: white;" for="high">High</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control">
                                                <input type="radio" class="custom-control-input" name="priority" id="medium" value="1">
                                                <label class="custom-control-label no-control" style="background-color: cornflowerblue;color: white;" for="medium">Medium</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control">
                                                <input type="radio" class="custom-control-input" name="priority" id="low" value="0">
                                                <label class="custom-control-label no-control" style="background-color: darkseagreen;color: white;" for="low">Low</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Assign :</label>
                                <div class="form-control-wrap col-sm-10">
                                    <select class="form-select js-select2" multiple="multiple" data-placeholder="" name="task_team[]">
                                        @foreach($team as $u)
                                        <option value="{{ $u->id_user }}"><b class="text-primary">{{ $u->role }}</b> - {{ $u->firstname }} {{ $u->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="text-center">
                                <button class="btn btn-primary" type="submit">Add Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<hr>
<div class="board">
    <!-- lane ของ TO DO -->
    <div class="lanes">
        <div class="swim-lane" id="0">
            <header class="kanban-board-header kanban-warning">
                <div class="kanban-title-board">
                    <div class="kanban-title-content py-1">
                        <h6 class="title">TO DO</h6>
                        <span class="badge rounded-pill bg-outline-warning text-dark" id="status0">{{count($status_todo)}}</span>
                    </div>
                </div>
            </header>

            @foreach ($status_todo as $item)
            <div class="taskcard task" id="{{ $item->id_task }}" draggable="true">
                <div class="d-flex justify-content-between px-1">
                    <div class="kanban-title-content justify-content-start">
                        <div class="badge badge-priority text-wrap @php if($item->priority == 0){ echo 'bg-low'; } elseif($item->priority == 1) { echo 'bg-medium'; } elseif($item->priority == 2) { echo 'bg-high'; } else { echo 'bg-none'; } @endphp">
                            @php if($item->priority == 0){ echo 'Low'; } elseif($item->priority == 1) { echo 'Medium'; } elseif($item->priority == 2) { echo 'High'; } else { echo ''; } @endphp
                        </div>
                    </div>
                    <div class="kanban-title-content justify-content-end">
                        <div class="drodown">
                            <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <ul class="link-list-opt no-bdr">
                                    <li><a href="{{ route('task_detail', $item->id_task) }}"><em class="icon ni ni-edit"></em><span>Checklist</span></a></li>
                                    <li><a data-bs-toggle="modal" href="#edittask-{{ $item->id_task }}"><em class="icon ni ni-edit"></em><span>Edit Task</span></a></li>
                                    <li><a href="{{ route('remove_tasks', $item->id_task) }}"><em class="icon ni ni-delete"></em><span>Remove Task</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-1">
                    <h4 class="name mb-0"><a data-bs-toggle="modal" href="#detailtask-{{ $item->id_task }}" style="color: #464e56;">{{ $item->title }}</a></h4>
                    <p class="created mb-1">Assigned by: {{ $item->created_by }}</p>
                    <p class="quote2">{{ $item->note }}</p>
                </div>

                <div class="text-start mb-1">
                    @foreach ($item->file as $file)
                        <a target="_blank" href="{{ '/'.$file->file_path }}" class="btn btn-outline-light btn-file mr-1">{{ $file->file_name }}</a>
                    @endforeach
                </div>
                <div class="px-1">
                    <p class="created mb-1">Checklist : {{ $item->created_by }}</p>
                    <div class="progress progress-lg"><div class="progress-bar progress-bar-striped progress-bar-animated fs-10px" data-progress="{{ $item->percents }}">{{ $item->percents }}%</div></div>
                </div>

                @if($item->link)
                <div class="d-flex justify-content-start px-1 align-items-center pt-1">
                    <span class="detail pl-2">Link: <a href="{{ $item->link }}">{{ $item->link }}</a></span>
                </div>
                @endif

                <div class="d-flex justify-content-between px-1 align-items-center pb-1">
                    <div class="d-flex justify-content-start align-items-center">
                        <span class="detail pl-2"><i class="fa fa-flag" style="padding-right: 2px;"></i> {{ DateThaiNoTime($item->due_date) }}</span>
                    </div>

                    <div class="d-flex justify-content-end">
                        @foreach ($item->members as $key => $member)
                            <img src="{{ $member->img }}" width="20" class="img{{ $key+1 }}" />
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- ----------------- MODAL EDIT ---------------- -->
            <div class="modal fade" tabindex="-1" role="dialog" id="edittask-{{ $item->id_task }}">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                        <div class="modal-body modal-body-md">
                            <form action="{{ route('update_tasks', $item->id_task) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control form-control-sm" id="ref_id_project" name="ref_id_project" placeholder="" value="{{ $project->id_project }}">
                                <div class="form-group row pt-2">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Title :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="" value="{{ $item->title }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Note :</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control form-control-sm" id="message-text" name="note">{{ $item->note }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Link :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" id="link" name="link" placeholder="" value="{{ $item->link }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">File :</label>                               
                                    <div class="col-sm-9">
                                        <div class="form-group" style="margin-bottom: 0.5rem;">
                                            <div class="form-control-wrap">
                                                @foreach ($item->file as $file)
                                                    <a href="{{ route('remove_task_file', $file->id_file) }}" class="btn btn-dim btn-outline-danger btn-file mr-1" onclick="return confirm('Are you sure to delete this file?');">{{ $file->file_name }} <em class="icon ni ni-file-remove"></em></a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="form-file" style="font-size: 12px;">
                                                    <input type="file" class="form-file-input" id="customFile" name="files[]" multiple />
                                                    <label class="form-file-label" for="customFile">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Due date :</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control form-control-sm" id="duedate" name="duedate" value="{{ $item->due_date }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Priority :</label>
                                    <div class="col-sm-10">
                                        <ul class="custom-control-group">
                                            <li>
                                                <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control">
                                                    <input type="radio" class="custom-control-input" name="priority" id="high-{{ $item->id_task }}" {{ $item->priority == 2 ? 'checked' : ''}} value="2">
                                                    <label class="custom-control-label no-control" style="background-color: indianred;color: white;" for="high-{{ $item->id_task }}">High</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control" >
                                                    <input type="radio" class="custom-control-input" name="priority" id="medium-{{ $item->id_task }}" {{ $item->priority == 1 ? 'checked' : ''}} value="1">
                                                    <label class="custom-control-label no-control" style="background-color: cornflowerblue;color: white;" for="medium-{{ $item->id_task }}">Medium</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control">
                                                    <input type="radio" class="custom-control-input" name="priority" id="low-{{ $item->id_task }}" {{ $item->priority == 0 ? 'checked' : ''}} value="0">
                                                    <label class="custom-control-label no-control" style="background-color: darkseagreen;color: white;" for="low-{{ $item->id_task }}">Low</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Assign :</label>
                                    <div class="form-control-wrap col-sm-10">
                                        <select class="form-select js-select2" multiple="multiple" data-placeholder="" name="task_team[]">
                                            @foreach($team as $u)
                                                <option value="{{ $u->id_user }}" {{ (in_array($u->id_user, explode(',', $item->assign_to))) ? 'selected' : '' }}><b class="text-primary">{{ $u->role }}</b> - {{ $u->firstname }} {{ $u->lastname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button class="btn btn-primary" type="submit">Update Task</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ----------------- END MODAL EDIT ---------------- -->

            <!-- ----------------- MODAL DETAIL 1 ---------------- -->
            <div class="modal fade" tabindex="-1" role="dialog" id="detailtask-{{ $item->id_task }}">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                        <div class="modal-body modal-body-md">

                            <div class="px-1">
                                <h4 class="name mb-0">{{ $item->title }}</h4>
                                <p class="created mb-1">Assigned by: {{ $item->created_by }}</p>
                                <p class="quote2">{{ $item->note }}</p>
                            </div>
                            <hr>
                            <div class="text-start mb-1 px-1">
                                <p class="detail mb-1">Attachment : </p>
                                @foreach ($item->file as $file)
                                    <a target="_blank" href="{{ '/'.$file->file_path }}" class="btn btn-outline-light btn-file mr-1">{{ $file->file_name }}</a>
                                @endforeach
                            </div>
                            @if($item->link)
                            <div class="d-flex justify-content-start px-1 align-items-center">
                                <span class="detail pl-2">Link : <a href="{{ $item->link }}">{{ $item->link }}</a></span>
                            </div>
                            <div class="d-flex justify-content-start px-1 align-items-center">
                                <span class="detail pl-2">Due Date :  {{ $item->due_date }}</span>
                            </div>
                            <div class="d-flex justify-content-start px-1 align-items-center">
                                <span class="detail pl-2">Assigned to : @foreach($team as $u) @if(in_array($u->id_user, explode(',', $item->assign_to))) <b class="text-primary">{{ $u->role }} - {{ $u->firstname }} {{ $u->lastname }}, </b> @endif @endforeach </span>
                            </div>
                            @endif
                            <hr>
                            <div class="px-1">
                                <p class="detail mb-1">Checklist : </p>
                                <div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated fs-10px" data-progress="{{ $item->percents }}">{{ $item->percents }}%</div></div>
                                @foreach($item->checklist as $key => $list)
                                    <div class="custom-control custom-checkbox py-1">
                                        <input type="checkbox" class="custom-control-input disabled" id="{{$list->id_checklist}}" disabled {{ $list->is_checked ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="{{$list->id_checklist}}" id="label{{$list->id_checklist}}" style="{{ $list->is_checked ? 'text-decoration-line: line-through;' : '' }}">{{ $list->checklist_title }}</label>
                                    </div>
                                    <br>
                                @endforeach
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- ----------------- END MODAL DETAIL 1 ---------------- -->
            @endforeach

        </div>

        <div class="swim-lane" id="1">
            <header class="kanban-board-header kanban-info">
                <div class="kanban-title-board">
                    <div class="kanban-title-content py-1">
                        <h6 class="title">DOING</h6>
                        <span class="badge rounded-pill bg-outline-info text-dark" id="status1">{{count($status_doing)}}</span>
                    </div>
                </div>
            </header>

            @foreach ($status_doing as $item)
            <div class="taskcard task" id="{{ $item->id_task }}" draggable="true">
                <div class="d-flex justify-content-between px-1">
                    <div class="kanban-title-content justify-content-start">
                        <div class="badge badge-priority text-wrap @php if($item->priority == 0){ echo 'bg-low'; } elseif($item->priority == 1) { echo 'bg-medium'; } elseif($item->priority == 2) { echo 'bg-high'; } else { echo 'bg-none'; } @endphp">
                            @php if($item->priority == 0){ echo 'Low'; } elseif($item->priority == 1) { echo 'Medium'; } elseif($item->priority == 2) { echo 'High'; } else { echo ''; } @endphp
                        </div>
                    </div>
                    <div class="kanban-title-content justify-content-end">
                        <div class="drodown">
                            <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <ul class="link-list-opt no-bdr">
                                    <li><a href="{{ route('task_detail', $item->id_task) }}"><em class="icon ni ni-edit"></em><span>Checklist</span></a></li>
                                    <li><a data-bs-toggle="modal" href="#edittask-{{ $item->id_task }}"><em class="icon ni ni-edit"></em><span>Edit Task</span></a></li>
                                    <li><a href="{{ route('remove_tasks', $item->id_task) }}"><em class="icon ni ni-delete"></em><span>Remove Task</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-1">
                    <h4 class="name mb-0"><a data-bs-toggle="modal" href="#detailtask-{{ $item->id_task }}" style="color: #464e56;">{{ $item->title }}</a></h4>
                    <p class="created mb-1">Assigned by: {{ $item->created_by }}</p>
                    <p class="quote2">{{ $item->note }}</p>
                </div>

                <div class="text-start mb-1">
                    @foreach ($item->file as $file)
                        <a target="_blank" href="{{ '/'.$file->file_path }}" class="btn btn-outline-light btn-file mr-1">{{ $file->file_name }}</a>
                    @endforeach
                </div>
                <div class="px-1">
                    <p class="created mb-1">Checklist : {{ $item->created_by }}</p>
                    <div class="progress progress-lg"><div class="progress-bar progress-bar-striped progress-bar-animated fs-10px" data-progress="{{ $item->percents }}">{{ $item->percents }}%</div></div>
                </div>

                @if($item->link)
                <div class="d-flex justify-content-start px-1 align-items-center pt-1">
                    <span class="detail pl-2">Link: <a href="{{ $item->link }}">{{ $item->link }}</a></span>
                </div>
                @endif

                <div class="d-flex justify-content-between px-1 align-items-center pb-1">
                    <div class="d-flex justify-content-start align-items-center">
                        <span class="detail pl-2"><i class="fa fa-flag" style="padding-right: 2px;"></i> {{ DateThaiNotime($item->due_date) }}</span>
                    </div>

                    <div class="d-flex justify-content-end">
                        @foreach ($item->members as $key => $member)
                            <img src="{{ $member->img }}" width="20" class="img{{ $key+1 }}" />
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- ----------------- MODAL EDIT ---------------- -->
            <div class="modal fade" tabindex="-1" role="dialog" id="edittask-{{ $item->id_task }}">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                        <div class="modal-body modal-body-md">
                            <form action="{{ route('update_tasks', $item->id_task) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control form-control-sm" id="ref_id_project" name="ref_id_project" placeholder="" value="{{ $project->id_project }}">
                                <div class="form-group row pt-2">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Title :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="" value="{{ $item->title }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Note :</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control form-control-sm" id="message-text" name="note">{{ $item->note }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Link :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" id="link" name="link" placeholder="" value="{{ $item->link }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">File :</label>                               
                                    <div class="col-sm-9">
                                        <div class="form-group" style="margin-bottom: 0.5rem;">
                                            <div class="form-control-wrap">
                                                @foreach ($item->file as $file)
                                                    <a href="{{ route('remove_task_file', $file->id_file) }}" class="btn btn-dim btn-outline-danger btn-file mr-1" onclick="return confirm('Are you sure to delete this file?');">{{ $file->file_name }} <em class="icon ni ni-file-remove"></em></a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="form-file" style="font-size: 12px;">
                                                    <input type="file" class="form-file-input" id="customFile" name="files[]" multiple />
                                                    <label class="form-file-label" for="customFile">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Due date :</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control form-control-sm" id="duedate" name="duedate" value="{{ $item->due_date }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Priority :</label>
                                    <div class="col-sm-10">
                                        <ul class="custom-control-group">
                                            <li>
                                                <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control">
                                                    <input type="radio" class="custom-control-input" name="priority" id="high-{{ $item->id_task }}" {{ $item->priority == 2 ? 'checked' : ''}} value="2">
                                                    <label class="custom-control-label no-control" style="background-color: indianred;color: white;" for="high-{{ $item->id_task }}">High</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control" >
                                                    <input type="radio" class="custom-control-input" name="priority" id="medium-{{ $item->id_task }}" {{ $item->priority == 1 ? 'checked' : ''}} value="1">
                                                    <label class="custom-control-label no-control" style="background-color: cornflowerblue;color: white;" for="medium-{{ $item->id_task }}">Medium</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control">
                                                    <input type="radio" class="custom-control-input" name="priority" id="low-{{ $item->id_task }}" {{ $item->priority == 0 ? 'checked' : ''}} value="0">
                                                    <label class="custom-control-label no-control" style="background-color: darkseagreen;color: white;" for="low-{{ $item->id_task }}">Low</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Assign :</label>
                                    <div class="form-control-wrap col-sm-10">
                                        <select class="form-select js-select2" multiple="multiple" data-placeholder="" name="task_team[]">
                                            @foreach($team as $u)
                                                <option value="{{ $u->id_user }}" {{ (in_array($u->id_user, explode(',', $item->assign_to))) ? 'selected' : '' }}><b class="text-primary">{{ $u->role }}</b> - {{ $u->firstname }} {{ $u->lastname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button class="btn btn-primary" type="submit">Update Task</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ----------------- END MODAL EDIT ---------------- -->

            <!-- ----------------- MODAL DETAIL 1 ---------------- -->
            <div class="modal fade" tabindex="-1" role="dialog" id="detailtask-{{ $item->id_task }}">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                        <div class="modal-body modal-body-md">

                            <div class="px-1">
                                <h4 class="name mb-0">{{ $item->title }}</h4>
                                <p class="created mb-1">Assigned by: {{ $item->created_by }}</p>
                                <p class="quote2">{{ $item->note }}</p>
                            </div>
                            <hr>
                            <div class="text-start mb-1 px-1">
                                <p class="detail mb-1">Attachment : </p>
                                @foreach ($item->file as $file)
                                    <a target="_blank" href="{{ '/'.$file->file_path }}" class="btn btn-outline-light btn-file mr-1">{{ $file->file_name }}</a>
                                @endforeach
                            </div>
                            @if($item->link)
                            <div class="d-flex justify-content-start px-1 align-items-center">
                                <span class="detail pl-2">Link : <a href="{{ $item->link }}">{{ $item->link }}</a></span>
                            </div>
                            <div class="d-flex justify-content-start px-1 align-items-center">
                                <span class="detail pl-2">Due Date :  {{ $item->due_date }}</span>
                            </div>
                            <div class="d-flex justify-content-start px-1 align-items-center">
                                <span class="detail pl-2">Assigned to : @foreach($team as $u) @if(in_array($u->id_user, explode(',', $item->assign_to))) <b class="text-primary">{{ $u->role }} - {{ $u->firstname }} {{ $u->lastname }}, </b> @endif @endforeach </span>
                            </div>
                            @endif
                            <hr>
                            <div class="px-1">
                                <p class="detail mb-1">Checklist : </p>
                                <div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated fs-10px" data-progress="{{ $item->percents }}">{{ $item->percents }}%</div></div>
                                @foreach($item->checklist as $key => $list)
                                    <div class="custom-control custom-checkbox py-1">
                                        <input type="checkbox" class="custom-control-input disabled" id="{{$list->id_checklist}}" disabled {{ $list->is_checked ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="{{$list->id_checklist}}" id="label{{$list->id_checklist}}" style="{{ $list->is_checked ? 'text-decoration-line: line-through;' : '' }}">{{ $list->checklist_title }}</label>
                                    </div>
                                    <br>
                                @endforeach
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- ----------------- END MODAL DETAIL 1 ---------------- -->
            @endforeach

        </div>

        <div class="swim-lane" id="2">
            <header class="kanban-board-header kanban-success">
                <div class="kanban-title-board">
                    <div class="kanban-title-content py-1">
                        <h6 class="title">DONE</h6>
                        <span class="badge rounded-pill bg-outline-success text-dark" id="status2">{{count($status_done)}}</span>
                    </div>
                </div>
            </header>

            @foreach ($status_done as $item)
            <div class="taskcard task" id="{{ $item->id_task }}" draggable="true">
                <div class="d-flex justify-content-between px-1">
                    <div class="kanban-title-content justify-content-start">
                        <div class="badge badge-priority text-wrap @php if($item->priority == 0){ echo 'bg-low'; } elseif($item->priority == 1) { echo 'bg-medium'; } elseif($item->priority == 2) { echo 'bg-high'; } else { echo 'bg-none'; } @endphp">
                            @php if($item->priority == 0){ echo 'Low'; } elseif($item->priority == 1) { echo 'Medium'; } elseif($item->priority == 2) { echo 'High'; } else { echo ''; } @endphp
                        </div>
                    </div>
                    <div class="kanban-title-content justify-content-end">
                        <div class="drodown">
                            <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <ul class="link-list-opt no-bdr">
                                    <li><a href="{{ route('task_detail', $item->id_task) }}"><em class="icon ni ni-edit"></em><span>Checklist</span></a></li>
                                    <li><a data-bs-toggle="modal" href="#edittask-{{ $item->id_task }}"><em class="icon ni ni-edit"></em><span>Edit Task</span></a></li>
                                    <li><a href="{{ route('remove_tasks', $item->id_task) }}"><em class="icon ni ni-delete"></em><span>Remove Task</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-1">
                    <h4 class="name mb-0"><a data-bs-toggle="modal" href="#detailtask-{{ $item->id_task }}" style="color: #464e56;">{{ $item->title }}</a></h4>
                    <p class="created mb-1">Assigned by: {{ $item->created_by }}</p>
                    <p class="quote2">{{ $item->note }}</p>
                </div>

                <div class="text-start mb-1">
                    @foreach ($item->file as $file)
                        <a target="_blank" href="{{ '/'.$file->file_path }}" class="btn btn-outline-light btn-file mr-1">{{ $file->file_name }}</a>
                    @endforeach
                </div>
                <div class="px-1">
                    <p class="created mb-1">Checklist : {{ $item->created_by }}</p>
                    <div class="progress progress-lg"><div class="progress-bar progress-bar-striped progress-bar-animated fs-10px" data-progress="{{ $item->percents }}">{{ $item->percents }}%</div></div>
                </div>

                @if($item->link)
                <div class="d-flex justify-content-start px-1 align-items-center pt-1">
                    <span class="detail pl-2">Link: <a href="{{ $item->link }}">{{ $item->link }}</a></span>
                </div>
                @endif

                <div class="d-flex justify-content-between px-1 align-items-center pb-1">
                    <div class="d-flex justify-content-start align-items-center">
                        <span class="detail pl-2"><i class="fa fa-flag" style="padding-right: 2px;"></i> {{ DateThaiNoTime($item->due_date) }}</span>
                    </div>

                    <div class="d-flex justify-content-end">
                        @foreach ($item->members as $key => $member)
                            <img src="{{ $member->img }}" width="20" class="img{{ $key+1 }}" />
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- ----------------- MODAL EDIT ---------------- -->
            <div class="modal fade" tabindex="-1" role="dialog" id="edittask-{{ $item->id_task }}">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                        <div class="modal-body modal-body-md">
                            <form action="{{ route('update_tasks', $item->id_task) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control form-control-sm" id="ref_id_project" name="ref_id_project" placeholder="" value="{{ $project->id_project }}">
                                <div class="form-group row pt-2">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Title :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="" value="{{ $item->title }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Note :</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control form-control-sm" id="message-text" name="note">{{ $item->note }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Link :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" id="link" name="link" placeholder="" value="{{ $item->link }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">File :</label>                               
                                    <div class="col-sm-9">
                                        <div class="form-group" style="margin-bottom: 0.5rem;">
                                            <div class="form-control-wrap">
                                                @foreach ($item->file as $file)
                                                    <a href="{{ route('remove_task_file', $file->id_file) }}" class="btn btn-dim btn-outline-danger btn-file mr-1" onclick="return confirm('Are you sure to delete this file?');">{{ $file->file_name }} <em class="icon ni ni-file-remove"></em></a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="form-file" style="font-size: 12px;">
                                                    <input type="file" class="form-file-input" id="customFile" name="files[]" multiple />
                                                    <label class="form-file-label" for="customFile">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Due date :</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control form-control-sm" id="duedate" name="duedate" value="{{ $item->due_date }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Priority :</label>
                                    <div class="col-sm-10">
                                        <ul class="custom-control-group">
                                            <li>
                                                <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control">
                                                    <input type="radio" class="custom-control-input" name="priority" id="high-{{ $item->id_task }}" {{ $item->priority == 2 ? 'checked' : ''}} value="2">
                                                    <label class="custom-control-label no-control" style="background-color: indianred;color: white;" for="high-{{ $item->id_task }}">High</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control" >
                                                    <input type="radio" class="custom-control-input" name="priority" id="medium-{{ $item->id_task }}" {{ $item->priority == 1 ? 'checked' : ''}} value="1">
                                                    <label class="custom-control-label no-control" style="background-color: cornflowerblue;color: white;" for="medium-{{ $item->id_task }}">Medium</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control">
                                                    <input type="radio" class="custom-control-input" name="priority" id="low-{{ $item->id_task }}" {{ $item->priority == 0 ? 'checked' : ''}} value="0">
                                                    <label class="custom-control-label no-control" style="background-color: darkseagreen;color: white;" for="low-{{ $item->id_task }}">Low</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Assign :</label>
                                    <div class="form-control-wrap col-sm-10">
                                        <select class="form-select js-select2" multiple="multiple" data-placeholder="" name="task_team[]">
                                            @foreach($team as $u)
                                                <option value="{{ $u->id_user }}" {{ (in_array($u->id_user, explode(',', $item->assign_to))) ? 'selected' : '' }}><b class="text-primary">{{ $u->role }}</b> - {{ $u->firstname }} {{ $u->lastname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button class="btn btn-primary" type="submit">Update Task</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ----------------- END MODAL EDIT ---------------- -->

            <!-- ----------------- MODAL DETAIL 1 ---------------- -->
            <div class="modal fade" tabindex="-1" role="dialog" id="detailtask-{{ $item->id_task }}">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                        <div class="modal-body modal-body-md">

                            <div class="px-1">
                                <h4 class="name mb-0">{{ $item->title }}</h4>
                                <p class="created mb-1">Assigned by: {{ $item->created_by }}</p>
                                <p class="quote2">{{ $item->note }}</p>
                            </div>
                            <hr>
                            <div class="text-start mb-1 px-1">
                                <p class="detail mb-1">Attachment : </p>
                                @foreach ($item->file as $file)
                                    <a target="_blank" href="{{ '/'.$file->file_path }}" class="btn btn-outline-light btn-file mr-1">{{ $file->file_name }}</a>
                                @endforeach
                            </div>
                            @if($item->link)
                            <div class="d-flex justify-content-start px-1 align-items-center">
                                <span class="detail pl-2">Link : <a href="{{ $item->link }}">{{ $item->link }}</a></span>
                            </div>
                            <div class="d-flex justify-content-start px-1 align-items-center">
                                <span class="detail pl-2">Due Date :  {{ $item->due_date }}</span>
                            </div>
                            <div class="d-flex justify-content-start px-1 align-items-center">
                                <span class="detail pl-2">Assigned to : @foreach($team as $u) @if(in_array($u->id_user, explode(',', $item->assign_to))) <b class="text-primary">{{ $u->role }} - {{ $u->firstname }} {{ $u->lastname }}, </b> @endif @endforeach </span>
                            </div>
                            @endif
                            <hr>
                            <div class="px-1">
                                <p class="detail mb-1">Checklist : </p>
                                <div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated fs-10px" data-progress="{{ $item->percents }}">{{ $item->percents }}%</div></div>
                                @foreach($item->checklist as $key => $list)
                                    <div class="custom-control custom-checkbox py-1">
                                        <input type="checkbox" class="custom-control-input disabled" id="{{$list->id_checklist}}" disabled {{ $list->is_checked ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="{{$list->id_checklist}}" id="label{{$list->id_checklist}}" style="{{ $list->is_checked ? 'text-decoration-line: line-through;' : '' }}">{{ $list->checklist_title }}</label>
                                    </div>
                                    <br>
                                @endforeach
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- ----------------- END MODAL DETAIL 1 ---------------- -->
            @endforeach

        </div>

        <div class="swim-lane" id="3">
            <header class="kanban-board-header kanban-danger">
                <div class="kanban-title-board">
                    <div class="kanban-title-content py-1">
                        <h6 class="title">REJECT</h6>
                        <span class="badge rounded-pill bg-outline-danger text-dark" id="status3">{{count($status_reject)}}</span>
                    </div>
                </div>
            </header>

            @foreach ($status_reject as $item)
            <div class="taskcard task" id="{{ $item->id_task }}" draggable="true">
                <div class="d-flex justify-content-between px-1">
                    <div class="kanban-title-content justify-content-start">
                        <div class="badge badge-priority text-wrap @php if($item->priority == 0){ echo 'bg-low'; } elseif($item->priority == 1) { echo 'bg-medium'; } elseif($item->priority == 2) { echo 'bg-high'; } else { echo 'bg-none'; } @endphp">
                            @php if($item->priority == 0){ echo 'Low'; } elseif($item->priority == 1) { echo 'Medium'; } elseif($item->priority == 2) { echo 'High'; } else { echo ''; } @endphp
                        </div>
                    </div>
                    <div class="kanban-title-content justify-content-end">
                        <div class="drodown">
                            <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger me-n1" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <ul class="link-list-opt no-bdr">
                                    <li><a href="{{ route('task_detail', $item->id_task) }}"><em class="icon ni ni-edit"></em><span>Checklist</span></a></li>
                                    <li><a data-bs-toggle="modal" href="#edittask-{{ $item->id_task }}"><em class="icon ni ni-edit"></em><span>Edit Task</span></a></li>
                                    <li><a href="{{ route('remove_tasks', $item->id_task) }}"><em class="icon ni ni-delete"></em><span>Remove Task</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-1">
                    <h4 class="name mb-0"><a data-bs-toggle="modal" href="#detailtask-{{ $item->id_task }}" style="color: #464e56;">{{ $item->title }}</a></h4>
                    <p class="created mb-1">Assigned by: {{ $item->created_by }}</p>
                    <p class="quote2">{{ $item->note }}</p>
                </div>

                <div class="text-start mb-1">
                    @foreach ($item->file as $file)
                        <a target="_blank" href="{{ '/'.$file->file_path }}" class="btn btn-outline-light btn-file mr-1">{{ $file->file_name }}</a>
                    @endforeach
                </div>
                <div class="px-1">
                    <p class="created mb-1">Checklist : {{ $item->created_by }}</p>
                    <div class="progress progress-lg"><div class="progress-bar progress-bar-striped progress-bar-animated fs-10px" data-progress="{{ $item->percents }}">{{ $item->percents }}%</div></div>
                </div>

                @if($item->link)
                <div class="d-flex justify-content-start px-1 align-items-center pt-1">
                    <span class="detail pl-2">Link: <a href="{{ $item->link }}">{{ $item->link }}</a></span>
                </div>
                @endif

                <div class="d-flex justify-content-between px-1 align-items-center pb-1">
                    <div class="d-flex justify-content-start align-items-center">
                        <span class="detail pl-2"><i class="fa fa-flag" style="padding-right: 2px;"></i> {{ DateThaiNoTime($item->due_date) }}</span>
                    </div>

                    <div class="d-flex justify-content-end">
                        @foreach ($item->members as $key => $member)
                            <img src="{{ $member->img }}" width="20" class="img{{ $key+1 }}" />
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- ----------------- MODAL EDIT ---------------- -->
            <div class="modal fade" tabindex="-1" role="dialog" id="edittask-{{ $item->id_task }}">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                        <div class="modal-body modal-body-md">
                            <form action="{{ route('update_tasks', $item->id_task) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control form-control-sm" id="ref_id_project" name="ref_id_project" placeholder="" value="{{ $project->id_project }}">
                                <div class="form-group row pt-2">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Title :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="" value="{{ $item->title }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Note :</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control form-control-sm" id="message-text" name="note">{{ $item->note }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Link :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" id="link" name="link" placeholder="" value="{{ $item->link }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">File :</label>                               
                                    <div class="col-sm-9">
                                        <div class="form-group" style="margin-bottom: 0.5rem;">
                                            <div class="form-control-wrap">
                                                @foreach ($item->file as $file)
                                                    <a href="{{ route('remove_task_file', $file->id_file) }}" class="btn btn-dim btn-outline-danger btn-file mr-1" onclick="return confirm('Are you sure to delete this file?');">{{ $file->file_name }} <em class="icon ni ni-file-remove"></em></a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="form-file" style="font-size: 12px;">
                                                    <input type="file" class="form-file-input" id="customFile" name="files[]" multiple />
                                                    <label class="form-file-label" for="customFile">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Due date :</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control form-control-sm" id="duedate" name="duedate" value="{{ $item->due_date }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Priority :</label>
                                    <div class="col-sm-10">
                                        <ul class="custom-control-group">
                                            <li>
                                                <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control">
                                                    <input type="radio" class="custom-control-input" name="priority" id="high-{{ $item->id_task }}" {{ $item->priority == 2 ? 'checked' : ''}} value="2">
                                                    <label class="custom-control-label no-control" style="background-color: indianred;color: white;" for="high-{{ $item->id_task }}">High</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control" >
                                                    <input type="radio" class="custom-control-input" name="priority" id="medium-{{ $item->id_task }}" {{ $item->priority == 1 ? 'checked' : ''}} value="1">
                                                    <label class="custom-control-label no-control" style="background-color: cornflowerblue;color: white;" for="medium-{{ $item->id_task }}">Medium</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-control-sm custom-radio custom-control-pro no-control">
                                                    <input type="radio" class="custom-control-input" name="priority" id="low-{{ $item->id_task }}" {{ $item->priority == 0 ? 'checked' : ''}} value="0">
                                                    <label class="custom-control-label no-control" style="background-color: darkseagreen;color: white;" for="low-{{ $item->id_task }}">Low</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Assign :</label>
                                    <div class="form-control-wrap col-sm-10">
                                        <select class="form-select js-select2" multiple="multiple" data-placeholder="" name="task_team[]">
                                            @foreach($team as $u)
                                                <option value="{{ $u->id_user }}" {{ (in_array($u->id_user, explode(',', $item->assign_to))) ? 'selected' : '' }}><b class="text-primary">{{ $u->role }}</b> - {{ $u->firstname }} {{ $u->lastname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button class="btn btn-primary" type="submit">Update Task</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ----------------- END MODAL EDIT ---------------- -->

            <!-- ----------------- MODAL DETAIL 1 ---------------- -->
            <div class="modal fade" tabindex="-1" role="dialog" id="detailtask-{{ $item->id_task }}">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                        <div class="modal-body modal-body-md">

                            <div class="px-1">
                                <h4 class="name mb-0">{{ $item->title }}</h4>
                                <p class="created mb-1">Assigned by: {{ $item->created_by }}</p>
                                <p class="quote2">{{ $item->note }}</p>
                            </div>
                            <hr>
                            <div class="text-start mb-1 px-1">
                                <p class="detail mb-1">Attachment : </p>
                                @foreach ($item->file as $file)
                                    <a target="_blank" href="{{ '/'.$file->file_path }}" class="btn btn-outline-light btn-file mr-1">{{ $file->file_name }}</a>
                                @endforeach
                            </div>
                            @if($item->link)
                            <div class="d-flex justify-content-start px-1 align-items-center">
                                <span class="detail pl-2">Link : <a href="{{ $item->link }}">{{ $item->link }}</a></span>
                            </div>
                            <div class="d-flex justify-content-start px-1 align-items-center">
                                <span class="detail pl-2">Due Date :  {{ $item->due_date }}</span>
                            </div>
                            <div class="d-flex justify-content-start px-1 align-items-center">
                                <span class="detail pl-2">Assigned to : @foreach($team as $u) @if(in_array($u->id_user, explode(',', $item->assign_to))) <b class="text-primary">{{ $u->role }} - {{ $u->firstname }} {{ $u->lastname }}, </b> @endif @endforeach </span>
                            </div>
                            @endif
                            <hr>
                            <div class="px-1">
                                <p class="detail mb-1">Checklist : </p>
                                <div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated fs-10px" data-progress="{{ $item->percents }}">{{ $item->percents }}%</div></div>
                                @foreach($item->checklist as $key => $list)
                                    <div class="custom-control custom-checkbox py-1">
                                        <input type="checkbox" class="custom-control-input disabled" id="{{$list->id_checklist}}" disabled {{ $list->is_checked ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="{{$list->id_checklist}}" id="label{{$list->id_checklist}}" style="{{ $list->is_checked ? 'text-decoration-line: line-through;' : '' }}">{{ $list->checklist_title }}</label>
                                    </div>
                                    <br>
                                @endforeach
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- ----------------- END MODAL DETAIL 1 ---------------- -->
            @endforeach

        </div>

    </div>

    @endsection

    @section('js_script')

    <script src="{{ asset('assets/js/kanban.js') }}"></script>

    @endsection