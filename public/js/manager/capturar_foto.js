$(document).ready(function () {
    var video = document.getElementById("video");
    //var canvas = document.getElementById("canvas");
    const snap = document.getElementById("snap");
    const errorMsgElement = document.querySelector("span#errorMsg");
    var imagen = document.getElementById("imagen");

    const constraints = {
        audio: false,
        video: {
            width: 140,
            height: 120,
        },
    };

    ImagenCanvas();

    async function init() {
        //function init(){
        try {
            const stream = await navigator.mediaDevices.getUserMedia(
                constraints
            );
            handleSuccess(stream);
        } catch (e) {
            errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
        }
    }

    // Success
    function handleSuccess(stream) {
        window.stream = stream;
        video.srcObject = stream;
    }

    //Load init
    $("#encender").click(function (event) {
        init();
        video.play();
    });

    $("#apagar").click(function (event) {
        Apagar();
    });

    //Apagar camara//
    function Apagar() {
        stream = video.srcObject;
        if (stream != null) {
            tracks = stream.getTracks();
            tracks.forEach(function (track) {
                track.stop();
            });
            video.srcObject = null;
            video.setAttribute(
                "poster",
                "/img/user-default.png"
            );
        }
    }

    // Draw image
    snap.addEventListener("click", function () {
        let context = canvas.getContext("2d");
        context.drawImage(video, 0, 0, 140, 120);
        imagen.setAttribute("src", canvas.toDataURL("image/jpeg", 1.0));
        //console.log(imagen.src);

        let es_foto = canvas.toDataURL("image/jpeg", 1.0);

        $("#es_foto").val(es_foto);
        /*console.log($('#es_foto').val());*/
    });

    function ImagenCanvas() {
        const canvas = document.getElementById('canvas');
        let contex = canvas.getContext("2d");
        imagenes = document.getElementById("imagen");
        imagenes.setAttribute(
            "src",
            "/img/undraw_profile.svg"
        );
        contex.drawImage(imagenes, 0, 0, 120, 120);
    }

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var imagen = document.getElementById("imagen");
            const canvas = document.getElementById("canvas");
            let context = canvas.getContext("2d");
            reader.onload = function (e) {
                imagen.src = e.target.result;
                imagen.onload = function () {
                    context.drawImage(imagen, 0, 0, 140, 120);
                    let es_foto = e.target.result;

                    $("#es_foto").val(es_foto);
                    console.log($("#es_foto").val());
                };
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    var fileUpload = document.getElementById("file-upload");
    fileUpload.onchange = function (e) {
        readFile(e.srcElement);
    };

    $(".apagar").click(function (event) {
        Apagar();
    });
});
