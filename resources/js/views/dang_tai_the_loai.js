
const delay = ms => new Promise(res => setTimeout(res, ms));

let tenTheLoai = document.getElementById("TenTheLoai");
let moTaTheLoai = document.getElementById("MoTaTheLoai");
let submit = document.getElementById("submit");
let status = document.getElementById("status");
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

submit.addEventListener("click", async (event) => {
    const data = {
        "TenTheLoai": tenTheLoai.value,
        "MoTaTheLoai": moTaTheLoai.value,
        "image": imagefile.files[0]
    };

    console.log(data);

    await axios.post('/api/cac_the_loai', data,  {
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


