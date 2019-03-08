alert("entra aqui");
//$(function () {
//    //Open a WebSocket connection.
//    var wsUri = "ws://127.0.0.1:12345";
//    websocket = new WebSocket(wsUri);
//
//    //Connected to server
//    websocket.onopen = function (ev) {
//        alert('Connected to server ');
//    };
//
//    //Connection close
//    websocket.onclose = function (ev) {
//        alert('Disconnected');
//    };
//
//    //Message Receved
//    websocket.onmessage = function (ev) {
//        alert('Message ' + ev.data);
//    };
//
//    //Error
//    websocket.onerror = function (ev) {
//        alert('Error ' + ev.data);
//    };
//
//    //Send a Message
//    $('#send').click(function () {
//        var mymessage = 'This is a test message';
//        websocket.send(mymessage);
//    });
//});
var socket;
window.onload = function () {
    alert("entra aqui tambien");


    var host = "ws://127.0.0.1:12345";
    try {
        socket = new WebSocket(host);
        log('WebSocket - status ' + socket.readyState);

        socket.onopen = function (msg) {
            log("Welcome - status " + this.readyState);
        };
        socket.onmessage = function (msg) {
            log("Received: " + msg.data);
        };
        socket.onclose = function (msg) {
            log("Disconnected - status " + this.readyState);
        };
    } catch (ex) {
        log(ex);
    }
    $("msg").focus();
};
function send() {
    var txt, msg;
    txt = $("msg");
    msg = txt.value;
    if (!msg) {
        alert("Message can not be empty");
        return;
    }
    txt.value = "";
    txt.focus();
    try {
        socket.send(msg);
        log('Sent: ' + msg);
    } catch (ex) {
        log(ex);
    }
}
function quit() {
    log("Goodbye!");
    socket.close();
    socket = null;
}

// Utilities
function $(id) {
    return document.getElementById(id);
}
function log(msg) {
    $("log").innerHTML += "\n" + msg;
}
function onkey(event) {
    if (event.keyCode == 13) {
        send();
    }
}

// Utilities
function $(id) {
    return document.getElementById(id);
}
function log(msg) {
    $("log").innerHTML += "\n" + msg;
}
function onkey(event) {
    if (event.keyCode == 13) {
        send();
    }
}