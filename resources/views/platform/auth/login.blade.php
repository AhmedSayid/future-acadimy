@extends('dashboard.layouts.master2')
@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{asset('assets/img/media/focus_academy.svg')}}"
                             class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                    </div>
                </div>
            </div>
            <!-- The content half -->
            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                <div class="login d-flex align-items-center py-2">
                    <!-- Demo content-->
                    <div class="container p-0">
                        <div class="row">
                            @if(session('msg'))
                                <div class="alert alert-warning" style="width: 100%" role="alert">
                                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>{{session('msg')}}</strong>
                                </div>
                            @endif
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="card-sigin">
                                    <div class="mb-5 d-flex">
                                        <a href="{{ url('/' . $page='index') }}"><img
                                                src="{{asset('assets/img/media/focus_academy.svg')}}"
                                                class="sign-favicon ht-40" alt="logo"></a>
                                        <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">Focus<span>Academy</span></h1>
                                    </div>
                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            <h2>مرحبا في منصة فوكس التعليمية</h2>
                                            <h5 class="font-weight-semibold mb-4">برجاء تسجيل الدخول للمتابعة.</h5>
                                            <form method="post" action="{{route('postLogin')}}">
                                                @csrf
                                                <div class="form-group">
                                                    <label>رقم الهاتف</label>
                                                    <input class="form-control" name="phone"
                                                           placeholder="ادخل رقم الهاتف"
                                                           type="text">
                                                </div>
                                                <div class="form-group">
                                                    <label>كلمة المرور</label>
                                                    <input class="form-control" name="password"
                                                           placeholder="ادخل الباسورد"
                                                           type="password">
                                                </div>
                                                <button type="submit" class="btn btn-main-primary btn-block">تسجيل
                                                    دخول
                                                </button>
                                            </form>
                                            <div class="main-signin-footer mt-5">
                                                <h6>إذا نسيت كلمة المرور قم بالتواصل مع احد المسئولين</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->
        </div>
    </div>
@endsection
