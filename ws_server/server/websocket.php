<?php

$socket = stream_socket_server("tcp://localhost:4000", $errno, $errstr);

if(!$socket)
	die("Не удалось создать слушающий сокет!");
  else{
	  echo "The server was created and is listening on port 4000 \r\n\r\n";
  }
	
$connects = [];
while (true) {
    //формируем массив прослушиваемых сокетов:
    $read = $connects;
    array_push($read, $socket);
    $write = NULL;
	$except = NULL;
echo "0";
    stream_select($read, $write, $except, null);
        
    
		print_r($read);

    if (in_array($socket, $read)) {//есть новое соединение
		print_r($read);
        $connect = stream_socket_accept($socket, -1);//принимаем новое соединение
        array_push($connects, $connect);//добавляем его в список необходимых для обработки
        unset($read[ array_search($socket, $read) ]);
    }

    foreach($read as $connect) {//обрабатываем все соединения
		print_r($read);
	echo "2";
        $headers = '';
        while ($buffer = rtrim(fgets($connect))) {
            $headers .= $buffer;
        }
        fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nПривет");
        fclose($connect);
        unset($connects[ array_search($connect, $connects) ]);
    }
}

fclose($socket);