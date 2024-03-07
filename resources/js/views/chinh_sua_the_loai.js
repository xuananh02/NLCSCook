
const delay = ms => new Promise(res => setTimeout(res, ms));


let tenTheLoaiCu = document.getElementById("TenTheLoaiCu");
let tenTheLoaiMoi = document.getElementById("TenTheLoaiMoi");
let moTaTheLoai = document.getElementById("MoTaTheLoai");
let submit = document.getElementById("submit");
let status = document.getElementById("status");
let deleteSubmit = document.getElementById("delete-submit");
let imagefile = document.querySelector('#image');

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

deleteSubmit.addEventListener("click", async (_) => {

    if (confirm("bạn có chắc là xóa thể loại cũ này?")) {
        await axios({
            method: 'delete',
            url: '/api/cac_the_loai/' + tenTheLoaiCu.value
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

submit.addEventListener("click", async (event) => {

    const data = (imagefile.files.length == 0) ? {
        "TenTheLoai": tenTheLoaiMoi.value,
        "MoTaTheLoai": moTaTheLoai.value,
    } : {
        "TenTheLoai": tenTheLoaiMoi.value,
        "MoTaTheLoai": moTaTheLoai.value,
        "image": imagefile.files[0]
    };

    console.log(data);

    await axios.post('/api/cac_the_loai/' + tenTheLoaiCu.value, data, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
        .then(function (response) {
            console.log(response.data);
            status.innerHTML = "Thành Công!";
        })
        .catch(function (error) {
            console.log(error);
            status.innerHTML = "Thất Bại!";
        });

    submit.disabled = true;
    status.classList.remove('invisible');
    await delay(2000);
    status.classList.add('invisible');
    submit.disabled = false

});


