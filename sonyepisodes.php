<?php
include('vendor/rmccue/requests/library/Requests.php');
Requests::register_autoloader();

$headers = array(
    'origin' => 'https://www.sonyliv.com',
    'security_token' => 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpYXQiOjE2MjA0OTU2MDMsImV4cCI6MTYyMTc5MTYwMywiYXVkIjoiKi5zb255bGl2LmNvbSIsImlzcyI6IlNvbnlMSVYiLCJzdWIiOiJzb21lQHNldGluZGlhLmNvbSJ9.KsRRWOEbV9ZLCCugUoqNemLwd17xX0jjPFkhSmttKEv_2dm8nfce6CPhypwivu9AE91AqAsyuOLQlA15HNACGIE6GCYAoPycEUpiwazm16FKH9ba__lt88cscv4i4Y0FaPBM1UM-KVLupa6Cz8KQ1R3uxXMBJzGefJSS62qdq-6f6xvU5s6u29jlDOE9hgQZPAhYOsr5D7FZIds6UU49xZf35t1Cbt0d5_dk59QhXrjAfGhDcYkOlKfONJlO5sR3ah4gJQzCzmYLiXcCVdVTi0t2NaFcmEwAn-xGvwLzwOU0_af1qlnOV1lZjcIw6WTvXCc_BXy2dLUeybiHnEmER7jiZAycsksTTnk8cEaCkqR7NPR1zPBGAIymikqOqtyb3KKZCcq_qfe986BO5QSmi4UkUz5fSMzCEGknookekEbaQE1yRcrrcOeAjYoTEXvvw1ZA1d7Dz5tf_lzXF2ueH3rLkSDvcLMn6Vy2pPpUfETTQ6qy1YJpBifP0eMLV879YM0GjejeFVT3KU8o68ZHtHUldUc6270fuApt--RR-Kq52xMVcQ0hv-Zhj058b8e0oQZixBUELkObO9ojGbQVXGn-MO-Al6fsHizKyhw-8IAWn7s4AZ9pewzlR4ASnuCFL3rK_VTU2LEXZuds4njV33q-KoUUKt6AUu5xL7jr9XU'
);


$fetchUrl = "https://apiv2.sonyliv.com/AGL/1.4/R/ENG/WEB/IN/CONTENT/DETAIL/BUNDLE/".$_GET['id']."?from=0&to=1000&orderBy=episodeNumber&sortOrder=asc";
$response = Requests::post($fetchUrl, $headers);

$data = json_decode($response->body, true);

$data1 = $data['resultObj']['containers'][0]['containers'];
$json = []; //create empty array
foreach ($data1 as $value) {
	$json[] = array(
	"id"=> $value['metadata']['contentId'],
	"title"=>$value['metadata']['title'],
	"description"=>$value['metadata']['longDescription'],
	"link"=> "https://softtv.gq/".$value['metadata']['contentId'],
	"episodeTitle"=>$value['metadata']['episodeTitle'],
	"episodeNumber"=>$value['metadata']['episodeNumber'],
	"thumbnail"=>$value['metadata']['emfAttributes']['thumbnail'],
    "year"=>$value['metadata']['year']
	);
}

$point['data'] = $json;
$point['errorCode'] = 0;
$point['errorMsg'] = '';
$response =  json_encode($point);

$encryption_key = 'fuckyouflixtv3000@fuckyouflixtv3';

$encryption_iv = 'fuckyouflixtv300';

$ciphering = "AES-256-CBC"; 

$encryption = openssl_encrypt($response, $ciphering, $encryption_key, 0, $encryption_iv);

echo $encryption;

?>