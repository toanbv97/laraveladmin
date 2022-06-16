@extends('admin.layouts.main')
@section('css')
    <link rel="stylesheet" href="/css/user.css">
@endsection
@section('subcontent')

    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto uppercase">
            Thông tin tài khoản
        </h2>
        @if (request()->input('update-url') == 'password')
            <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-primary mr-1">Chỉnh sửa thông tin</a>
        @else
            <a href="{{ request()->fullUrlWithQuery(['update-url' => 'password']) }}" class="btn btn-primary mr-1">Thay
                đổi
                mật
                khẩu</a>
        @endif

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
                        <div class="mt-1 flex">
                            @if ($user->is_admin == 1)
                                <div class="italic text-theme-1 font-bold mr-4 role-name">Quản trị viên</div>
                            @else
                                @if (!empty($user->role_id))
                                    <div class="italic text-theme-1 font-bold mr-4 role-name">{{ $user->role->name }}
                                    </div>
                                @else
                                    <div class="italic text-theme-1 font-bold mr-4 role-name">Người dùng</div>
                                @endif
                            @endif
                        </div>
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
        {{-- ==== Thay đổi password --}}
        @if (request()->input('update-url') == 'password')
            @can('update', App\Models\User::class)
                <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                    <!-- BEGIN: Change Password -->
                    <div class="intro-y box lg:mt-5">
                        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="font-medium text-base mr-auto">
                                Thay đổi mật khẩu
                            </h2>
                        </div>
                        <div class="p-5">
                            <form action="{{ route('admin.updatePassword', $user->id) }}" method="POST">
                                @csrf
                                <div class="mt-3">
                                    <label for="change-password-form-1" class="form-label">Mật khẩu mới:</label>
                                    <div class="group-input-pw">
                                        <input id="change-password-form-1" name="password" type="password"
                                            class="form-control @error('password') border-2 border-red-500 @enderror"
                                            placeholder="Nhập mật khẩu mới" value="{{ old('password') }}" required>
                                        <span class="show-btn pw_old" onclick="myFunction()"><i
                                                class="fas fa-eye"></i></span>
                                    </div>
                                    @error('password')
                                        <span role="alert">
                                            <p class="italic mt-2 text-red-400">{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <label for="change-password-form-2" class="form-label">Nhập lại mật khẩu:</label>
                                    <div class="group-input-pw">
                                        <input id="change-password-form-2" name="password_confirmation" type="password"
                                            class="form-control @error('password_confirmation') border-2 border-red-500 @enderror"
                                            placeholder="Nhập lại mật khẩu mới" value="{{ old('password_confirmation') }}"
                                            required>
                                        <span class="show-btn pw_new" onclick="myFunction()"><i
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
            @endcan
        @else
            {{-- ==== Thay đổi thông tin và phân quyền --}}
            <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                <!-- BEGIN: Display Information -->
                <div class="intro-y box lg:mt-5">
                    <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto">
                            Cập nhật thông tin
                        </h2>
                    </div>
                    <div class="p-5">
                        <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="flex flex-col-reverse xl:flex-row flex-col">
                                <div class="flex-1 mt-6 xl:mt-0">
                                    <div class="grid grid-cols-12 gap-x-5">
                                        <div class="col-span-12 2xl:col-span-6">
                                            <div>
                                                <label for="update-profile-form-1" class="form-label">Họ tên:</label>
                                                <input id="update-profile-form-1" name="name" type="text"
                                                    class="form-control mb-3 @error('name') border-2 border-red-500 @enderror"
                                                    value="@php
                                                        if (!empty(old('name'))) {
                                                            echo old('name');
                                                        } else {
                                                            echo $user->name;
                                                        }
                                                    @endphp" required>
                                                @error('name')
                                                    <p class="block mb-2 mt-2 italic text-red-400"><i
                                                            class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="update-profile-form-2" class="form-label">Email:</label>
                                                <input id="update-profile-form-2" name="email" type="email"
                                                    class="form-control mb-3" value="{{ $user->email }}" disabled>

                                            </div>
                                            <div>
                                                <label for="update-profile-form-3" class="form-label">Số điện
                                                    thoại:</label>
                                                <input id="update-profile-form-3" name="phone_number" type="text"
                                                    class="form-control @error('phone_number') border-2 border-red-500 @enderror"
                                                    value="@php
                                                        if (!empty(old('phone_number'))) {
                                                            echo old('phone_number');
                                                        } else {
                                                            echo $user->phone_number;
                                                        }
                                                    @endphp">
                                                @error('phone_number')
                                                    <p class="block mb-2 mt-2 italic text-red-400"><i
                                                            class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-12">
                                            <div class="mt-3">
                                                <label for="update-profile-form-4" class="form-label">Địa chỉ:</label>
                                                <input type="text" name="address" id="update-profile-form-4"
                                                    class="form-control" value="@php
                                                        if (!empty(old('address'))) {
                                                            echo old('address');
                                                        } else {
                                                            echo $user->address;
                                                        }
                                                    @endphp">
                                                @error('address')
                                                    <p class="block mb-2 mt-2 italic text-red-400"><i
                                                            class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-12">
                                            <div class="mt-3">
                                                <label for="update-profile-form-4" class="form-label">Ngày sinh:</label>
                                                <input type="date" name="birthday" class="form-control w-56 block mx-auto"
                                                    id="update-profile-form-4" value="@php
                                                        if (!empty(old('birthday'))) {
                                                            echo old('birthday');
                                                        } else {
                                                            echo $user->birthday;
                                                        }
                                                    @endphp">
                                            </div>
                                        </div>
                                        <div class="col-span-12">
                                            <label>Giới tính:</label>
                                            <div class="mt-2">
                                                <select class="tom-select w-full" name="gender">
                                                    <option value="">Chọn giới tính</option>
                                                    <option value="Nam" @if ($user->gender == 'Nam') selected @endif>
                                                        Nam
                                                    </option>
                                                    <option value="Nữ" @if ($user->gender == 'Nữ') selected @endif>Nữ
                                                    </option>
                                                    <option value="Gới tính khác"
                                                        @if ($user->gender == 'Gới tính khác') selected @endif>Giới tính khác
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        @if (Auth::user()->is_admin == 1)
                                            <div class="mt-4 col-span-12 mb-1">
                                                <input name="is_admin"
                                                    class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                                    type="checkbox" value="1" id="flexCheckDefault"
                                                    @if ($user->is_admin == 1) checked @endif>
                                                <label class="form-check-label inline-block text-gray-800"
                                                    for="flexCheckDefault" style="font-size: 1rem">
                                                    Quản trị viên
                                                </label>
                                            </div>
                                        @endif
                                        @can('role_user', App\Models\User::class)
                                            <div class="mt-3 col-span-12">
                                                <label>Vai trò:</label>
                                                <div class="mt-2">
                                                    <select class="tom-select w-full" name="role">
                                                        <option value="">Phân quyền cho người dùng</option>
                                                        <option value="0">Hủy quyền</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}"
                                                                @if ($user->role_id == $role->id) selected @endif>
                                                                {{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                    <input type="hidden" value="{{ $user->id }}" name="user_id">
                                    <button type="submit" value="btn_update" name="btn_update"
                                        class="btn btn-primary w-30 mt-3">Cập nhật</button>
                                </div>
                                <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                                    <div
                                        class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md p-5">
                                        <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                            <img class="rounded-md" id="upload-image" alt="" src="@php
                                                if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
                                                    echo '/upload/user/' . $_FILES['avatar']['name'];
                                                } else {
                                                    if (!empty($user->avatar)) {
                                                        echo '/upload/images/user/' . $user->avatar;
                                                    } else {
                                                        echo '/upload/images/common_img/avt-user.png';
                                                    }
                                                }
                                            @endphp">
                                        </div>
                                        <div class="mx-auto cursor-pointer relative mt-5">
                                            <label for="avatar" class="btn btn-primary w-full cursor-pointer">Thay đổi ảnh
                                                đại
                                                diện</label>
                                            <input type="file" name="avatar" id="avatar"
                                                class="w-full h-full top-0 left-0 absolute opacity-0 cursor-pointer"
                                                onchange="show_upload_image()">
                                        </div>
                                        @error('avatar')
                                            <p class="block mb-2 mt-2 italic text-red-400"><i
                                                    class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <!-- END: Display Information -->
                <!-- BEGIN: Personal Information -->

                <!-- END: Personal Information -->
            </div>
        @endif

    </div>
@endsection
@section('js')
    <script src="/js/user.js"></script>
@endsection
