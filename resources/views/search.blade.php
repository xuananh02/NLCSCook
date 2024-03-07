<x-cook>
    <section class="small-receipe-area section-padding-80-0">
        <div class="container">
            <div class="row">
                @php
                    $sizeOfctNauAns = sizeOf($ctNauAns);
                    $sizeStandard = $sizeOfctNauAns < 12 ? $sizeOfctNauAns : 12;
                    
                    for ($i = 0; $i < $sizeStandard; $i++) {
                        $hinhAnhCongThuc = DB::table('hinh_anh_c_t_nau_an')
                            ->where('MaCT', '=', $ctNauAns[$i]->MaCT)->select('MaHinhAnh')
                            ->get()->map(function ($item) { return $item->MaHinhAnh; });
                        $hinhAnh = App\Models\HinhAnh::whereIn('MaHinhAnh', $hinhAnhCongThuc)->first()->Nguon ?? '';
                        echo "<div class=\"col-12 col-sm-6 col-lg-4\">";
                        echo "<div class=\"single-small-receipe-area d-flex\">";
                        echo "<div class=\"receipe-thumb\">";
                        echo "<img src=\"" . $hinhAnh . "\" alt=\"\"/>";
                        echo '</div>';
                        echo "<div class=\"receipe-content\">";
                        echo '<span>' . explode(' ', $ctNauAns[$i]->created_at)[0] . '</span>';
                        echo "<a href=\"" . url('/cong-thuc/' . $ctNauAns[$i]->MaCT) . "\"><h5>" . $ctNauAns[$i]->TenMonAn . '</h5></a>';
                        echo '<p>' . $ctNauAns[$i]->danhGias()->count() . ' Comments</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                @endphp
            </div>
        </div>
    </section>
</x-cook>