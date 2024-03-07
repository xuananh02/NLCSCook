<x-cook>
    {{-- @vite(['resources/js/dang_tai_the_loai.js']) --}}
    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb-area bg-img bg-overlay" style="background-image: url(img/bg-img/breadcumb3.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-text text-center">
                        <h2>Tạo Thể Loại</h2>
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
                            <label>Tất cả Thể Loại Hiện Tại</label>
                            <select class="select2" name="filter-by">
                                @php
                                    $theLoais = App\Models\TheLoai::all();
                                    foreach ($theLoais as $key => $theLoai) {
                                        echo "<option value=\"" . $key . "\">" . $theLoai->TenTheLoai . '</option>';
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
                                        <label>Tên Thể Loại</label>
                                        <input type="text" placeholder="Tên Thể Loại" class="form-control"
                                            name="name" id="TenTheLoai" data-error="Subject field is required"
                                            required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Mô Tả Ngắn</label>
                                        <textarea placeholder="Gõ Văn Bản Của Bạn" class="textarea form-control" name="message" id="MoTaTheLoai" rows="3"
                                            cols="20" data-error="Message field is required" required></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="additional-input-wrap">
                                    <label>Tải Ảnh Của Bạn</label>
                                    <div class="form-group">
                                        <ul id="image-list" class="upload-img">
    
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
