document.addEventListener("DOMContentLoaded", function () {
    const baseUrl = window.apiUrl;
    const usuario = JSON.parse(localStorage.getItem("user"));
    const token = localStorage.getItem("token");
    
    if (token) {
        if (usuario.us_tipo != 0) {
            $("#overlay").hide();
            switch (usuario.us_tipo) {
                case 3:
                    window.location.href = baseUrl + "/admin/home";
                    break;
                case 1:
                    window.location.href = baseUrl + "/docente/home";
                    break;
                case 2:
                    window.location.href = baseUrl + "/manager/home";
                    break;
                default:
                    window.location.href = baseUrl + "/login";
            }
        }
    
        if (usuario.us_tipo == 0) {
            console.log("es estudiante");
            document.body.style.visibility = "visible";
        }
        
        $("#overlay").hide();
        $("#us_correo").html(usuario.us_correo);
        $("#foto_perfil").attr("src", usuario.estudiante.es_foto);
    }
    // Verificar si hay un token almacenado
    if (token === null) {
        $("#overlay").hide();
        window.location.href = baseUrl + "/login";
    }

    

});
