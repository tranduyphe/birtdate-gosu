<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Validator;
use App\Models\User;
use App\Helpers\GosuApi;

class AuthController extends Controller
{
    protected $gosuApi;

    public function __construct(GosuApi $gosuApi)
    {
        $this->gosuApi = $gosuApi;
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if (last(explode("@", $email)) != 'gosu.vn') {
            $results = array(
                'message' => 'Địa chỉ email không chính xác',
                'data' => false,
                'status' => Response::HTTP_UNAUTHORIZED
            );
            return response()->json($results);
        }

        if(Auth::attempt(['email' => $email, 'password' => $password])){
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken($authUser->name)->plainTextToken; 
            $success['name'] =  $authUser->last_name;
            $success['avatar'] =  $authUser->avatar;
            $results = array(
                'message' => 'Đăng nhập thành công.',
                'data' => $success,
                'status' => Response::HTTP_OK
            );
        }else{
            $response = $this->gosuApi->authorize($email, $password);
            $results = [];
            $status = 0;
            if ($response->Code == 1) {
                $token = $response->Data->Token;
                $infoProfile = $this->gosuApi->profile($token);
                if ($infoProfile->Code == 1) {
                    $status = 1;
                    $data = array(
                        'profile_id' => $infoProfile->Data->ProfileId,
                        'name' => current(explode("@", $infoProfile->Data->Email)),
                        'email' => $infoProfile->Data->Email,
                        'password' => bcrypt($password),
                        'avatar' => $infoProfile->Data->AvatarUrl,
                        'first_name' => $infoProfile->Data->FirstName,
                        'last_name' => $infoProfile->Data->LastName,
                    );
                    $this->create($data);
                    if(Auth::attempt(['email' => $request->email, 'password' => $password])){
                        $authUser = Auth::user();
                        $success['token'] =  $authUser->createToken(current(explode("@", $infoProfile->Data->Email)))->plainTextToken; 
                        $success['name'] =  $authUser->last_name;
                        $success['avatar'] =  $authUser->avatar;
                        $results = array(
                            'message' => 'Đăng nhập thành công.',
                            'data' => $success,
                            'status' => Response::HTTP_OK
                        );
                    }
                }
            }

            if ($status == 0){
                $results = array(
                    'message' => 'Mật khẩu không đúng',
                    'data' => false,
                    'status' => Response::HTTP_UNAUTHORIZED
                );
            }
        }
        return response()->json($results);
    }

    public function logout(Request $request)
    {
        Auth()->user()->tokens()->delete();
        $results = array(
            'message' => 'Đăng xuất thành công.',
            'status' => Response::HTTP_OK
        );
        return response()->json($results);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($data)
    {
        $results = User::create($data);
        return $results;
    }
}
