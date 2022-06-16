@extends('admin.layouts.main')
@section('css')
<script src="{{ asset('lib/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
@endsection
@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
<h2 class="text-lg font-medium mr-auto">
    {{ $title }}
</h2>
<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
    @can('viewAny', App\Models\Products::class)
    <a class="btn btn-primary shadow-md mr-2" href="{{ route('products.index') }}">Danh sách sản phẩm</a>
    @endcan
</div>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12">
        <!-- BEGIN: Form Layout -->
        <form action="{{ route('products.update', ['id' => $edit->id]) }}" method="post" enctype="multipart/form-data"
            id="form-post">
            <div class="intro-y box p-5">
                <div>
                    <label for="crud-form-1" class="form-label">Tên sản phẩm(<span
                            class="text-red-600">*</span>)</label>
                    <input id="crud-form-1" type="text" name="name" value="{{ old('name') ?? $edit->name }}"
                        class="form-control w-full">
                    @error('name')
                        <span style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label>Trạng thái</label><br>
                    <input type="checkbox" class="form-check-switch" name='status'
                        value="{{ $edit->status == true ? '1' : '0' }}" {{ $edit->status == true ? 'checked' : ' ' }}></div>
                <div class="mt-3">
                <div class="grid grid-cols-12 gap-x-5">
                <div class="col-span-12 xl:col-span-4">
                    <label>Ảnh sản phẩm</label><br>
                    <div class="px-4 pb-4 flex items-center cursor-pointer relative">
                        <i data-feather="image" class="w-4 h-4 mr-2"></i> <span
                            class="text-theme-1 dark:text-theme-10 mr-1">Upload ảnh</span>
                        <input name='thumb' type="file" class="w-56 h-56 top-0 left-0 absolute opacity-0" id="fileupload2" />
                        {{-- @include('admin.products.cropimg') --}}
                    </div>
                    <div class="border-2 border-dashed dark:border-dark-5 rounded-md p-2">
                    <div class="m-2" id="dvPreview2">
                        @if ($edit->thumb === '' || $edit->thumb === 'no-images.jpg')
                            <img src="{{ asset('/upload/images/common_img/no-images.jpg') }}" style="object-fit: cover; object-position: 50% 0; width: 300px;height: 300px;">
                        @else
                            <img src="{{ asset('/upload/images/products/medium') . '/' . $edit->thumb }}" style="object-fit: cover; object-position: 50% 0; width: 300px;height: 300px;">
                        @endif
                        @error('thumb')
                            <span style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    </div>
                </div>
                <div class="col-span-12 xl:col-span-7">
                    <label>Ảnh giới thiệu sản phẩm</label><br>
                    <div class="px-4 pb-4 flex items-center cursor-pointer relative">
                        <i data-feather="image" class="w-4 h-4 mr-2"></i> <span
                            class="text-theme-1 dark:text-theme-10 mr-1">Upload ảnh</span>
                        <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0" name="image[]"
                            multiple id="fileupload">
                    </div>
                    <div class="border-2 border-dashed dark:border-dark-5 rounded-md pt-2">
                    <div class="flex flex-wrap px-4 w-full">

                    <div class="mt-2 ">
                    <div id="dvPreview">
                        @if ($edit->image === '' || $edit->image === 'no-images.jpg')
                        <img class="rounded-md"src="{{ asset('/upload/images/common_img/no-images.jpg') }}"style="object-fit: cover; object-position: 50% 0; width: 100px;height: 100px;">
                        @else
                            @foreach ($img as $item)
                            <div class="inline-block w-24 h-24 relative image-fit mb-5 mr-5 cursor-pointer zoom-in" id="">
                            <img class="rounded-md"src="{{ asset('/upload/images/products') . '/' . $item }}" style="object-fit: cover; object-position: 50% 0; width: 100px;height: 100px;">
                            <div title="Xóa ảnh?" data-product_id="{{ $edit->id }}"data-img="{{ $item }}"
                                class="xoa_anh tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-theme-6 right-0 top-0 -mr-2 -mt-2">
                                <i data-feather="x" class="w-4 h-4"></i>
                            </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                        @error('thumb')
                            <span style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    </div>
                    </div>
                </div>
                </div>
                </div>
                <div class="mt-3">
                <label>Giá bán</label>
                <div class="mt-2">
                <input type="int-number" id="tiente" class="form-control" name="price" value="{{ old('price') ?? $edit->price }}">
                </div>
                </div>
                <div class="mt-3">
                <label>Số lượng</label>
                <div class="mt-2">
                <input type="int-number" id="soluong" class="form-control" name="quantity"
                        value="{{ old('quantity') ?? $edit->quantity }}">
                </div>
                </div>
                <div class="mt-3">
                    <label>Nội dung</label>
                    <div class="mt-2">
                    <textarea name="content" id="tiny-editor" rows="7">{{ old('content') ?? $edit->content }}</textarea>
                    </div>
                </div>
                <div class="text-right mt-5">
                    @can('viewAny', App\Models\Products::class)
                        <a type="button" href="{{ route('products.index') }}"
                            class="btn btn-outline-secondary w-24 mr-1">Hủy</a>
                    @endcan
                    @can('update', App\Models\Products::class)
                        <button type="submit" class="btn btn-primary w-24">Lưu</button>
                    @endcan
                </div>
                @csrf
            </div>
        </form>
        <!-- END: Form Layout -->
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('/js/post-form.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.xoa_anh').click(function() {
            var img = $(this).data('img');
            var product_id = $(this).data('product_id');
            var _token = $('meta[name="csrf-token"]').attr('content');
            var data = {
                img: img,
                _token: _token,
                product_id: product_id
            };
            var t =  $(this).parent();
            $.ajax({
                url: "{{ route('products.deleteImg') }}",
                method: "POST",
                data: data,
                dataType: "json",
                success: function(data) {
                    t.remove();
                }

            });
        });
        //xu ly show tien te
        if(document.getElementById('tiente').value !=''){
        const dinhdangtiente_load0 = document.getElementById('tiente').value;
        document.getElementById('tiente').value = new Intl.NumberFormat('vi-VN').format(dinhdangtiente_load0);
        }

        //xu ly show so luong
        if(document.getElementById('soluong').value !=''){
        const dinhdangtiente_load0 = document.getElementById('soluong').value;
        document.getElementById('soluong').value = new Intl.NumberFormat('vi-VN').format(dinhdangtiente_load0);
        }
    });
</script>
@endsection
