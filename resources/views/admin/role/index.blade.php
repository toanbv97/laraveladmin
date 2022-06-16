@extends('admin.layouts.main')
@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <a href="{{ route('role.list') }}" class="text-lg font-medium mr-auto uppercase">
            Danh sách quyền quản trị
        </a>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            @can('create', App\Models\Role::class)
                <div class="text-center"> <a href="{{ route('role.create') }}" class="btn btn-primary">Thêm quyền</a> </div>
            @endcan
        </div>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5 overflow-x-auto">
        <table class="table">
            <thead>
                <tr class="bg-gray-700 dark:bg-dark-1 text-white">
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">Tên quyền</th>
                    <th class="whitespace-nowrap">Mô tả</th>
                    <th class="whitespace-nowrap">Tác vụ</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $t = 0;
                @endphp
                @foreach ($roles as $role)
                    @php
                        $t++;
                    @endphp
                    <tr id="html-role-{{ $role->id }}">
                        <td class="border-b dark:border-dark-5">{{ $t }}</td>
                        <td class="border-b dark:border-dark-5 font-bold"><a href="javascript:;" data-toggle="modal"
                                data-target="#header-footer-modal-preview-{{ $role->id }}">{{ $role->name }}</a>
                            <!-- END: Modal Toggle -->
                            <!-- BEGIN: Modal Content -->
                            <div id="header-footer-modal-preview-{{ $role->id }}" class="modal" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog" style="width:60%;">
                                    <div class="modal-content">
                                        <!-- BEGIN: Modal Header -->
                                        <div class="modal-header">
                                            <h2 class="text-lg uppercase font-medium text-base mr-auto">Chi tiết quyền quản trị</h2>
                                        </div> <!-- END: Modal Header -->
                                        <!-- BEGIN: Modal Body -->
                                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                            <div class="col-span-12 sm:col-span-10 text-lg">
                                                <p><span class="mr-2 font-medium">Tên quyền: </span>{{ $role->name }}</p>
                                            </div>
                                            <div class="col-span-12 mt-2 mb-1">
                                                <p class="text-lg font-medium">Các chức năng:</p>
                                            </div>
                                            <div class="col-span-12 mt-2 mb-3">
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
                                                                    <div class="form-check col-span-12 md:col-span-4 xl:col-span-3 2xl:col-span-2 px-3 py-2">
                                                                        <input name="permission_id[]" disabled
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
                                        </div> <!-- END: Modal Body -->
                                        <!-- BEGIN: Modal Footer -->
                                        <div class="modal-footer text-right"> <button type="button" data-dismiss="modal"
                                                class="btn btn-outline-secondary w-20 mr-1">Hủy</button>
                                                @can('update', App\Models\Role::class)
                                                <a href="{{ route('role.edit', $role->id) }}" class="btn btn-primary">Chỉnh
                                                    sửa</a>
                                                @endcan
                                        </div>
                                        <!-- END: Modal Footer -->
                                    </div>
                                </div>
                            </div> <!-- END: Modal Content -->
                        </td>

                        <td class="border-b dark:border-dark-5">{{ $role->desc }}</td>
                        <td class="border-b dark:border-dark-5">
                            <div class="flex">
                                @can('update', App\Models\Role::class)
                                    <a href="{{ route('role.edit', $role->id) }}" title="Chỉnh sửa"
                                        class="tooltip btn btn-sm btn-primary mr-2">
                                        <i class="fa-solid fa-pen-to-square"></i></a>
                                @endcan
                                @can('delete', App\Models\Role::class)
                                    <a href="javascript:;" title="Xóa" data-toggle="modal"
                                        data-target="#delete-modal-preview-{{ $role->id }}"
                                        class="tooltip btn btn-danger py-1 px-2"><i class="fa-solid fa-trash-can"
                                            style="padding: 1px"></i></a>
                                    <div id="delete-modal-preview-{{ $role->id }}" class="modal" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="p-5 text-center"> <i data-feather="x-circle"
                                                            class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                                        <div class="text-3xl mt-5">Xóa quyền!</div>
                                                        <div class="text-gray-600 mt-2">Bạn có chắc muốn xóa quyền
                                                            {{ $role->name }}</div>
                                                    </div>
                                                    <div class="px-5 pb-8 text-center"> <button type="button"
                                                            data-dismiss="modal"
                                                            class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</button>
                                                        <button type="button" data-dismiss="modal"
                                                            data-role_id="{{ $role->id }}"
                                                            class="delete-role btn btn-danger w-24">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('.delete-role').click(function() {
                var id = $(this).data('role_id');
                var _token = $('meta[name="csrf-token"]').attr('content');
                var data = {
                    id: id,
                    _token: _token
                };
                $.ajax({
                    url: "{{ route('role.delete') }}",
                    method: "POST",
                    data: data,
                    success: function(data) {
                        $('#html-role-' + id).remove();
                    }
                });
            });
        });
    </script>
@endsection
