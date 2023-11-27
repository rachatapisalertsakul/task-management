<!DOCTYPE html>
<html lang="zxx" class="js">
<!-- Mirrored from dashlite.net/demo6/_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Jul 2023 06:16:52 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Softnio" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers." />
    <link rel="shortcut icon" href="images/favicon.png" />
    <title>Task Management</title>

    <link rel="stylesheet" href="{{ asset('assets/css/dashlitedeae.css?ver=3.2.1') }}" />
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/themedeae.css?ver=3.2.1') }}" />

    <link rel="stylesheet" href="{{ asset('../../assets/css/dashlitedeae.css?ver=3.2.1') }}" />
    <link id="skin-default" rel="stylesheet" href="{{ asset('../../assets/css/themedeae.css?ver=3.2.1') }}" />

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .font_thai {
            font-family: 'Anuphan', sans-serif !important;

        }

        .highcharts-title {
            font-family: 'Anuphan', sans-serif !important;

        }
    </style>


    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-91615293-4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());
        gtag("config", "UA-91615293-4");
    </script>

    <style>
        .svg-color {
            fill: white;
        }
    </style>


</head>

<body class="nk-body npc-invest bg-lighter font_thai">
    <div class="nk-app-root">
        <div class="nk-wrap">
            <div class="nk-header nk-header-fixed nk-header-fluid is-theme is-regular">
                <div class="container-xl wide-xl">
                    <div class="nk-header-wrap">
                        <div class="nk-menu-trigger me-sm-2 d-lg-none">
                            <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-menu"></em></a>
                        </div>
                        <div class="nk-header-brand">
                            <a href="{{ route('home') }}" class="logo-link"><img class="logo-light logo-img" src="images/task.gif" srcset="/images/task.gif" alt="logo" /><img class="logo-dark logo-img" src="images/task.gif" srcset="       /images/task.gif                                  " alt="logo-dark" /></a>
                        </div>
                        <div class="nk-header-menu" data-content="headerNav">
                            <div class="nk-header-mobile">
                                <div class="nk-header-brand">
                                    <a href="{{ route('home') }}" class="logo-link">
                                        <img width="450" height="150" class="logo-light logo-img" src="/images/task.gif" srcset="
                                    /images/Asset.gif
                                                " alt="logo" />
                                        <img class="logo-dark logo-img" src="images/logo-dark.png" srcset="
                                                /images/Asset.gif
                                                " alt="logo-dark" /></a>
                                </div>
                                <div class="nk-menu-trigger me-n2">
                                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                                </div>
                            </div>
                            <ul class="nk-menu nk-menu-main ui-s2">
                                @foreach($menu as $m)
                                @if($m->id_menu == 4)
                                @if($_SESSION['username'] == 'admin')
                                <li class="nk-menu-item has-sub">
                                    <a href="{{$m->route}}" class="nk-menu-link {{ $_SESSION['is_block'] == 'Y' ? 'disabled' : ' ' }}">
                                        <img src="/images/svg/{{$m->svg}}.svg" width="25" height="25" style="fill:white;">
                                        <span class="nk-menu-text">&nbsp;&nbsp;{{$m->name}}</span>
                                    </a>
                                </li>
                                @endif
                                @else
                                @if($_SESSION['username'] != 'admin')
                                <li class="nk-menu-item has-sub">
                                    <a href="{{$m->route}}" class="nk-menu-link {{ $_SESSION['is_block'] == 'Y' ? 'disabled' : ' ' }}">
                                        <img src="/images/svg/{{$m->svg}}.PNG" width="25" height="25" style="fill:white;">
                                        <span class="nk-menu-text">&nbsp;&nbsp;{{$m->name}}</span>
                                    </a>
                                </li>
                                @endif
                                @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="nk-header-tools">
                            <ul class="nk-quick-nav">
                                <li class="dropdown user-dropdown order-sm-first">
                                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                        <div class="user-toggle">
                                            <div class="user-avatar sm">
                                                <em class="icon ni ni-user-alt"></em>
                                            </div>
                                            <div class="user-info d-none d-xl-block">
                                                <div class="user-status">
                                                    {{ $_SESSION['role']}}<br>
                                                    @if($_SESSION['is_block'] == 'Y')
                                                    <span class="badge bg-danger">ถูกระงับการใช้งานระบบ</span>
                                                    @endif
                                                </div>
                                                <div class="user-name dropdown-indicator">
                                                    {{ $_SESSION['username']}}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1 is-light">
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li>
                                                    <a href="{{ route('edit_profile') }}"><em class="icon ni ni-user"></em><span>Edit Profile</span></a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('logout') }}"><em class="icon ni ni-signout"></em><span>Sign out</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-footer nk-footer-fluid bg-lighter">
                <div class="container-xl">
                    <div class="nk-footer-wrap">
                        <div class="nk-footer-copyright">
                            <!-- &copy; 2023 Task managemen
                            <a href="https://softnio.com/" target="_blank">Task management</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <ul class="nk-sticky-toolbar">
        <li class="demo-layout">
            <a class="toggle tipinfo" data-target="demoML" href="#" title="Main Demo Preview"><em class="icon ni ni-dashlite"></em></a>
        </li>
        <li class="demo-thumb">
            <a class="toggle tipinfo" data-target="demoUC" href="#" title="Use Case Concept"><em class="icon ni ni-menu-squared"></em></a>
        </li>
        <li class="demo-settings">
            <a class="toggle tipinfo" data-target="settingPanel" href="#" title="Demo Settings"><em class="icon ni ni-setting-alt"></em></a>
        </li>
        <li class="demo-purchase">
            <a class="tipinfo" target="_blank" href="https://1.envato.market/e0y3g" title="Purchase"><em class="icon ni ni-cart"></em></a>
        </li>
    </ul> -->



    <script src="{{ asset('assets/js/bundledeae.js') }}"></script>
    <script src="{{ asset('assets/js/scriptsdeae.js?ver=3.2.1') }}"></script>
    <script src="{{ asset('assets/js/demo-settingsdeae.js?ver=3.2.1') }}"></script>
    <script src="{{ asset('/assets/js/example-toastrdeae.js?ver=3.2.1') }}"></script>
    <script src="../../assets/js/libs/datatable-btnsdeae.js?ver=3.2.1"></script>


    <script src="https://cdn.datatables.net/searchpanes/2.1.2/js/dataTables.searchPanes.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.min.js"></script>

    <link href="https://cdn.datatables.net/searchpanes/2.1.2/css/searchPanes.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.6.2/css/select.dataTables.min.css" rel="stylesheet" />

    <script src="https://code.highcharts.com/highcharts.js"></script>


    @if(Session::has('success'))
    <script>
        $(document).ready(function() {
            !(function(o, t) {
                o.Toast("{{ Session::get('success') }} ", "success", {
                    position: "top-right",
                    timeOut: "5000",
                });
            })(NioApp, jQuery);
        });
    </script>
    @endif

    @if(Session::has('danger'))
    <script>
        $(document).ready(function() {
            !(function(o, t) {
                o.Toast("{{ Session::get('danger') }} ", "error", {
                    position: "top-right",
                    timeOut: "5000",
                });
            })(NioApp, jQuery);
        });
    </script>
    @endif





    @yield('js_script')
</body>
<!-- Mirrored from dashlite.net/demo6/_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Jul 2023 06:16:52 GMT -->

</html>