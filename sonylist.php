<?php
include('vendor/rmccue/requests/library/Requests.php');
Requests::register_autoloader();
$microTime = microtime(true);
$st = round($microTime);
$exp = $st + 1296000;
$tok = '{"iat":'.$st.',"exp":'.$exp.',"aud":"*.sonyliv.com","iss":"SonyLIV","sub":"some@setindia.com"}';
$token = base64_encode($tok);

$fulltoken = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.'.$token.'.C2SSiOs0BBNDXe_fgUylEzRD2TCnZ7Wl3wqpSfePEEOeS_hfMvExEv8pCSgMzq7LaFJiEkM0YL1ypWm8ORZvbXuYY0kwj6zYT4ZtLw0gbUVtYQ2s3S53AwKxb2U4-wvdCvdOw6NrTRVA32qUf1moucHn3P-Gl1brztE7XQBbAHC8PbxT39suUxMXhqCBilubGzTXm04bzM8pzJ-2IQ-Yogr7N9TnZwausqLLJszULFm9ua4_HQqvfCapJ6i0yoee5C44tqO4-jv-pZEkvvZA7Tf9G6M8iDxuczGAiTWtAsdSoAytqyJzXrnu99NhOcr9a6TO90JKWqzIBggkQ-Fu9Dgh4JEtqK1xRkgapSAECbpsBhkmqag8nhocDLkWqPv9kNcskWjYNjB0pF5rkqlnBopk6eYqKrB-hv0TJLfF32MRY01naZk2Deh7qn0JlKOU4F2LH1LDqIN-AODxmJ8yDt_WkMzs0uiiMZdmsbApwP7Eu-vAtYXTQcVyR61-tbZYXF1SHEZvdGv0IFy_A6UViUPjlc8FhmL_g5JEMPjM1kmiIEXeQV27pCcxZLIzKL0-Bhl_kHnznXmPirUHbeZyyKThn_CoI-jagW2iEotvglzNTjfz_7rtiIuwtQVKgpEd15DHA84_MoNgSzgrmyp1VSeYi8fUu-3F6D1sJOXCxQQ';

$headers = array(
    'origin' => 'https://www.sonyliv.com',
    'security_token' => 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpYXQiOjE2MjA0OTU2MDMsImV4cCI6MTYyMTc5MTYwMywiYXVkIjoiKi5zb255bGl2LmNvbSIsImlzcyI6IlNvbnlMSVYiLCJzdWIiOiJzb21lQHNldGluZGlhLmNvbSJ9.KsRRWOEbV9ZLCCugUoqNemLwd17xX0jjPFkhSmttKEv_2dm8nfce6CPhypwivu9AE91AqAsyuOLQlA15HNACGIE6GCYAoPycEUpiwazm16FKH9ba__lt88cscv4i4Y0FaPBM1UM-KVLupa6Cz8KQ1R3uxXMBJzGefJSS62qdq-6f6xvU5s6u29jlDOE9hgQZPAhYOsr5D7FZIds6UU49xZf35t1Cbt0d5_dk59QhXrjAfGhDcYkOlKfONJlO5sR3ah4gJQzCzmYLiXcCVdVTi0t2NaFcmEwAn-xGvwLzwOU0_af1qlnOV1lZjcIw6WTvXCc_BXy2dLUeybiHnEmER7jiZAycsksTTnk8cEaCkqR7NPR1zPBGAIymikqOqtyb3KKZCcq_qfe986BO5QSmi4UkUz5fSMzCEGknookekEbaQE1yRcrrcOeAjYoTEXvvw1ZA1d7Dz5tf_lzXF2ueH3rLkSDvcLMn6Vy2pPpUfETTQ6qy1YJpBifP0eMLV879YM0GjejeFVT3KU8o68ZHtHUldUc6270fuApt--RR-Kq52xMVcQ0hv-Zhj058b8e0oQZixBUELkObO9ojGbQVXGn-MO-Al6fsHizKyhw-8IAWn7s4AZ9pewzlR4ASnuCFL3rK_VTU2LEXZuds4njV33q-KoUUKt6AUu5xL7jr9XU'
);
$response = Requests::get('https://apiv2.sonyliv.com/AGL/2.2/A/ENG/WEB/IN/DL/PAGE/'.$_GET['id'], $headers);

$data = json_decode($response->body, true);

$data1 = $data['resultObj']['containers'][0]['assets']['containers'];
$json = []; //create empty array
foreach ($data1 as $value) {
	$json[] = array(
	"id"=>$value['metadata']['contentId'],
	"title"=>$value['metadata']['title'],
	"description"=>$value['metadata']['longDescription'],
	"thumbnail"=>$value['metadata']['emfAttributes']['thumbnail'],
	"portrait_thumb"=>$value['metadata']['emfAttributes']['portrait_thumb'],
	"language"=>$value['metadata']['language'],
	"pcVodLabel"=>$value['metadata']['pcVodLabel'],
	"genres"=>$value['metadata']['genres'],
	"type"=>$value['metadata']['objectSubtype']
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