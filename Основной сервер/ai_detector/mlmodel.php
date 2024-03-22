<?php
    require('translate.php');
    function and_the_man_is_definitely_not_a_nerd($text){
        $host = 'IP-адрес сервера, на котором размещена модель';
        $port = 80; // Порт, который использовался для подключения
        
        // Create a new socket
        $socket = socket_create(AF_INET, SOCK_STREAM, 0);
        
        // Connect to the server
        socket_connect($socket, $host, $port);
        
        // Write data to the server
        $str = translate($text);
        socket_write($socket, mb_convert_encoding($str, "UTF-8"));
        
        // Read data from the server
        $data = mb_convert_encoding(socket_read($socket, 1024), "UTF-8");
        
        // Close the connection
        socket_close($socket);
        
        if($data < 0.5) return "Human - $data";
        
        return "AI - $data";
    }
?>