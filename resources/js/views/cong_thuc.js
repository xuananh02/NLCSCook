"use strict";

import axios from 'axios';
import DanhGiaService from '../services/danhGia.service'
import UserService from '../services/user.service';

const currentURL = window.location.href;
const delay = ms => new Promise(res => setTimeout(res, ms));
const urlParams = new URLSearchParams(window.location.search);
const maCT = urlParams.get('maCT');

const status = document.querySelector('#status');
const messageComment = document.querySelector("#message");
const submit = document.querySelector("#submit-post");
const comments = document.querySelector("#comments");


const danhGiaService = new DanhGiaService();
const userService = new UserService();

function editComment(paraCmt, idCmnt, editBtn) {
    let contenParaCmt = paraCmt.children[0].innerText;

    let eleTextarea = document.createElement("textarea");
    eleTextarea.setAttribute("class", "textarea form-control");
    eleTextarea.setAttribute("rows", "4");
    eleTextarea.value = contenParaCmt

    let eleSubmit = document.createElement("button");
    eleSubmit.innerHTML = "Đồng Ý";
    eleSubmit.setAttribute("class", "btn btn-primary btn-sm");

    eleSubmit.addEventListener("click", () => {
        let dataForm = {
            'MaCT': maCT,
            'BinhLuan': eleTextarea.value
        };
        axios.put("/api/danh_gia/" + idCmnt, dataForm)
            .then(function (response) {
                console.log(response.data);
                editBtn.setAttribute("style", "");
                paraCmt.innerHTML = "<p>" + dataForm['BinhLuan'] + "</p>";
                alert("Thành Công");
            })
            .catch(function (error) {
                console.log(error);
                alert("Thất bại");
            });
    });

    editBtn.setAttribute("style", "display: none;");
    paraCmt.innerHTML = "";
    paraCmt.appendChild(eleTextarea);
    paraCmt.appendChild(eleSubmit);
}

function delComment(eleCmnt, idCmt) {
    if (confirm("bạn có chắc là xóa đánh giá này?")) {
        axios({
            method: 'delete',
            url: '/api/danh_gia/' + idCmt,
        })
            .then(function (response) {
                console.log(response.data);
                eleCmnt.remove();
                alert("Thành Công");
            })
            .catch(function (error) {
                console.log(error);
                alert("Thất bại");
            });
    }
}

function createEleCmtHtml(user, userCmt, idCmt, comment, urlImage, created_at) {
    let editBtn = document.createElement("button");
    let delBtn = document.createElement("button");
    let eleCmtHtml = document.createElement("div");

    editBtn.setAttribute("class", "btn btn-primary btn-sm mr-2");
    delBtn.setAttribute("class", "btn btn-danger btn-sm");
    eleCmtHtml.setAttribute("class", "d-flex flex-start mb-4 flex-md-row flex-column");

    let eleCmtInnerHtml = `
        <img class="rounded-circle shadow-1-strong me-3"
            src="/` + urlImage + `" alt="avatar"
            style="width: 10rem; height: 10rem" />
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="container-user">
                    <div class="d-flex justify-content-between ">
                        <h5>Johny Cash</h5>
                        <div class="d-flex"></div>
                    </div>
                    <p class="small">`+ created_at.split("T")[0] + `</p>
                    <div class="d-flex flex-column">
                        <p>` + comment + `</p>
                    </div>
                </div>
            </div>
        </div>`;

    eleCmtHtml.innerHTML = eleCmtInnerHtml;

    let containerUser = eleCmtHtml.children[1].children[0].children[0];
    let userEleHtml = containerUser.children[0].children[1];
    let commentEleHtml = containerUser.children[2];

    if (user == userCmt) {
        editBtn.innerHTML = "Thay Đổi";
        delBtn.innerHTML = "Xóa";

        editBtn.addEventListener("click", () => {
            editComment(commentEleHtml, idCmt, editBtn);
        });
        delBtn.addEventListener("click", () => {
            delComment(eleCmtHtml, idCmt);
        });

        userEleHtml.appendChild(editBtn);
        userEleHtml.appendChild(delBtn);
    }

    return eleCmtHtml;
}

if (submit) {

    submit.addEventListener("click", async () => {
        let user = (await axios.get('/api/user-session')).data;
        let dataForm = {
            "MaCT": maCT,
            "BinhLuan": messageComment.value
        }
        // console.log(dataForm);
        await axios.post('/api/danh_gia', dataForm).then(function (response) {
            console.log(response.data);
            if (response.data.message != null) {
                status.innerHTML = "Thất Bại!";
                alert(response.data.message);
            } else {
                status.innerHTML = "Thành Công!";
                let danhGia = response.data['danh-gia'];
                let eleCmntHtml = createEleCmtHtml(user['MaND'], danhGia['MaND'], danhGia['MaDanhGia'], danhGia['BinhLuan'], user['pathAvatar'], danhGia['created_at']);
                comments.appendChild(eleCmntHtml);
            }
        }).catch(function (error) {
            console.log(error);
            status.innerHTML = "Thất Bại!";
        });

        submit.disabled = true;
        status.classList.remove('invisible');
        await delay(2000);
        status.classList.add('invisible');
        submit.disabled = false
    });
}


async function main() {
    try {
        const dataDG = await danhGiaService.getDanhGiaByMaCT(maCT);
        const congThuc = (await axios.get("/api/cac_cong_thuc/" + maCT)).data;
        const userCT = congThuc["cong-thuc"]["cong-thuc-nau-an"]["maND"];
        // console.log(congThuc);

        comments.innerHTML = "";
        dataDG['cac-danh-gia'].forEach((element) => {
            let eleCmntHtml = createEleCmtHtml(userCT, element['MaND'], element['MaDanhGia'], element['BinhLuan'], userSS['pathAvatar'], element['created_at']);
            comments.appendChild(eleCmntHtml);
        });
    } catch (error) {
        console.log(error);
    }
}



main();