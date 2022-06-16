@extends('admin.layouts.main')
@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
           <a href="{{ route('products.index') }}">{{ $title }}</a> 
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            @can('create', App\Models\Products::class)
                <a class="btn btn-primary shadow-md mr-2" href="{{ route('products.create') }}">Tạo sản phẩm</a>
            @endcan
            <div class="hidden md:block mx-auto text-gray-600"></div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <form action="?">
                    <div class="w-56 relative text-gray-700 dark:text-gray-300">
                        <input type="text" class="form-control w-56 box pr-10 placeholder-theme-13" name="search" value="{{ request()->search }}" placeholder="Tìm kiếm...">
                        <button class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" type="submit"><i
                        class="absolute my-auto inset-y-0 right-0" data-feather="search"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">Ảnh sản phẩm</th>
                        <th class="whitespace-nowrap">Tên sản phẩm</th>
                        <th class="text-center whitespace-nowrap">Số lượng</th>
                        <th class="text-center whitespace-nowrap">Giá bán</th>
                        <th class="text-center whitespace-nowrap">Trạng thái</th>
                        <th class="text-center whitespace-nowrap">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr id="{{ $product->id }}" class="intro-x clickable-row" href="javascript:;" data-toggle="modal"
                            data-target="#header-footer-modal-preview-{{ $product->id }}">
                            <td >
                                @if ($product->thumb == \App\Models\Products::IMAGE)
                                    <img src="{{ asset('/upload/images/common_img/') . '/' . $product->thumb }}" style="object-fit: cover; object-position: 50% 0; width: 130px;height: 130px;">
                                @else
                                    <img src="{{ asset('/upload/images/products/medium') . '/' . $product->thumb }}" style="object-fit: cover; object-position: 50% 0; width: 130px;height: 130px;">
                                @endif
                            </td>
                            <td>
                                <div class="font-medium ">
                                    @can('viewAny', \App\Models\Products::class)
                                        <a href="javascript:;" data-toggle="modal"
                                            data-target="#header-footer-modal-preview-{{ $product->id }}"
                                            title="Chi tiết sản phẩm">
                                            {{ $product->name }}
                                        </a>
                                    @endcan
                                    @cannot('viewAny', \App\Models\Products::class)
                                        {{ $product->name }}
                                    @endcannot
                                </div>
                            </td>
                            <td>
                                <div class="font-medium text-center" >
                                    {{ number_format($product->quantity, 0, '', '.')  }}</div>
                            </td>
                            <td>
                                <div class="font-medium text-center" >
                                    {{ number_format($product->price, 0, '', '.') }}
                                </div>
                            </td>
                            <td class="w-10">
                                @if ($product->status == 0)
                                    <div class="text-theme-6 text-center"> <i data-feather="check-square"
                                            class="w-4 h-4 mr-2"></i></div>
                                @else
                                    <div class="text-theme-9 text-center"> <i data-feather="check-square"
                                            class="w-4 h-4 mr-2"></i></div>
                                @endif
                            </td>
                            <td class="table-report__action w-40">
                                <div class="flex justify-center items-center">
                                    @can('update', App\Models\Products::class)
                                        <a href="{{ route('products.edit', ['id' => $product->id]) }}" title="Chỉnh sửa"
                                            class="btn btn-sm btn-primary mr-2">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    @endcan
                                    @can('delete', App\Models\Products::class)
                                        <a title="Xóa" data-toggle="modal" data-value="{{ $product->id }}"
                                            data-target="#delete-confirmation-modal"
                                            class="btn btn-danger py-1 px-2 btn-delete"><i class="fa-solid fa-trash-can" style="padding: 1px"></i>
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @include('admin.products.view')
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            {!! $products->links('admin.layouts.pagination') !!}
        </div>
        <!-- END: Pagination -->
    </div>
    @include('admin.products.delete')
@endsection
