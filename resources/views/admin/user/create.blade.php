@extends('admin.layouts.main')
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto uppercase">
            Thêm thành viên
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <!-- BEGIN: Display Information -->
            <div class="intro-y box lg:mt-5">
                <div class="p-5">
                    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col-reverse xl:flex-row flex-col">
                            <div class="flex-1 mt-6 xl:mt-0">
                                <div class="grid grid-cols-12 gap-x-5">
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div>
                                            <label for="">Họ tên(<span class="text-red-600">*</span>):</label>
                                            <input type="text"
                                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-2 mb-3"
                                                placeholder="Nhập họ tên" name="name" id="name" value="{{ old('name') }}"
                                                required autocomplete="name" autofocus>
                                            @error('name')
                                                <p class="block mb-2 mt-2 italic text-red-400"><i
                                                        class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="">Email(<span class="text-red-600">*</span>):</label>
                                            <input type="email"
                                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-2 mb-3"
                                                placeholder="Nhập email" name="email" id="email"
                                                value="{{ old('email') }}" required autocomplete="email">
                                            @error('email')
                                                <p class="block mb-2 mt-2 italic text-red-400"><i
                                                        class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="">Mật khẩu(<span class="text-red-600">*</span>):</label>
                                            <input type="password"
                                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-2 mb-3"
                                                placeholder="Nhập mật khẩu" name="password" id="password" required
                                                autocomplete="new-password">
                                            @error('password')
                                                <p class="block mb-2 mt-2 italic text-red-400"><i
                                                        class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="">Nhập lại mật khẩu(<span class="text-red-600">*</span>):</label>
                                            <input type="password"
                                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-2"
                                                placeholder="Nhập lại mật khẩu" name="password_confirmation"
                                                id="password_confirm" required autocomplete="new-password">
                                            @error('password_confirmation')
                                                <p class="block mb-2 mt-2 italic text-red-400"><i
                                                        class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div class="mt-2">
                                            <label for="update-profile-form-3" class="form-label">Số điện
                                                thoại:</label>
                                            <input id="update-profile-form-3" name="phone_number" type="text"
                                                class="form-control @error('phone_number') border-2 border-red-500 @enderror"
                                                value="{{ old('phone_number') }}" placeholder="Nhập số điện thoại">
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
                                                class="form-control" value="{{ old('address') }}"
                                                placeholder="Nhập địa chỉ">
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
                                                id="update-profile-form-4" value="{{ old('birthday') }}">
                                        </div>
                                    </div>
                                    <div class="col-span-12">
                                        <label>Giới tính:</label>
                                        <div class="mt-2">
                                            <select class="tom-select w-full" name="gender">
                                                <option value="">Chọn giới tính</option>
                                                <option value="Nam" @if (old('gender') == 'Nam') selected @endif>Nam
                                                </option>
                                                <option value="Nữ" @if (old('gender') == 'Nữ') selected @endif>Nữ
                                                </option>
                                                <option value="Gới tính khác"
                                                    @if (old('gender') == 'Gới tính khác') selected @endif>Giới tính khác
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    @if (Auth::user()->is_admin == 1)
                                        <div class="mt-4 col-span-12 mb-1">
                                            <input name="is_admin"
                                                class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                                type="checkbox" value="1" id="flexCheckDefault">
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
                                                            @if (old('role') == $role->id) selected @endif>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endcan
                                </div>
                                <button type="submit" value="add" name="btn_add" class="btn btn-primary w-30 mt-3">Thêm
                                    mới</button>
                            </div>
                            <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                                <div
                                    class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md p-5">
                                    <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                        <img class="rounded-md" id="upload-image" alt="" src="@php
                                            if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
                                                echo '/uploads/user/' . $_FILES['avatar']['name'];
                                            } else {
                                                echo '/upload/images/common_img/avt-user.png';
                                            }
                                        @endphp">
                                    </div>
                                    <div class="mx-auto cursor-pointer relative mt-5">
                                        <label for="avatar" class="btn btn-primary w-full cursor-pointer">Chọn ảnh đại
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
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/user.js') }}"></script>
@endsection
