<?php
include "settings.php";

function httpPost($url, $data)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                        'Content-Type: application/json',
                                        'Content-Length: '.strlen($data)
                                        ));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function httpPostToken($url, $data, $token)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                        'Content-Type: application/json',
                                        'TOKEN_AUTH: '.$token,
                                        'Content-Length: '.strlen($data)
                                        ));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function httpGet($url, $token)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                        'Content-Type: application/json',
                                        'TOKEN_AUTH: '.$token
                                        ));
    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function login() {
    global $password, $clientId, $username, $serveruri, $authtoken;

    $data = array(
	"password" => $password,
	"client_specifier" => $clientId,
	"email" => $username
    );

    $result=httpPost($serveruri."/login", json_encode($data));
    $result=json_decode($result);

    $authtoken=$result->{'authtoken'}->{'authtoken'};
}

function getNetworks() {
    global $serveruri, $authtoken;

    $result=httpGet($serveruri."/networks", $authtoken);
    echo $result;
}
?>