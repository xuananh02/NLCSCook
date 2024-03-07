<x-cook>

    {{-- @vite(['resources/js/chinh_sua_cong_thuc.js']) --}}

    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb-area bg-img bg-overlay" style="background-image: <?php echo 'url(' . url('img/bg-img/breadcumb3.jpg') . ')'; ?>">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-text text-center">
                        <h2>Chỉnh Sửa Công Thức Nấu Ăn</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <div class="receipe-post-area section-padding-80">
        <section class="submit-recipe-page-wrap padding-top-74 padding-bottom-50">
            <div class="container">
                <div class="row gutters-60">
                    <div class="col-lg-8">
                        <div class="submit-recipe-form">
                            <div class="form-group">
                                <label>Tên Món Ăn</label>
                                <input type="text" placeholder="Tên Món Ăn" class="form-control" name="name"
                                    id="TenMonAn" data-error="Subject field is required"
                                    value="{{ $ctNauAn->TenMonAn }}" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label>Thể Loại</label>
                                <select id="cac-the-loai" class="select2" name="filter-by">
                                    @php
                                        $theLoais = App\Models\TheLoai::all();
                                        $theLoaiCur = $ctNauAn->TenTheLoai;
                                        echo "<option value=\"" . 0 . "\">" . $theLoaiCur . '</option>';
                                    @endphp
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Mô Tả Ngắn</label>
                                <textarea placeholder="Gõ Văn Bản Của Bạn" class="textarea form-control" name="message" id="MoTa" rows="3"
                                    cols="20" data-error="Message field is required" required>{{ $ctNauAn->MoTa }}</textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label>Mô Tả Chi Tiết</label>
                                <textarea placeholder="Gõ Văn Bản Của Bạn" class="textarea form-control" name="message" id="MoTaChiTiet" rows="6"
                                    cols="20" data-error="Message field is required" required>{{ $ctNauAn->MoTaChiTiet }}</textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="additional-input-wrap">
                                <label>Quy Trình:</label>
                                <div id="workflow-receipe">
                                    @php
                                        $quyTrinhs = $ctNauAn->quyTrinhs()->get();
                                        foreach ($quyTrinhs as $quyTrinh) {
                                            echo "<div class=\"form-group\">";
                                            echo "<input type=\"text\" placeholder=\"Thời Gian\" class=\"form-control workflow-step\" value=\"" . $quyTrinh->ThoiGian . "\" id=\"$quyTrinh->MaQT\"/>";
                                            echo "<textarea placeholder=\"Gõ Văn Bản Của Bạn\" class=\"textarea form-control workflow-textarea\" name=\"message\" rows=\"6\"";
                                            echo "cols=\"20\" data-error=\"Message field is required\" required >" . $quyTrinh->NoiDungBuoc . '</textarea>';
                                            echo "<div class=\"help-block with-errors\"></div>";
                                            echo '</div>';
                                        }
                                    @endphp
                                </div>
                                <button id="add-new-step" class="btn-upload"><i
                                        class="flaticon-add-plus-button"></i>Thêm Bước</button>
                            </div>
                            <div class="additional-input-wrap">
                                <label>Tải Ảnh Của Bạn</label>
                                <div class="form-group">
                                    <ul id="image-list" class="upload-img">
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
                                                echo "<li style=\"width: 12rem; height: auto;\"><img src=\"/" . $hinhAnh->Nguon . "\" alt=\"Upload Image\"/></li>";
                                            }
                                        @endphp
                                    </ul>
                                    <input type="file" name="images[]" multiple id="images"
                                        class="btn-upload" /><br><br>
                                </div>
                            </div>
                            <div class="additional-input-wrap">
                                <label>Nguyên Liệu:</label>
                                <div class="row no-gutters" id="container-ingredient">
                                    @php
                                        $nguyenLieus = $ctNauAn
                                            ->nguyenLieus()
                                            ->get()
                                            ->all();
                                        foreach ($nguyenLieus as $nguyenLieu) {
                                            echo "<div class=\"col-4\">" . "<div class=\"form-group additional-input-box icon-left\">" . "<input type=\"text\" placeholder=\"Tên Thành Phần\" class=\"form-control name-ingredient\"" . "name=\"name\" id=\"" . $nguyenLieu->MaNL . "\" value=\"" . $nguyenLieu->TenNguyenLieu . "\">" . '</div>' . '</div>';
                                            echo "<div class=\"col-4\">" . "<div class=\"form-group additional-input-box icon-left\">" . "<input type=\"text\" placeholder=\"Số Lượng\" class=\"form-control amount-ingredient\"" . "name=\"name\" id=\"" . $nguyenLieu->MaNL . "\" value=\"" . $nguyenLieu->SoLuong . "\">" . '</div>' . '</div>';
                                            echo "<div class=\"col-4\">" . "<div class=\"form-group additional-input-box icon-left\">" . "<input type=\"text\" placeholder=\"Đơn Vị\" class=\"form-control unit-ingredient\"" . "name=\"name\" id=\"" . $nguyenLieu->MaNL . "\" value=\"" . $nguyenLieu->DonVi . "\">" . '</div>' . '</div>';
                                        }
                                    @endphp
                                </div>
                                <button id="add-new-row-ingredient" class="btn-upload"><i
                                        class="flaticon-add-plus-button"></i>Thêm Hàng Mới</button>
                            </div>
                            <div class="d-flex">
                                <button type="submit" class="btn-submit mr-4" id="submit">Đăng Tải</button>
                                <button class="btn-submit" id="delete-submit">Xóa Công Thức</button>
                                <div class="invisible ml-2 mt-30" id="status">Thành Công!</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</x-cook>
