<!-- BEGIN: Modal Content -->
<div id="header-footer-modal-preview-{{ $user->id }}"
    class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto uppercase">Thông tin
                    nhân viên
                </h2>

            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-3"></div>
                <div class="col-span-6">
                    <img style="object-fit: cover; width: 200px; height: 200px;"
                        class="rounded-full" src="@php
                            if (!empty($user->avatar)) {
                                echo '/upload/images/user/' . $user->avatar;
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
                            {{ $user->name }}
                        </div>
                        <div
                            class="truncate sm:whitespace-normal items-center mt-3">
                            <i class="fa-solid fa-envelope mr-2"></i>
                            <strong class="mr-2">Email:</strong>
                            {{ $user->email }}
                        </div>
                        <div
                            class="truncate sm:whitespace-normal flex items-center mt-3">
                            <i class="fa-solid fa-phone mr-2"></i></i><strong
                                class="mr-2">Số điện thoại:</strong>
                            {{ $user->phone_number }}
                        </div>
                        <div
                            class="truncate sm:whitespace-normal flex items-center mt-3">
                            <i class="fa-solid fa-house mr-2"></i></i><strong
                                class="mr-2">Địa chỉ:</strong>
                            {{ $user->address }}
                        </div>
                        <div
                            class="truncate sm:whitespace-normal flex items-center mt-3">
                            <i class="fa-solid fa-cake-candles mr-2"></i><strong
                                class="mr-2">Ngày sinh:</strong>
                            {{ date('d/m/Y', strtotime($user->birthday)) }}
                        </div>
                        <div
                            class="truncate sm:whitespace-normal flex items-center mt-3">
                            <i
                                class="fa-solid fa-venus-mars mr-2"></i></i><strong
                                class="mr-2">Giới tính:</strong>
                            {{ $user->gender }}
                        </div>
                    </div>
                </div>

            </div> <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer text-right">
                <button type="button" data-dismiss="modal"
                    class="btn btn-sm btn-primary w-20 mr-1">Hủy</button>
                @if ($user->is_admin == 1)
                    @if (Auth::user()->is_admin == 1)
                        @can('update', App\Models\User::class)
                            @if (request()->status != 'trash')
                                <a href="{{ route('admin.edit', $user->id) }}"
                                    type="button"
                                    class="btn btn-sm btn-primary mr-1">Chỉnh
                                    sửa</a>
                            @endif
                        @endcan
                    @endif
                @else
                    @can('update', App\Models\User::class)
                        @if (request()->status != 'trash')
                            <a href="{{ route('admin.edit', $user->id) }}"
                                type="button"
                                class="btn btn-sm btn-primary mr-1">Chỉnh
                                sửa</a>
                        @endif
                    @endcan
                @endif
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div> <!-- END: Modal Content -->
