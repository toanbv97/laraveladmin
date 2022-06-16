<div class="flex justify-center items-center">
    {{-- *********** User Ở Trạng Thái Vô Hiệu Hóa ******** --}}
    @if (request()->input('status') == 'trash')
        @if ($user->is_admin == 1)
            {{-- Trường hợp user là Quản trị viên --}}
            @if (Auth::user()->is_admin == 1)
                @can('delete', App\Models\User::class)
                    <a href="javascript:;" title="Khôi phục"
                        data-user_id="{{ $user->id }}"
                        class="tooltip restore-user mr-2 flex items-center btn btn-sm btn-success"><i
                            class="fa-solid fa-recycle"></i></a>
                    <a class="tooltip flex items-center btn btn-sm btn-danger"
                        href="javascript:;" data-toggle="modal" title="Xóa vĩnh viễn"
                        data-target="#delete-modal-preview-{{ $user->id }}"> <i
                            class="fa-solid fa-trash-can"></i></a>
                    <div id="delete-modal-preview-{{ $user->id }}"
                        class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <div class="p-5 text-center"> <i data-feather="x-circle"
                                            class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                        <div class="text-3xl mt-5">Xóa vĩnh viễn!</div>
                                        <div class="text-gray-600 mt-2">Bạn có chắc muốn
                                            xóa
                                            vĩnh
                                            viễn
                                            tài
                                            khoản
                                            này?</div>
                                    </div>
                                    <div class="px-5 pb-8 text-center">
                                        <button type="button" data-dismiss="modal"
                                            class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Hủy</button>
                                        <button type="button" data-dismiss="modal"
                                            data-user_id="{{ $user->id }}"
                                            class="force-del-user btn btn-danger w-24">Thực
                                            hiện</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            @endif
        @else
            @can('delete', App\Models\User::class)
                <a href="javascript:;" title="Khôi phục" data-user_id="{{ $user->id }}"
                    class="tooltip restore-user mr-2 flex items-center btn btn-sm btn-success"><i
                        class="fa-solid fa-recycle"></i></a>
                <a class="tooltip flex items-center btn btn-sm btn-danger"
                    href="javascript:;" data-toggle="modal" title="Xóa vĩnh viễn"
                    data-target="#delete-modal-preview-{{ $user->id }}"> <i
                        class="fa-solid fa-trash-can"></i></a>
                <div id="delete-modal-preview-{{ $user->id }}" class="modal"
                    tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="p-5 text-center"> <i data-feather="x-circle"
                                        class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                    <div class="text-3xl mt-5">Xóa vĩnh viễn!</div>
                                    <div class="text-gray-600 mt-2">Bạn có chắc muốn xóa
                                        vĩnh
                                        viễn
                                        tài
                                        khoản
                                        này?</div>
                                </div>
                                <div class="px-5 pb-8 text-center">
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Hủy</button>
                                    <button type="button" data-dismiss="modal"
                                        data-user_id="{{ $user->id }}"
                                        class="force-del-user btn btn-danger w-24">Thực
                                        hiện</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        @endif
    @else
        {{-- *********** User Ở trạng thái kích hoạt ******** --}}
        @if ($user->is_admin == 1)
            {{-- Trường hợp user là Quản trị viên --}}
            @if (Auth::user()->is_admin == 1)
                @can('update', App\Models\User::class)
                    @if (empty($user->deleted_at))
                        <a class="tooltip flex items-center mr-2 btn btn-sm btn-primary"
                            title="Chỉnh sửa"
                            href="{{ route('admin.edit', $user->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i></a>
                    @endif
                @endcan
                @can('delete', App\Models\User::class)
                    @if ($user->id != Auth::user()->id)
                        <a class="tooltip flex items-center btn btn-sm btn-warning"
                            href="javascript:;" data-toggle="modal" title="Vô hiệu hóa"
                            data-target="#delete-modal-preview-{{ $user->id }}"> <i
                                class="fa-solid fa-user-slash"></i></a>
                        <div id="delete-modal-preview-{{ $user->id }}"
                            class="modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="p-5 text-center"> <i
                                                data-feather="x-circle"
                                                class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                            <div class="text-3xl mt-5">Vô hiệu hóa!</div>
                                            <div class="text-gray-600 mt-2">Bạn có chắc
                                                muốn vô
                                                hiệu
                                                hóa
                                                tài
                                                khoản
                                                này?</div>
                                        </div>
                                        <div class="px-5 pb-8 text-center">
                                            <button type="button" data-dismiss="modal"
                                                class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Hủy</button>
                                            <button type="button" data-dismiss="modal"
                                                data-user_id="{{ $user->id }}"
                                                class="delete-user btn btn-danger w-24">Thực
                                                hiện</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endcan
            @endif
        @else
            @can('update', App\Models\User::class)
                @if (empty($user->deleted_at))
                    <a class="tooltip flex items-center mr-2 btn btn-sm btn-primary"
                        title="Chỉnh sửa" href="{{ route('admin.edit', $user->id) }}">
                        <i class="fa-solid fa-pen-to-square"></i></a>
                @endif
            @endcan
            @can('delete', App\Models\User::class)
                @if ($user->id != Auth::user()->id)
                    <a class="tooltip flex items-center btn btn-sm btn-warning"
                        href="javascript:;" data-toggle="modal" title="Vô hiệu hóa"
                        data-target="#delete-modal-preview-{{ $user->id }}"> <i
                            class="fa-solid fa-user-slash"></i></a>
                    <div id="delete-modal-preview-{{ $user->id }}"
                        class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <div class="p-5 text-center"> <i
                                            data-feather="x-circle"
                                            class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                        <div class="text-3xl mt-5">Vô hiệu hóa!</div>
                                        <div class="text-gray-600 mt-2">Bạn có chắc muốn vô
                                            hiệu
                                            hóa
                                            tài
                                            khoản
                                            này?</div>
                                    </div>
                                    <div class="px-5 pb-8 text-center">
                                        <button type="button" data-dismiss="modal"
                                            class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Hủy</button>
                                        <button type="button" data-dismiss="modal"
                                            data-user_id="{{ $user->id }}"
                                            class="delete-user btn btn-danger w-24">Thực
                                            hiện</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endcan
        @endif
    @endif
</div>
