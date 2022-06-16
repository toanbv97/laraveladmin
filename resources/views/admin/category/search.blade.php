<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
    <table class="table table-report -mt-2">
                            <thead>
                                <tr >
                                    <th class="whitespace-nowrap text-center">STT</th>
                                    <th class="whitespace-nowrap">TÊN DANH MỤC</th>
                                    <th class="text-center whitespace-nowrap ">SLUG</th>
                                    <th class="text-center whitespace-nowrap ">DANH MỤC CHA</th>
                                    <th class="text-center whitespace-nowrap ">CHUYÊN ĐỀ</th>
                                    <th class="text-center whitespace-nowrap w-30">NGƯỜI DÙNG</th>
                                    <th style="display:none;"></th>
                                    <th class="text-center whitespace-nowrap w-30">TRẠNG THÁI</th>
                                    <th class="text-center whitespace-nowrap ">CHỨC NĂNG</th>
                                </tr>
                            </thead>
                            <tbody class="col-span-12 " id="table1" >
                                @foreach($Category as $key => $list)
                                <tr class=" overflow-x-auto scrollbar-hidden" id="{{ $list->id }}">
                                    <td class="text-center font-medium ">{{$list->id}}</td>
                                    <td class="">{{$list->name}} </td>
                                    <td class="overflow-hidden ">{{$list->slug}}</td>
                                    <td class="text-center font-medium ">{{$list->parent_id}}</td>
                                    <td class="text-center font-medium ">{{$list->taxonomy}}</td>
                                    <td class="w-30 text-center">{{$list->user_id}}</td>
                                    <td style="display:none;">{{$status = $list->status}}</td>
                                    <td>
                                        @if($status == '1')
                                        <div class="flex items-center justify-center text-theme-9 mr-3" data-bs-toggle="tooltip" title="Kích hoạt"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i></div>
                                        @else
                                        <div class="flex items-center justify-center text-theme-6 mr-3"data-bs-toggle="tooltip" title="Vô hiệu hóa"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i></div>
                                        @endif
                                    </td>
                                    <td class="w-20">
                                        <div class="flex justify-center items-center">
                                            @can('update',App\Models\Category::class)
                                            <a class="btn btn-sm btn-primary mr-2"
                                            href="{{route('category.edit',['id'=>$list->id])}}" data-bs-toggle="tooltip" title="Sửa" > <i class="fa-solid fa-pen-to-square"></i>
                                            {{-- <i data-feather="check-square" class="w-4 h-4 mr-1"></i></a> --}}
                                            @endcan
                                            @can('delete',App\Models\Category::class)
                                             <a title="Xóa" data-toggle="modal"
                                           data-value="{{$list->id}}"
                                           data-target="#delete-confirmation-modal"
                                           class="btn btn-danger py-1 px-2 btn-delete"><i class="fa-solid fa-trash-can"style="padding: 1px"></i>
                                        </a>
                                            @endcan

                                        </div>
                                    </td>
                                   
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                    @include('admin.category.delete')
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center"  >
                        
                        <ul class="pagination" >

                            <li> {{ $Category->withQueryString()->onEachSide(1)->links('admin.layouts.pagination') }}</li>
                        </ul>
                    </div>