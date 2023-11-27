@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/project.css') }}">

<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">Projects</h3>
            <div class="nk-block-des text-soft">
                <!-- <span class="badge rounded-pill bg-info">โปรเจ็คจำนวน {{ count($project) }} รายการ</span> -->
            </div>
        </div>
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle"><a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        @if ($filter_id)
                            <li>
                                <span style="font-size: 10px;">Filter By : <a href="{{ route('project_list') }}" class="btn btn-dim btn-outline-danger btn-file mr-1" onclick="return confirm('Are you sure to remove filter?');" style="font-size: 9px;">{{ $filter_person->name_project }} <em class="icon ni ni-trash"></em></a></span>
                            </li>
                        @endif
                        <li>
                            <div class="drodown">
                                <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown" style="border-radius: 10px;">
                                    <em class="d-none d-sm-inline icon ni ni-filter-alt"></em>
                                    <span>Filtered By</span>
                                    <!-- <em class="dd-indc icon ni ni-chevron-right"></em> -->
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                <input type="text" class="form-control" id="filterInput" onkeyup="filterBy()" placeholder="Search for names.." title="Type in a name">
                                    <ul id="myUL" class="link-list-opt no-bdr">
                                        @foreach ($project as $key => $item)
                                            @if($_SESSION['role'] == 'Chief')
                                                <li><a href="{{ route('project_list', ['filter' => $item->id_project]) }}"><span>{{ $item->name_project }}</span></a></li>
                                            @elseif(count($item->is_myproject) >= 1)
                                                <li><a href="{{ route('project_list', ['filter' => $item->id_project]) }}"><span>{{ $item->name_project }}</span></a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nk-block-tools-opt d-none d-sm-block">
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_project" style="border-radius: 10px;">
                                <em class="icon ni ni-plus"></em>
                                <span>New Project</span>
                            </a>
                        </li>
                        <li class="nk-block-tools-opt d-block d-sm-none"><a href="#" class="btn btn-icon btn-primary"><em class="icon ni ni-plus"></em></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="nk-block">
    <div class="row g-gs">
        @foreach($project as $p)
        <!-- เช็คว่า หากไม่ใช่ project ของ user นั้นให้ข้าม ยกเว้น cheif จะเห็นทั้งหมด -->
        @if($_SESSION['role'] == 'Chief')
            @if($filter_id && count($p->is_myproject) >= 1)
                <!-- แสดงโปรเจค -->
            @elseif ($filter_id && count($p->is_myproject) >= 0)
                @continue <!-- ข้าม -->
            @else
                <!-- แสดงโปรเจค -->
            @endif
        @elseif($filter_id && count($p->is_myproject) >= 1)
            <!-- แสดงโปรเจค -->
        @elseif (!$filter_id && count($p->is_myproject) >= 1)
            <!-- แสดงโปรเจค -->
        @else
            @continue <!-- ข้าม -->
        @endif
        <div class="col-sm-6 col-lg-4 col-xxl-4">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="project">
                        <div class="project-head"><a href="{{ route('task_list',$p->id_project) }}" class="project-title">
                                <div class="user-avatar sq">
                                    <span>{{substr($p->name_project, 0, 1)}}</span>
                                </div>
                                <div class="project-info">
                                    <h6 class="title">{{ $p->name_project }}</h6>
                                </div>
                            </a>
                            <div class="drodown"><a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger mt-n1 me-n1" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li>
                                            <a href="{{ route('task_list', $p->id_project) }}">
                                                <em class="icon ni ni-eye"></em>
                                                <span>View Project</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#edit_project_{{ $p->id_project }}"><em class="icon ni ni-edit"></em><span>Edit Project</span></a></li>
                                        <li>
                                            <a href="{{ route('remove_project', $p->id_project) }}"><em class="icon ni ni-delete"></em><span>Remove Project</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="project-details">
                            <p>{{ $p->desciption_project }}</p>
                        </div>
                        <div class="project-meta">
                            <div>
                                <a href="{{ route('task_list',$p->id_project) }}" class="btn btn-dim btn-primary">{{ count($p->task) }} Task <em class="icon ni ni-pen-alt-fill" style="padding-left: 5px;"></em></a>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#project_library_{{ $p->id_project }}" class="btn btn-dim btn-primary">Library <em class="icon ni ni-book-fill" style="padding-left: 5px;"></em></a>
                            </div>
                            <ul class="project-users g-1">
                                @foreach($p->team as $key => $t)
                                    @if($key < 2)
                                    <li>
                                        <div class="user-avatar sm bg-blue"><img src="{{$t->img}}" alt=""></div>
                                    </li>
                                    @endif
                                    @if($key >= 2)
                                    <li>
                                        <div class="user-avatar bg-light sm"><span>+{{count($p->team)-2}}</span></div>
                                    </li>
                                    @break
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ------------------------------------ MODAL EDIT ---------------------------------- -->
        <div class="modal fade" tabindex="-1" id="edit_project_{{ $p->id_project }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Edit Project
                        </h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
                    </div>
                    <div class="card-inner">
                        <div class="preview-block">
                            <form action="{{ route('update_project', $p->id_project) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="name_project">Project Name :</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="name_project" name="name_project" placeholder="" value="{{ $p->name_project }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group"><label class="form-label" for="desciption_project">Project Description :</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control no-resize" id="desciption_project" name="desciption_project">{{ $p->desciption_project }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group"><label class="form-label">Members :</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2" multiple="multiple" data-placeholder="Select Multiple options" name="project_team[]">
                                                    @foreach($user as $u)
                                                        <option value="{{ $u->id_user }}" {{ $p->team->contains('ref_id_user', $u->id_user) ? 'selected' : '' }}><b class="text-primary">{{ $u->role }}</b> - {{ $u->firstname }} {{ $u->lastname }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="nk-block nk-block-lg">
                                    <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="title nk-block-title">Project Library</h5>
                                    </div>
                                    </div>
                                    <div class="card">
                                        <textarea class="summernote-basic" id="summernote_{{ $p->id_project }}" name="project_library">{!! nl2br($p->library_project) !!}</textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Update Project</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ------------------------------------ MODAL EDIT ---------------------------------- -->

        <!-- ------------------------------------ MODAL LIBRARY ---------------------------------- -->
        <div class="modal fade" tabindex="-1" id="project_library_{{ $p->id_project }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Project Library
                        </h5>
                        <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
                    </div>
                    <div class="card-inner">
                        <div class="preview-block">
                            {!! nl2br($p->library_project) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ------------------------------------ MODAL LIBRARY ---------------------------------- -->

        @endforeach
    </div>
</div>


<div class="modal fade" tabindex="-1" id="add_project">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    New Project
                </h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
            </div>
            <div class="card-inner">
                <div class="preview-block">
                    <form action="{{ route('insert_project') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="name_project">Project Name :</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="name_project" name="name_project" placeholder="" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group"><label class="form-label" for="desciption_project">Project Description :</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control no-resize" id="desciption_project" name="desciption_project" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group"><label class="form-label">Members :</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2" multiple="multiple" data-placeholder="Select Multiple options" name="project_team[]" required>
                                            @foreach($user as $u)
                                            <option value="{{ $u->id_user }}">{{ $u->firstname }} {{ $u->lastname }} - <b class="text-primary">{{ $u->role }}</b></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="nk-block nk-block-lg">
                            <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="title nk-block-title">Project Library</h5>
                            </div>
                            </div>
                            <div class="card">
                                <textarea class="summernote-basic" id="summernote" name="project_library"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Add Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js_script')

<script>
function filterBy() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("filterInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

$(document).ready(function() {
    $('#summernote').summernote({ height: 140 });
    @foreach($project as $p)
        $('#summernote_{{ $p->id_project }}').summernote({ height: 140 });
    @endforeach
});
</script>

<link rel="stylesheet" href="{{ asset('assets/css/editors/summernotedeae.css?ver=3.2.1') }}">
<script src="{{ asset('assets/js/libs/editors/summernotedeae.js?ver=3.2.1') }}"></script>
<script src="{{ asset('assets/js/editorsdeae.js?ver=3.2.1') }}"></script>

@endsection