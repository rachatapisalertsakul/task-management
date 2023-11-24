<!DOCTYPE html>
<html lang="zxx" class="js">
<!-- Mirrored from dashlite.net/demo6/pages/auths/auth-login-v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Jul 2023 06:16:52 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <link rel="shortcut icon" href="../../images/favicon.png">
    <title>Login | DashLite Admin Template</title>
    <link rel="stylesheet" href="../../assets/css/dashlitedeae.css?ver=3.2.1">
    <link id="skin-default" rel="stylesheet" href="../../assets/css/themedeae.css?ver=3.2.1">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-91615293-4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-91615293-4');
    </script>
</head>

<body class="nk-body  npc-general pg-auth" style="background-color: #364a63;">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="images/task.gif" srcset="/demo6/images/logo2x.png 2x" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="images/task.gif" srcset="/demo6/images/logo-dark2x.png 2x" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Sign-In</h4>
                                        <div class="nk-block-des">
                                        </div>
                                    </div>
                                </div>
                                <form action="{{route('login2')}}" method="GET">
                                    <div class="form-group">
                                        <div class="form-label-group"><label class="form-label" for="default-01">Username</label></div>
                                        <div class="form-control-wrap"><input type="text" class="form-control form-control-lg" id="default-01" name="username" placeholder="Enter your username"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group"><label class="form-label" for="password">Password</label>
                                            <!-- <a class="link link-primary link-sm" href="auth-reset-v2.html">Forgot Code?</a> -->
                                        </div>
                                        <div class="form-control-wrap"><a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password"><em class="passcode-icon icon-show icon ni ni-eye"></em><em class="passcode-icon icon-hide icon ni ni-eye-off"></em></a>
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your passcode"></div>
                                    </div>
                                    <div class="form-group"><button class="btn btn-lg btn-primary btn-block">Sign in</button></div>
                                </form>
                                <!-- <div class="form-note-s2 text-center pt-4"> New on our platform? <a href="auth-register-v2.html">Create an account</a></div>
                                <div class="text-center pt-4 pb-3">
                                    <h6 class="overline-title overline-title-sap"><span>OR</span></h6>
                                </div>
                                <ul class="nav justify-center gx-4">
                                    <li class="nav-item"><a class="nav-link" href="#">Facebook</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#">Google</a></li>
                                </ul> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pmo-lv pmo-dark"><a class="pmo-close" href="#"><em class="ni ni-cross"></em></a><a class="pmo-wrap" target="_blank" href="https://softnio.com/get-early-access/">
            <div class="pmo-text text-white">Looking for functional script for HYIP Investment Platform? Check out <em class="ni ni-arrow-long-right"></em></div>
        </a></div><a class="pmo-st pmo-dark" target="_blank" href="https://softnio.com/get-early-access/">
        <div class="pmo-st-img"><img src="../../../images/landing/promo-investorm.png" alt="Investorm"></div>
        <div class="pmo-st-text">Looking for Advanced <br> HYIP Investment Platform?</div>
    </a>
    <script src="../../assets/js/bundledeae.js?ver=3.2.1"></script>
    <script src="../../assets/js/scriptsdeae.js?ver=3.2.1"></script>
    <script src="../../assets/js/demo-settingsdeae.js?ver=3.2.1"></script>
    <script src="{{ asset('/assets/js/example-toastrdeae.js?ver=3.2.1') }}"></script>

    <div class="modal fade" tabindex="-1" role="dialog" id="region">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h5 class="title mb-4">Select Your Country</h5>
                    <div class="nk-country-region">
                        <ul class="country-list text-center gy-2">
                            <li><a href="#" class="country-item"><img src="../../images/flags/arg.png" alt="" class="country-flag"><span class="country-name">Argentina</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/aus.png" alt="" class="country-flag"><span class="country-name">Australia</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/bangladesh.png" alt="" class="country-flag"><span class="country-name">Bangladesh</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/canada.png" alt="" class="country-flag"><span class="country-name">Canada <small>(English)</small></span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/china.png" alt="" class="country-flag"><span class="country-name">Centrafricaine</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/china.png" alt="" class="country-flag"><span class="country-name">China</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/french.png" alt="" class="country-flag"><span class="country-name">France</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/germany.png" alt="" class="country-flag"><span class="country-name">Germany</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/iran.png" alt="" class="country-flag"><span class="country-name">Iran</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/italy.png" alt="" class="country-flag"><span class="country-name">Italy</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/mexico.png" alt="" class="country-flag"><span class="country-name">México</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/philipine.png" alt="" class="country-flag"><span class="country-name">Philippines</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/portugal.png" alt="" class="country-flag"><span class="country-name">Portugal</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/s-africa.png" alt="" class="country-flag"><span class="country-name">South Africa</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/spanish.png" alt="" class="country-flag"><span class="country-name">Spain</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/switzerland.png" alt="" class="country-flag"><span class="country-name">Switzerland</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/uk.png" alt="" class="country-flag"><span class="country-name">United Kingdom</span></a></li>
                            <li><a href="#" class="country-item"><img src="../../images/flags/english.png" alt="" class="country-flag"><span class="country-name">United State</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mirrored from dashlite.net/demo6/pages/auths/auth-login-v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Jul 2023 06:16:52 GMT -->

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

</html>