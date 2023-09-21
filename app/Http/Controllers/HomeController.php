<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogActivity;
use App\Repositories\QuestRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Validator;
use App\Helpers\GosuApi;
use App\Models\LogItem;

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
        if ($user) {
            // dump($user);die;
            // gửi thông tin để cập nhật quest:
            $QuestRepository = new QuestRepository();
            $questType = 0;
            $QuestRepository->updateQuest($user, $questType, 1);
        }
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
        if ($user) {
            // dump($user);die;
            // gửi thông tin để cập nhật quest:
            $QuestRepository = new QuestRepository();
            $questType = 0;
            $QuestRepository->updateQuest($user, $questType, 1);
        }
        return view('layouts.launch');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function quest(Request $request)
    {
        $user = $request->user();
        if ($user) {
            // gửi thông tin để cập nhật quest:
            $QuestRepository = new QuestRepository();
            $questType = 5;
            $QuestRepository->updateQuest($user, $questType, 1);
            // gửi thông tin để cập nhật quest:
            $questType = 0;
            $QuestRepository->updateQuest($user, $questType, 1);
        }

        return view('layouts.launch');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDataSanhTruongHopHep(Request $request)
    {
        $result = User::leftJoin('sanh_hop_hep', 'users.id', '=', 'sanh_hop_hep.user_id')
            ->select('users.id', DB::raw('COALESCE(sanh_hop_hep.is_open, 0) as is_open'))
            ->orderBy('users.id')
            ->get()->toArray();
        $data = [];
        for ($i = 0; $i < 198; $i++) {

            
            $data[] = [
                "user_id" => 0,
                "is_open" => 1
            ];
            // if (!empty($result[$i])) {
            //     $data[] = [
            //         "user_id" => $result[$i]['id'],
            //         "is_open" => $result[$i]['is_open']
            //     ];
            // } else {
            //     $data[] = [
            //         "user_id" => 0,
            //         "is_open" => 0
            //     ];
            // }
        }
        $response = [
            "status" => 200,
            "message" => "success",
            "data" => $data,
            "success" => true
        ];
        return response()->json($response);
    }

    // public function getAccessToken(Request $request)
    // {
    //     $accessToken = $request->session()->get('access_token_client');
    //     return response()->json(['access_token' => $accessToken]);
    // }
    public function getTopFeathers(Request $request)
    {
        $usersWithFeathers = User::select('id', 'name', 'first_name', 'last_name', 'email', 'feathers', 'avatar')
            ->orderBy('feathers', 'desc')
            ->orderBy('id', 'asc') // Sắp xếp tiếp theo id nếu feathers bằng nhau
            ->limit(10)
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
        $logTiemLong = LogItem::selectRaw('log_item.user_id, log_item.reason, users.name, DATE_FORMAT(log_item.created_at, "%Y-%m-%d %H:%i:%s") as formatted_created_at')
            ->join('users', 'users.id', '=', 'log_item.user_id')
            ->where('log_item.user_id', $user->id)
            ->where('log_item.item_type', 3) // tìm item tìm long
            // ->limit(30) // Thêm dòng này để giới hạn kết quả thành 30 hàng
            ->first();
            // dump($logTiemLong);die;
        $logActivities = LogActivity::selectRaw('log_activity.user_id, log_activity.reason, log_activity.log_item, users.name, DATE_FORMAT(log_activity.created_at, "%Y-%m-%d %H:%i:%s") as formatted_created_at')
            ->join('users', 'users.id', '=', 'log_activity.user_id')
            ->where('log_activity.user_id', $user->id)
            ->orderBy('log_activity.id', 'desc')
            // ->limit(30) // Thêm dòng này để giới hạn kết quả thành 30 hàng
            ->get();
        // dump($logActivity);die;
        $response = [
            "status" => 200,
            "message" => "success",
            "data" => [
                'log_activity' => $logActivities,
                'log_item'=> $logTiemLong
            ],
            "success" => true
        ];
        return response()->json($response);
    }

    public function getItem(Request $request)
    {
        $user = $request->user();
        $diamond = 0;
        if ($user) {
            $diamond =  $user->diamond;
            $feathers = $user->feathers;
            $readInstructions = $user->read_instructions;
        }
        $response = [
            "status" => 200,
            "message" => "success",
            "data" => [
                'diamond' => $diamond,
                'feathers' => $feathers,
                'read_instructions' => $readInstructions
            ],
            "success" => true
        ];
        return response()->json($response);
    }

    public function doneInstructions(Request $request)
    {
        $user = $request->user();
        $user->read_instructions = 1;
        $user->save();
        $response = [
            "status" => 200,
            "message" => "success",
            "data" => [],
            "success" => true
        ];
        return response()->json($response);
    }
}
