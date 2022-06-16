@extends('admin.layouts.base')
@section('body')

    <body class="main">

        <!-- BEGIN: Mobile Menu -->
        @include('admin.layouts.mobile-menu')
        <!-- END: Mobile Menu -->

        <div class="flex">

            @include('admin.layouts.side-menu')

            <!-- BEGIN: Content -->
            <div class="content">
                @include('admin.layouts.top-bar')

                {{-- MESSAGE --}}
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible show flex items-center mb-2" role="alert">
                    <i class="fa-solid fa-bell mr-2 text-base"></i>{{ $message }}
                    <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                        <i class="fa-regular fa-circle-xmark text-base"></i>
                    </button>
                </div>
                @endif

                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible show flex items-center mb-2" role="alert">
                    <i class="fa-solid fa-bell mr-2 text-base"></i>{{ $message }}
                    <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                        <i class="fa-regular fa-circle-xmark text-base"></i>
                    </button>
                </div>
                @endif

                @if ($message = Session::get('warning'))
                <div class="alert alert-warning alert-dismissible show flex items-center mb-2" role="alert">
                    <i class="fa-solid fa-bell mr-2 text-base"></i>{{ $message }}
                    <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                        <i class="fa-regular fa-circle-xmark text-base"></i>
                    </button>
                </div>
                @endif

                @if ($message = Session::get('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                    </div>
                @endif

                @yield('subcontent')
                @yield('category')
            </div>
            <!-- END: Content -->
        </div>
        {{-- @yield('dark-mode-switcher') --}}
        <!-- BEGIN: JS Assets-->
        <script src="/lib/jquery360.min.js"></script>
        <script src="/js/app.js"></script>
        <script src="/js/common.js"></script>
        <!-- END: JS Assets-->
        @yield('js')
    </body>
@endsection
