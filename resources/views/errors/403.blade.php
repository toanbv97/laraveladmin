@extends('admin.layouts.base')
@section('body')
<body class="main">
    <div class="container">
        <!-- BEGIN: Error Page -->
        <div class="error-page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left">
            <div class="-intro-x lg:mr-20">
                <img alt="Rubick Tailwind HTML Admin Template" class="h-48 lg:h-auto" src="{{asset('upload/images/common_img/error-illustration.svg')}}">
            </div>
            <div class="text-white mt-10 lg:mt-0">
                <div class="intro-x text-8xl font-medium">403</div>
                <div class="intro-x text-xl lg:text-3xl font-medium mt-5">Xin lỗi, chúng tôi không tìm thấy trang mà bạn cần!</div>
                <div class="intro-x text-lg mt-3">Bạn có thể đã nhập sai địa chỉ hoặc trang có thể đã bị di chuyển.</div>
                @if (!empty(Auth::user()->role_id))
                <a href="{{route('dashboard')}}" class="intro-x btn py-3 px-4 text-white border-white dark:border-dark-5 dark:text-gray-300 mt-10">Back to Home</a>
                @else
                <a href="{{route('user')}}" class="intro-x btn py-3 px-4 text-white border-white dark:border-dark-5 dark:text-gray-300 mt-10 nr-3">Back to Home</a>
                <a href="tel:88888888" class="intro-x btn py-3 px-4 text-white border-white dark:border-dark-5 dark:text-gray-300 mt-10">Hotline</a>
                @endif
            </div>
        </div>
        <!-- END: Error Page -->
    </div>
    <!-- BEGIN: JS Assets-->
    <script src="{{asset('js/app.js')}}"></script>
    <!-- END: JS Assets-->
</body>
@endsection
