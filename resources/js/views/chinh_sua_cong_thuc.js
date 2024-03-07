
const delay = ms => new Promise(res => setTimeout(res, ms));

let url = window.location.href;
let urlArray = url.split('/');
let urlHost = urlArray[2];
let urlArrayLength = urlArray.length;

const urlParams = new URLSearchParams(window.location.search);
let maCT = urlParams.get('maCT');
let tenTheLoai = document.getElementsByClassName("current")[0];
let status = document.querySelector('#status');

let imagefile = document.querySelector('#images');
let tenMonAn = document.querySelector('#TenMonAn');
let moTa = document.querySelector('#MoTa');
let moTaChiTiet = document.querySelector("#MoTaChiTiet");
let submit = document.querySelector("#submit");
let deleteSubmit = document.querySelector("#delete-submit");
let urlDestination = 'http://' + urlHost + '/cook'
let nguyenLieu = document.querySelector("#container-ingredient");
let themNguyenLieu = document.querySelector("#add-new-row-ingredient");
let themQuyTrinh = document.querySelector("#add-new-step");
let quyTrinh = document.querySelector("#workflow-receipe");

function themElementQT(tGian, noiDungBC, MaQT) {
    let bcHtml = document.createElement("div");
    bcHtml.setAttribute("class", "form-group");
    let innerBcHtml = `
        <input type="text" placeholder="Thời Gian" class="form-control workflow-step" value="`+ tGian + `" ` + MaQT + `/>
        <textarea placeholder="Gõ Văn Bản Của Bạn" class="textarea form-control workflow-textarea" name="message" rows="6"
            cols="20" data-error="Message field is required" required >`+ noiDungBC + `</textarea>
        <div class="help-block with-errors"></div>`;
    bcHtml.innerHTML = innerBcHtml;
    quyTrinh.appendChild(bcHtml);
}

themQuyTrinh.addEventListener("click", () => {
    themElementQT("", "", "");
})

function displayImage(input) {
    let ulImage = document.getElementById("image-list");
    ulImage.innerHTML = "";

    if (input.files) {
        for (var key in input.files) {
            if (key != "item" && key != "length") {
                console.log(key, input.files[key]);

                let reader = new FileReader();
                let image = document.createElement("img");
                let li = document.createElement("li");
                li.setAttribute("style", "width: 12rem; height: auto;");

                reader.onload = function (e) {
                    image.setAttribute("src", e.target.result);
                    image.setAttribute("alt", "Upload Image");
                }

                reader.readAsDataURL(input.files[key]);
                li.appendChild(image);

                ulImage.appendChild(li);
            }
        };
    }
}

imagefile.addEventListener("change", () => {
    displayImage(imagefile);
});

function themElementNL(tenNL, slNL, dvNL, id) {
    let eleTenHtml = document.createElement("div");
    let eleSLHtml = document.createElement("div");
    let eleDVHtml = document.createElement("div");

    eleTenHtml.setAttribute("class", "col-4");
    eleSLHtml.setAttribute("class", "col-4");
    eleDVHtml.setAttribute("class", "col-4");

    let eleTen = `
        <div class="form-group additional-input-box icon-left">
            <input type="text" placeholder="Tên Thành Phần" class="form-control name-ingredient"
                name="name" value="`+ tenNL + `" ` + id + `/>
        </div>`;
    let eleSL = `
        <div class="form-group additional-input-box icon-right">
            <input type="text" placeholder="Số Lượng" class="form-control amount-ingredient"
                name="name" value="`+ slNL + `" ` + id + `/>
        </div>`;
    let eleDV = `
        <div class="form-group additional-input-box icon-right">
            <input type="text" placeholder="Đơn Vị" class="form-control unit-ingredient"
                name="name" value="`+ dvNL + `" ` + id + `/>
        </div>`;

    eleTenHtml.innerHTML = eleTen;
    eleSLHtml.innerHTML = eleSL;
    eleDVHtml.innerHTML = eleDV;

    nguyenLieu.appendChild(eleTenHtml);
    nguyenLieu.appendChild(eleSLHtml);
    nguyenLieu.appendChild(eleDVHtml);
}

themNguyenLieu.addEventListener("click", () => {
    themElementNL("", "", "", "");
});

deleteSubmit.addEventListener("click", async () => {
    if (confirm("bạn có chắc là xóa công thức này?")) {
        await axios({
            method: 'delete',
            url: '/api/cac_cong_thuc/' + maCT,
        }).then(function (response) {
            console.log(response.data);
            if (response.data.message != null) {
                status.innerHTML = "Thất Bại!";
                alert(response.data.message);
            } else {
                status.innerHTML = "Thành Công!";
            }
        })
            .catch(function (error) {
                console.log(error);
                status.innerHTML = "Thất Bại!";
            });
        deleteSubmit.disabled = true;
        status.classList.remove('invisible');
        await delay(2000);
        status.classList.add('invisible');
        deleteSubmit.disabled = false
    }

});

submit.addEventListener("click", async () => {
    let dataForm = {
        "MaCT": maCT,
        "TenMonAn": tenMonAn.value,
        "TenTheLoai": tenTheLoai.innerText,
        "MoTa": moTa.value,
        "MoTaChiTiet": moTaChiTiet.value,
        "images[]": imagefile.files,
        "NguyenLieu": [],
        "QuyTrinh": []
    };

    let tenNLieu = document.getElementsByClassName("name-ingredient");
    let sLNLieu = document.getElementsByClassName("amount-ingredient");
    let donViNLieu = document.getElementsByClassName("unit-ingredient");
    for (let i = 0; i < tenNLieu.length; i++) {
        if (tenNLieu[i].value != "" && sLNLieu[i].value != "" && donViNLieu[i].value != "") {
            let eleNLData = {
                "tenNL": tenNLieu[i].value,
                "slNL": sLNLieu[i].value,
                "dvNL": donViNLieu[i].value,
                "MaNL": tenNLieu[i].id
            }
            dataForm['NguyenLieu'].push(eleNLData);
        }
    }



    let textQT = document.getElementsByClassName("workflow-textarea");
    let stepQT = document.getElementsByClassName("workflow-step");

    for (let i = 0; i < textQT.length; i++) {
        if (stepQT[i].value != "" && textQT[i].value != "") {
            let eleQTData = {
                "tGian": stepQT[i].value,
                "noiDung": textQT[i].value,
                "MaQT": stepQT[i].id
            };
            dataForm['QuyTrinh'].push(eleQTData);
        }
    }



    await axios.post('/api/cac_cong_thuc/' + maCT, dataForm, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(function (response) {
        console.log(response.data);
        if (response.data.message != null) {
            status.innerHTML = "Thất Bại!";
            alert(response.data.message);
        } else {
            status.innerHTML = "Thành Công!";
            quyTrinh.innerHTML = "";
            for (let i = 0; i < response.data['cac-quy-trinh'].length; i++) {
                let tGian = response.data['cac-quy-trinh'][i]['ThoiGian'];
                let noiDung = response.data['cac-quy-trinh'][i]['NoiDungBuoc'];
                let id = "id=\"" + response.data['cac-quy-trinh'][i]['MaQT'] + "\"";
                themElementQT(tGian, noiDung, id);
            }

            nguyenLieu.innerHTML = "";
            for (let i = 0; i < response.data['cac-nguyen-lieu'].length; i++) {
                let tenNL = response.data['cac-nguyen-lieu'][i]['TenNguyenLieu'];
                let slNL = response.data['cac-nguyen-lieu'][i]['SoLuong'];
                let dvNL = response.data['cac-nguyen-lieu'][i]['DonVi'];
                let id = "id=\"" + response.data['cac-nguyen-lieu'][i]['MaNL'] + "\"";
                themElementNL(tenNL, slNL, dvNL, id);
            }
        }
    })
        .catch(function (error) {
            console.log(error);
            status.innerHTML = "Thất Bại!";
        });

    console.log("dataForm", dataForm);

    submit.disabled = true;
    status.classList.remove('invisible');
    await delay(2000);
    status.classList.add('invisible');
    submit.disabled = false
});
