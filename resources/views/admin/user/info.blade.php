@extends('admin.layouts.main')
@section('subcontent')

    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto uppercase" id="a.a">
            Thông tin tài khoản
        </h2>
    </div>
    <!-- BEGIN: Profile Info -->
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <img alt="" class="rounded-full" src="@php
                        if (!empty($user->avatar)) {
                            echo '/upload/images/user/' . $user->avatar;
                        } else {
                            echo '/upload/images/common_img/avt-user.png';
                        }
                    @endphp">

                </div>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $user->name }}</div>
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
            <div
                class="mt-6 lg:mt-0 flex-1 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="font-medium text-center lg:text-left lg:mt-3">Thông tin chi tiết:</div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center"><i class="fa-solid fa-envelope mr-2"></i>
                        <strong class="mr-2">Email:</strong> {{ $user->email }}
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i
                            class="fa-solid fa-phone mr-2"></i></i><strong class="mr-2">Số điện thoại:</strong>
                        {{ $user->phone_number }} </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i
                            class="fa-solid fa-house mr-2"></i></i><strong class="mr-2">Địa chỉ:</strong>
                        {{ $user->address }} </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i
                            class="fa-solid fa-cake-candles mr-2"></i><strong class="mr-2">Ngày sinh:</strong>
                        {{ date('d/m/Y', strtotime($user->birthday)) }} </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i
                            class="fa-solid fa-venus-mars mr-2"></i></i><strong class="mr-2">Giới tính:</strong>
                        {{ $user->gender }} </div>
                </div>
            </div>

        </div>

    </div>
    <!-- END: Profile Info -->
@endsection
