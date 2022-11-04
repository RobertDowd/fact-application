<?php 
namespace App\HelperClasses;

use Illuminate\Support\Facades\Cache;

class Curl {
    //CHECK OUT GUZZLE...
    public function curlRequest($cUrl, $postPayload, $cRec) {
		$ch = curl_init ();
        // set options
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 8 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 8 ); // timeout in seconds
        curl_setopt ( $ch, CURLOPT_URL, $cUrl );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
            'Content-Type: application/json',
            'Content-Length: ' . strlen ( $postPayload ), 
            'X-Fungenerators-Api-Secret: ' . env('API_KEY')
    ) );
		if ($cRec) {
			curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, $cRec );
        }
		if ($postPayload) {
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postPayload );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
					'Content-Type: application/json',
                    'Content-Length: ' . strlen ( $postPayload ), 
                    'X-Fungenerators-Api-Secret: ' . 'qCsdDQTBVMFgpt4Su7pqUQeF'
			) );
		}
        $response = curl_exec ( $ch );         
		$errCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
        curl_close ( $ch );
        
		$opArr = array (
				'status' => $errCode,
				'response' => $response 
        );
		return $opArr;
    }

    //Function to GET data from API
    public function getMetaData($apiUrl) 
    {
        $cUrl = $apiUrl;
        $curlResults = $this->curlRequest($cUrl, null, null);
        if($curlResults['status'] === 200) {            
            $lists = json_decode($curlResults['response'], true);
                return $lists;
        }
    }

    public function deleteRequest($cUrl) {
        $curlResponse = $this->curlRequest($cUrl, null, 'DELETE');        
        if ($curlResponse['status'] === 200) {
            return true;
        } else {
            return false;
        }
    }

}