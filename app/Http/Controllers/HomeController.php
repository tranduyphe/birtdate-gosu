<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogActivity;
use App\Repositories\QuestRepository;
use App\Models\User;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Validator;
use App\Helpers\GosuApi;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        return redirect(route("home"));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function launch(Request $request)
    {
        $user = $request->user();
        // dump($user);die;
        // gửi thông tin để cập nhật quest:
        $QuestRepository = new QuestRepository();
        $questType = 0;
        $QuestRepository->updateQuest($user, $questType, 1);
        return view('layouts.launch');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home(Request $request)
    {
        $user = $request->user();
        // dump($user);die;
        // gửi thông tin để cập nhật quest:
        $QuestRepository = new QuestRepository();
        $questType = 0;
        $QuestRepository->updateQuest($user, $questType, 1);
        return view('layouts.home');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function quest(Request $request)
    {
        $user = $request->user();
        // gửi thông tin để cập nhật quest:
        $QuestRepository = new QuestRepository();
        $questType = 5;
        $QuestRepository->updateQuest($user, $questType, 1);
        // gửi thông tin để cập nhật quest:
        $questType = 0;
        $QuestRepository->updateQuest($user, $questType, 1);
        return view('layouts.home');
    }
    public function getAccessToken(Request $request)
    {
        $accessToken = $request->session()->get('access_token_client');
        return response()->json(['access_token' => $accessToken]);
    }
    public function getTopFeathers(Request $request)
    {
        $usersWithFeathers = User::select('id', 'name', 'email', 'feathers')
            ->orderBy('feathers', 'desc')
            ->orderBy('id', 'asc') // Sắp xếp tiếp theo id nếu feathers bằng nhau
            ->get();
        $response = [
            "status" => 200,
            "message" => "success",
            "data" => [
                'top_feathers' => $usersWithFeathers
            ],
            "success" => true
        ];
        return response()->json($response);
    }
    public function getLogActivity(Request $request)
    {
        $user = $request->user();
        $logActivities = LogActivity::selectRaw('log_activity.user_id, log_activity.reason, users.name, DATE_FORMAT(log_activity.created_at, "%Y-%m-%d %H:%i:%s") as formatted_created_at')
            ->join('users', 'users.id', '=', 'log_activity.user_id')
            ->where('log_activity.user_id', $user->id)
            ->orderBy('log_activity.id', 'desc')
            ->get();
        // dump($logActivity);die;
        $response = [
            "status" => 200,
            "message" => "success",
            "data" => [
                'log_activity' => $logActivities
            ],
            "success" => true
        ];
        return response()->json($response);
    }

    public function getItem(Request $request)
    {
        $user = $request->user();
        $response = [
            "status" => 200,
            "message" => "success",
            "data" => [
                'diamond' => $user->diamond,
                'feathers' => $user->feathers
            ],
            "success" => true
        ];
        return response()->json($response);
    }
}
