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

    .item-photo__preview {
        max-width: 100%;
        width: 250px;
        height: 250px;
        border: solid;
        margin: 0px 10px 10px 10px;
        border-radius: 25px;
        display: inline;
    }

    .img-profile {
        width: 100px;
        height: 100px;
        border-radius: 10px;
    }
</style>


<div class="nk-block nk-block-lg">


    @csrf
    <div class="row">
        <div class="d-flex flex-row-reverse  ">
            <!-- <a href="/file/asset_template.xlsx">
                <i class="fa fa-download" aria-hidden="true"></i>
                Download Template File
            </a> -->
        </div>

        <div class="d-flex  mb-3">
            <div class="p-2 ">
                <h4 class="nk-block-title">รายชื่อลูกค้า</h4>
            </div>
            <div class="ms-auto p-2 ">
                <button type="button" class="btn btn-success mr-1" data-bs-toggle="modal" data-bs-target="#modal_insert">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>


    <div class="card card-bordered card-preview">
        <div class="card-inner">
            <table class="asset_list table" id="table">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>รูปลูกค้า</th>
                        <!-- <th>เลขบัตรประชาชน</th> -->
                        <th>ชื่อ-นามสกุล</th>
                        <th>ประเภทลูกค้า</th>
                        <!-- <th>ที่อยู่</th> -->
                        <th>วันเกิด</th>
                        <th>
                            <i class="fa fa-cog" aria-hidden="true"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customer as $key => $c)
                    <tr class="text-center">
                        <td>{{ ++$key }}</td>
                        <td>
                            @if($c->img_customer != null)
                            <img src="{{ $c->img_customer }}" class="img-fluid img-profile">
                            @else
                            <img src="/images/profile/avartar.png" class="img-fluid img-profile">
                            @endif
                        </td>
                        <!-- <td>{{ $c->id_card }}</td> -->
                        <td>{{ $c->prename }} {{ $c->firstname_customer }} {{ $c->lastname_customer }}</td>
                        <td>
                            <i class="fas fa-check-circle text-success"></i>
                            {{ $c->name_customer_type }}
                        </td>
                        <!-- <td>{{ $c->address_customer }}</td> -->
                        <td>
                            <i class="fa fa-birthday-cake text-warning" aria-hidden="true"></i>
                            <b>{{ DateThaiNoTime($c->birthday_customer) }}</b>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-warning mr-1" data-bs-toggle="modal" data-bs-target="#edit_customer{{$c->id_customer}}">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </button>
                            <a class="btn btn-outline-danger btn-sm" href="{{ route('rm_customer',$c->id_customer) }}">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="modal_insert">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มข้อมูลลูกค้า</h5><a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
            </div>
            <div class="card-inner">
                <form action="{{ route('insert_customer') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="default-06">
                                    ประเภทลูกค้า
                                </label>
                                <div class="form-control-wrap">
                                    <div class="form-control-select">
                                        <select class="form-control" id="default-06" name="customer_type">
                                            @foreach($customer_type as $ct)
                                            <option value="{{$ct->id_customer_type}}">{{$ct->name_customer_type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="default-06">
                                    คำนำหน้า
                                </label>
                                <div class="form-control-wrap">
                                    <div class="form-control-select">
                                        <select class="form-control" id="default-06" name="prename">
                                            <option value="นาย">นาย</option>
                                            <option value="นางสาว">นางสาว</option>
                                            <option value="นาง">นาง</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="firstname_customer">ชื่อ</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="firstname_customer" name="firstname_customer" placeholder="ชื่อ" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="lastname_customer">นามสกุล</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="lastname_customer" name="lastname_customer" placeholder="นามสกุล" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="id_card">เลขบัตรประชาชน</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" id="id_card" name="id_card" placeholder="เลขบัตรประชาชน" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="serial_no">วันเกิด</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" class="form-control form-control-outlined date-picker" id="outlined-date-picker" name="birthday_customer" />
                                    <label class="form-label-outlined" for="outlined-date-picker">
                                        วันเกิด
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="address_customer">ที่อยู่</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control no-resize" name="address_customer" id="address_customer"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="default-06">รูปลูกค้า</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" onchange="preview_img(this)" multiple class="form-file-input" id="customFile" name="img" /><label class="form-file-label" for="customFile">เลือกไฟล์รูปสินทรัพย์</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <div class="gallery">
                            </div>
                        </div>


                    </div>
                    <button type="submit" style="float: right;" class="btn btn-success float-right">บันทึกข้อมูล</button>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($customer as $key => $c)
<div class="modal fade" tabindex="-1" id="edit_customer{{$c->id_customer}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขข้อมูลลูกค้า</h5><a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
            </div>
            <div class="card-inner">
                <form action="{{ route('update_customer',$c->id_customer) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="default-06">
                                    ประเภทลูกค้า
                                </label>
                                <div class="form-control-wrap">
                                    <div class="form-control-select">
                                        <select class="form-control" id="default-06" name="customer_type">
                                            @foreach($customer_type as $ct)
                                            <option value="{{$ct->id_customer_type}}" @if($c->customer_type == $ct->id_customer_type) selected @endif>{{$ct->name_customer_type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="default-06">
                                    คำนำหน้า
                                </label>
                                <div class="form-control-wrap">
                                    <div class="form-control-select">
                                        <select class="form-control" id="default-06" name="prename">
                                            <option value="นาย" @if($c->prename == 'นาย') selected @endif>นาย</option>
                                            <option value="นางสาว" @if($c->prename == 'นางสาว') selected @endif>นางสาว</option>
                                            <option value="นาง" @if($c->prename == 'นาง') selected @endif>นาง</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="firstname_customer">ชื่อ</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="firstname_customer" name="firstname_customer" placeholder="ชื่อ" value="{{ $c->firstname_customer }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="lastname_customer">นามสกุล</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="lastname_customer" name="lastname_customer" placeholder="นามสกุล" value="{{ $c->lastname_customer }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="id_card">เลขบัตรประชาชน</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" id="id_card" name="id_card" placeholder="เลขบัตรประชาชน" value="{{ $c->id_card }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="serial_no">วันเกิด</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" class="form-control form-control-outlined date-picker" id="outlined-date-picker" name="birthday_customer" value="{{ $c->birthday_customer }}" />
                                    <label class="form-label-outlined" for="outlined-date-picker">
                                        วันเกิด
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="address_customer">ที่อยู่</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control no-resize" name="address_customer" id="address_customer">{{ $c->address_customer }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="default-06">รูปลูกค้า</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" onchange="preview_img(this)" multiple class="form-file-input" id="customFile" name="img" />
                                        <label class="form-file-label" for="customFile">เลือกไฟล์รูปสินทรัพย์</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <div class="gallery">
                                @if($c->img_customer != null)
                                <img src="{{ $c->img_customer }}" class="img-fluid ">
                                @else
                                <img src="/images/profile/avartar.png" class="img-fluid ">
                                @endif
                            </div>
                        </div>


                    </div>
                    <button type="submit" style="float: right;" class="btn btn-success float-right">บันทึกข้อมูล</button>
                </form>
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
            dom: "Pfrtip",
            searchPanes: {
                columns: [2, 3, 4],
                initCollapsed: false,
                cascadePanes: true,
                dtOpts: {
                    select: {
                        style: "multi",
                    },
                },
            },

            language: {
                search: "",
                searchPlaceholder: "ค้นหาด้วย Keyword ข้อมูล",
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