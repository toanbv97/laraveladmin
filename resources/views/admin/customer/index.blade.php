@extends('admin.layouts.main')
@section('css')
    <link rel="stylesheet" href="/css/user.css">
@endsection
@section('subcontent')

    <a href="{{ route('customer.list') }}" class="inline-block uppercase intro-y text-lg font-medium mt-10">
        Danh sách khách hàng
    </a>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            @can('create', App\Models\Customer::class)
                <a href="{{ route('customer.create') }}" class="btn btn-primary shadow-md mr-2">Tạo người dùng mới</a>
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
            <a href="{{ route('customer.list') }}" class=" @if (empty(request()->input('status'))) active-url @endif">Kích hoạt
                (<span class="count-total">{{ $count['count_total'] }}</span>)</a>|
            <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}"
                class=" @if (request()->input('status') == 'trash') active-url @endif">Vô hiệu hóa (<span
                    class="count-trash">{{ $count['count_trash'] }}</span>)</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">AVATAR</th>
                        <th class="whitespace-nowrap">HỌ TÊN</th>
                        <th class="whitespace-nowrap">EMAIL</th>
                        <th class="text-center whitespace-nowrap">VOTE</th>
                        <th class="text-center whitespace-nowrap">ORDER</th>
                        <th class="text-center whitespace-nowrap">TÁC VỤ</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- ========= HTML đổ ra khi số user lớn hơn 0 ========= --}}
                    @if ($customers->count() > 0)
                        @php
                            if (empty(request()->page)) {
                                $t = 0;
                            } else {
                                $page = request()->page;
                                $t = ($page - 1) * 20;
                            }
                        @endphp
                        @foreach ($customers as $customer)
                            @php
                                $t++;
                            @endphp
                            <tr class="intro-x" id="html-user-{{ $customer->id }}">
                                <td>{{ $t }}</td>
                                {{-- ======= ẢNH ĐẠI DIỆN ========== --}}
                                <td class="w-8">
                                    <div class="flex">
                                        <div class="w-10 h-10 image-fit zoom-in">
                                            <a href="javascript:;" data-toggle="modal"
                                                data-target="#header-footer-modal-preview-{{ $customer->id }}">
                                                <img alt="{{ $customer->name }}" class="rounded-full"
                                                    style="object-fit: cover;
                                                                        width: 50px;
                                                                        height: 40px;"
                                                    src="@php
                                                                            if (!empty($customer->avatar)) {
                                                                                echo '/upload/images/user/' . $customer->avatar;
                                                                            } else {
                                                                                echo '/upload/images/common_img/avt-user.png';
                                                                            }
                                                                        @endphp"
                                                    title="{{ $customer->name }}">
                                            </a> <!-- END: Modal Toggle -->
                                            <!-- BEGIN: Modal Content -->
                                            <div id="header-footer-modal-preview-{{ $customer->id }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- BEGIN: Modal Header -->
                                                        <div class="modal-header">
                                                            <h2 class="font-medium text-base mr-auto uppercase">Thông tin
                                                                khách hàng
                                                            </h2>

                                                        </div> <!-- END: Modal Header -->
                                                        <!-- BEGIN: Modal Body -->
                                                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                                            <div class="col-span-3"></div>
                                                            <div class="col-span-6">
                                                                <img alt="" class="rounded-full"
                                                                    style="object-fit: cover;
                                                                                        width: 200px;
                                                                                        height: 200px;"
                                                                    src="@php
                                                                        if (!empty($customer->avatar)) {
                                                                            echo '/upload/images/user/' . $customer->avatar;
                                                                        } else {
                                                                            echo '/upload/images/common_img/avt-user.png';
                                                                        }
                                                                    @endphp">
                                                            </div>
                                                            <div class="col-span-3"></div>
                                                            <div class="col-span-12 pl-12">
                                                                <div>
                                                                    <div class="truncate sm:whitespace-normal items-center">
                                                                        <i class="fa-solid fa-user mr-2"></i>
                                                                        <strong class="mr-2">Họ tên:</strong>
                                                                        {{ $customer->name }}
                                                                    </div>
                                                                    <div
                                                                        class="truncate sm:whitespace-normal items-center mt-3">
                                                                        <i class="fa-solid fa-envelope mr-2"></i>
                                                                        <strong class="mr-2">Email:</strong>
                                                                        {{ $customer->email }}
                                                                    </div>
                                                                    <div
                                                                        class="truncate sm:whitespace-normal flex items-center mt-3">
                                                                        <i class="fa-solid fa-phone mr-2"></i></i><strong
                                                                            class="mr-2">Số điện thoại:</strong>
                                                                        {{ $customer->phone_number }}
                                                                    </div>
                                                                    <div
                                                                        class="truncate sm:whitespace-normal flex items-center mt-3">
                                                                        <i class="fa-solid fa-house mr-2"></i></i><strong
                                                                            class="mr-2">Địa chỉ:</strong>
                                                                        {{ $customer->address }}
                                                                    </div>
                                                                    <div
                                                                        class="truncate sm:whitespace-normal flex items-center mt-3">
                                                                        <i class="fa-solid fa-cake-candles mr-2"></i><strong
                                                                            class="mr-2">Ngày sinh:</strong>
                                                                        {{ date('d/m/Y', strtotime($customer->birthday)) }}
                                                                    </div>
                                                                    <div
                                                                        class="truncate sm:whitespace-normal flex items-center mt-3">
                                                                        <i
                                                                            class="fa-solid fa-venus-mars mr-2"></i></i><strong
                                                                            class="mr-2">Giới tính:</strong>
                                                                        {{ $customer->gender }}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div> <!-- END: Modal Body -->
                                                        <!-- BEGIN: Modal Footer -->
                                                        <div class="modal-footer text-right">
                                                            <button type="button" data-dismiss="modal"
                                                                class="btn btn-sm btn-primary w-20 mr-1">Cancel</button>
                                                            @can('update', App\Models\Customer::class)
                                                                @if (request()->status != 'trash')
                                                                    <a href="{{ route('customer.edit', $customer->id) }}"
                                                                        type="button"
                                                                        class="btn btn-sm btn-primary mr-1">Chỉnh
                                                                        sửa</a>
                                                                @endif
                                                            @endcan

                                                        </div>
                                                        <!-- END: Modal Footer -->
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                        </div>
                                    </div>
                                </td>

                                {{-- ========== HỌ TÊN ========= --}}
                                <td class="mr-0">
                                    <a href="javascript:;" data-toggle="modal"
                                        data-target="#header-footer-modal-preview-{{ $customer->id }}"
                                        class="font-medium whitespace-nowrap w-52 xl:w-48 lg:w-32 block overflow-hidden">{{ $customer->name }}</a>
                                </td>

                                {{-- =========== EMAIL ================ --}}
                                <td>
                                    <div style="word-wrap: break-word;" class="w-52 lg:w-44 xl:w-60 2xl:72 mr-0">
                                        <p>{{ $customer->email }}</p>
                                    </div>
                                </td>

                                {{-- ========= VOTE ======= --}}
                                <td class="text-center">2</td>

                                {{-- ======= ORDER ======== --}}
                                <td class="text-center">{{ $customer->order->count() }}</td>

                                {{-- ================ CÁC TÁC VỤ ================ --}}
                                <td class="table-report__action w-50">
                                    <div class="flex justify-center items-center">
                                        {{-- *********** User Ở Trạng Thái Vô Hiệu Hóa ******** --}}
                                        @if (request()->input('status') == 'trash')
                                            @can('delete', App\Models\Customer::class)
                                                <a href="javascript:;" title="Khôi phục"
                                                    data-user_id="{{ $customer->id }}"
                                                    class="tooltip restore-user mr-2 flex items-center btn btn-sm btn-success"><i
                                                        class="fa-solid fa-recycle"></i></a>
                                                <a class="tooltip flex items-center btn btn-sm btn-danger" href="javascript:;"
                                                    data-toggle="modal" title="Xóa vĩnh viễn"
                                                    data-target="#delete-modal-preview-{{ $customer->id }}"> <i
                                                        class="fa-solid fa-trash-can"></i></a>
                                                <div id="delete-modal-preview-{{ $customer->id }}" class="modal"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <div class="p-5 text-center"> <i data-feather="x-circle"
                                                                        class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                                                    <div class="text-3xl mt-5">Xóa vĩnh viễn!</div>
                                                                    <div class="text-gray-600 mt-2">Bạn có chắc muốn xóa vĩnh
                                                                        viễn
                                                                        tài
                                                                        khoản
                                                                        này?</div>
                                                                </div>
                                                                <div class="px-5 pb-8 text-center">
                                                                    <button type="button" data-dismiss="modal"
                                                                        class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Hủy</button>
                                                                    <button type="button" data-dismiss="modal"
                                                                        data-user_id="{{ $customer->id }}"
                                                                        class="force-del-user btn btn-danger w-24">Thực
                                                                        hiện</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                        @else
                                            {{-- *********** User Ở trạng thái kích hoạt ******** --}}
                                            @can('update', App\Models\Customer::class)
                                                @if (empty($customer->deleted_at))
                                                    <a class="tooltip flex items-center mr-2 btn btn-sm btn-primary"
                                                        title="Chỉnh sửa"
                                                        href="{{ route('customer.edit', $customer->id) }}">
                                                        <i class="fa-solid fa-pen-to-square"></i></a>
                                                @endif
                                            @endcan
                                            @can('delete', App\Models\Customer::class)
                                                <a class="tooltip flex items-center btn btn-sm btn-warning"
                                                    href="javascript:;" data-toggle="modal" title="Vô hiệu hóa"
                                                    data-target="#delete-modal-preview-{{ $customer->id }}"> <i
                                                        class="fa-solid fa-user-slash"></i></a>
                                                <div id="delete-modal-preview-{{ $customer->id }}" class="modal"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <div class="p-5 text-center"> <i data-feather="x-circle"
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
                                                                        data-user_id="{{ $customer->id }}"
                                                                        class="delete-user btn btn-danger w-24">Thực
                                                                        hiện</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                        @endif
                                    </div>
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
                {!! $customers->appends(['search' => request()->search])->links('admin.layouts.pagination') !!}
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
                    url: "{{ route('customer.delete') }}",
                    method: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                        $('#html-user-' + id).remove();
                        $('.count-total').text(data.count_total);
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
                    url: "{{ route('customer.restore') }}",
                    method: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                        $('#html-user-' + id).remove();
                        $('.count-total').text(data.count_total);
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
                    url: "{{ route('customer.forceDelete') }}",
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
