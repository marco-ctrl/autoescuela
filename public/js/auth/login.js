$(document).ready(function () {
    const baseUrl = window.apiUrl;
    
    $("#loginForm").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: baseUrl + "/api/login-user",
            Headers: {
                Accept: "application/json",
            },
            data: {
                us_correo: $("#us_correo").val(),
                us_password: $("#us_password").val(),
            }, // serializes the form's elements.
            success: function (response) {
                if (response.status) {
                    localStorage.setItem("token", response.token);
                    localStorage.setItem("user", JSON.stringify(response.user));
                    // Redirigir a la página de inicio
                    if (response.user.us_tipo == 3) {
                        window.location.href = baseUrl + "/admin/home";
                    }
                    if (response.user.us_tipo == 1) {
                        console.log(response.user.us_tipo);
                        window.location.href = baseUrl + "/docente/home";
                    }
                    if (response.user.us_tipo == 0) {
                        console.log(response.user.us_tipo);
                        window.location.href = baseUrl + "/estudiante/home";
                    }
                } else {
                    $("#error").html(response.message);
                }
            },
            error: function (xhr) {
                var errorElement = document.getElementById("error");
                errorElement.hidden = false;
                $("#error").html(
                    "<strong>" + xhr.responseJSON.message + "</strong>"
                );
                console.log(xhr.responseJSON.message);
            },
        });
    });

    $("#salir").click(function (e) {
        e.preventDefault();
        console.log("logout");
        let token = localStorage.getItem("token");
        $.ajax({
            type: "POST",
            url: baseUrl + "/api/logout",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token, // Pasar el token como parte de la cabecera de autorización
            },
            success: function (response) {
                if (response.status) {
                    localStorage.removeItem("token");
                    localStorage.removeItem("user");
                    // Redirigir a la página de inicio
                    window.location.href = baseUrl + "/login";
                } else {
                    $("#error").html(response.message);
                }
            },
            error: function (xhr) {
                var errorElement = document.getElementById("error");
                errorElement.hidden = false;
                $("#error").html(
                    "<strong>" + xhr.responseJSON.message + "</strong>"
                );
                console.log(xhr.responseJSON.message);
            },
        });
    });
});
