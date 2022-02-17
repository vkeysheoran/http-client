<?php

/**
  * A light-weight HTTP client capable of :
  * Send HTTP requests to the given URL using different methods, such as GET, POST, etc.
  * Send JSON payloads
  * Send custom HTTP headers
  * Retrieve HTTP response payloads
  * Retrieve/parse HTTP response headers
  */
class Request
{
    /*
    * The Main function which takes Request parameters and prepare the http context
    */
    function send($url,$method,$http_headers="",$data = array()){
      //Condition to check if http_headers array is set , Convert to headers if yes.
      if($http_headers !=""){
        $headers = $this->array_to_headers($http_headers);
      }
      // detect the payload type and set to headers and create payload object

           $json_data = json_encode($data);
           if(json_last_error() !== JSON_ERROR_NONE){
             //return the error if any while JSON conversion
             return json_last_error();
           }else{
             $post_payload = $json_data;
           }

       // creates http context option array
      $context_options = array(
        'http' => array(
          'method' => $method,
          'header' => $headers."\r\n".strlen($data),
          'content' => $post_payload
        )
      );
      //print_r($context_options);exit;
      //define http stream context by providing prepared options
      $context = stream_context_create($context_options);
      //call the request execute function to execute the http request and parse the response
      return $this->execute_request($url,$context);

    }
    /* A function to format http request headers from provided headers array in associatuve form
    * In response provide a string formatted according to http headers
    */
    function array_to_headers($headers = array())
    {
      $result = [];
      $delimiter = "\r\n";
      foreach ($headers as $name => $value) {
        $result[]= sprintf("%s: %s", $name, $value);
      }
      return implode($delimiter,$result);
    }
    /* A function execute the stream context and
    * check the response type and provide the output accordingly.
    */
    function execute_request($url,$context){
      $result = @file_get_contents($url,false,$context);
      //throw an exception if any error e.g 4XX , 5XX etc or else return the parsed response
      if($result === false){
        $error = error_get_last();
        return  $error['message'];
      }else{
          $data = json_decode($result,true);
           if(json_last_error() !== JSON_ERROR_NONE){
             $response['response_payloads'] = $result;
             $response['response_headers'] = $http_response_header;
             return $response;
           }else{
             $response['response_payloads'] = $data;
             $response['response_headers'] = $http_response_header;
             return $response;
           }
     }
    }
}



 ?>
