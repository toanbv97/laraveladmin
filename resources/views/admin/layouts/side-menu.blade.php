<!-- BEGIN: Side Menu -->

<nav class="side-nav">
    <a href="{{ route('dashboard') }}" class="intro-x flex items-center pl-5 pt-4">
        <img alt="" class="w-6" src="/upload/images/common_img/logo.svg">
        <span class="hidden xl:block text-white text-lg ml-3">IT24h</span>
    </a>
    <div class="side-nav__devider my-6"></div>
    @php
        $module_active = session('module_active');
    @endphp
    <ul>
        <li>
            <a href="{{ route('dashboard') }}"
                class="side-menu {{ $module_active == 'dashboard' ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="home"></i> </div>
                <div class="side-menu__title">
                    Dashboard
                    <div class="side-menu__sub-icon transform rotate-180"></div>
                </div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="side-menu {{ $module_active == 'post' ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="file-text"></i> </div>
                <div class="side-menu__title">
                    Bài viết
                    <div class="side-menu__sub-icon "> <i
                            data-feather="{{ $module_active == 'post' ? 'chevron-up' : 'chevron-down' }}"
                            class="{{ $module_active == 'post' ? 'menu__sub-icon transform rotate-180' : '' }}"></i>
                    </div>
                </div>
            </a>
            <ul class="{{ $module_active == 'post' ? 'side-menu__sub-open' : '' }}">
                @can('view', App\Models\Post::class)
                    <li>
                        <a href="{{ route('post.index') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Danh sách bài viết </div>
                        </a>
                    </li>
                @endcan
                @can('create', App\Models\Post::class)
                    <li>
                        <a href="{{ route('post.create') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Thêm mới </div>
                        </a>
                    </li>
                @endcan
                @can('viewAnypost', App\Models\Category::class)
                    <li>
                        <a href="{{ route('categorypost.index') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Danh mục bài viết </div>
                        </a>
                    </li>
                @endcan
                @can('viewPost', App\Models\Vote::class)
                    <li>
                        <a href="{{ route('vote.indexPost') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Đánh giá</div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="side-menu {{ $module_active == 'slider' ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="layout"></i> </div>
                <div class="side-menu__title">
                    Slider
                    <div class="side-menu__sub-icon "> <i
                            data-feather="{{ $module_active == 'slider' ? 'chevron-up' : 'chevron-down' }}"
                            class="{{ $module_active == 'slider' ? 'menu__sub-icon transform rotate-180' : '' }}"></i>
                    </div>
                </div>
            </a>
            <ul class="{{ $module_active == 'slider' ? 'side-menu__sub-open' : '' }}">
                @can('view', App\Models\Slider::class)
                    <li>
                        <a href="{{ route('slider.index') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Danh sách Slider </div>
                        </a>
                    </li>
                @endcan
                @can('create', App\Models\Slider::class)
                    <li>
                        <a href="{{ route('slider.create') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Thêm mới </div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="side-menu {{ $module_active == 'user' ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                <div class="side-menu__title">
                    Nhân viên
                    <div class="side-menu__sub-icon "> <i
                            data-feather="{{ $module_active == 'user' ? 'chevron-up' : 'chevron-down' }}"
                            class="{{ $module_active == 'user' ? 'menu__sub-icon transform rotate-180' : '' }}"></i>
                    </div>
                </div>
            </a>
            <ul class="{{ $module_active == 'user' ? 'side-menu__sub-open' : '' }}">
                @can('view', App\Models\User::class)
                    <li>
                        <a href="{{ route('user.list') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Danh sách nhân viên </div>
                        </a>
                    </li>
                @endcan
                @can('create', App\Models\User::class)
                    <li>
                        <a href="{{ route('admin.create') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Thêm mới </div>
                        </a>
                    </li>
                @endcan
            </ul>

        </li>
        <li>
            <a href="javascript:;" class="side-menu {{ $module_active == 'role' ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="bookmark"></i> </div>
                <div class="side-menu__title">
                    Quyền quản trị
                    <div class="side-menu__sub-icon "> <i
                            data-feather="{{ $module_active == 'role' ? 'chevron-up' : 'chevron-down' }}"
                            class="{{ $module_active == 'role' ? 'menu__sub-icon transform rotate-180' : '' }}"></i>
                    </div>
                </div>
            </a>
            <ul class="{{ $module_active == 'role' ? 'side-menu__sub-open' : '' }}">
                @can('view', App\Models\Role::class)
                    <li>
                        <a href="{{ route('role.list') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Danh sách quyền </div>
                        </a>
                    </li>
                @endcan
                @can('create', App\Models\Role::class)
                    <li>
                        <a href="{{ route('role.create') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Thêm mới </div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
        @can('view', App\Models\Customer::class)
            <li>
                <a href="{{ route('customer.list') }}"
                    class="side-menu {{ $module_active == 'customer' ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                    <div class="side-menu__title">
                        Khách hàng
                        <div class="side-menu__sub-icon transform rotate-180"></div>
                    </div>
                </a>
            </li>
        @endcan
        @can('view', App\Models\Order::class)
            <li>
                <a href="{{ route('order.list') }}"
                    class="side-menu {{ $module_active == 'order' ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-feather="shopping-cart"></i> </div>
                    <div class="side-menu__title">
                        Đơn hàng
                        <div class="side-menu__sub-icon transform rotate-180"></div>
                    </div>
                </a>
            </li>
        @endcan
        <li>
            <a href="javascript:;" class="side-menu {{ $module_active == 'products' ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="clipboard"></i> </div>
                <div class="side-menu__title">
                    Sản phẩm
                    <div class="side-menu__sub-icon "> <i
                            data-feather="{{ $module_active == 'products' ? 'chevron-up' : 'chevron-down' }}"
                            class="{{ $module_active == 'products' ? 'menu__sub-icon transform rotate-180' : '' }}"></i>
                    </div>
                </div>
            </a>
            <ul class="{{ $module_active == 'products' ? 'side-menu__sub-open' : '' }}">
                @can('viewAny', App\Models\Products::class)
                    <li>
                        <a href="{{ route('products.index') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Danh sách sản phẩm</div>
                        </a>
                    </li>
                @endcan
                @can('create', App\Models\Products::class)
                    <li>
                        <a href="{{ route('products.create') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Thêm mới </div>
                        </a>
                    </li>
                @endcan
                @can('viewAny', App\Models\Category::class)
                    <li>
                        <a href="{{ route('category.index') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Danh mục sản phẩm</div>
                        </a>
                    @endcan
                    @can('viewProduct', App\Models\Vote::class)
                    <li>
                        <a href="{{ route('vote.indexProduct') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Đánh giá</div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    </ul>
</nav>
<!-- END: Side Menu -->
