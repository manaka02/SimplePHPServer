<?php
class Util {

    public function sendCurl($url,$type,$headers,$params){
        $curl=curl_init();

        curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        if(strtoupper($type)=='POST'){
            curl_setopt($curl,CURLOPT_POST,1);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$params);
        }else{
            $query=http_build_query($params);
            // var_dump($query);
            //$url.="?".$query;
        }
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
        $result=curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}