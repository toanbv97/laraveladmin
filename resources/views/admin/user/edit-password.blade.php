@extends('admin.layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto uppercase">
            Thông tin tài khoản
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Profile Menu -->
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">
            <div class="intro-y box mt-5">
                <div class="relative flex items-center p-5">
                    <div class="w-12 h-12 image-fit">
                        <img alt="" class="rounded-full" src="@php
                            if (!empty($user->avatar)) {
                                echo '/upload/images/user/' . $user->avatar;
                            } else {
                                echo '/upload/images/common_img/avt-user.png';
                            }
                        @endphp">
                    </div>
                    <div class="ml-4 mr-auto">
                        <div class="font-medium text-base">{{ $user->name }}</div>
                        @if ($user->is_admin == 1)
                            <div class="italic text-theme-1 font-bold mr-4 role-name">Quản trị viên</div>
                        @else
                            @if (!empty($user->role_id))
                                <div class="italic text-theme-1 font-bold mr-4 role-name">{{ $user->role->name }}</div>
                            @else
                                <div class="italic text-theme-1 font-bold mr-4 role-name">Người dùng</div>
                            @endif
                        @endif
                    </div>

                </div>
                <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center"><i
                                class="fa-solid fa-envelope mr-2"></i> <strong class="mr-2">Email:</strong>
                            <p class="lg:w-2/5 xl:w-52" style="word-wrap: break-word;">{{ $user->email }}</p>
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i
                                class="fa-solid fa-phone mr-2"></i></i><strong class="mr-2">Số điện
                                thoại:</strong> {{ $user->phone_number }} </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i
                                class="fa-solid fa-house mr-2"></i></i><strong class="mr-2">Địa chỉ:</strong>
                            {{ $user->address }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i
                                class="fa-solid fa-cake-candles mr-2"></i><strong class="mr-2">Ngày sinh:</strong>
                            {{ date('d-m-Y', strtotime($user->birthday)) }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i
                                class="fa-solid fa-venus-mars mr-2"></i></i><strong class="mr-2">Giới
                                tính:</strong>
                            {{ $user->gender }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- END: Profile Menu -->
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <!-- BEGIN: Change Password -->
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Thay đổi mật khẩu
                    </h2>
                </div>
                <div class="p-5">
                    <form action="{{ route('user.updatePassword') }}" method="POST">
                        @csrf
                        <div>
                            <label for="change-password-form-1" class="form-label">Mật khẩu cũ:</label>
                            <div class="group-input-pw">
                                <input id="change-password-form-1" name="pw_old" type="password"
                                    class="form-control @error('pw_old') border-2 border-red-500 @enderror
                                @if (session('error')) border-2 border-red-500 @endif"
                                    placeholder="Nhập mật khẩu cũ" value="{{ old('pw_old') }}" required>
                                <span class="show-btn pw_old"><i class="fas fa-eye"></i></span>
                            </div>
                            @error('pw_old')
                                <span role="alert">
                                    <p class="italic mt-2 text-red-400">{{ $message }}</p>
                                </span>
                            @enderror
                            @if (session('error'))
                                <span role="alert">
                                    <p class="italic mt-2 text-red-400">{{ session('error') }}</p>
                                </span>
                            @endif
                        </div>
                        <div class="mt-3">
                            <label for="change-password-form-2" class="form-label">Mật khẩu mới:</label>
                            <div class="group-input-pw">
                                <input id="change-password-form-2" name="password" type="password"
                                    class="form-control @error('password') border-2 border-red-500 @enderror"
                                    placeholder="Nhập mật khẩu mới" value="{{ old('password') }}" required>
                                <span class="show-btn pw_new" onclick="myFunction()"><i class="fas fa-eye"></i></span>
                            </div>
                            @error('password')
                                <span role="alert">
                                    <p class="italic mt-2 text-red-400">{{ $message }}</p>
                                </span>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="change-password-form-3" class="form-label">Nhập lại mật khẩu:</label>
                            <div class="group-input-pw">
                                <input id="change-password-form-3" name="password_confirmation" type="password"
                                    class="form-control @error('password_confirmation') border-2 border-red-500 @enderror"
                                    placeholder="Nhập lại mật khẩu mới" value="{{ old('password_confirmation') }}"
                                    required>
                                <span class="show-btn pw_new_confirm" onclick="myFunction()"><i
                                        class="fas fa-eye"></i></span>
                            </div>
                            @error('password_confirmation')
                                <span role="alert">
                                    <p class="italic mt-2 text-red-400">{{ $message }}</p>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" name="btn_update" value="update" class="btn btn-primary mt-4">Lưu thay
                            đổi</button>
                    </form>
                </div>
            </div>
            <!-- END: Change Password -->
        </div>
    </div>
@endsection
@section('js')
    <script src="/js/user.js"></script>
@endsection
