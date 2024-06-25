document.addEventListener("DOMContentLoaded", function () {
    const baseUrl = window.apiUrl;
    const usuario = JSON.parse(localStorage.getItem("user"));

    const token = localStorage.getItem("token");

    if (usuario.us_tipo != 1) {
        $("#overlay").hide();
        switch (usuario.us_tipo) {
            case 0:
                window.location.href = baseUrl + "/estudiante/home";
                break;
            case 3:
                window.location.href = baseUrl + "/admin/home";
                break;
            case 2:
                window.location.href = baseUrl + "/manager/home";
                break;
            default:
                window.location.href = baseUrl + "/login";
        }
    }

    if (usuario.us_tipo == 1) {
        console.log(usuario.us_tipo);
        document.body.style.visibility = "visible";
    }
    
    if (token) {
        $("#overlay").hide();
        $("#us_correo").html(usuario.us_correo);
        $("#foto_perfil").attr("src", usuario.docente.es_foto);
    }
    // Verificar si hay un token almacenado
    if (token == null) {
        $("#overlay").hide();
        window.location.href = baseUrl + "/login";
    }

});
