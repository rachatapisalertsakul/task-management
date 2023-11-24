@extends('layout')
@section('content')

<!-- <div class="nk-block nk-block-lg">
    <div class="card card-bordered card-preview">

    </div>
</div> -->

<link rel="stylesheet" href="{{ asset('assets/css/kanban.css') }}">
            <div class="d-flex ">
                <div class="p-2 flex-grow-1">
                    <h1 class="nk-block-title page-title">
                        <b> <a href="{{ route('project_list') }}"><u class="text-info">Projects</u></a> / <a href="{{ route('task_list', $task->ref_id_project) }}"><u class="text-info">{{ $project->name_project }}</u></a> / <span class="project-name">{{ $task->title }}</span></b>
                    </h1>
                </div>
                <div class="p-2">
                    <!-- ปุ่มเพิ่ม checklist และ Modal -->
                    <a data-bs-toggle="modal" href="#newchecklist" class="btn btn-primary btn-sm" style="border-radius: 10px;"><span class="ms-1">+ New Checklist</span></a>
                    <div class="modal fade" tabindex="-1" role="dialog" id="newchecklist">
                        <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content">
                                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                                <div class="modal-body modal-body-md">
                                    <form action="{{ route('insert_checklist') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control form-control-sm" id="ref_id_project" name="ref_id_project" placeholder="" value="{{ $task->ref_id_project }}">
                                        <input type="hidden" class="form-control form-control-sm" id="ref_id_task" name="ref_id_task" placeholder="" value="{{ $task->id_task }}">
                                        <div class="form-group row pt-2">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">Title :</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button class="btn btn-primary" type="submit">Add Checklist</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="card card-bordered card-preview" style="border-radius: 20px;">
    <div class="card-inner">
            <div class="p-2">
                <div class="px-1">
                    <h4 class="name mb-0">{{ $task->title }}</h4>
                    <p class="created mb-1">Assigned by: {{ $task->created_by }}</p>
                    <p class="quote2">{{ $task->note }}</p>
                </div>
                <div class="text-start mb-1 px-1">
                    <p class="detail mb-1">Attachment : </p>
                    @foreach ($task->file as $file)
                        <a target="_blank" href="{{ '/'.$file->file_path }}" class="btn btn-outline-light btn-file mr-1">{{ $file->file_name }}</a>
                    @endforeach
                </div>
                @if($task->link)
                <div class="d-flex justify-content-start px-1 align-items-center">
                    <span class="detail pl-2">Link : <a href="{{ $task->link }}">{{ $task->link }}</a></span>
                </div>
                <div class="d-flex justify-content-start px-1 align-items-center">
                    <span class="detail pl-2">Due Date :  {{ $task->due_date }}</span>
                </div>
                <div class="d-flex justify-content-start px-1 align-items-center">
                    <span class="created pl-2">Assigned to : @foreach($task->members as $u) @if(in_array($u->id_user, explode(',', $task->assign_to))) <b class="text-primary">{{ $u->role }} - {{ $u->firstname }} {{ $u->lastname }}, </b> @endif @endforeach </span>
                </div>
                @endif
                <hr>
                <div class="px-1">
                    <p class="mb-1">Checklist : </p>
                    <div class="progress progress-lg mb-2"><div class="progress-bar progress-bar-striped progress-bar-animated fs-10px" id="progress-bar" data-progress="{{ $percents }}">{{ $percents }}%</div></div>
                    @foreach($checklist as $key => $list)
                        <div class="custom-control custom-checkbox pb-2 pr-4">
                            <input type="checkbox" class="custom-control-input" id="{{$list->id_checklist}}" {{ $list->is_checked ? 'checked' : '' }}>
                            <label class="custom-control-label" for="{{$list->id_checklist}}" id="label{{$list->id_checklist}}" style="{{ $list->is_checked ? 'text-decoration-line: line-through;' : '' }}">{{ $list->checklist_title }}</label>
                        </div>
                        <a href="{{ route('remove_checklist', [$task->id_task, $list->id_checklist]) }}" class="btn btn-sm btn-dim btn-danger pl-3">x</a>
                        <br>
                    @endforeach
                </div>
            </div>
    </div>
</div>
@endsection

@section('js_script')

<script>
$(document).ready(function () {
    $('.custom-control-input').click(function() {
        let checklist_id = $(this).attr('id');
            if(this.checked) {
                $.get("/task_detail/update_checklist/{{$task->id_task}}/" + checklist_id + "/1", function(res) {
                    document.getElementById('progress-bar').innerHTML = res+'%';
                    document.getElementById('progress-bar').style.width = res+'%';
                    document.getElementById("label"+checklist_id).style.textDecorationLine = "line-through";

                    !(function(o, t) {
                    o.Toast("Update Checklist Successfully!", "success", {
                        position: "top-right",
                        timeOut: "2000",
                    });
                    })(NioApp, jQuery);

                });
            } else {
                $.get("/task_detail/update_checklist/{{$task->id_task}}/" + checklist_id + "/0", function(res) {
                    document.getElementById('progress-bar').innerHTML = res+'%';
                    document.getElementById('progress-bar').style.width = res+'%';
                    document.getElementById("label"+checklist_id).style.textDecorationLine = "none";

                    !(function(o, t) {
                    o.Toast("Update Checklist Successfully!", "success", {
                        position: "top-right",
                        timeOut: "2000",
                    });
                    })(NioApp, jQuery);

                });
            }
        });
});

</script>

@endsection