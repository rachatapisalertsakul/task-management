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
                <h4 class="nk-block-title">รายชื่อผู้ใช้งานทั้งหมด</h4>
            </div>
            <div class="ms-auto p-2 ">
                <button type="button" class="btn btn-primary mr-1" data-bs-toggle="modal" data-bs-target="#add_user">+ เพิ่มผู้ใช้งาน</button>
            </div>
        </div>
    </div>


    <div class="card card-bordered card-preview">
        <div class="card-inner">
            <table class="asset_list table" id="table">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>รูปโปรไฟล์</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>สถานะ</th>
                        <th>Role</th>
                        <th>E-mail</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user as $key => $u)
                    <tr class="text-center">
                        <td>{{ ++$key }}</td>
                        <td>
                            @if($u->img != null)
                            <img src="{{ $u->img }}" class="img-fluid img-profile">
                            @else
                            <img src="/images/profile/avartar.png" class="img-fluid img-profile">
                            @endif
                        </td>
                        <td>{{ $u->firstname }} {{ $u->lastname }}</td>
                        <td>@if($u->is_block == 'N') <i class="fa-solid fa-circle-check text-success"> ใช้งานได้ปกติ</i> @else <i class="fa-solid fa-circle-xmark text-danger"> ถูกระงับ</i> @endif</td>
                        <td>{{ $u->role }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-success mr-1" data-bs-toggle="modal" data-bs-target="#edit_user{{$u->id_user}}">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </button>
                            @if( $u->username != 'admin')
                            <a href="{{ route('rm_user',$u->id_user) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('ต้องการลบผู้ใช้งานชื่อ {{ $u->firstname }} ใช่หรือไม่ ?');">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="add_user">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-user"></i> เพิ่มข้อมูลผู้ใช้งาน
                </h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
            </div>
            <div class="card-inner">
                <div class="preview-block">
                    <form action="{{ route('insert_user') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-md-12 col-sm-12">
                                <div class="preview-block">
                                    <span class="preview-title overline-title">ระงับการใช้งานผู้ใช้</span>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch0" name="is_block" value="Y" />
                                        <label class="custom-control-label" for="customSwitch0"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-06">
                                        ตำแหน่ง
                                    </label>
                                    <div class="form-control-wrap">
                                        <div class="form-control-select">
                                            <select class="form-control" id="default-06" name="role">
                                                <option value="Chief">Chief</option>
                                                <option value="Senior">Senior</option>
                                                <option value="Worker">Worker</option>
                                                <option value="Intern">Intern</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="email">อีเมล</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="email" name="email" placeholder="อีเมล" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="firstname">ชื่อ</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="ชื่อ" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="lastname">นามสกุล</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="นามสกุล" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="username">Username</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="username" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="password" name="password" placeholder="password" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="birth">วันเกิด</label>
                                    <div class="form-control-wrap">
                                        <input type="date" class="form-control" id="birth" name="birth" placeholder="วันเกิด" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="tel">เบอร์โทรศัพท์</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="tel" name="tel" placeholder="เบอร์โทรศัพท์" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="position">ตำแหน่ง</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="position" name="position" placeholder="ตำแหน่ง" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-06">รูปโปรไฟล์</label>
                                    <div class="form-control-wrap">
                                        <div class="form-file">
                                            <input type="file" onchange="preview_img(this)" class="form-file-input" id="customFile" name="img" /><label class="form-file-label" for="customFile">เลือกไฟล์รูปโปรไฟล์</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <div class="gallery">
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

@foreach($user as $key => $u)
<div class="modal fade" tabindex="-1" id="edit_user{{$u->id_user}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-user"></i> แก้ไขข้อมูลผู้ใช้งาน
                </h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
            </div>
            <div class="card-inner">
                <div class="preview-block">
                    <form action="{{ route('update_user',$u->id_user) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-md-12 col-sm-12">
                                <div class="preview-block">
                                    <span class="preview-title overline-title">ระงับการใช้งานผู้ใช้</span>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch{{$u->id_user}}" name="is_block" value="Y" {{ $u->is_block == 'Y' ? 'checked' : ' ' }} />
                                        <label class="custom-control-label" for="customSwitch{{$u->id_user}}"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-06">
                                        ROLE
                                    </label>
                                    <div class="form-control-wrap">
                                        <div class="form-control-select">
                                            <select class="form-control" id="default-06" name="role">
                                                <option value="Chief" @if($u->role == 'Chief') selected @endif>Chief</option>
                                                <option value="Senior" @if($u->role == 'Senior') selected @endif>Senior</option>
                                                <option value="Worker" @if($u->role == 'Worker') selected @endif>Worker</option>
                                                <option value="Intern" @if($u->role == 'Intern') selected @endif>Intern</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="firstname">ชื่อ</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="ชื่อ" value="{{$u->firstname}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="lastname">นามสกุล</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="นามสกุล" value="{{$u->lastname}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="username">Username</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{$u->username}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="password" name="password" placeholder="password" value="{{$u->password}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="birth">วันเกิด</label>
                                    <div class="form-control-wrap">
                                        <input type="date" class="form-control" id="birth" name="birth" placeholder="วันเกิด" value="{{$u->birth}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="tel">เบอร์โทรศัพท์</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="tel" name="tel" placeholder="เบอร์โทรศัพท์" value="{{$u->tel}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="position">ตำแหน่ง</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="position" name="position" placeholder="ตำแหน่ง" value="{{$u->position}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="email">E-mail</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="email" name="email" placeholder="email" value="{{$u->email}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-06">รูปโปรไฟล์</label>
                                    <div class="form-control-wrap">
                                        <div class="form-file">
                                            <input type="file" onchange="preview_img(this)" class="form-file-input" id="customFile" name="img" /><label class="form-file-label" for="customFile">เลือกไฟล์รูปโปรไฟล์</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <div class="gallery">
                                    @if($u->img != null)
                                    <img src="{{ $u->img }}" class="img-fluid ">
                                    @else
                                    <img src="/images/profile/avartar.png" class="img-fluid ">
                                    @endif
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
        var table = $('.asset_list').DataTable({
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