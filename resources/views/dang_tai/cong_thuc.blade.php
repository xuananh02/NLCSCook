<x-cook>
    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb-area bg-img bg-overlay" style="background-image: url(img/bg-img/breadcumb3.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-text text-center">
                        <h2>Tạo Công Thức Nấu Ăn</h2>
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
                                    id="TenMonAn" data-error="Subject field is required" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label>Chọn Thể Loại</label>
                                <select id="cac-the-loai" class="select2" name="filter-by">
                                    @php
                                        $theLoais = App\Models\TheLoai::all();
                                        foreach ($theLoais as $key => $theLoai) {
                                            echo "<option value=\"" . $key . "\">" . $theLoai->TenTheLoai . '</option>';
                                        }
                                    @endphp
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Mô Tả Ngắn</label>
                                <textarea placeholder="Gõ Văn Bản Của Bạn" class="textarea form-control" name="message" id="MoTa" rows="3"
                                    cols="20" data-error="Message field is required" required></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label>Mô Tả Chi Tiết</label>
                                <textarea placeholder="Gõ Văn Bản Của Bạn" class="textarea form-control" name="message" id="MoTaChiTiet" rows="6"
                                    cols="20" data-error="Message field is required" required></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="additional-input-wrap">
                                <label>Quy Trình:</label>
                                <div id="workflow-receipe">
                                    <div class="form-group">
                                        <input type="text" placeholder="Thời Gian" class="form-control workflow-step" />
                                        <textarea placeholder="Gõ Văn Bản Của Bạn" class="textarea form-control workflow-textarea" name="message" rows="6"
                                            cols="20" data-error="Message field is required" required></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <button id="add-new-step" class="btn-upload"><i class="flaticon-add-plus-button"></i>Thêm Bước</button>
                            </div>
                            <div class="additional-input-wrap">
                                <label>Tải Ảnh Của Bạn</label>
                                <div class="form-group">
                                    <ul id="image-list" class="upload-img">

                                    </ul>

                                    <input type="file" name="images[]" multiple id="images"
                                        class="btn-upload" /><br><br>
                                    {{-- <button type="submit" class="btn-upload"><i
                                            class="fas fa-cloud-upload-alt"></i>
                                            UPLOAD</button> --}}
                                </div>
                            </div>
                            <div class="additional-input-wrap">
                                <label>Nguyên Liệu:</label>
                                <div class="row no-gutters"  id="container-ingredient">
                                    <div class="col-4">
                                        <div class="form-group additional-input-box icon-left">
                                            <input type="text" placeholder="Tên Thành Phần" class="form-control name-ingredient"
                                                name="name">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group additional-input-box icon-right">
                                            <input type="text" placeholder="Số Lượng" class="form-control amount-ingredient"
                                                name="name">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group additional-input-box icon-right">
                                            <input type="text" placeholder="Đơn Vị" class="form-control unit-ingredient"
                                                name="name">
                                        </div>
                                    </div>

                                </div>
                                <button id="add-new-row-ingredient" class="btn-upload"><i class="flaticon-add-plus-button"></i>Thêm Nguyên Liệu Mới</button>
                            </div>

                            <div class="d-flex">
                                <button type="submit" class="btn-submit" id="submit">Đăng Tải</button>
                                <div class="invisible ml-2 mt-30" id="status">Thành Công!</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</x-cook>
