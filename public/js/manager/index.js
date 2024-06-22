$(document).ready(function () {
    $("#overlay").show();
    const token = localStorage.getItem("token");
    const user = JSON.parse(localStorage.getItem("user"));

    console.log(token);

    const BASEURL = window.apiUrl;
    
    if (user.us_tipo != 2) {
        $("#overlay").hide();
        switch (user.us_tipo) {
            case 0:
                window.location.href = BASEURL + "/estudiante/home";
                break;
            case 1:
                window.location.href = BASEURL + "/docente/home";
                break;
            case 3:
                window.location.href = BASEURL + "/admin/home";
                break;
            default:
                window.location.href = BASEURL + "/login";
        }
    }

    if (user.us_tipo == 2) {
        console.log(user.us_tipo);
        document.body.style.visibility = "visible";
    }

    if (token) {
        $("#overlay").hide();
        $("#us_correo").html(user.us_correo);
        $("#foto_perfil").attr("src", user.trabajador.es_foto);
    }
    // Verificar si hay un token almacenado
    if (token === null) {
        $("#overlay").hide();
        window.location.href = BASEURL + "/login";
    }
});
