@extends('layout')
@section('content')

<div class="card card-bordered card-preview">

    <div class="card-inner">
        <div class="preview-block">
            <form action="{{ route('update_user',$user->id_user) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row gy-4">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-label" for="default-06">
                                ROLE
                            </label>
                            <div class="form-control-wrap">
                                <div class="form-control-select">
                                    <select class="form-control" id="default-06" name="role" disabled>
                                        <option value="Chief" @if($user->role == 'Chief') selected @endif>Chief</option>
                                        <option value="Senior" @if($user->role == 'Senior') selected @endif>Senior</option>
                                        <option value="Worker" @if($user->role == 'Worker') selected @endif>Worker</option>
                                        <option value="Intern" @if($user->role == 'Intern') selected @endif>Intern</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label" for="firstname">ชื่อ</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="ชื่อ" value="{{$user->firstname}}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label" for="lastname">นามสกุล</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="นามสกุล" value="{{$user->lastname}}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label" for="username">Username</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{$user->username}}" {{ $_SESSION['username'] == 'admin' ? ' ' : 'disabled' }}/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="password" name="password" placeholder="password" value="{{$user->password}}" {{ $_SESSION['username'] == 'admin' ? ' ' : 'disabled' }}/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label" for="birth">วันเกิด</label>
                            <div class="form-control-wrap">
                                <input type="date" class="form-control" id="birth" name="birth" placeholder="วันเกิด" value="{{$user->birth}}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label" for="tel">เบอร์โทรศัพท์</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="tel" name="tel" placeholder="เบอร์โทรศัพท์" value="{{$user->tel}}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-label" for="position">ตำแหน่ง</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="position" name="position" placeholder="ตำแหน่ง" value="{{$user->position}}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-label" for="email">E-mail</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="email" name="email" placeholder="email" value="{{$user->email}}" />
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
                            @if($user->img != null)
                            <img src="{{ $user->img }}" class="img-fluid ">
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
@endsection