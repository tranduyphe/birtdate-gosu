<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

//use GosuApi;
use App\Helpers\GosuApi;
class LoginController extends Controller
{
    
    protected $gosuApi;

    public function __construct(GosuApi $gosuApi)
    {
        $this->gosuApi = $gosuApi;
    }
    
    public function index()
    {
        $email = 'phe.tran@gosu.vn';
        $password = 'duyphe123!@#';
        $response = $this->gosuApi->authorize($email, $password);
        $results = [];
        $status = 0;
        if ($response->Code == 1) {
            $token = $response->Data->Token;
            $infoProfile = $this->gosuApi->profile($token);
            if ($infoProfile->Code == 1) {
                $status = 1;
                $results = array(
                    'message' => 'Đăng nhập thành công.',
                    'data' => $infoProfile->Data,
                    'status' => Response::HTTP_OK
                );
            }
        }

        if ($status == 0){
            $results = array(
                'message' => 'Đăng nhập không thành công.',
                'data' => false,
                'status' => Response::HTTP_UNAUTHORIZED
            );
        }
        return response()->json($results);
    }
}
