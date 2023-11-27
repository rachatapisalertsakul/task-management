@extends('layout')
@section('content')

<style>
    .card-in:hover {
        transform: scale(1.05);
        background-color: #77a3d9 !important;
    }

    .card-in {
        transition: transform 0.3s;
    }
</style>

<style>
    /* Select the <a> tag and disable pointer events */
    a.disabled {
        pointer-events: none;
        cursor: default;
        text-decoration: none;
        /* Optional: removes underline */
        color: inherit;
        /* Optional: retains original color */
        opacity: 0.5;
    }
</style>



<div class="nk-block nk-block-lg">
    <div class="card-inner">
        <div class="row g-gs text-center">
            @foreach($menu as $m)
            @if($m->id_menu == 4)
            @if($_SESSION['username'] == 'admin')
            <div class="col-md-3 col-6 col-lg-6">
                <a href="{{$m->route}}" class="{{ $_SESSION['is_block'] == 'Y' ? 'disabled' : ' ' }}">
                    <div class="card card-in text-white bg-{{$m->color}}">
                        <div class="card-header">
                            <h5>{{$m->name}}</h5>
                        </div>
                        <div class="card-inner">
                            <img src="/images/svg/{{$m->svg}}.svg" width="100" height="100" style="fill:white;">
                        </div>
                    </div>
                </a>
            </div>
            @endif
            @else
            <div class="col-md-3 col-6 col-lg-6">
                <a href="{{$m->route}}" class="{{ $_SESSION['is_block'] == 'Y' ? 'disabled' : ' ' }}">
                    <div class="card card-in text-white bg-{{$m->color}}">
                        <div class="card-header">
                            <h5>{{$m->name}}</h5>
                        </div>
                        <div class="card-inner">
                            <img src="/images/svg/{{$m->svg}}.png" width="100" height="100" style="fill:white;">
                        </div>
                    </div>
                </a>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>




@endsection