<x-cook>
    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb-area bg-img bg-overlay" style="background-image: url(/img/bg-img/breadcumb3.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-text text-center">
                        <h2>Công Thức Món Ăn</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <div class="receipe-post-area section-padding-80">

        <!-- Receipe Post Search -->
        {{-- <div class="receipe-post-search mb-80">
            <div class="container">
                <form action="#" method="post">
                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <select name="select1" id="select1">
                                @php
                                    $theLoais = App\Models\TheLoai::all();
                                    foreach ($theLoais as $key => $theLoai) {
                                        echo "<option value=\"" . $key . "\">" . $theLoai->TenTheLoai . '</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                        <div class="col-12 col-lg-3">
                            <input type="search" name="search" placeholder="Tìm kiếm Công Thức">
                        </div>
                        <div class="col-12 col-lg-3 text-right">
                            <button class="btn delicious-btn">Tìm Kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> --}}

        <!-- Receipe Slider -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="receipe-slider owl-carousel">
                        @php
                            $hinhAnhCongThuc = DB::table('hinh_anh_c_t_nau_an')
                                ->where('MaCT', '=', $ctNauAn->MaCT)
                                ->select('MaHinhAnh')
                                ->get()
                                ->map(function ($item) {
                                    return $item->MaHinhAnh;
                                });
                            $hinhAnhs = App\Models\HinhAnh::whereIn('MaHinhAnh', $hinhAnhCongThuc)->get();
                            foreach ($hinhAnhs as $hinhAnh) {
                                echo "<img src=\"/" . $hinhAnh->Nguon . "\" alt=\"\"/>";
                            }
                        @endphp
                    </div>
                </div>
            </div>
        </div>

        <!-- Receipe Content Area -->
        <div class="receipe-content-area">
            <div class="container">

                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="receipe-headline my-5">
                            <span>{{ explode(' ', $ctNauAn->created_at)[0] }}</span>
                            <h2>{{ $ctNauAn->TenMonAn }}</h2>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-12 col-lg-8">
                        @php
                            $quyTrinhs = $ctNauAn->quyTrinhs()->get();
                            foreach ($quyTrinhs as $quyTrinh) {
                                echo "<div class=\"single-preparation-step d-flex\">";
                                echo "<h4>$quyTrinh->ThoiGian</h4>";
                                echo "<p>$quyTrinh->NoiDungBuoc</p>";
                                echo '</div>';
                            }
                        @endphp
                    </div>

                    <!-- Ingredients -->
                    <div class="col-12 col-lg-4">
                        <div class="ingredients">
                            <h4>Nguyên Liệu</h4>
                            @php
                                $nguyenLieus = $ctNauAn->nguyenLieus()->get();
                                foreach ($nguyenLieus as $key => $nguyenLieu) {
                                    echo "<div class=\"custom-control custom-checkbox\">";
                                    echo "<input type=\"checkbox\" class=\"custom-control-input\" id=\"customerCheck" . $key . "\"/>";
                                    echo "<label class=\"custom-control-label\" for=\"customerCheck" . $key . "\">";
                                    echo $nguyenLieu->TenNguyenLieu . ' ';
                                    echo $nguyenLieu->SoLuong . ' ';
                                    echo $nguyenLieu->DonVi;
                                    echo '</label>';
                                    echo '</div>';
                                }
                            @endphp
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="receipe-headline my-5">
                            <h2>Mô Tả Chi Tiết</h2>
                            <p>{{ $ctNauAn->MoTaChiTiet }}</p>
                        </div>
                    </div>

                </div>


                {{-- comments --}}
                <div class="row d-flex justify-content-center mb-50 mt-10">
                    <div class="col-12" id="comments">
                        {{-- sub-comments --}}
                        <div class="d-flex flex-start mb-4 flex-md-row flex-column">
                            <img class="rounded-circle shadow-1-strong me-3"
                                src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(32).webp" alt="avatar"
                                style="width: 10rem; height: 10rem" />
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <div class="">
                                        <div class="d-flex justify-content-between ">
                                            <h5>Johny Cash</h5>
                                            <div class="d-flex">
                                                <button class="btn btn-primary btn-sm mr-2">Thay Đổi</button>
                                                <button class="btn btn-danger btn-sm">Xóa</button>
                                            </div>
                                        </div>
                                        <p class="small">3 hours ago</p>
                                        <p>
                                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque
                                            ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus
                                            viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla.
                                            Donec lacinia congue felis in faucibus ras purus odio, vestibulum in
                                            vulputate at, tempus viverra turpis.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-start mb-4 flex-md-row flex-column">
                            <img class="rounded-circle shadow-1-strong me-3"
                                src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(31).webp" alt="avatar"
                                style="width: 10rem; height: 10rem" />
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <div class="">
                                        <h5>Mindy Campbell</h5>
                                        <p class="small">5 hours ago</p>
                                        <p>
                                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Delectus
                                            cumque doloribus dolorum dolor repellat nemo animi at iure autem fuga
                                            cupiditate architecto ut quam provident neque, inventore nisi eos quas?
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end-sub-comments --}}
                    </div>
                </div>
                {{-- end-comments --}}
                
                <div class="row">
                    <div class="col-12">
                        <div class="section-heading text-left mb-4">
                            <h3>Bình Luận</h3>
                        </div>
                    </div>
                </div>
                
                @auth
                <div class="row">
                    <div class="col-12">
                        <div class="contact-form-area">
                            <div class="row">
                                <div class="col-12">
                                    <textarea name="message" class="form-control" id="message" cols="30" rows="10" placeholder="Tin nhắn"></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex">
                                        <button class="btn delicious-btn mt-30" id="submit-post">Post Comments</button>
                                        <div class="invisible ml-2 mt-30" id="status">Thành Công!</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
</x-cook>
