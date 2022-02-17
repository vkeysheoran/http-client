<?php
/*  An example code to demonstrate how to use http-client class to send request
* to get Bearer token and then again sending JSON payload with Authorization header
*/

//Step 1 : include http-client
require_once 'http-client.php';
//Step 2 : create object of class Request
$request = new Request;
// Step 3 : Make an OPTIONS request to get Bearer Token and store it for Step 4:
$response= $request->send("https://corednacom.corewebdna.com/assessment-endpoint.php","OPTIONS",array("Content-type"=>"application/json"));
$token = "Bearer ".$response['response_payloads'];
//Step 4 Make a POST Request to Send JSON Payload as associative arrays alongwith Bearer Token in Authorization headers
$response_data= $request->send("https://corednacom.corewebdna.com/assessment-endpoint.php","POST",array("Authorization"=>$token,"Content-type"=>"application/json"),array("name"=>"Vikas Sheoran","email"=>"r.vikassheoran@gmail.com","url"=>"https://github.com/vkeysheoran/http-client.git"));
//Step 5 print resopnse_headers & payloads if any
print_r($response_data['response_payloads']);
print_r($response_data['response_headers']);

?>
