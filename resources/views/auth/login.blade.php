@extends('auth.layouts')
@section('content')
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center pt-5">
                    <img alt="" class="w-6"
                        src="{{ asset('upload/images/common_img/logo.svg') }}">
                    <span class="text-white text-lg ml-3"> IT24h </span>
                </a>
                <div class="my-auto">
                    <img alt="" class="-intro-x w-1/2 -mt-16" src="{{ asset('upload/images/common_img/illustration.svg') }}">
                    {{-- <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                    A few more clicks to
                    <br>
                    sign in to your account.
                </div>
                <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-gray-500">Manage all your e-commerce accounts in one place</div> --}}
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div
                    class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        Đăng nhập
                    </h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        {{-- <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div> --}}
                        <div class="intro-x mt-8">
                            <input type="email" class="intro-x login__input form-control py-3 px-4 border-gray-300 block"
                                placeholder="Email" id="email" name="email" value="{{ old('email') }}" required
                                autocomplete="email" autofocus>
                            @error('email')
                                <span role="alert">
                                    <p class="italic mt-2" style="color: red;">{{ $message }}</p>
                                </span>
                            @enderror
                            <input type="password"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                placeholder="Mật khẩu" id="password" name="password" required
                                autocomplete="current-password">
                            @error('password')
                                <span role="alert">
                                    <p class="italic mt-2" style="color: red;">{{ $message }}</p>
                                </span>
                            @enderror
                        </div>
                        <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                            <div class="flex items-center mr-auto">
                                <input id="remember-me" type="checkbox" class="form-check-input border mr-2" name="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="cursor-pointer select-none" for="remember-me">Ghi nhớ đăng nhập</label>
                            </div>
                            <a href="">Quên mật khẩu?</a>
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">Đăng
                                nhập</button>
                            <a href="{{route('register')}}" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Đăng
                                ký</a>
                        </div>
                        {{-- <div class="intro-x mt-10 xl:mt-24 text-gray-700 dark:text-gray-600 text-center xl:text-left">
                    By signin up, you agree to our
                    <br>
                    <a class="text-theme-1 dark:text-theme-10" href="">Terms and Conditions</a> & <a class="text-theme-1 dark:text-theme-10" href="">Privacy Policy</a>
                </div> --}}
                    </form>
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>
@endsection
