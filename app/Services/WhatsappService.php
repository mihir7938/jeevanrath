<?php

namespace App\Services;

use App\Models\Whatsapp;

class WhatsappService
{
    public function checkSessionExists($session_id)
    {
        $check_session_id_exists = Whatsapp::where('session_id', $session_id)->exists();
        return $check_session_id_exists;
    }
    public function getWhatsappBySession($session_id)
    {
        return Whatsapp::where('session_id', $session_id)->first();
    }
    public function create($data)
    {
        return Whatsapp::create($data);
    }
    public function update($whatsapp, $data)
    {
        return $whatsapp->update($data);
    }
    public function createSession($session_id){
		$server_url = env('WHATSAPP_HOST'); 
        $url = $server_url.'/create-session';
        $data = '{
                    "sessionId": "'.$session_id.'"
                }';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
    public function getQR($session_id){	
		$server_url = env('WHATSAPP_HOST');
		$url = $server_url.'/qr/'.$session_id;
		$curl = curl_init();		
		curl_setopt_array($curl, array(		  
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,		  
			CURLOPT_ENCODING => '',		  
			CURLOPT_MAXREDIRS => 10,		  
			CURLOPT_TIMEOUT => 0,		  
			CURLOPT_FOLLOWLOCATION => true,		  
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,		  
			CURLOPT_CUSTOMREQUEST => 'GET',		
		));		
		$response = curl_exec($curl);		
		curl_close($curl);
		return $response;
    }
	public function checkStatus($session_id){	
		$server_url = env('WHATSAPP_HOST');
		$url = $server_url.'/check-session/'.$session_id;
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response);
    }
}
