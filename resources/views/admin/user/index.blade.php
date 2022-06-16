@extends('admin.layouts.main')
@section('css')
    <link rel="stylesheet" href="/css/user.css">
@endsection
@section('subcontent')

    <a href="{{ route('user.list') }}" class="inline-block uppercase intro-y text-lg font-medium mt-10">
        Danh sách User
    </a>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            @can('create', App\Models\User::class)
                <a href="{{ route('admin.create') }}" class="btn btn-primary shadow-md mr-2">Thêm nhân viên</a>
            @endcan
            <div class="hidden md:block mx-auto text-gray-600"></div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-gray-700 dark:text-gray-300">
                    <form action="" autocomplete="off">
                        <input type="text" name="search" value="{{ request()->input('search') }}"
                            class="form-control w-56 box pr-10 placeholder-theme-13" placeholder="Tìm kiếm">
                        <button type="submit" class="absolute w-5 h-5 my-auto inset-y-0 mr-3 right-0"><i
                                class="w-4 h-4 my-auto inset-y-0 mr-3 right-0 cursor-pointer"
                                data-feather="search"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="analytic intro-y col-span-12">
            <a href="{{ route('user.list') }}" class=" @if (empty(request()->input('status'))) active-url @endif">Tất cả (<span
                    class="count-total">{{ $count['count_total'] }}</span>)</a>|
            <a href="{{ request()->fullUrlWithQuery(['status' => 'admin']) }}"
                class=" @if (request()->input('status') == 'admin') active-url @endif">Danh sách quản trị viên (<span
                    class="count-admin">{{ $count['count_admin'] }}</span>)</a>|
            <a href="{{ request()->fullUrlWithQuery(['status' => 'user']) }}"
                class=" @if (request()->input('status') == 'user') active-url @endif">Danh sách nhân viên (<span
                    class="count-user">{{ $count['count_user'] }}</span>)</a>|
            <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}"
                class=" @if (request()->input('status') == 'trash') active-url @endif">Đã vô hiệu
                hoá (<span class="count-trash">{{ $count['count_trash'] }}</span>)</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="w-8">#</th>
                        <th class="whitespace-nowrap">AVATAR</th>
                        <th class="whitespace-nowrap">HỌ TÊN</th>
                        <th class="whitespace-nowrap">EMAIL</th>
                        <th class="text-center whitespace-nowrap">VAI TRÒ</th>
                        <th class="text-center whitespace-nowrap">TÁC VỤ</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- ========= HTML đổ ra khi số user lớn hơn 0 ========= --}}
                    @if ($users->count() > 0)
                        @php
                            if (empty(request()->page)) {
                                $t = 0;
                            } else {
                                $page = request()->page;
                                $t = ($page - 1) * 20;
                            }
                        @endphp
                        @foreach ($users as $user)
                            @php
                                $t++;
                            @endphp
                            <tr class="intro-x" id="html-user-{{ $user->id }}">
                                <td>{{ $t }}</td>
                                {{-- ======= ẢNH ĐẠI DIỆN ========== --}}
                                <td class="w-8">
                                    <div class="flex">
                                        <div class="w-10 h-10 image-fit zoom-in">
                                            <a href="javascript:;" data-toggle="modal"
                                                data-target="#header-footer-modal-preview-{{ $user->id }}">
                                                <img alt="{{ $user->name }}" class="rounded-full"
                                                    style="object-fit: cover; width: 50px; height: 40px;"
                                                    title="{{ $user->name }}" src="@php
                                                        if (!empty($user->avatar)) {
                                                            echo '/upload/images/user/' . $user->avatar;
                                                        } else {
                                                            echo '/upload/images/common_img/avt-user.png';
                                                        }
                                                    @endphp">
                                            </a>
                                            @include('admin.user.modal', $user)
                                        </div>
                                    </div>
                                </td>

                                {{-- ========== HỌ TÊN ========= --}}
                                <td class="mr-0">
                                    <a href="javascript:;" data-toggle="modal"
                                        data-target="#header-footer-modal-preview-{{ $user->id }}"
                                        class="font-medium whitespace-nowrap w-52 xl:w-48 lg:w-32 block overflow-hidden">{{ $user->name }}</a>
                                </td>

                                {{-- =========== EMAIL ================ --}}
                                <td>
                                    <div style="word-wrap: break-word;" class="w-52 lg:w-44 xl:w-60 2xl:72 mr-0">
                                        <p>{{ $user->email }}</p>
                                    </div>
                                </td>

                                {{-- =========== VAI TRÒ ================ --}}
                                <td>
                                    <div class="flex justify-center items-center">
                                        <div class="role-name-{{ $user->id }}">
                                            @if ($user->is_admin == 1)
                                                <div
                                                    class="text-xs inline-flex items-center leading-sm px-2 py-1 bg-blue-200 text-blue-700 rounded-full">
                                                    Quản trị viên
                                                </div>
                                            @else
                                                @if (!empty($user->role_id))
                                                    <div
                                                        class="text-xs inline-flex items-center leading-sm px-2 py-1 bg-blue-200 text-blue-700 rounded-full">
                                                        {{ $user->role->name }}
                                                    </div>
                                                @else
                                                    <div
                                                        class="ml-4 text-xs inline-flex items-center leading-sm px-2 py-1 rounded-full bg-white text-gray-700 border">
                                                        Người dùng
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                </td>

                                {{-- ================ CÁC TÁC VỤ ================ --}}
                                <td class="table-report__action w-50">
                                    {{-- Làm việc tại action.blade.php --}}
                                    @include('admin.user.action', $user)
                                </td>
                            </tr>
                        @endforeach
                    @else
                        {{-- ======== HTML đổ ra khi số user bằng 0 =========== --}}
                        <td colspan="7">
                            <div class="intro-y col-span-12 text-center mt-10">
                                <p class="italic">Không tìm thấy thông tin đã yêu cầu</p>
                            </div>
                        </td>
                    @endif
                </tbody>
            </table>
            <!-- BEGIN: Pagination -->
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                {!! $users->appends(['search' => request()->search])->links('admin.layouts.pagination') !!}
            </div>
            <!-- END: Pagination -->
        </div>
        <!-- END: Data List -->
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {

            /* Xóa tạm thời user */
            $('.delete-user').click(function() {
                var id = $(this).data('user_id');
                var _token = $('meta[name="csrf-token"]').attr('content');
                var data = {
                    id: id,
                    _token: _token
                };
                $.ajax({
                    url: "{{ route('admin.delete') }}",
                    method: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                        $('#html-user-' + id).remove();
                        $('.count-total').text(data.count_total);
                        $('.count-admin').text(data.count_admin);
                        $('.count-user').text(data.count_user);
                        $('.count-trash').text(data.count_trash);
                    }
                });
            });


            /* Khôi phục User */
            $('.restore-user').click(function() {
                var id = $(this).data('user_id');
                var _token = $('meta[name="csrf-token"]').attr('content');
                var data = {
                    id: id,
                    _token: _token
                };
                $.ajax({
                    url: "{{ route('admin.restore') }}",
                    method: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                        $('#html-user-' + id).remove();
                        $('.count-total').text(data.count_total);
                        $('.count-admin').text(data.count_admin);
                        $('.count-user').text(data.count_user);
                        $('.count-trash').text(data.count_trash);
                    }
                });
            });

            /* Xóa vĩnh viễn user */
            $('.force-del-user').click(function() {
                var id = $(this).data('user_id');
                var _token = $('meta[name="csrf-token"]').attr('content');
                var data = {
                    id: id,
                    _token: _token
                };
                $.ajax({
                    url: "{{ route('admin.forceDelete') }}",
                    method: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                        $('#html-user-' + id).remove();
                        $('.count-trash').text(data.count_trash);
                    }
                });
            });
        });
    </script>
@endsection
