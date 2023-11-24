@extends('layout')
@section('content')

<link id="skin-default" rel="stylesheet" href="{{ asset('../../assets/css/datatable_bytle.css') }}" />
<style>
    .gallery>img {
        max-width: 100%;
        width: 250px;
        height: 250px;
        border: solid;
        margin: 0px 10px 10px 10px;
        border-radius: 25px;

    }

    .img-profile {
        width: 100px;
        height: 100px;
        border-radius: 10px;
    }

    .item-photo__preview {
        max-width: 100%;
        width: 250px;
        height: 250px;
        border: solid;
        margin: 0px 10px 10px 10px;
        border-radius: 25px;
        display: inline;
    }
</style>

<div class="nk-block nk-block-lg">


    @csrf
    <div class="row">

        <div class="d-flex  mb-3">
            <div class="p-2 ">
                <h4 class="nk-block-title">รายการประชุม</h4>
            </div>
            <div class="ms-auto p-2 ">
                <button type="button" class="btn btn-primary mr-1" data-bs-toggle="modal" data-bs-target="#add_meeting">+ เพิ่มรายการประชุม</button>
            </div>
        </div>
    </div>


    <div class="card card-bordered card-preview">
        <div class="card-inner">
            <table class="meet_list table" id="table">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>หัวข้อประชุม</th>
                        <th>ลิ้งประชุม</th>
                        <th>รายละเอียด</th>
                        <th>วันที่</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($meet as $key => $m)
                    <tr class="text-center">
                        <td>{{ ++$key }}</td>
                        <td>{{ $m->title }}</td>
                        <td><a href="{{ $m->link }}">{{ $m->link }}</a></td>
                        <td>{{ $m->description }}</td>
                        <td>{{ DateThai($m->date_start) }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-success mr-1" data-bs-toggle="modal" data-bs-target="#edit_meeting{{ $m->id_meeting }}">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="add_meeting">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-user"></i> เพิ่มรายการประชุม
                </h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
            </div>
            <div class="card-inner">
                <div class="preview-block">
                    <form action="{{ route('insert_meeting') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-06">
                                        Project
                                    </label>
                                    <div class="form-control-wrap">
                                        <div class="form-control-select">
                                            <select class="form-control" id="default-06" name="ref_id_project">
                                                @foreach($project as $p)
                                                <option value="{{ $p->id_project }}">{{ $p->name_project }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group"><label class="form-label">ผู้ร่วมประชุม</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2" multiple="multiple" data-placeholder="Select Multiple options" name="meeting_member[]">
                                            @foreach($user as $u)
                                            <option value="{{ $u->id_user }}">{{ $u->firstname }} {{ $u->lastname }} - <b class="text-primary">{{ $u->role }}</b></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="title">หัวข้อประชุม</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="title" name="title" placeholder="หัวข้อประชุม" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="link">ลิ้งประชุม</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="link" name="link" placeholder="ลิ้งประชุม" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="description">รายละเอียด</label>
                                    <div class="form-control-wrap">
                                        <textarea type="text" class="form-control" id="description" name="description" placeholder="รายละเอียด"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="date_start">วันที่ประชุม</label>
                                    <div class="form-control-wrap">
                                        <input type="datetime-local" class="form-control" id="date_start" name="date_start" placeholder="วันที่ประชุม" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" style="float: right;" class="btn btn-success float-right">บันทึกข้อมูล</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($meet as $key => $m)
<div class="modal fade" tabindex="-1" id="edit_meeting{{ $m->id_meeting }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-user"></i> แก้ไขรายการประชุม
                </h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
            </div>
            <div class="card-inner">
                <div class="preview-block">
                    <form action="{{ route('update_meeting',$m->id_meeting) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-06">
                                        Project
                                    </label>
                                    <div class="form-control-wrap">
                                        <div class="form-control-select">
                                            <select class="form-control" id="default-06" name="ref_id_project">
                                                @foreach($project as $p)
                                                <option value="{{ $p->id_project }}"  {{ $m->ref_id_project == $p->id_project ? 'selected' : ' ' }}>{{ $p->name_project }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group"><label class="form-label">ผู้ร่วมประชุม</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2" multiple="multiple" data-placeholder="Select Multiple options" name="meeting_member[]">
                                            @foreach($user as $u)
                                            <option value="{{ $u->id_user }}"  {{ in_array($u->id_user,$m->member_arr) ? 'selected' : ' ' }}>{{ $u->firstname }} {{ $u->lastname }} - <b class="text-primary">{{ $u->role }}</b></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="title">หัวข้อประชุม</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="title" name="title" placeholder="หัวข้อประชุม" value="{{ $m->title }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="link">ลิ้งประชุม</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="link" name="link" placeholder="ลิ้งประชุม" value="{{ $m->link }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="description">รายละเอียด</label>
                                    <div class="form-control-wrap">
                                        <textarea type="text" class="form-control" id="description" name="description" placeholder="รายละเอียด">{{ $m->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="date_start">วันที่ประชุม</label>
                                    <div class="form-control-wrap">
                                        <input type="datetime-local" class="form-control" id="date_start" name="date_start" placeholder="วันที่ประชุม" value="{{ $m->date_start }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" style="float: right;" class="btn btn-success float-right">บันทึกข้อมูล</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach

@endsection

@section('js_script')
<script>
    $(document).ready(function() {
        var table = $('.meet_list').DataTable({
            "pageLength": 15,
            responsive: {
                details: !0
            },
            // dom: "Pfrtip",
            // searchPanes: {
            //     columns: [2, 3, 4],
            //     initCollapsed: false,
            //     cascadePanes: true,
            //     dtOpts: {
            //         select: {
            //             style: "multi",
            //         },
            //     },
            // },

            language: {
                search: "",
                searchPlaceholder: "ค้นหาด้วยKeywordข้อมูล",
                lengthMenu: "<span class='d-none d-sm-inline-block'>Show</span><div class='form-control-select'> _MENU_ </div>",
                info: "_START_ -_END_ of _TOTAL_",
                infoEmpty: "",
                infoFiltered: "( Total _MAX_  )",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Prev",
                },
            },
        });


    });
</script>

<script type="text/javascript">
    function preview_img(t) {
        $('.gallery').find('img').remove();
        var name_class = 'div.gallery';
        imagesPreview(t, name_class);

    }

    function imagesPreview(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                console.log(reader);

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }

    }

    function rm_old_img() {
        $('.gallery').find('img').remove();
    }
</script>
@endsection