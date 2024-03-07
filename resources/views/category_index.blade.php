<x-cook>
    <!-- ##### Best Receipe Area Start ##### -->
    <section class="best-receipe-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h3>Công Thức Mới Nhất</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                @php
                    $ctNauAn = $theLoai
                        ->ctNauAns()
                        ->get()
                        ->all();
                    $sizeOfCTNauAn = sizeOf($ctNauAn);
                    $sizeStandard = ($sizeOfCTNauAn < 6) ? $sizeOfCTNauAn : 6;

                    for ($i = 0; $i < $sizeStandard; $i++) {
                        $hinhAnhCongThuc = DB::table('hinh_anh_c_t_nau_an')
                            ->where('MaCT', '=', $ctNauAn[$i]->MaCT)->select('MaHinhAnh')
                            ->get()->map(function ($item) { return $item->MaHinhAnh; });
                        $hinhAnh = App\Models\HinhAnh::whereIn('MaHinhAnh', $hinhAnhCongThuc)->first()->Nguon ?? '';
                        $tenMonAn = $ctNauAn[$i]->TenMonAn ?? "";
                        echo "<div class=\"col-12 col-sm-6 col-lg-4\">";
                        echo "<div class=\"single-best-receipe-area mb-30\">";
                        echo "<img src=\"/" . $hinhAnh . "\" alt=\"\"/>";
                        echo "<div class=\"receipe-content\">";
                        echo "<a href=\"" . url('/cong-thuc/?maCT=' . $ctNauAn[$i]->MaCT) . "\">";
                        echo '<h5>' . $tenMonAn . '</h5>';
                        echo '</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                @endphp

            </div>

        </div>
    </section>
    <!-- ##### Best Receipe Area End ##### -->


    <!-- ##### Small Receipe Area Start ##### -->
    <section class="small-receipe-area section-padding-80-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h3>Các Công Thức Khác</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                @php
                    $ctNauAn = $theLoai
                        ->ctNauAns()
                        ->get()
                        ->all();
                    $sizeOfCTNauAn = sizeOf($ctNauAn);
                    
                    for ($i = 5; $i < $sizeOfCTNauAn; $i++) {
                        $hinhAnhCongThuc = DB::table('hinh_anh_c_t_nau_an')
                            ->where('MaCT', '=', $ctNauAn[$i]->MaCT)->select('MaHinhAnh')
                            ->get()->map(function ($item) { return $item->MaHinhAnh; });
                        $hinhAnh = App\Models\HinhAnh::whereIn('MaHinhAnh', $hinhAnhCongThuc)->first()->Nguon ?? '';
                        $created_at = $ctNauAn[$i]->created_at ?? "";
                        $tenMonAn = $ctNauAn[$i]->TenMonAn ?? "";
                        echo "<div class=\"col-12 col-sm-6 col-lg-4\">";
                        echo "<div class=\"single-small-receipe-area d-flex\">";
                        echo "<div class=\"receipe-thumb\">";
                        echo "<img src=\"/" . $hinhAnh . "\" alt=\"\"/>";
                        echo '</div>';
                        echo "<div class=\"receipe-content\">";
                        echo '<span>' . explode(' ', $created_at)[0] . '</span>';
                        echo "<a href=\"#\"><h5>" . $tenMonAn . '</h5></a>';
                        echo '<p>2 Comments</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                @endphp

                {{-- <!-- Small Receipe Area -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-small-receipe-area d-flex">
                        <!-- Receipe Thumb -->
                        <div class="receipe-thumb">
                            <img src="img/bg-img/sr1.jpg" alt="">
                        </div>
                        <!-- Receipe Content -->
                        <div class="receipe-content">
                            <span>January 04, 2018</span>
                            <a href="receipe-post.html">
                                <h5>Homemade italian pasta</h5>
                            </a>
                            <div class="ratings">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </div>
                            <p>2 Comments</p>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
    <!-- ##### Small Receipe Area End ##### -->
</x-cook>
