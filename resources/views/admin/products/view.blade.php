<!-- BEGIN: Modal Content -->
<div id="header-footer-modal-preview-{{ $product->id }}" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto uppercase">Chi tiết sản phẩm</h2>
                @can('update', \App\Models\Post::class)
                    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                        <a href="{{ route('products.edit', ['id' => $product->id]) }}"
                            class="btn btn-primary shadow-md mr-2"><i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                            Sửa</a>
                    </div>
                @endcan
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div class="intro-y news p-5 box">
                    <!-- BEGIN: Blog Layout -->

                    <div class="grid grid-cols-12 gap-6 intro-y mt-6">
                        <div class="news__preview image-fit col-span-6">
                            <div class="">
                                @if ($product->thumb != 'no-images.jpg')
                                    <img style="object-fit: cover; object-position: 100% 0; width: 350px;height: 350px;" alt="{{ $product->title }}" class="rounded-md"
                                        src="/upload/images/products/{{ $product->thumb }}">
                                @else
                                    <img style="object-fit: cover; object-position: 100% 0; width: 350px;height: 350px;" alt="{{ $product->title }}" class="rounded-md"
                                        src="/upload/images/common_img/{{ $product->thumb }}">
                                @endif
                            </div>
                        </div>
                        <div class="col-span-6">
                            <h2 class="intro-y">
                                <span class="pl-3 font-medium">Tên sản phẩm:</span> {{ $product->name }}
                            </h2>
                            <div class=" text-justify  sm:pt-2 pb-2 leading-relaxed"><span class="pl-3 font-medium">Số lượng:</span>
                                {{ $product->quantity }}
                            </div>
                            <div class=" text-justify  sm:pt-2 pb-2 leading-relaxed"><span class="pl-3 font-medium">Giá bán:</span> {{ $product->price }}
                                VNĐ
                            </div>
                            <div class=" text-justify  sm:pt-2 pb-2 leading-relaxed"><span class="pl-3 font-medium">Slug:</span> {{ $product->slug }} </div>
                        </div>
                    </div>

                    <h2 class="text-lg font-medium">Thông tin sản phẩm</h2>
                    <div
                        class="intro-y flex text-xs sm:text-sm flex-col sm:flex-row items-center pt-5 border-t border-gray-200 dark:border-dark-5">
                        <div class="flex items-center">
                            <div class="ml-3 mr-auto">
                                <div class="intro-y text-justify leading-relaxed"> {!! $product->content !!}</div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Blog Layout -->
                </div>

            </div> <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer text-right">
                <button type="button" data-dismiss="modal" class="btn btn-sm btn-primary w-20 mr-1">Đóng</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div> <!-- END: Modal Content -->
