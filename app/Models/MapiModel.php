<?php

namespace App\Models;

use CodeIgniter\Model;

class MapiModel extends Model
{
    public static function curl_data($params, $type, $postData = null, $bearer = null){
        $url = "https://take-home-test-api.nutech-integrasi.app".$params;

        if($type == "GET"){
            $request = array(
                CURLOPT_CUSTOMREQUEST => $type,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer ".$bearer,
                ),
            );
        }else{
            $request = array(
                CURLOPT_CUSTOMREQUEST => $type,
                CURLOPT_POSTFIELDS => $postData,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer ".$bearer,
                    "accept: application/json"
                ),
                CURLOPT_RETURNTRANSFER => FALSE,
                CURLOPT_SSL_VERIFYPEER => FALSE,
            );
        }
        
        try {
            $curl = curl_init((string) $url);
            curl_setopt_array($curl, $request);
            $result = curl_exec($curl);
            curl_close($curl);


        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        $response = json_decode($result);

        return $response;
    }
}