@extends('admin.layouts.main')
@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto uppercase">
            Tạo quyền quản trị mới
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-12 2xl:col-span-12 flex lg:block flex-col-reverse">
            <div>
                <form method="POST" action="{{ route('role.update', $role->id) }}">
                    @csrf
                    <div class="intro-x mt-8">
                        <label for="name">Tên quyền:</label>
                        <input type="text"
                            class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-2 mb-3"
                            placeholder="Tên quyền" name="name" id="name" value="{{ $role->name }}" required
                            autocomplete="name">
                        @error('name')
                            <span role="alert">
                                <p class="italic my-1" style="color: red;">{{ $message }}</p>
                            </span>
                        @enderror

                        <label for="desc">Mô tả:</label>
                        <input type="text"
                            class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-2 mb-3"
                            placeholder="Mô tả thêm về vai trò của quyền" name="desc" id="desc" value="{{ $role->desc }}"
                            required autocomplete="desc">
                        @error('desc')
                            <span role="alert">
                                <p class="italic my-1" style="color: red;">{{ $message }}</p>
                            </span>
                        @enderror
                        <div class="justify-center grid grid-cols-12">
                            <div class="col-span-12 mt-5 mb-3">
                                <p class="text-lg font-medium">Chọn các chức năng:</p>
                            </div>
                            <div class="col-span-12 mt-5 mb-3">
                                @foreach ($permissionParents as $permissionParent)
                                    <div class="justify-center grid grid-cols-12 border-2">
                                        <div class="col-span-3 px-3 py-2 border-r-2 font-medium" style="font-size: 1rem; display: flex;
                                                justify-content: center;
                                                align-items: center;">
                                            <p class="inline-block">{{ $permissionParent->name }}</p>
                                        </div>
                                        <div class="col-span-9 px-3 py-2">
                                            <div class="justify-center grid grid-cols-12">
                                                @foreach ($permissionParent->permissionsChildrent as $permission)
                                                    <div class="form-check col-span-6 md:col-span-4 lg:col-span-3 2xl:col-span-2 px-3 py-2">
                                                        <input name="permission_id[]"
                                                            class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                                            type="checkbox" value="{{ $permission->id }}"
                                                            id="flexCheckDefault-{{ $permission->id }}"
                                                            {{ $role->permission_role->contains('permission_id', $permission->id) ? 'checked' : '' }}>
                                                        <label class="form-check-label inline-block text-gray-800"
                                                            for="flexCheckDefault-{{ $permission->id }}"
                                                            style="font-size: 1rem">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button type="submit" name="btn_update" value="update"
                            class="btn btn-primary py-3 px-4 w-full lg:w-32 xl:mr-3 align-top">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
