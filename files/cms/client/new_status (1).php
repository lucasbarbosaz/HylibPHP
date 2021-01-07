<?php
require_once('../../../geral.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//echo 123;
//die('123');
$query = $db->query("SELECT * FROM radio_stats WHERE fetch_time + 30 >= " . time());
if ($query) {
    $data = $query->fetch_assoc();
    if ($data)
    	die($data['json_response']);
}

// Criando a url para o aquivo json
$jsonurl = "http://stm14.voxtreaming.com.br:6776/sc_uvade.php/";

// Retorna o conteudo do arquivo em formato de string
$json = file_get_contents($jsonurl, 0, null, null);

if ($stmt = $db->prepare('UPDATE radio_stats SET fetch_time = ?, json_response = ?')) {
    $time = time();
    $stmt->bind_param('is', $time, $json);
    $stmt->execute();
    $stmt->close();
}
echo $json;
