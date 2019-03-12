function showMessage(messageHTML) {
    $('#chat-box').append(messageHTML);
}

$(document).ready(function () {
    var websocket = new WebSocket("ws://" + host + ":8090/demo/php-socket.php");
    websocket.onopen = function (event) {
        var div = document.createElement("div");
        var txt = document.createTextNode("Se ha conectado al chat");
        div.setAttribute("class", "conexion");
        //append
        div.appendChild(txt);
        var chat = document.getElementById("chat-box");
        chat.appendChild(div);
    };
    websocket.onmessage = function (event) {
        var Mensaje = JSON.parse(event.data);
        if (Mensaje.mensaje !== null) {

            var div = document.createElement("div");

            //Solo escribe el nombre si el mensaje es de tipo "mensaje" o "mensaje-admin"
            if (Mensaje.tipo_mensaje.indexOf("mensaje") !== -1) {
                var span = document.createElement("span");
                span.setAttribute("class", "nombre");
                var nombre = document.createTextNode(Mensaje.usuario + ": ");
                span.appendChild(nombre);
                div.appendChild(span);
            }

            var txt = document.createTextNode(Mensaje.mensaje);
            div.setAttribute("class", Mensaje.tipo_mensaje);
            div.appendChild(txt);
            var chat = document.getElementById("chat-box");
            chat.appendChild(div);
        }
    };

    websocket.onerror = function (event) {
        var clase = "error";
        var err = "Error inesperado";
        createDivErr(clase, err);
    };
    websocket.onclose = function (event) {
        var clase = "desconexion";
        var err = "Conexión cerrada";
        createDivErr(clase, err);
    };

    $('#frmChat').on("submit", function (event) {
        event.preventDefault();
        $('#input-user').attr("type", "hidden");
        $('#ayudaNombre').attr("type", "hidden");

        var messageJSON = {
            chat_user: $('#input-user').val(),
            chat_message: $('#input-mensaje').val()
        };
        websocket.send(JSON.stringify(messageJSON));
        $('#input-mensaje').val('');
    });
});

function createDivErr(clase, err) {
    var div = document.createElement("div");
    div.setAttribute("class", clase);
    var txt = document.createTextNode(err);
    div.appendChild(txt);
    var chat = document.getElementById("chat-box");
    chat.appendChild(div);
}