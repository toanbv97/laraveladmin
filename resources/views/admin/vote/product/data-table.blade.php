<!-- BEGIN: Data List -->
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible" id="data">
    <table class="table table-report -mt-2" id="myTable">
        <thead>
        <tr>
            <th class="whitespace-nowrap">Sản Phẩm</th>
            <th class="text-center whitespace-nowrap">Đánh giá</th>
            <th class="text-center whitespace-nowrap">Ngày tạo</th>
            <th class="text-center whitespace-nowrap">Người tạo</th>
            <th class="text-center whitespace-nowrap">Chức năng</th>
        </tr>
        </thead>
        <tbody>
        @foreach($votes as $vote)
            <tr class="intro-x" id="{{$vote->id}}">
                <td class="w-52">
                    <div class=""><a href="javascript:;" data-toggle="modal"
                                    data-target="#header-footer-modal-preview-{{ $vote->id }}">
                            {{$vote->product_name}}</a>
                    </div>
                </td>
                <td class="w-10">
                    <div class="text-center whitespace-nowrap">{{$vote->level}}</div>
                </td>
                <td class="w-10">
                    <div class="text-center">{{date('d/m/Y',strtotime($vote->created_at))}}</div>
                </td>
                <td class="w-10">
                    <div class="text-center">{{is_null($vote->name_user) ? '' : $vote->name_user}}</div>
                </td>

                <td class="table-report__action w-10">
                    <div class="flex justify-center items-center">
                        @can('updateProduct',\App\Models\Vote::class)
                            <a href="{{route('vote.editProduct',['id'=>$vote->id])}}" title="Chỉnh sửa"
                               class="btn btn-sm btn-primary mr-2">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        @endcan
                        @can('deleteProduct',\App\Models\Vote::class)
                            <a href="javascript:;" title="Xóa" data-toggle="modal"
                               data-value="{{$vote->id}}"
                               data-target="#delete-confirmation-modal"
                               class="btn btn-danger py-1 px-2 btn-delete"><i class="fa-solid fa-trash-can"
                                                                              style="padding: 1px"></i>
                            </a>
                        @endcan
                    </div>
                </td>
            </tr>
            <!-- BEGIN: Modal Content -->
            <div id="header-footer-modal-preview-{{ $vote->id }}"
                 class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- BEGIN: Modal Header -->
                        <div class="modal-header">
                            <h2 class="font-medium text-base mr-auto uppercase">Chi tiết đánh giá</h2>
                            @can('updateProduct',\App\Models\Vote::class)
                                <div class="sm:w-auto flex mt-4 sm:mt-0">
                                    <a href="{{route('vote.editProduct',['id'=>$vote->id])}}" class="btn btn-primary shadow-md mr-2">Sửa</a>
                                </div>
                            @endcan
                        </div> <!-- END: Modal Header -->
                        <!-- BEGIN: Modal Body -->
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12">
                                <div>
                                    <div class="truncate sm:whitespace-normal items-center mt-3">
                                        <strong class="mr-2">Sản phẩm:</strong>
                                        {{$vote->product_name}}
                                    </div>
                                    <div class="truncate sm:whitespace-normal items-center mt-3">
                                        <strong class="mr-2">Người đánh giá:</strong>
                                        {{ $vote->name_user }}
                                    </div>
                                    <div class="truncate sm:whitespace-normal flex items-center mt-3">
                                        <strong class="mr-2">Ngày tạo:</strong>
                                        {{date('d/m/Y',strtotime($vote->created_at))}}                                    </div>
                                    <div class="truncate sm:whitespace-normal flex items-center mt-3">
                                        <strong class="mr-2">Đánh giá:</strong>
                                        {{ $vote->level }}
                                    </div>
                                    <div class="truncate sm:whitespace-normal items-center mt-3">
                                        <strong class="mr-2">Bình luận:</strong>
                                        {{ $vote->comment }}
                                    </div>
                                </div>
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

<!-- BEGIN: Pagination -->
<div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center" id="pagi">
    {!! $votes->appends(['search' =>request()->search,'limit'=>request()->limit])->links('admin.layouts.pagination') !!}
    <form action="{{route('vote.indexProduct')}}" id="form-limit">
        <select id="limit" name="limit" class="w-20 form-select box mt-3 sm:mt-0">
            <option value="10" {{request()->limit =='10' ? 'selected' : ''}}>10</option>
            <option value="25" {{request()->limit =='25' ? 'selected' : ''}}>25</option>
            <option value="35" {{request()->limit =='35' ? 'selected' : ''}}>35</option>
            <option value="50" {{request()->limit =='50' ? 'selected' : ''}}>50</option>
        </select>
    </form>

</div>
<!-- END: Pagination -->
