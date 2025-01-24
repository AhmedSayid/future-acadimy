@extends('layouts.app')

@section('auth')
    @if(Auth::user()->isStudent())
        @if(!Str::contains(Request::path(), 'part_single&'))
            @include('layouts.navbars.guest.nav')
        @endif
        @yield('content')
        @include('layouts.footers.guest.footer')
    @else
        @if(!Str::contains(Request::path(), 'part_single&'))
            @if(Auth::user()->isAdmin())
                @include('layouts.navbars.auth.admin-sidebar')
            @else
                @include('layouts.navbars.auth.sidebar-teacher')
            @endif
            <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg overflow-hidden">
                @include('layouts.navbars.auth.nav-rtl')
                <div class="container-fluid py-4">
                    @yield('content')
                    @include('layouts.footers.auth.footer')
                </div>
            </main>
        @else
            <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg overflow-hidden">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </main>
        @endif
    @endif

@endsection
