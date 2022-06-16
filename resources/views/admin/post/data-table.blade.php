<!-- BEGIN: Data List -->
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible" id="data">
    <table class="table table-report -mt-2">
        <thead>
        <tr>
            <th class="text-center whitespace-nowrap">Ảnh đại diện</th>
            <th class="whitespace-nowrap">Tiêu đề</th>
            <th class="text-center whitespace-nowrap">Ngày đăng</th>
            <th class="text-center whitespace-nowrap">Tác giả</th>
            <th class="text-center whitespace-nowrap">Trạng thái</th>
            <th class="text-center whitespace-nowrap">Chức năng</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr class="intro-x" id="{{$post->id}}">
                <td class="w-40">
                    @if($post->thumb == \App\Models\Post::IMAGE)
                        <img src="{{asset('/upload/images/common_img/').'/'.$post->thumb}}">
                    @else
                        <img src="{{asset('/upload/images/post/thumb').'/'.$post->thumb}}">
                    @endif
                </td>
                <td>
                    <div class="font-medium ">
                        <a href="javascript:;" data-toggle="modal"
                           data-target="#header-footer-modal-preview-{{ $post->id }}">
                            {{$post->title}}
                        </a>
                    </div>
                </td>
                <td class="w-10">
                    <div class="text-center">{{\App\Helpers\CommonHelper::convertDateToDMY($post->created_at)}}</div>
                </td>
                <td class="w-10">
                    <div class="text-center">{{$post->user_name}}</div>
                </td>
                <td class="w-10">
                    @if($post->status == \App\Models\Post::ACTIVE)
                        <div class="text-theme-9 text-center"> <i class="fa-regular fa-circle-check"></i></div>
                    @else
                        <div class="text-theme-6 text-center"> <i class="fa-solid fa-ban"></i></div>
                    @endif
                </td>

                <td class="table-report__action w-40">
                    <div class="flex justify-center items-center">
                        @can('update',\App\Models\Post::class)
                            <a href="{{route('post.edit',['id'=>$post->id])}}" title="Chỉnh sửa"
                               class="btn btn-sm btn-primary mr-2">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        @endcan
                        @can('delete',\App\Models\Post::class)
                            <a href="javascript:;" title="Xóa" data-toggle="modal"
                               data-value="{{$post->id}}"
                               data-target="#delete-confirmation-modal"
                               class="btn btn-danger py-1 px-2 btn-delete"><i class="fa-solid fa-trash-can"
                                                                              style="padding: 1px"></i>
                            </a>
                        @endcan
                    </div>
                </td>
            </tr>
            <!-- BEGIN: Modal Content -->
            <div id="header-footer-modal-preview-{{ $post->id }}"
                 class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <!-- BEGIN: Modal Header -->
                        <div class="modal-header">
                            <h2 class="font-medium text-base mr-auto uppercase">Chi tiết bài viết</h2>
                            @can('update',\App\Models\Post::class)
                                <div class="sm:w-auto flex mt-4 sm:mt-0">
                                    <a href="{{route('post.edit',['id'=>$post->id])}}" class="btn btn-primary shadow-md mr-2">Sửa</a>
                                </div>
                            @endcan
                        </div> <!-- END: Modal Header -->
                        <!-- BEGIN: Modal Body -->
                        <div class="modal-body">
                            <div class="intro-y news p-5 box">
                                <!-- BEGIN: Blog Layout -->
                                <h2 class="intro-y font-medium text-xl sm:text-2xl">
                                    {{$post->title}}
                                </h2>
                                <div class="intro-y text-gray-700 dark:text-gray-600 mt-3 text-xs sm:text-sm"> {{\App\Helpers\CommonHelper::convertDateToDMY($post->created_at)}} </div>
                                <div class="intro-y mt-6">
                                    <div class="news__preview image-fit">
                                        @if($post->thumb != \App\Models\Post::IMAGE)
                                            <img alt="{{$post->title}}" class="rounded-md" src="/upload/images/post/{{$post->thumb}}">
                                        @else
                                            <img alt="{{$post->title}}" class="rounded-md" src="/upload/images/common_img/{{$post->thumb}}">
                                        @endif
                                    </div>
                                </div>
                                <div class="intro-y text-justify pt-16 sm:pt-6 pb-6 leading-relaxed">
                                    <p><strong>{{$post->excerpt}}</strong></p>
                                </div>
                                <div class="intro-y text-justify leading-relaxed">
                                    {!! $post->content !!}
                                </div>
                                <div class="intro-y flex text-xs sm:text-sm flex-col sm:flex-row items-center mt-5 pt-5 border-t border-gray-200 dark:border-dark-5">
                                    <div class="flex items-center">
                                        <div class="ml-3 mr-auto">
                                            <div class="text-gray-600"><strong class="mr-2">Tác giả:</strong> {{$post->user_name}}</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Blog Layout -->
                            </div>

                        </div> <!-- END: Modal Body -->
                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer text-right">
                            <button type="button" data-dismiss="modal"
                                    class="btn btn-sm btn-primary w-20 mr-1">Đóng</button>
                        </div>
                        <!-- END: Modal Footer -->
                    </div>
                </div>
            </div> <!-- END: Modal Content -->
        @endforeach
        </tbody>
    </table>
</div>
<!-- END: Data List -->
<!-- BEGIN: Pagination -->
<div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center" id="pagi">
    {!! $posts->appends(['search' =>request()->search,'limit'=>request()->limit])->links('admin.layouts.pagination') !!}
    <form action="{{route('post.index')}}" id="form-limit">
        <select id="limit" name="limit" class="w-20 form-select box mt-3 sm:mt-0">
            <option value="10" {{request()->limit =='10' ? 'selected' : ''}}>10</option>
            <option value="25" {{request()->limit =='25' ? 'selected' : ''}}>25</option>
            <option value="35" {{request()->limit =='35' ? 'selected' : ''}}>35</option>
            <option value="50" {{request()->limit =='50' ? 'selected' : ''}}>50</option>
        </select>
    </form>
</div>
<!-- END: Pagination -->
