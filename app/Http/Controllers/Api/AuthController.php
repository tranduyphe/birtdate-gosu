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
            $success['name'] =  $authUser->name;
            $success['avatar'] =  $authUser->avatar;
            $success['user_code'] =  $authUser->user_code;
            $success['fullname'] =  $authUser->first_name.' '.$authUser->last_name;
            $success['profile_id'] =  $authUser->profile_id;
            $success['user_id'] =  $authUser->id;
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
                        'user_code' => $this->generateUniqueUserCode(),
                        'fullname' =>  $infoProfile->Data->FirstName.' '.$infoProfile->Data->LastName,
                    );
                    $this->create($data);
                    if(Auth::attempt(['email' => $request->email, 'password' => $password])){
                        $authUser = Auth::user();
                        $success['token'] =  $authUser->createToken(current(explode("@", $infoProfile->Data->Email)))->plainTextToken; 
                        $success['name'] = $authUser->name;
                        $success['avatar'] =  $authUser->avatar;
                        $success['user_code'] =  $authUser->user_code;
                        $success['fullname'] =  $authUser->first_name.' '.$authUser->last_name;
                        $success['profile_id'] =  $authUser->profile_id;
                        $success['user_id'] =  $authUser->id;
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
        //dd($request->json()->get('headers')['Authorization']);// get token
        Auth()->user()->tokens()->delete();
        $data['logout'] = true;
        $results = array(
            'message' => 'Đăng xuất thành công.',
            'data' => $data,
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
    function generateUniqueUserCode() {
        $code = $this->generateCode(); // Hàm generateCode() để tạo mã mới
        
        // Kiểm tra xem mã đã tồn tại trong cơ sở dữ liệu hay chưa
        $userWithCode = User::where('user_code', $code)->first();        
        // Lặp lại cho đến khi tìm được mã không trùng
        while ($userWithCode) {
            $code = $this->generateCode();
            $userWithCode = User::where('user_code', $code)->first();
        }
        
        return $code;
    }
    
    function generateCode() {
        // Đây là nơi bạn thực hiện logic để tạo mã mới, ví dụ:
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';

        for ($i = 0; $i < 8; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $code;
    }
}
