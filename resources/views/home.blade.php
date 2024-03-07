<x-cook>
    <!-- ##### Top Catagory Area Start ##### -->
    <section class="top-catagory-area section-padding-80-0">
        <div class="container">
            <div id="container-top-category" class="row">
                <!-- Top Catagory Area -->
                <div class="col-12 col-lg-6">
                    <div class="single-top-catagory">
                        <img style="width: auto; height 28rem;" src="images/QOW5kbUghaEqSip6vqJ8IoAauSy2w4vNzbhzWzGD.png"
                            alt="">
                        <!-- Content -->
                        <div class="top-cta-content">
                            <h3>Strawberry Cake</h3>
                            <h6>Simple &amp; Delicios</h6>
                            <a href="receipe-post.html" class="btn delicious-btn">See Full Receipe</a>
                        </div>
                    </div>
                </div>
                <!-- End Top Catagory Area -->
            </div>
        </div>
    </section>
    <!-- ##### Top Catagory Area End ##### -->

    <!-- ##### Best Receipe Area Start ##### -->
    <section class="best-receipe-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h3>Công Thức Tốt Nhất</h3>
                    </div>
                </div>
            </div>

            <div id="container-best-category" class="row">
                <!-- Single Best Receipe Area -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-best-receipe-area mb-30">
                        <img src="img/bg-img/r1.jpg" alt="">
                        <div class="receipe-content">
                            <a href="receipe-post.html">
                                <h5>Sushi Easy Receipy</h5>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Single Best Receipe Area -->
            </div>
        </div>
    </section>
    <!-- ##### Best Receipe Area End ##### -->


    <!-- ##### CTA Area Start ##### -->
    <section class="cta-area bg-img bg-overlay" style="background-image: url(img/bg-img/bg4.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <!-- Cta Content -->
                    <div class="cta-content text-center">
                        <h2>{{ $noCalories->TenTheLoai ?? '' }}</h2>
                        <p>{{ $noCalories->MoTa ?? '' }}</p>
                        <a href="{{ url('/the-loai/?tenTheLoai=' . (str_replace(" ", "+", $noCalories->TenTheLoai) ?? '')) }}"
                            class="btn delicious-btn">Nhấp Để Khám Phá</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### CTA Area End ##### -->

    <!-- ##### Small Receipe Area Start ##### -->
    <section class="small-receipe-area section-padding-80-0">
        <div class="container">
            <div class="row">
                @php
                    $ctNauAn = App\Models\CTNauAn::all()->all();
                    $sizeOfCTNauAn = sizeOf($ctNauAn);
                    $sizeStandard = $sizeOfCTNauAn < 12 ? $sizeOfCTNauAn : 12;
                    
                    for ($i = 0; $i < $sizeStandard; $i++) {
                        $hinhAnhCongThuc = DB::table('hinh_anh_c_t_nau_an')
                            ->where('MaCT', '=', $ctNauAn[$i]->MaCT)->select('MaHinhAnh')
                            ->get()->map(function ($item) { return $item->MaHinhAnh; });
                        $hinhAnh = App\Models\HinhAnh::whereIn('MaHinhAnh', $hinhAnhCongThuc)->first()->Nguon ?? '';
                        echo "<div class=\"col-12 col-sm-6 col-lg-4\">";
                        echo "<div class=\"single-small-receipe-area d-flex\">";
                        echo "<div class=\"receipe-thumb\">";
                        echo "<img src=\"" . $hinhAnh . "\" alt=\"\"/>";
                        echo '</div>';
                        echo "<div class=\"receipe-content\">";
                        echo '<span>' . explode(' ', $ctNauAn[$i]->created_at)[0] . '</span>';
                        echo "<a href=\"" . url('/cong-thuc/?maCT=' . $ctNauAn[$i]->MaCT) . "\"><h5>" . $ctNauAn[$i]->TenMonAn . '</h5></a>';
                        echo '<p>' . $ctNauAn[$i]->danhGias()->count() . ' Comments</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                @endphp
            </div>
        </div>
    </section>
    <!-- ##### Small Receipe Area End ##### -->

</x-cook>
