$("#pdfModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Botón que activa el modal
    var pdfUrl = button.data("pdf-url"); // Extraer la URL del PDF desde data-pdf-url
    var modal = $(this);
    modal.find("#pdfModalLabel").html(button.data("title")); // Asignar el título del modal
    modal.find("#pdfIframe").attr("src", pdfUrl); // Asignar la URL del PDF al iframe
});

$(".cancelar").click(function (e) {
    e.preventDefault;
    var modal = $(this);
    modal.find("#pdfIframe").attr("src", ""); // Asignar la URL del PDF al iframe
}); 