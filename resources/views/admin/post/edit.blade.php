@extends('admin.layouts.main')
@section('css')
    <script src="{{ asset('lib/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
@endsection
@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{$title}}
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            @can('view',\App\Models\Post::class)
                <a class="btn btn-primary shadow-md mr-2" href="{{route('post.index')}}">Danh sách bài viết</a>
            @endcan
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <!-- BEGIN: Form Layout -->
            <form action="{{route('post.update',['id'=>$post->id])}}" method="post" enctype="multipart/form-data" id="form-post">
                <div class="intro-y box p-5">
                    <div>
                        <label for="crud-form-1" class="form-label">Tiêu đề(<span class="text-red-600">*</span>)</label>
                        <input id="crud-form-1" type="text" name="title" value="{{old('title') ?? $post->title}}" class="form-control w-full" placeholder="Nhập tiêu đề">
                        @error('title')
                        <span style="color:red">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="crud-form-2" class="form-label">Danh mục</label>
                        <select name="categories[]" data-placeholder="Chọn danh mục" class="tom-select w-full" id="crud-form-2" multiple>
                            @foreach($arrCate as $index => $item)
                                <option value="{{$index}}"
                                    {{ (collect(old('categories'))->contains($index) || in_array($index,$arrCateRela)) ? 'selected': false }}
                                >{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-3">
                        <label>Trạng thái</label>
                        <div class="mt-2">
                            <input type="checkbox" name="status" {{(old('status') == 'on' || $post->status == \App\Models\Post::ACTIVE) ? 'checked' : false}} class="form-check-switch">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label>Ảnh đại diện</label>
                        <div class="mt-2">
                            <div class="w-40 show-image">
                                <div class="w-24 h-24 relative image-fit mb-5 mr-5 cursor-pointer zoom-in">
                                    @if($post->thumb == \App\Models\Post::IMAGE)
                                        <img src="{{asset('/upload/images/common_img').'/'.$post->thumb}}">
                                    @else
                                        <img class="rounded-md" src="{{asset('/upload/images/post').'/'.$post->thumb}}">
                                        <div title="Xoá ảnh?" data-value="{{$post->id}}" class="btn-delete-img tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-theme-6 right-0 top-0 -mr-2 -mt-2"> <i data-feather="x" class="w-4 h-4"></i> </div>
                                    @endif
                                </div>
                            </div>
                            <input name="thumb" type="file" class="mt-2" id="file-image"/>
                            @error('thumb')
                                <span style="color:red">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-3">
                        <label>Mô tả</label>
                        <div class="mt-2">
                            <textarea class="form-control" rows="3" name="excerpt" placeholder="Nhập mô tả ngắn">{{old('excerpt') ?? $post->excerpt}}</textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label>Nội dung</label>
                        <div class="mt-2">
                            <textarea name="content" id="tiny-editor" rows="7">{{old('content') ?? $post->content}}</textarea>
                        </div>
                    </div>
                    <div class="text-right mt-5">
                        @can('view',\App\Models\Post::class)
                            <a type="button" href="{{route('post.index')}}" class="btn btn-outline-secondary w-24 mr-1">Hủy</a>
                        @endcan
                        <button type="submit" class="btn btn-primary w-24">Lưu</button>
                    </div>
                    @csrf
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $(document).on("click", ".btn-delete-img", function(e) {
                e.preventDefault();
                var id = $(this).attr('data-value');
                var _token = $('meta[name="csrf-token"]').attr('content');
                var data = {
                    id: id,
                    _token: _token
                };
                $.ajax({
                    url:"{{route('post.deleteImg')}}",
                    type:"post",
                    dataType:"json",
                    data: data,
                    beforeSend: function(){
                    },
                    success: function (result) {
                        var show_image = $(".show-image");
                        show_image.empty();
                    },
                    error: function (r) {
                    }
                })
            })
        })
    </script>
    <script src="{{ asset('/js/post-form.js') }}"></script>
@endsection
