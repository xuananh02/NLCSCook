const urlParams = new URLSearchParams(window.location.search);
const tableParam = urlParams.get('table');
const table = document.querySelector("#table");
const nameTable = document.querySelector("#name-table");
table.innerHTML = "";

if (tableParam == "cong thuc") {
    nameTable.innerText = "Các công thức nấu ăn";
    axios.get("/api/cac_cong_thuc").then(async (response) => {
        const arrCT = response.data['cac-cong-thuc-nau-an'];
        for (let kct in arrCT) {
            const ct = arrCT[kct]['cong-thuc-nau-an'];
            const userId = ct['MaND'];
            const user = (await axios.get("/api/users/"+userId)).data;
            const tr = createEleTableCT(user, ct['MaCT'], ct['TenMonAn'], ct['TenTheLoai'], ct['MoTa']);
            table.appendChild(tr);
        }
    }).catch((error) => {
        console.log(error);
    });
} else if (tableParam == "danh gia") {
    nameTable.innerText = "Các đánh giá";
    axios.get("/api/danh_gia").then(async (response) => {
        const user = (await axios.get('/api/user-session')).data;
        const arrDG = response.data['cac-danh-gia'];
        for (let kdg in arrDG) {
            const dg = arrDG[kdg];
            
            const tr = createEleTableDG(user, dg['MaCT'], dg['MaDanhGia'], dg['BinhLuan'], dg['updated_at']);
            table.appendChild(tr);
        }
    }).catch((error) => {
        console.log(error);
    });
} else if (tableParam == "the loai") {
    nameTable.innerText = "Các thể loại";
    axios.get("/api/cac_the_loai").then(async (response) => {
        const arrTL = response.data['cac-the-loai'];
        for (let ktl in arrTL) {
            console.log(arrTL[ktl]);
            const tl = arrTL[ktl]['the-loai'];
            const ha = arrTL[ktl]['hinh-anh-the-loai'][0];
            const tr = createEleTableTL(tl['TenTheLoai'], tl['MoTa'], ha['Nguon']);
            table.appendChild(tr);
        }
    }).catch((error) => {
        console.log(error);
    });
} else {
    axios.get("/api/users").then(async (response) => {
        console.log(response.data);
        const arrUser = response.data;
        for (let kUser in arrUser) {
            const user = arrUser[kUser];
            console.log(user);
            const tr = createEleTableUser(user['MaND'], user['name'], user['SoDienThoai'], user['created_at']);
            table.appendChild(tr);
        }
    }).catch((error) => {
        console.log(error);
    });
}

function deleteEleDG(tr, idCmt) {
    if (confirm("Bạn có chắc là xóa đánh giá này?")) {
        axios({
            method: 'delete',
            url: '/api/danh_gia/' + idCmt,
        })
            .then(function (response) {
                console.log(response.data);
                tr.remove();
                alert("Thành Công");
            })
            .catch(function (error) {
                console.log(error);
                alert("Thất bại");
            });
    }
}

function deleteEleUser(tr, idUser) {
    if (confirm("Bạn có chắc là xóa người dùng này?")) {
        axios({
            method: 'delete',
            url: '/profile/delete/' + idUser,
        })
            .then(function (response) {
                console.log(response.data);
                tr.remove();
                alert("Thành Công");
            })
            .catch(function (error) {
                console.log(error);
                alert("Thất bại");
            });
    }
}

function createEleTableCT(tacGia, maCT, tenTL, tenCT, moTaNgan) {
    const mainEle = document.createElement("tr");
    const innerMainEle = `
        <td>
            <div class="d-flex px-2 py-1">
                <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">`+ tacGia['name'] +`</h6>
                    <p class="text-xs text-secondary mb-0">`+ tacGia['email'] +`</p>
                </div>
            </div>
        </td>
        <td>
            <p class="text-xs font-weight-bold mb-0">`+ maCT +`
            </p>
        </td>
        <td class="align-middle text-center text-sm">
            <p class="text-xs font-weight-bold mb-0">`+ tenTL +`
            </p>
        </td>
        <td class="align-middle text-center">
            <p class="text-xs font-weight-bold mb-0">`+ tenCT +`
            </p>
        </td>
        <td class="align-middle text-center">
            <p class="text-xs font-weight-bold mb-0">`+ moTaNgan +`
            </p>
        </td>
        <td class="align-middle">
            <a href="/chinh-sua-cong-thuc/?maCT=`+ maCT +`" class="text-secondary font-weight-bold text-xs"
                data-toggle="tooltip" data-original-title="Edit user">
                Edit
            </a>
        </td>
    `;

    mainEle.innerHTML = innerMainEle

    return mainEle;
}


function createEleTableDG(tacGia, maCT, maDG, noiDung, ngayDang) {
    const mainEle = document.createElement("tr");
    const innerMainEle = `
        <td>
            <div class="d-flex px-2 py-1">
                <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">`+ tacGia.name +`</h6>
                    <p class="text-xs text-secondary mb-0">`+ tacGia.email +`</p>
                </div>
            </div>
        </td>
        <td>
            <p class="text-xs font-weight-bold mb-0">`+ maCT +`
            </p>
        </td>
        <td class="align-middle text-sm">
            <span class="text-secondary text-xs ">`+ noiDung +`</span>
        </td>
        <td class="align-middle text-center">
            <span class="text-secondary text-xs font-weight-bold">`+ ngayDang +`</span>
        </td>  
    `;
    const delCmt = document.createElement("td");
    const delCmtLink = document.createElement("a");
    delCmt.setAttribute("class", "align-middle");
    delCmtLink.setAttribute("class", "text-secondary font-weight-bold text-xs");
    delCmtLink.setAttribute("data-toggle", "tooltip");
    delCmtLink.setAttribute("data-original-title", "Edit user");
    delCmtLink.innerText = "Delete";

    delCmt.appendChild(delCmtLink);
    delCmtLink.addEventListener("click", () => {
        deleteEleDG(mainEle, maDG);
    });

    console.log("del true");

    mainEle.innerHTML = innerMainEle
    mainEle.appendChild(delCmt);
    return mainEle;
}

function createEleTableTL(tenTL, moTa, path) {
    const tenTLEncode = encodeURIComponent(tenTL);
    const mainEle = document.createElement("tr");
    const innerMainEle = `
        <td>
            <p class="text-xs font-weight-bold mb-0">`+ tenTL +`
            </p>
        </td>
        <td>
            <p class="text-xs font-weight-bold mb-0">`+ moTa +`
            </p>
        </td>
        <td class="align-middle text-center text-sm">
            <p class="text-xs font-weight-bold mb-0">`+ path +`
            </p>
        </td>
        <td class="align-middle">
            <a href="/chinh-sua-the-loai/?tenTL=`+ tenTLEncode +`" class="text-secondary font-weight-bold text-xs"
                data-toggle="tooltip" data-original-title="Edit user">
                Edit
            </a>
        </td>
    `;
    mainEle.innerHTML = innerMainEle
    return mainEle;
}

function createEleTableUser(maUser, tenUser, soDT, ngayTao) {
    const mainEle = document.createElement("tr");
    const innerMainEle = `
        <td>
            <p class="text-xs font-weight-bold mb-0">`+ maUser +`
            </p>
        </td>
        <td>
            <p class="text-xs font-weight-bold mb-0">`+ tenUser +`
            </p>
        </td>
        <td class="align-middle text-center text-sm">
            <p class="text-xs font-weight-bold mb-0">`+ soDT +`
            </p>
        </td>
        <td class="align-middle text-center text-sm">
            <p class="text-xs font-weight-bold mb-0">`+ ngayTao +`
            </p>
        </td>
    `;
    const delUser = document.createElement("td");
    const delUserLink = document.createElement("a");
    delUser.setAttribute("class", "align-middle");
    delUserLink.setAttribute("class", "text-secondary font-weight-bold text-xs");
    delUserLink.setAttribute("data-toggle", "tooltip");
    delUserLink.setAttribute("data-original-title", "Edit user");
    delUserLink.innerText = "Delete";


    delUser.appendChild(delUserLink);
    delUserLink.addEventListener("click", () => {
        deleteEleUser(mainEle, maUser);
    });

    console.log("del true");

    mainEle.innerHTML = innerMainEle
    mainEle.appendChild(delUser);
    return mainEle;
}