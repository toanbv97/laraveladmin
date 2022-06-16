@extends('admin.layouts.main')
@section('subcontent')
    <div class="intro-x grid grid-cols-12 gap-6">
        @if (request()->view == 'change-customer')
            <div class="box col-span-12">
                <h2 class="text-xl font-medium mr-auto uppercase border-b border-gray-200 p-5">
                    Thông tin đơn hàng
                </h2>
                <div class="box px-2 border pb-4">
                    <h2 class="text-lg font-medium mr-auto p-3">
                        <i class="fa-solid fa-address-card"></i> Cập nhật thông tin khách hàng
                    </h2>
                    <form action="{{ route('order.updateCustomer') }}" method="post">
                        @csrf
                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-12 lg:col-span-6 pl-3">
                                <label class="font-medium">Họ tên khách hàng(<span
                                        class="text-red-600">*</span>):</label>
                                <input type="text" class="form-control py-3 px-4 border-gray-300 block mt-2 mb-3"
                                    placeholder="Nhập họ tên" name="customer_name"
                                    value="{{ old('customer_name') ?? $order->customer_name }}" required>
                                @error('customer_name')
                                    <p class="block mb-2 mt-2 italic text-red-400"><i
                                            class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 lg:col-span-6 pl-3">
                                <label class="font-medium">Số điện thoại(<span class="text-red-600">*</span>):</label>
                                <input type="text" class="form-control py-3 px-4 border-gray-300 block mt-2 mb-3"
                                    placeholder="Số điện thoại" name="phone_number"
                                    value="{{ old('phone_number') ?? $order->phone_number }}" required>
                                @error('phone_number')
                                    <p class="block mb-2 mt-2 italic text-red-400"><i
                                            class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 lg:col-span-6 pl-3">
                                <label class="font-medium">Địa chỉ(<span class="text-red-600">*</span>):</label>
                                <input type="text" class="form-control py-3 px-4 border-gray-300 block mt-2 mb-3"
                                    placeholder="Số điện thoại" name="address"
                                    value="{{ old('address') ?? $order->address }}" required>
                                @error('address')
                                    <p class="block mb-2 mt-2 italic text-red-400"><i
                                            class="fa-solid fa-triangle-exclamation mr-2"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 mb-4">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <button type="submit" class="btn btn-primary w-28 ml-3">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="box col-span-12">
                <h2 class="text-xl font-medium mr-auto uppercase border-b border-gray-200 p-5">
                    Thông tin đơn hàng
                </h2>
                <div class="box px-2 border">
                    <div>
                        <h2 class="text-lg inline-block font-medium mr-auto p-3">
                            <i class="fa-solid fa-address-card"></i> Thông tin khách hàng
                        </h2>
                        @if ($order->status == 1)
                            <a href="{{ request()->fullUrlWithQuery(['view' => 'change-customer']) }}"
                                class="btn btn-primary">Chỉnh sửa</a>
                        @endif
                    </div>
                    <div class="overflow-auto my-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="border border-b-2 whitespace-nowrap">Mã đơn</th>
                                    <th class="border border-b-2 whitespace-nowrap">Họ tên</th>
                                    <th class="border border-b-2 whitespace-nowrap">Số điện thoại</th>
                                    <th class="border border-b-2 whitespace-nowrap">Địa chỉ</th>
                                    <th class="border border-b-2 whitespace-nowrap">Email</th>
                                    <th class="border border-b-2 whitespace-nowrap">Thời gian</th>
                                    <th class="border border-b-2 whitespace-nowrap">Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border">#{{ $order->id }}</td>
                                    <td class="border">{{ $order->customer_name }}</td>
                                    <td class="border">{{ $order->phone_number }}</td>
                                    <td class="border">{{ $order->address }}</td>
                                    <td class="border">{{ $order->email }}</td>
                                    <td class="border">
                                        {{ \App\Helpers\CommonHelper::convertDateToDMY($order->created_at) }}</td>
                                    <td class="border">{{ $order->note }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box px-2 border grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-6">
                        <h2 class="text-lg font-medium mr-auto p-3">
                            <i class="fa-solid fa-clipboard-check"></i> Tình trạng đơn hàng:
                            @if ($order->status == 1)
                                <span class="inline-block bg-red-600 text-white rounded-lg px-1.5">Chờ xử lý</span>
                            @elseif ($order->status == 2)
                                <span class="inline-block bg-yellow-600 text-white rounded-lg px-1.5">Đã đóng gói</span>
                            @elseif ($order->status == 3)
                                <span class="inline-block bg-blue-600 text-white rounded-lg px-1.5">Đang vận chuyển</span>
                            @elseif ($order->status == 4)
                                <span class="inline-block bg-green-600 text-white rounded-lg px-1.5">Hoàn thành</span>
                            @elseif ($order->status == 5)
                                <span class="inline-block bg-gray-600 text-white rounded-lg px-1.5">Đã huỷ</span>
                            @endif
                        </h2>
                        @can('update', App\Models\Order::class)
                            <form action="{{ route('order.update') }}" method="POST" class="flex">
                                @csrf
                                <select data-placeholder="Cập nhật trạng thái đơn hàng" class="tom-select w-2/3 mr-4"
                                    name="status">
                                    <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Đã đóng gói</option>
                                    <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Đang vận chuyển</option>
                                    <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>Hoàn thành</option>
                                    <option value="5" {{ $order->status == 5 ? 'selected' : '' }}>Huỷ đơn</option>
                                </select>
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </form>
                        @endcan
                    </div>
                    <div class="col-span-12 lg:col-span-6 py-4">
                        <div class="overflow-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="border border-b-2 whitespace-nowrap">Tổng giá trị đơn hàng</th>
                                        <th class="border border-b-2 whitespace-nowrap">Hình thức thanh toán</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border">{{ number_format($order->total, 0, '', '.') }} VNĐ
                                        </td>
                                        <td class="border">{{ $order->payment_method }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
    <div class="intro-y grid grid-cols-12 gap-6 mt-4">
        <div class="box col-span-12 px-2">
            <h2 class="text-xl font-medium mr-auto uppercase border-b border-gray-200 p-5">
                Chi tiết đơn hàng
            </h2>
            <div class="overflow-auto mb-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="border border-b-2 whitespace-nowrap w-8">STT</th>
                            <th class="border border-b-2 whitespace-nowrap">Ảnh</th>
                            <th class="border border-b-2 whitespace-nowrap">Tên sản phẩm</th>
                            <th class="border border-b-2 whitespace-nowrap">Giá</th>
                            <th class="border border-b-2 whitespace-nowrap">Số lượng</th>
                            <th class="border border-b-2 whitespace-nowrap">Tổng</th>
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
                                <td class="border w-40">
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
@endsection
