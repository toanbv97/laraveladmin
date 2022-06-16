@extends('admin.layouts.main')
@section('css')
    <link rel="stylesheet" href="/css/user.css">
@endsection
@section('subcontent')

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('order.list') }}" class="block uppercase intro-y text-lg font-medium">
                Danh sách đơn hàng
            </a>
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
            <a href="{{ route('order.list') }}" class=" @if (empty(request()->input('status'))) active-url @endif">Tất cả
                (<span class="count-total">{{ $count['count_total'] }}</span>)</a>|
            <a href="{{ request()->fullUrlWithQuery(['status' => 'processing']) }}"
                class=" @if (request()->input('status') == 'processing') active-url @endif">Chờ xử lý (<span
                    class="count-processing">{{ $count['count_processing'] }}</span>)</a>|
            <a href="{{ request()->fullUrlWithQuery(['status' => 'packed']) }}"
                class=" @if (request()->input('status') == 'packed') active-url @endif">Đã đóng gói (<span
                    class="count-packed">{{ $count['count_packed'] }}</span>)</a>|
            <a href="{{ request()->fullUrlWithQuery(['status' => 'shipping']) }}"
                class=" @if (request()->input('status') == 'shipping') active-url @endif">Đang vận chuyển (<span
                    class="count-shipping">{{ $count['count_shipping'] }}</span>)</a>|
            <a href="{{ request()->fullUrlWithQuery(['status' => 'done']) }}"
                class=" @if (request()->input('status') == 'done') active-url @endif">Hoàn thành (<span
                    class="count-done">{{ $count['count_done'] }}</span>)</a>|
            <a href="{{ request()->fullUrlWithQuery(['status' => 'cancelled']) }}"
                class=" @if (request()->input('status') == 'cancelled') active-url @endif">Đơn huỷ (<span
                    class="count-cancelled">{{ $count['count_cancelled'] }}</span>)</a>|
            <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}"
                class=" @if (request()->input('status') == 'trash') active-url @endif">Vô hiệu hóa (<span
                    class="count-trash">{{ $count['count_trash'] }}</span>)</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap w-32">MÃ ĐƠN</th>
                        <th class="whitespace-nowrap">HỌ TÊN</th>
                        <th class="text-center whitespace-nowrap">GIÁ TRỊ ĐƠN</th>
                        <th class="text-center whitespace-nowrap">THỜI GIAN</th>
                        <th class="text-center whitespace-nowrap">TRẠNG THÁI</th>
                        <th class="text-center whitespace-nowrap">TÁC VỤ</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- ========= HTML đổ ra khi số user lớn hơn 0 ========= --}}
                    @if ($orders->count() > 0)
                        @foreach ($orders as $order)
                            <tr class="intro-x" id="html-user-{{ $order->id }}">
                                <td>#{{ $order->id }}</td>
                                {{-- ========== HỌ TÊN - SĐT ========= --}}
                                <td class="mr-0">
                                    @can('show', App\Models\Order::class)
                                        <a href="javascript:;" data-toggle="modal"
                                            data-target="#header-footer-modal-preview-{{ $order->id }}"
                                            class="font-medium whitespace-nowrap">{{ $order->customer_name }}</a>
                                    @endcan
                                    @cannot('show', App\Models\Order::class)
                                        <p class="font-medium whitespace-nowrap">{{ $order->customer_name }}</p>
                                    @endcannot
                                    <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">
                                        {{ $order->phone_number }}</div>
                                    @can('show', App\Models\Order::class)
                                        <!-- BEGIN: Modal Content -->
                                        <div id="header-footer-modal-preview-{{ $order->id }}" class="modal"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog" style="width:80%;">
                                                <div class="modal-content">
                                                    <div class="grid grid-cols-12 gap-6">
                                                        <div class="box col-span-12">
                                                            <h2
                                                                class="text-xl font-medium mr-auto uppercase border-b border-gray-200 p-5">
                                                                Thông tin đơn hàng
                                                            </h2>
                                                            <div class="box px-2 border">
                                                                <h2 class="text-lg font-medium mr-auto p-3">
                                                                    <i class="fa-solid fa-address-card"></i> Thông tin khách
                                                                    hàng
                                                                </h2>
                                                                <div class="overflow-auto">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="border border-b-2 whitespace-nowrap">
                                                                                    Mã đơn</th>
                                                                                <th class="border border-b-2 whitespace-nowrap">
                                                                                    Họ tên</th>
                                                                                <th class="border border-b-2 whitespace-nowrap">
                                                                                    Số điện thoại</th>
                                                                                <th class="border border-b-2 whitespace-nowrap">
                                                                                    Địa chỉ</th>
                                                                                <th class="border border-b-2 whitespace-nowrap">
                                                                                    Email</th>
                                                                                <th class="border border-b-2 whitespace-nowrap">
                                                                                    Thời gian</th>
                                                                                <th class="border border-b-2 whitespace-nowrap">
                                                                                    Ghi chú</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="border">#{{ $order->id }}
                                                                                </td>
                                                                                <td class="border">
                                                                                    {{ $order->customer_name }}</td>
                                                                                <td class="border">
                                                                                    {{ $order->phone_number }}</td>
                                                                                <td class="border">
                                                                                    {{ $order->address }}</td>
                                                                                <td class="border">
                                                                                    {{ $order->email }}</td>
                                                                                <td class="border">
                                                                                    {{ \App\Helpers\CommonHelper::convertDateToDMY($order->created_at) }}
                                                                                </td>
                                                                                <td class="border">{{ $order->note }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="box px-2 border grid grid-cols-12 gap-6 pt-4">
                                                                <div class="col-span-12 lg:col-span-6">
                                                                    <h2 class="text-lg font-medium mr-auto p-3">
                                                                        <i class="fa-solid fa-clipboard-check"></i> Tình trạng
                                                                        đơn hàng:
                                                                        <div
                                                                            class="inline-block status-order-{{ $order->id }}">
                                                                            @if ($order->status == 1)
                                                                                <span
                                                                                    class="inline-block bg-red-600 text-white rounded-lg px-1.5">Chờ
                                                                                    xử lý</span>
                                                                            @elseif ($order->status == 2)
                                                                                <span
                                                                                    class="inline-block bg-yellow-600 text-white rounded-lg px-1.5">Đã
                                                                                    đóng gói</span>
                                                                            @elseif ($order->status == 3)
                                                                                <span
                                                                                    class="inline-block bg-blue-600 text-white rounded-lg px-1.5">Đang
                                                                                    vận chuyển</span>
                                                                            @elseif ($order->status == 4)
                                                                                <span
                                                                                    class="inline-block bg-green-600 text-white rounded-lg px-1.5">Hoàn
                                                                                    thành</span>
                                                                            @elseif ($order->status == 5)
                                                                                <span
                                                                                    class="inline-block bg-gray-600 text-white rounded-lg px-1.5">Đã
                                                                                    huỷ</span>
                                                                            @endif
                                                                        </div>
                                                                    </h2>
                                                                    @can('update', App\Models\Order::class)
                                                                        @if (request()->status != 'trash')
                                                                            <select data-placeholder="Cập nhật trạng thái đơn hàng"
                                                                                class="tom-select w-2/3 mr-4 select-status"
                                                                                name="status" data-order_id="{{ $order->id }}"
                                                                                data-view_status="{{ request()->status }}">
                                                                                <option value="1"
                                                                                    {{ $order->status == 1 ? 'selected' : '' }}>
                                                                                    Chờ xử lý</option>
                                                                                <option value="2"
                                                                                    {{ $order->status == 2 ? 'selected' : '' }}>
                                                                                    Đã đóng gói</option>
                                                                                <option value="3"
                                                                                    {{ $order->status == 3 ? 'selected' : '' }}>
                                                                                    Đang vận chuyển</option>
                                                                                <option value="4"
                                                                                    {{ $order->status == 4 ? 'selected' : '' }}>
                                                                                    Hoàn thành</option>
                                                                                <option value="5"
                                                                                    {{ $order->status == 5 ? 'selected' : '' }}>
                                                                                    Huỷ đơn</option>
                                                                            </select>
                                                                        @endif
                                                                    @endcan
                                                                </div>
                                                                <div class="col-span-12 lg:col-span-6 py-4">
                                                                    <div class="overflow-auto">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th
                                                                                        class="border border-b-2 whitespace-nowrap">
                                                                                        Tổng giá trị đơn hàng</th>
                                                                                    <th
                                                                                        class="border border-b-2 whitespace-nowrap">
                                                                                        Hình thức thanh toán</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="border">
                                                                                        {{ number_format($order->total, 0, '', '.') }}
                                                                                        VNĐ</td>
                                                                                    <td class="border">
                                                                                        {{ $order->payment_method }}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="grid grid-cols-12 gap-6 mt-4">
                                                        <div class="box col-span-12 px-2">
                                                            <h2
                                                                class="text-xl font-medium mr-auto uppercase border-b border-gray-200 p-5">
                                                                Chi tiết đơn hàng
                                                            </h2>
                                                            <div class="overflow-auto mb-4">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="border border-b-2 whitespace-nowrap w-8">
                                                                                STT</th>
                                                                            <th
                                                                                class="border border-b-2 whitespace-nowrap w-40">
                                                                                Ảnh
                                                                            </th>
                                                                            <th class="border border-b-2 whitespace-nowrap">Tên
                                                                                sản phẩm</th>
                                                                            <th class="border border-b-2 whitespace-nowrap">Giá
                                                                            </th>
                                                                            <th
                                                                                class="border border-b-2 whitespace-nowrap w-6 text-center">
                                                                                Số
                                                                                lượng</th>
                                                                            <th class="border border-b-2 whitespace-nowrap">Tổng
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @php
                                                                            $t = 0;
                                                                        @endphp
                                                                        @foreach ($order->order_item as $item)
                                                                            @php
                                                                                $t++;
                                                                            @endphp
                                                                            <tr>
                                                                                <td class="border">{{ $t }}
                                                                                </td>
                                                                                <td class="border">
                                                                                    @if (empty($item->product_id))
                                                                                        <img width="120px"
                                                                                            src="/upload/images/common_img/no-images.jpg"
                                                                                            alt="">
                                                                                    @else
                                                                                        @foreach ($products as $product)
                                                                                            @if ($product->id == $item->product_id)
                                                                                                @if ($product->thumb == \App\Models\Products::IMAGE)
                                                                                                    <img width="120px"
                                                                                                        src="/upload/images/common_img/no-images.jpg"
                                                                                                        alt="">
                                                                                                @else
                                                                                                    <img width="120px"
                                                                                                        src="/upload/images/products/{{$product->thumb }}"
                                                                                                        alt="">
                                                                                                @endif
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endif
                                                                                </td>
                                                                                <td class="border">{{ $item->product_name }}</a>
                                                                                </td>
                                                                                <td class="border">
                                                                                    {{ number_format($item->price, 0, '', '.') }}đ
                                                                                </td>
                                                                                <td class="border text-center">
                                                                                    {{ $item->quantily }}</td>
                                                                                <td class="border">
                                                                                    {{ number_format($item->price * $item->quantily, 0, '', '.') }}đ
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- BEGIN: Modal Footer -->
                                                    <div class="modal-footer text-right"> <button type="button"
                                                            data-dismiss="modal" class="btn btn-primary w-20 mr-1">Hủy</button>
                                                    </div>
                                                    <!-- END: Modal Footer -->
                                                </div>
                                            </div>
                                        </div> <!-- END: Modal Content -->
                                    @endcan
                                </td>
                                {{-- =========== GIÁ TRỊ ĐƠN ================ --}}
                                <td class="text-center">
                                    <p>{{ number_format($order->total, 0, '', '.') }}đ</p>
                                </td>

                                {{-- =====THỜI GIAN ===== --}}
                                <td class="text-center">
                                    <p>{{ \App\Helpers\CommonHelper::convertDateToDMY($order->created_at) }}</p>
                                </td>

                                {{-- ========= STATUS ======= --}}
                                <td class="text-center">
                                    <div class="status-view-all-{{ $order->id }}">
                                        @if ($order->status == 1)
                                            <span class="inline-block bg-red-600 text-white rounded-lg px-1.5">Chờ xử
                                                lý</span>
                                        @elseif ($order->status == 2)
                                            <span class="inline-block bg-yellow-600 text-white rounded-lg px-1.5">Đã đóng
                                                gói</span>
                                        @elseif ($order->status == 3)
                                            <span class="inline-block bg-blue-600 text-white rounded-lg px-1.5">Đang vận
                                                chuyển</span>
                                        @elseif ($order->status == 4)
                                            <span class="inline-block bg-green-600 text-white rounded-lg px-1.5">Hoàn
                                                thành</span>
                                        @elseif ($order->status == 5)
                                            <span class="inline-block bg-gray-600 text-white rounded-lg px-1.5">Đã
                                                huỷ</span>
                                        @endif
                                    </div>
                                </td>


                                {{-- ================ CÁC TÁC VỤ ================ --}}
                                <td class="table-report__action w-50">
                                    <div class="flex justify-center items-center">
                                        {{-- *********** Order Ở Trạng Thái Vô Hiệu Hóa ******** --}}
                                        @if (request()->input('status') == 'trash')
                                            @can('delete', App\Models\Order::class)
                                                <a href="javascript:;" title="Khôi phục" data-user_id="{{ $order->id }}"
                                                    class="tooltip restore-user mr-2 flex items-center btn btn-sm btn-success"><i
                                                        class="fa-solid fa-recycle"></i></a>
                                                <a class="tooltip flex items-center btn btn-sm btn-danger" href="javascript:;"
                                                    data-toggle="modal" title="Xóa vĩnh viễn"
                                                    data-target="#delete-modal-preview-{{ $order->id }}"> <i
                                                        class="fa-solid fa-trash-can"></i></a>
                                                <div id="delete-modal-preview-{{ $order->id }}" class="modal"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <div class="p-5 text-center"> <i data-feather="x-circle"
                                                                        class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                                                    <div class="text-3xl mt-5">Xóa vĩnh viễn!</div>
                                                                    <div class="text-gray-600 mt-2">Bạn có chắc muốn xóa vĩnh
                                                                        viễn
                                                                        đơn hàng
                                                                        này?</div>
                                                                </div>
                                                                <div class="px-5 pb-8 text-center">
                                                                    <button type="button" data-dismiss="modal"
                                                                        class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Hủy</button>
                                                                    <button type="button" data-dismiss="modal"
                                                                        data-user_id="{{ $order->id }}"
                                                                        class="force-del-user btn btn-danger w-24">Thực
                                                                        hiện</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                        @else
                                            {{-- *********** Order Ở trạng thái kích hoạt ******** --}}
                                            @can('update', App\Models\Order::class)
                                                @if (empty($customer->deleted_at))
                                                    <a class="tooltip flex items-center mr-2 btn btn-sm btn-primary"
                                                        title="Chỉnh sửa" href="{{ route('order.edit', $order->id) }}">
                                                        <i class="fa-solid fa-pen-to-square"></i></a>
                                                @endif
                                            @endcan
                                            @can('delete', App\Models\Order::class)
                                                <a class="tooltip flex items-center btn btn-sm btn-warning" href="javascript:;"
                                                    data-toggle="modal" title="Vô hiệu hóa"
                                                    data-target="#delete-modal-preview-{{ $order->id }}"> <i
                                                        class="fa-solid fa-trash-can"></i></a>
                                                <div id="delete-modal-preview-{{ $order->id }}" class="modal"
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
                                                                        đơn hàng
                                                                        này?</div>
                                                                </div>
                                                                <div class="px-5 pb-8 text-center">
                                                                    <button type="button" data-dismiss="modal"
                                                                        class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Hủy</button>
                                                                    <button type="button" data-dismiss="modal"
                                                                        data-user_id="{{ $order->id }}"
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
            {{-- <div class="pagination mt-3">{{ $users->links() }}</div> --}}
            <!-- BEGIN: Pagination -->
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                {!! $orders->appends(['search' => request()->search])->links('admin.layouts.pagination') !!}
            </div>
            <!-- END: Pagination -->
        </div>
        <!-- END: Data List -->
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {

            // Cập nhật trạng thái đơn hàng
            $('.select-status').change(function() {
                var status = $(this).val();
                var order_id = $(this).data('order_id');
                var _token = $('meta[name="csrf-token"]').attr('content');
                var view_status = $(this).data('view_status');
                var data = {
                    status: status,
                    order_id: order_id,
                    _token: _token
                };
                $.ajax({
                    url: "{{ route('order.updateAjax') }}",
                    method: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                        $('.status-order-' + order_id).html(data.html_status);
                        $('.count-total').text(data.count_total);
                        $('.count-processing').text(data.count_processing);
                        $('.count-packed').text(data.count_packed);
                        $('.count-shipping').text(data.count_shipping);
                        $('.count-done').text(data.count_done);
                        $('.count-cancelled').text(data.count_cancelled);
                        $('.count-trash').text(data.count_trash);
                        if (view_status == '') {
                            $('.status-view-all-' + order_id).html(data.html_status);
                        } else {
                            $('#html-user-' + order_id).remove();
                        }
                    }
                });
            });

            /* Xóa tạm thời */
            $('.delete-user').click(function() {
                var id = $(this).data('user_id');
                var _token = $('meta[name="csrf-token"]').attr('content');
                var data = {
                    id: id,
                    _token: _token
                };
                $.ajax({
                    url: "{{ route('order.delete') }}",
                    method: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                        $('#html-user-' + id).remove();
                        $('.count-total').text(data.count_total);
                        $('.count-processing').text(data.count_processing);
                        $('.count-packed').text(data.count_packed);
                        $('.count-shipping').text(data.count_shipping);
                        $('.count-done').text(data.count_done);
                        $('.count-cancelled').text(data.count_cancelled);
                        $('.count-trash').text(data.count_trash);
                    }
                });
            });


            /* Khôi phục */
            $('.restore-user').click(function() {
                var id = $(this).data('user_id');
                var _token = $('meta[name="csrf-token"]').attr('content');
                var data = {
                    id: id,
                    _token: _token
                };
                $.ajax({
                    url: "{{ route('order.restore') }}",
                    method: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                        $('#html-user-' + id).remove();
                        $('.count-total').text(data.count_total);
                        $('.count-processing').text(data.count_processing);
                        $('.count-packed').text(data.count_packed);
                        $('.count-shipping').text(data.count_shipping);
                        $('.count-done').text(data.count_done);
                        $('.count-cancelled').text(data.count_cancelled);
                        $('.count-trash').text(data.count_trash);
                    }
                });
            });

            /* Xóa vĩnh viễn */
            $('.force-del-user').click(function() {
                var id = $(this).data('user_id');
                var _token = $('meta[name="csrf-token"]').attr('content');
                var data = {
                    id: id,
                    _token: _token
                };
                $.ajax({
                    url: "{{ route('order.forceDelete') }}",
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
