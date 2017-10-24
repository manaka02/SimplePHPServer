<?php
class Expo_util {

    private $ch = null;
    const EXPO_API_URL = 'https://exp.host/--/api/v2/push/send';

    public function sendCurl($params){
        $ch = $this->prepareCurl();
        curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
        $response = $this->executeCurl($ch);

    }

    private function prepareCurl()
    {
        $this->ch = curl_init();
        if (!$this->ch) {
            throw new ExpoException('Could not initialise cURL!');
        }
        var_dump('tonga aty ap prepare curl');

        $ch = $this->ch;
        curl_setopt($ch, CURLOPT_URL, self::EXPO_API_URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json',
            'content-type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return $ch;
    }

    private function executeCurl($ch)
    {
        $response = [
            'body' => curl_exec($ch),
            'status_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE)
        ];

        // return json_decode($response['body'], true)['data'];
    }

    

}