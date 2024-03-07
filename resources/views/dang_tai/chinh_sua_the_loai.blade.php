<x-cook>
    {{-- @vite(['resources/js/chinh_sua_the_loai.js']) --}}
    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb-area bg-img bg-overlay" style="background-image: <?php echo 'url(' . url('img/bg-img/breadcumb3.jpg') . ')'; ?>">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-text text-center">
                        <h2>Chỉnh Sửa Thể Loại</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <div class="receipe-post-area section-padding-80">

        <div class="receipe-post-search mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <div class="form-group">
                            <label>Các Thể Loại Hiện Tại</label>
                            <select class="select2" name="filter-by">
                                @php
                                    $theLoais = App\Models\TheLoai::all();
                                    foreach ($theLoais as $key => $ele) {
                                        echo "<option value=\"" . $key . "\">" . $ele->TenTheLoai . '</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Receipe Content Area -->
        <div class="receipe-content-area">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <div class="contact-form-area">
                            <div class="row submit-recipe-form">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tên Thể Loại Cũ</label>
                                        <input type="text" placeholder="Tên Thể Loại Cũ" class="form-control"
                                            name="name" id="TenTheLoaiCu" data-error="Subject field is required"
                                            value="@php if (!is_null($theLoai)) echo $theLoai->TenTheLoai; @endphp"
                                            required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tên Thể Loại Mới</label>
                                        <input type="text" placeholder="Tên Thể Loại" class="form-control"
                                            name="name" id="TenTheLoaiMoi" data-error="Subject field is required"
                                            required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Mô Tả Ngắn</label>
                                        <textarea placeholder="Gõ Văn Bản Của Bạn" class="textarea form-control" name="message" id="MoTaTheLoai" rows="3"
                                            cols="20" data-error="Message field is required" required>@php
                                                if ($theLoai != null) {
                                                    echo $theLoai->MoTa;
                                                }
                                            @endphp</textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="additional-input-wrap">
                                    <label>Tải Ảnh Của Bạn</label>
                                    <div class="form-group">
                                        <ul id="image-list" class="upload-img">
                                            @php
                                                if ($theLoai != null) {
                                                    $hinhAnhTheLoai = DB::table('hinh_anh_the_loai')
                                                        ->where('TenTheLoai', '=', $theLoai->TenTheLoai)
                                                        ->select('MaHinhAnh')
                                                        ->get()
                                                        ->map(function ($item) {
                                                            return $item->MaHinhAnh;
                                                        });
                                                    $hinhAnhs = App\Models\HinhAnh::whereIn('MaHinhAnh', $hinhAnhTheLoai)->get();
                                                    foreach ($hinhAnhs as $hinhAnh) {
                                                        echo "<li style=\"width: 12rem; height: auto;\"><img src=\"/" . $hinhAnh->Nguon . "\" alt=\"Upload Image\"/></li>";
                                                    }
                                                }
                                            @endphp
                                        </ul>

                                        <input type="file" name="image" id="image"
                                            class="btn-upload" /><br><br>
                                        {{-- <button type="submit" class="btn-upload"><i
                                                class="fas fa-cloud-upload-alt"></i>
                                                UPLOAD</button> --}}
                                    </div>
                                </div>
                                <div class="col-12 d-flex align-items-center">
                                    <button class="btn delicious-btn mt-30" id="submit">Đăng Tải</button>
                                    <button class="btn delicious-btn mt-30 ml-2" id="delete-submit">Xóa Thể Loại
                                        Cũ</button>
                                    <div class="invisible ml-2 mt-30" id="status">Thành Công!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-cook>
