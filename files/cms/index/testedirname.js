var socket = new WebSocket("ws://66.70.142.131", "30002");

socket.onopen = function(event) {
    socket.send("teste socket");
};
