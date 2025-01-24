<?php
$grades = \App\Models\Grade::with('subjects')->get();

?>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-end me-3 rotate-caret" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute start-0 top-0 d-none d-xl-none"
           aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="">
            <img src="../../assets/img/logos/Focus_logo.png" loading="lazy" class="navbar-brand-img w-lg-100 mt-n4" style="max-height: 4rem" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse px-0 w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{route('dashboard')}}"  class="nav-link {{ (Str::contains(Request::path(), 'dashboard') ? 'active' : '') }}" aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                    <span class="avatar avatar-sm border-radius-md {{ (Str::contains(Request::path(), 'dashboard') ? 'bg-gradient-info' : 'bg-white shadow') }}">
                        <svg class="{{ (Str::contains(Request::path(), 'dashboard') ? 'text-white' : 'text-dark') }}" width="14px" height="16px" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <title>shop </title> <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Rounded-Icons" transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF" fill-rule="nonzero"> <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)"> <g id="shop-" transform="translate(0.000000, 148.000000)"> <path class="color-background" d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z" id="Path" opacity="0.598981585"></path> <path class="color-background" d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z" id="Path"></path> </g> </g> </g> </g> </svg>
                    </span>
                    <span class="nav-link-text me-2">لوحة التحكم</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 me-4 text-uppercase text-xs font-weight-bolder opacity-6">COURSES</h6>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#pagesExamples" class="nav-link {{ (Str::contains(Request::path(), 'courses') ? 'active' : '') }}" aria-controls="pagesExamples" role="button" aria-expanded="false">
                    <span class="avatar avatar-sm border-radius-md {{ (Str::contains(Request::path(), 'courses') ? 'bg-gradient-info' : 'bg-white shadow') }}">
                        <svg class="{{ (Str::contains(Request::path(), 'courses') ? 'text-white' : 'text-dark') }}" width="14px" height="50px" viewBox="2 0 20 22" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>video</title><g id="video" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="video-playlist" transform="translate(4.000000, 4.000000)" fill="#FFFFFF" fill-rule="nonzero"><path class="color-background opacity-6" d="M15.4545455,3.09090909 L1.54545455,3.09090909 C1.54545455,2.45076086 2.06439722,1.93181818 2.70454545,1.93181818 L14.2954545,1.93181818 C14.9356028,1.93181818 15.4545455,2.45076086 15.4545455,3.09090909 Z" id="Path" opacity="0.498569222"></path><path class="color-background" d="M13.9090909,1.15909091 L3.09090909,1.15909091 C3.09090909,0.518942676 3.60985177,0 4.25,0 L12.75,0 C13.3901482,0 13.9090909,0.518942676 13.9090909,1.15909091 Z" id="Path" opacity="0.195108103"></path><path class="color-background" d="M15.8409091,3.86363636 L1.15909091,3.86363636 C0.518942676,3.86363636 0,4.38257904 0,5.02272727 L0,15.0681818 C0,15.7083301 0.518942676,16.2272727 1.15909091,16.2272727 L15.8409091,16.2272727 C16.4810573,16.2272727 17,15.7083301 17,15.0681818 L17,5.02272727 C17,4.38257904 16.4810573,3.86363636 15.8409091,3.86363636 Z M11.0326136,10.3669091 L7.55534091,12.6850909 C7.43678188,12.764192 7.28430352,12.7715985 7.15863623,12.7043604 C7.03296895,12.6371223 6.95454545,12.5061608 6.95454545,12.3636364 L6.95454545,7.72727273 C6.95454545,7.58474826 7.03296895,7.45378675 7.15863623,7.38654869 C7.28430352,7.31931063 7.43678188,7.3267171 7.55534091,7.40581818 L11.0326136,9.724 C11.1400827,9.79566009 11.2046321,9.91628504 11.2046321,10.0454545 C11.2046321,10.174624 11.1400827,10.295249 11.0326136,10.3669091 Z" id="Shape"></path></g></g></svg>
                    </span>
                    <span class="nav-link-text me-2">الكورسات</span>
                </a>
                <div class="collapse  {{ (Str::contains(Request::path(), 'courses') ? 'show' : '') }}" id="pagesExamples">
                    <ul class="nav">
                        @foreach($grades as $grade)
                        <li class="nav-item ">
                            <a class="nav-link {{ (Str::contains(Request::path(), 'courses'.$grade->id) ? 'active' : '') }}" data-bs-toggle="collapse" aria-expanded="false" href="#profileExample{{$grade->id}}">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal">{{$grade->name}}<b class="caret"></b></span>
                            </a>
                            <div class="collapse {{ (Str::contains(Request::path(), 'courses'.$grade->id) ? 'show' : '') }}" id="profileExample{{$grade->id}}">
                                <ul class="nav nav-sm flex-column">
                                    @foreach($grade->subjects as $subject)
                                        <li class="nav-item">
                                            <a class="nav-link {{ (Str::contains(Request::path(), 'courses'.$grade->id.'&'.$subject->id) ? 'active' : '') }}" href="{{route('courses_manage',['grade'=>$grade->id,'sub_id'=>$subject->id ,'sub'=>$subject->name])}}">
                                                <span class="sidenav-mini-icon text-xs">S</span>
                                                <span class="sidenav-normal">
                                                    {{$subject->name}}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <hr class="horizontal dark"/>
                <h6 class="ps-4 me-4 text-uppercase text-xs font-weight-bolder opacity-6">MANAGE</h6>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#components" class="nav-link {{ (Str::contains(Request::path(), 'students') ? 'active' : '') }}" aria-controls="components" role="button" aria-expanded="false">
                    <span class="avatar avatar-sm border-radius-md {{ (Str::contains(Request::path(), 'students') ? 'bg-gradient-info' : 'bg-white shadow') }}">
                        <svg class="{{ (Str::contains(Request::path(), 'students') ? 'text-white' : 'text-dark') }}" width="14px" height="12px" viewbox="0 0 46 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>customer-support</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(1.000000, 0.000000)">
                                            <path class="color-background" d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z" opacity="0.59858631"></path>
                                            <path class="color-foreground" d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z"></path>
                                            <path class="color-foreground" d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="nav-link-text me-2">الطلاب</span>
                </a>
                <div class="collapse  {{ (Str::contains(Request::path(), 'students') ? 'show' : '') }}" id="components">
                    <ul class="nav">
                        @foreach($grades as $grade)
                            <li class="nav-item ">
                                <a class="nav-link {{ (Str::contains(Request::path(), 'students'.$grade->id) ? 'active' : '') }}" data-bs-toggle="collapse" aria-expanded="false" href="#profile{{$grade->id}}">
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal">{{$grade->name}}<b class="caret"></b></span>
                                </a>
                                <div class="collapse {{ (Str::contains(Request::path(), 'students'.$grade->id) ? 'show' : '') }}" id="profile{{$grade->id}}">
                                    <ul class="nav nav-sm flex-column">
                                        @foreach($grade->subjects as $subject)
                                            <li class="nav-item">
                                                <a class="nav-link {{ (Str::contains(Request::path(), 'students'.$grade->id.'&'.$subject->id) ? 'active' : '') }}" href="{{route('students',['gradeId'=>$grade->id,'sub_id'=>$subject->id ,'sub'=>$subject->name])}}">
                                                    <span class="sidenav-mini-icon text-xs">S</span>
                                                    <span class="sidenav-normal">
                                                    {{$subject->name}}
                                                </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#applicationsExamples" class="nav-link {{ (Str::contains(Request::path(), 'management') ? 'active' : '') }}" aria-controls="applicationsExamples" role="button" aria-expanded="false">
                    <span class="avatar avatar-sm border-radius-md {{ (Str::contains(Request::path(), 'management') ? 'bg-gradient-info' : 'bg-white shadow') }}">
                        <svg class="{{ (Str::contains(Request::path(), 'management') ? 'text-white' : 'text-dark') }}" width="14px" height="12px" viewbox="0 0 46 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>settings</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(304.000000, 151.000000)">
                                            <polygon class="color-background" opacity="0.596981957" points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667"></polygon>
                                            <path class="color-background" d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z" opacity="0.596981957"></path>
                                            <path class="color-background" d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="nav-link-text me-1">الادارة العامه</span>
                </a>
                <div class="collapse {{ (Str::contains(Request::path(), 'management') ? 'show' : '') }}"
                     id="applicationsExamples">
                    <ul class="nav ms-4 ps-3">
                        <li class="nav-item ">
                            <a class="nav-link {{ (Route::is('grade') ? 'active' : '') }} {{ (Str::contains(Request::path(), 'grade') ? 'active' : '')}}"
                               href="{{route('grade')}}">
                                <span class="sidenav-mini-icon"> ص </span>
                                <span class="sidenav-normal">الصفوف الدراسيه</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ (Route::is('subjects') ? 'active' : '') }} {{ (Str::contains(Request::path(), 'subjects') ? 'active' : '')}}"
                               href="{{route('subjects')}}">
                                <span class="sidenav-mini-icon"> م </span>
                                <span class="sidenav-normal">المواد</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</aside>
