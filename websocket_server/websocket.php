<?php
# Carregar a extensão Swoole
# websocket_server\websocket.php
if (!extension_loaded('swoole')) {
    die("Swoole extension is not installed\n");
}

// Criar um servidor WebSocket com Swoole
$server = new Swoole\WebSocket\Server("0.0.0.0", 4109);

$server->on("start", function (Swoole\WebSocket\Server $server) {
    echo "Swoole WebSocket Server is started at http://127.0.0.1:4109\n";
});

$server->on('open', function(Swoole\WebSocket\Server $server, $request) {
    echo "Connection open: {$request->fd}\n";
    // Enviar uma mensagem de volta ao cliente assim que a conexão for estabelecida
    $server->push($request->fd, "Conexão estabelecida com sucesso");
});

$server->on('message', function(Swoole\WebSocket\Server $server, $frame) {
    echo "Received message: {$frame->data}\n";
    
    // Broadcasting a mensagem para todos os clientes conectados
    foreach ($server->connections as $fd) {
        if ($server->isEstablished($fd)) {
            $server->push($fd, $frame->data);
        }
    }
});

$server->on('close', function($ser, $fd) {
    echo "Connection closed: {$fd}\n";
});

$server->start();
