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
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);

    $response = curl_exec($curl);

    $info = curl_getinfo($curl);
    echo $info['request_header'];

    curl_close($curl);

    return $response;
}

function httpPostToken($url, $data, $token)
{
    global $devtoken;

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
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);

    $response = curl_exec($curl);

    $info = curl_getinfo($curl);
    echo $info['request_header'];

    curl_close($curl);

    return $response;
}

function httpGet($url, $token)
{
    global $devtoken;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                        'Content-Type: application/json',
                                        'TOKEN_AUTH: '.$token
                                        ));
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    $response = curl_exec($curl);

    $info = curl_getinfo($curl);
    echo $info['request_header'];

    curl_close($curl);

    return $response;
}

function login() {
    global $password, $clientId, $username, $serveruri, $authtoken, $networkId;

    if ($authtoken === "")
    {
	echo "Login<br />";
	$data = array(
	    "password" => $password,
	    "client_specifier" => $clientId,
	    "email" => $username
	);

	$result=httpPost($serveruri."/login", json_encode($data));
	$result=json_decode($result, true);

	$authtoken=$result['authtoken']['authtoken'];
	$networks=array_keys($result['networks']);
	$networkId=$networks[0];
    }
}

function getNetworks() {
    global $serveruri, $authtoken;

    $result=httpGet($serveruri."/account/clients", $authtoken);
    echo $result;
}

function arm() {
    global $serveruri, $authtoken, $networkId;

    $result=httpPostToken($serveruri."/network/".$networkId."/arm", "", $authtoken);
    echo $result;
}

function disarm() {
    global $serveruri, $authtoken, $networkId;

    $result=httpPostToken($serveruri."/network/".$networkId."/disarm", "", $authtoken);
    echo $result;
}
?>
