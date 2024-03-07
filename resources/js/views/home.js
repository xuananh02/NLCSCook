// "Không Calories"

"use strict";

import '../bootstrap';

let bestCategory = document.getElementById("container-best-category");
let topCategory = document.getElementById("container-top-category");

const PHOBIEN = "Phổ Biến";
const TOTNHAT = "Tốt Nhất";

bestCategory.innerHTML = "";
topCategory.innerHTML = "";

axios.get("/api/cac_the_loai").then((response) => {
    response.data["cac-the-loai"].forEach(element => {
        let tenTheLoaiCur = element['the-loai'].TenTheLoai
        axios.get("/api/cac_cong_thuc?TenTheLoai=" + tenTheLoaiCur).then((response) => {
            console.log(tenTheLoaiCur);
            let chunkCongThuc = 0;
            const arrCT = response.data["cac-cong-thuc-nau-an"]
            for (let k in arrCT) {
                element = arrCT[k];
                if (chunkCongThuc == 4) {
                    break;
                }
                chunkCongThuc += 1;
                if (tenTheLoaiCur == PHOBIEN) {
                    console.log(PHOBIEN + " Được Chọn");
                    console.log(element);

                    let eleHtmlRecipe = `
                        <div class="col-12 col-lg-6">
                            <div class="single-top-catagory">
                                <img style="width: auto; height 28rem;" src="/`+ element["hinh-anh-cong-thuc"][0].Nguon + `" alt="">
                                <!-- Content -->
                                <div class="top-cta-content">
                                    <h3>`+ element["cong-thuc-nau-an"].TenMonAn + `</h3>
                                    <h6>`+ element["cong-thuc-nau-an"].MoTa + `</h6>
                                    <a href="`+ window.location.href + `cong-thuc/?maCT=` + element["cong-thuc-nau-an"].MaCT + `" class="btn delicious-btn">Xem Công Thức</a>
                                </div>
                            </div>
                        </div>`;
                    topCategory.innerHTML += eleHtmlRecipe;
                }
                if (tenTheLoaiCur == TOTNHAT) {
                    console.log(TOTNHAT + " Được Chọn");
                    let eleHtmlRecipe = `
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-best-receipe-area mb-30">
                                <img src="`+ element["hinh-anh-cong-thuc"][0].Nguon + `" alt="">
                                <div class="receipe-content">
                                    <a href="`+ window.location.href + `cong-thuc/?maCT=` + element["cong-thuc-nau-an"].MaCT + `">
                                        <h5>`+ element["cong-thuc-nau-an"].TenMonAn + `</h5>
                                    </a>
                                </div>
                            </div>
                        </div>`;
                    bestCategory.innerHTML += eleHtmlRecipe;
                }
            };
        }).catch((error) => {
            console.log(error);
        });
    });
}).catch((error) => {
    console.log(error);
});

