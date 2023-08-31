<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Log;

class GosuApi
{
    protected $appid = 'UA';
    protected $secret = '482222d580dc4b6baf90dc78eca2c46a';
    protected $url = 'https://apis.gosu.vn/'; #http://apis.gosu.vn/
    //protected $url = 'http://localhost:27698/';

    protected function header_authorize(){

        $time = date("YmdHis");
        $sign = md5($this->secret."GsS".$this->appid.$this->secret.$time);
        return array(
            'gss-application:'.$this->appid,
            'gss-time:'.$time,
            'gss-signature:'.$sign
        );
        
    }

     /*
    * POST body DÀNH CHO account/authorize
    */
    protected function POST_body_authorize($body,$get_url){

        $header = $this->header_authorize();
        $url = $this->url.$get_url;
        $data = $this->GosuCurl($header, $body, $url, 'POSTFIELDS');       
        return $data;
    }

    public function authorize($email, $password){
		$body = array('Email' => $email, 'Password' => $password);
        $data = $this->POST_body_authorize($body,'v1/account/authorize');
        return $data;
	}

    // get information profile
    public function profile($token){
        $time = date("YmdHis");
        $sign = md5($this->secret."GsS".$this->appid.$token.$time.$this->secret);
        $header = array(
            'gss-application:'.$this->appid,
            'gss-time:'.$time,
            'gss-signature:'.$sign,
            'gss-token:'.$token
        );

        $url = $this->url.'v1/hrm/employee/profile';

        $data = $this->GosuCurl($header, null, $url, 'GET');
        
        return $data;
    }
    
    // get data from curl
    protected function GosuCurl($header = [], $body = [], $url, $method = 'POSTFIELDS')
    {
        $accept = array(
            'Content-Type: application/json',
            'Accept: application/json',
        );

        $url = str_replace(" ","%20",$url);

        $header = array_merge($header, $accept);

        $data_json = json_encode($body);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL, $url);

        if($method == 'POSTFIELDS'){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        }else if($method == 'POST'){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        }else if($method == 'GET'){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_TIMEOUT, 3600);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3600);


        //Hỗ trợ https
        $ssl = stripos($url,'https://') === 0 ? true : false;
        if ($ssl) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        }

        $server_output = curl_exec ($ch);

        if (curl_error($ch)) {
            Log::channel('daily')->info(date("Y-m-d H:i:s")."-".curl_error($ch)."-".json_encode($header)."- url: ".$url." - server output ".json_decode($server_output)."\n");
        }
        if (!curl_version()['features'] && CURL_VERSION_SSL) {
            Log::channel('daily')->info(date("Y-m-d H:i:s")." SSL is not supported with this cURL installation - ".json_encode($header)."- url: ".$url." - server output ".json_decode($server_output)."\n");
        }

        $res = json_decode($server_output);
        return $res;
    }
}