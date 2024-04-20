$('#overlay').show();

$(document).ready(function () {
    
    const baseUrl = window.location.origin;
    // Obtener el token almacenado en localStorage
    const token = localStorage.getItem('token');
    const user = JSON.parse(localStorage.getItem('user'));
    
    if(token)
    {
        $('#overlay').hide();
        $("#us_correo").html(user.us_correo);
        //console.log(user.us_correo);
    }
    // Verificar si hay un token almacenado
    if (token === null) {
        $('#overlay').hide();
        window.location.href = baseUrl +'/autoescuela/public/login';
    }

});
