<!-- ##### Header Area Start ##### -->
<!-- Preloader -->
<div id="preloader">
    <i class="circle-preloader"></i>
    <img src="<?php echo url('img/core-img/salad.png'); ?>" alt="">
</div>

<!-- Search Wrapper -->
<div class="search-wrapper">
    <!-- Close Btn -->
    <div class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="/search">
                    <input id="search-input" name="TenMonAn" type="search" placeholder="Nhập Tên Công Thức">
                    <button type="submit" id="search"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<header class="header-area">

    <!-- Top Header Area -->
    <div class="top-header-area">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-between">
                <!-- Breaking News -->
                <div class="col-12 col-sm-6 ">
                    <div class="breaking-news ">
                        <div id="breakingNewsTicker" class="ticker">
                            <ul>
                                @auth
                                    <li><a href="#">Chào {{ Auth::user()->name }}</a></li>
                                @endauth
                                @unless (Auth::check())
                                    <li><a href="#">Chào Mọi Người</a></li>
                                @endunless
                                <li><a href="#">Chào Mừng Đến Với Dilicious</a></li>
                            </ul>
                        </div>
                    </div>


                </div>


                <!-- Profile User -->
                <div class="col-12 col-sm-6">
                    <div class=" text-left">
                        @auth
                            <div class="dropdown">
                                <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <div class="dropdown-item" href="route('profile.edit')">
                                        <x-dropdown-link :href="route('profile.edit')">
                                            {{ __('Hồ Sơ') }}
                                        </x-dropdown-link>
                                    </div>

                                    <div class="dropdown-item">
                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                {{ __('Đăng Xuất') }}
                                            </x-dropdown-link>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endauth
                        @unless (Auth::check())
                            <div class="d-flex">
                                <a class="mr-3" href="/login">Đăng nhập</a>
                                <a href="/register">Đăng ký</a>
                            </div>
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar Area -->
    <div class="delicious-main-menu">
        <div class="classy-nav-container breakpoint-off">
            <div class="container">
                <!-- Menu -->
                <nav class="classy-navbar justify-content-between" id="deliciousNav">

                    <!-- Logo -->
                    <a class="nav-brand" href="/"><img src="<?php echo url('img/core-img/logo.png'); ?>" alt=""></a>

                    <!-- Navbar Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <!-- Menu -->
                    <div class="classy-menu">

                        <!-- close btn -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <!-- Nav Start -->
                        <div class="classynav">
                            <ul>
                                <li class="active"><a href="/">Trang Chủ</a></li>
                                <li><a href="#">Các Trang Khác</a>
                                    <ul class="dropdown">
                                        <li><a href="/">Trang Chủ</a></li>
                                        <li><a href="/about">Về Chúng Tôi</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Các Thể Loại</a>
                                    <div class="megamenu">
                                        @php
                                            $theLoais = App\Models\TheLoai::all();
                                            $chunk = 0;
                                            
                                            foreach ($theLoais as $theLoai) {
                                                $tenTL = urlencode($theLoai->TenTheLoai);
                                                if ($chunk == 0) {
                                                    echo "<ul class=\"single-mega cn-col-4\">";
                                                }
                                                if ($chunk == 3) {
                                                    echo "<li><a href=\"" . url("/the-loai/?tenTheLoai=") . $tenTL ."\">" . $theLoai->TenTheLoai . '</a></li></ul>';
                                                } else {
                                                    echo "<li><a href=\"" . url("/the-loai/?tenTheLoai=") . $tenTL . "\">" . $theLoai->TenTheLoai . '</a></li>';
                                                }
                                                $chunk = ($chunk + 1) % 4;
                                            }
                                        @endphp
                                    </div>
                                </li>
                                @auth
                                    <li><a href="#">Đăng Tải</a>
                                        <ul class="dropdown">
                                            <li><a href="/dang-tai-cong-thuc">Công Thức Món Ăn</a></li>
                                            @if (Auth::user()->TenVaiTro == 'Admin')
                                                <li><a href="/dang-tai-the-loai">Thể Loại</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                    @if (Auth::user()->TenVaiTro == 'Admin')
                                        <li><a href="/dashboard">Admin</a>
                                        </li>
                                    @endif
                                @endauth
                            </ul>

                            <!-- Newsletter Form -->
                            <div class="search-btn">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </div>

                        </div>
                        <!-- Nav End -->
                    </div>
                </nav>
            </div>
        </div>
    </div>

</header>
<!-- ##### Header Area End ##### -->
