var connection = new WebSocket("wss://ohabbo.org", "90");

connection.onopen = function() {
    connection.send("teste");
};

connection.onerror = function(error) {
    console.log("Erro no Websocket: " + error);
};

connection.onmessage = function(e) {
    console.log("Server: " + e.data);
};