<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
// use App\Models\Vote;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Cache;
use App\Models\MinigameQuests;
use App\Models\User;
use App\Models\UserInvite;
use App\Models\LogActivity;
use App\Models\LogItem;

use Exception;
use Illuminate\Support\Facades\Log;

use App\Repositories\LogRepository;
use App\Repositories\QuestRepository;

class QuestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('auth');
    }

    // /**
    //  * Show the application dashboard.
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
    // public function index()
    // {
    //     return view('home');
    // }
    // public function getQuests(Request $request)
    // {
    //     $user = $request->user();
    //     $QuestRepository = new QuestRepository();
    //     $getQuest = $QuestRepository->getQuests($user->id);
    //     $response = [
    //         "status" => 200,
    //         "message" => "success",
    //         "data" => [
    //             'quests' => $getQuest
    //         ],
    //         "success" => true
    //     ];
    //     return response()->json($response);
    // }
    
    public function getQuests(Request $request)
    {
        $user = $request->user();
        $QuestRepository = new QuestRepository();
        $getQuest = $QuestRepository->getQuests($user->id);
        $getQuestOrder = [];
        $getQuestOrder[] = $getQuest[0];
        $getQuestOrder[] = $getQuest[3];
        $getQuestOrder[] = $getQuest[4];
        $getQuestOrder[] = $getQuest[5];
        $getQuestOrder[] = $getQuest[1];
        $getQuestOrder[] = $getQuest[2];
        $getQuestOrder[] = $getQuest[6];
        $getQuestOrder[] = $getQuest[7];
        $getQuestOrder[] = $getQuest[8];
        $getQuestOrder[] = $getQuest[9];
        
        $response = [
            "status" => 200,
            "message" => "success",
            "data" => [
                'quests' => $getQuestOrder
            ],
            "success" => true
        ];
        return response()->json($response);
    }
    
    public function invite(Request $request)
    {
        
        $user_name = $request->input('user_name');
        $cacheKey = "cache_flag_invite_" . $user_name;
        if (Cache::get($cacheKey, 0) > 0) {
            $response = [
                "status" => 200,
                "message" => "Request quá nhiều",
                "data" => [],
                "success" => false
            ];
            return response()->json($response);
        }
        Cache::put($cacheKey, 1, now()->addMinutes(5)); // Lưu trong cache trong 5 phút
        $user = $request->user();
        $friendCode = $request->input('user_code');
        $QuestRepository = new QuestRepository();
        $getQuest = $QuestRepository->getQuests($user->id);
        if ($user->user_code == $friendCode) {
            $getQuestOrder = [];
        $getQuestOrder[] = $getQuest[0];
        $getQuestOrder[] = $getQuest[3];
        $getQuestOrder[] = $getQuest[4];
        $getQuestOrder[] = $getQuest[5];
        $getQuestOrder[] = $getQuest[1];
        $getQuestOrder[] = $getQuest[2];
        $getQuestOrder[] = $getQuest[6];
        $getQuestOrder[] = $getQuest[7];
        $getQuestOrder[] = $getQuest[8];
        $getQuestOrder[] = $getQuest[9];
            $response = [
                "status" => 200,
                "message" => "Bạn không thể mời chính mình đi học!",
                "data" => [
                    'quests' => $getQuestOrder
                ],
                "success" => false
            ];
            Cache::forget($cacheKey); // Lưu trong cache trong 5 phút
            return response()->json($response);
        }
        if ($getQuest[1]['current_attempts'] >= $getQuest[1]['total_attempts']) {
            $getQuestOrder = [];
        $getQuestOrder[] = $getQuest[0];
        $getQuestOrder[] = $getQuest[3];
        $getQuestOrder[] = $getQuest[4];
        $getQuestOrder[] = $getQuest[5];
        $getQuestOrder[] = $getQuest[1];
        $getQuestOrder[] = $getQuest[2];
        $getQuestOrder[] = $getQuest[6];
        $getQuestOrder[] = $getQuest[7];
        $getQuestOrder[] = $getQuest[8];
        $getQuestOrder[] = $getQuest[9];
            $response = [
                "status" => 200,
                "message" => "Bạn đã hết Lượt mời đi học!",
                "data" => [
                    'quests' => $getQuestOrder
                ],
                "success" => false
            ];
            Cache::forget($cacheKey); // Lưu trong cache trong 5 phút
            return response()->json($response);
        }
        $friend = User::where('user_code', $friendCode)
            ->first();
        if (!$friend) {
            $getQuestOrder = [];
        $getQuestOrder[] = $getQuest[0];
        $getQuestOrder[] = $getQuest[3];
        $getQuestOrder[] = $getQuest[4];
        $getQuestOrder[] = $getQuest[5];
        $getQuestOrder[] = $getQuest[1];
        $getQuestOrder[] = $getQuest[2];
        $getQuestOrder[] = $getQuest[6];
        $getQuestOrder[] = $getQuest[7];
        $getQuestOrder[] = $getQuest[8];
        $getQuestOrder[] = $getQuest[9];
            $response = [
                "status" => 200,
                "message" => "Không tìm thấy Bạn học này!",
                "data" => [
                    'quests' => $getQuestOrder
                ],
                "success" => false
            ];
            Cache::forget($cacheKey); // Lưu trong cache trong 5 phút
            return response()->json($response);
        }

        $friendInvites = UserInvite::where('friend_id', $friend->id)->whereDate('created_at', Carbon::today())
            ->get()->toArray();
        if (count($friendInvites) >= 10) {
            $getQuestOrder = [];
        $getQuestOrder[] = $getQuest[0];
        $getQuestOrder[] = $getQuest[3];
        $getQuestOrder[] = $getQuest[4];
        $getQuestOrder[] = $getQuest[5];
        $getQuestOrder[] = $getQuest[1];
        $getQuestOrder[] = $getQuest[2];
        $getQuestOrder[] = $getQuest[6];
        $getQuestOrder[] = $getQuest[7];
        $getQuestOrder[] = $getQuest[8];
        $getQuestOrder[] = $getQuest[9];
            $response = [
                "status" => 200,
                "message" => "Phù thủy này đã đi học rồi!",
                "data" => [
                    'quests' => $getQuestOrder
                ],
                "success" => false
            ];
            Cache::forget($cacheKey); // Lưu trong cache trong 5 phút
            return response()->json($response);
        }
        // //check người chơi đã mời hay bạn này trước đó hay chưa:
        $userHasInvitation = false;
        foreach ($friendInvites as $invite) {
            if ($invite['user_id'] === $user->id) {
                $userHasInvitation = true;
                break; // Bạn có thể thoát vòng lặp khi tìm thấy một lời mời từ người dùng.
            }
        }
        if($userHasInvitation){
            $getQuestOrder = [];
        $getQuestOrder[] = $getQuest[0];
        $getQuestOrder[] = $getQuest[3];
        $getQuestOrder[] = $getQuest[4];
        $getQuestOrder[] = $getQuest[5];
        $getQuestOrder[] = $getQuest[1];
        $getQuestOrder[] = $getQuest[2];
        $getQuestOrder[] = $getQuest[6];
        $getQuestOrder[] = $getQuest[7];
        $getQuestOrder[] = $getQuest[8];
        $getQuestOrder[] = $getQuest[9];
            $response = [
                "status" => 200,
                "message" => "Bạn đã mời bạn học này trước đó!",
                "data" => [
                    'quests' => $getQuestOrder
                ],
                "success" => false
            ];
        Cache::forget($cacheKey); // Lưu trong cache trong 5 phút
            return response()->json($response);
        }
        $newInvite = new UserInvite;
        $newInvite->user_id = $user->id;
        $newInvite->friend_id = $friend->id;
        $newInvite->friend_code = $friend->user_code;
        $newInvite->save();
        $questType = 1;
        $QuestRepository->updateQuest($user, $questType, 1);
        $newQuest = $QuestRepository->getQuests($user->id);
        $getQuestOrder = [];
        $getQuestOrder[] = $newQuest[0];
        $getQuestOrder[] = $newQuest[3];
        $getQuestOrder[] = $newQuest[4];
        $getQuestOrder[] = $newQuest[5];
        $getQuestOrder[] = $newQuest[1];
        $getQuestOrder[] = $newQuest[2];
        $getQuestOrder[] = $newQuest[6];
        $getQuestOrder[] = $newQuest[7];
        $getQuestOrder[] = $newQuest[8];
        $getQuestOrder[] = $newQuest[9];
        $response = [
            "status" => 200,
            "message" => "Mời bạn đi học thành công!",
            "data" => [
                'quests' => $getQuestOrder,
            ],
            "success" => true
        ];
        Cache::forget($cacheKey); // Lưu trong cache trong 5 phút
        return response()->json($response);
    }


    public function getReward(Request $request)
    {
        $questId = $request->input('quest_id');
        
        $user_name = $request->input('user_name');
        $cacheKey = "cache_flag_reward_" . $user_name;

        // $cacheFlagReward = Cache::get( $cacheKey, 0);

        // Cache::forget($cacheKey); // Lưu trong cache trong 5 phút
        // die;
        if (Cache::get($cacheKey, 0) > 0) {
            $response = [
                "status" => 200,
                "message" => "Request quá nhiều",
                "data" => [],
                "success" => false
            ];
            return response()->json($response);
        }
        $user = $request->user();
        
        $QuestRepository = new QuestRepository();
        Cache::put($cacheKey, 1, now()->addMinutes(5)); // Lưu trong cache trong 5 phút
        if ($questId !== null) {
            $getQuest = $QuestRepository->getQuests($user->id);
            if($getQuest[$questId] && $getQuest[$questId]['is_reward'] ==1 ){
                Cache::forget($cacheKey); // Lưu trong cache trong 5 phút
                $response = [
                    "status" => 200,
                    "message" => "Đã nhận thưởng trước đó.",
                    "data" => [
                    ],
                    "success" => false
                ];
                return response()->json($response);
            }
            if ($getQuest[$questId] && $getQuest[$questId]['current_attempts'] >= $getQuest[$questId]['total_attempts']) {
                // ghi nhận đã nhận thưởng.
                $getQuest = $QuestRepository->rewardQuest($user, $questId, 1);

                $record = $getQuest[$questId]['diamond_reward'] ?? 0;
                if ($record > 0) {
                    $LogRepository = new LogRepository();
                    $LogRepository->saveLogItem($user, 2, $record, "Nhận thưởng nhiệm vụ " . ($questId + 1));

                    $user->diamond = $user->diamond + $record;
                    $user->save();
                    // lưu lịch sử hoạt động
                    $LogRepository = new LogRepository();
                    $LogRepository->saveLogActivity($user, 2,[['item_id'=>2,'record'=>$record]], "Nhận thưởng nhiệm vụ " . ($questId + 1) . " tại bảng thử thách.");
                }
                Cache::forget($cacheKey); // Lưu trong cache trong 5 phút
                // Cache::forget($cacheKey);
                
                $user->refresh();
                $logActivities = LogActivity::selectRaw('log_activity.user_id, log_activity.reason, log_activity.log_item, users.name, DATE_FORMAT(log_activity.created_at, "%Y-%m-%d %H:%i:%s") as formatted_created_at')
                    ->join('users', 'users.id', '=', 'log_activity.user_id')
                    ->where('log_activity.user_id', $user->id)
                    ->orderBy('log_activity.id', 'desc')
                    // ->limit(30) // Thêm dòng này để giới hạn kết quả thành 30 hàng
                    ->get();
                    $getQuestOrder = [];
        $getQuestOrder[] = $getQuest[0];
        $getQuestOrder[] = $getQuest[3];
        $getQuestOrder[] = $getQuest[4];
        $getQuestOrder[] = $getQuest[5];
        $getQuestOrder[] = $getQuest[1];
        $getQuestOrder[] = $getQuest[2];
        $getQuestOrder[] = $getQuest[6];
        $getQuestOrder[] = $getQuest[7];
        $getQuestOrder[] = $getQuest[8];
        $getQuestOrder[] = $getQuest[9];
        $logTiemLong = LogItem::selectRaw('log_item.user_id, log_item.reason, users.name, DATE_FORMAT(log_item.created_at, "%Y-%m-%d %H:%i:%s") as formatted_created_at')
            ->join('users', 'users.id', '=', 'log_item.user_id')
            ->where('log_item.user_id', $user->id)
            ->where('log_item.item_type', 3) // tìm item tìm long
            // ->limit(30) // Thêm dòng này để giới hạn kết quả thành 30 hàng
            ->first();
                $response = [
                    "status" => 200,
                    "message" => "Bạn đã nhận được " . $record . " Đá mặt trăng",
                    "data" => [
                        'quests' => $getQuestOrder,
                        'user' => $user,
                        'log_activity'=>$logActivities,
                        'log_item'=>$logTiemLong
                    ],
                    "success" => true
                ];
                return response()->json($response);
            } else {
                $getQuest = $QuestRepository->getQuests($user->id);
                Cache::forget($cacheKey); // Lưu trong cache trong 5 phút
                // Cache::forget($cacheKey);
                    $getQuestOrder = [];
                    $getQuestOrder[] = $getQuest[0];
                    $getQuestOrder[] = $getQuest[3];
                    $getQuestOrder[] = $getQuest[4];
                    $getQuestOrder[] = $getQuest[5];
                    $getQuestOrder[] = $getQuest[1];
                    $getQuestOrder[] = $getQuest[2];
                    $getQuestOrder[] = $getQuest[6];
                    $getQuestOrder[] = $getQuest[7];
                    $getQuestOrder[] = $getQuest[8];
                    $getQuestOrder[] = $getQuest[9];
                $response = [
                    "status" => 200,
                    "message" => "Nhiệm vụ chưa hoàn thành.",
                    "data" => [
                        'quests' => $getQuestOrder
                    ],
                    "success" => false
                ];
                return response()->json($response);
            }
        } else {
            // dump("check quest id2");die;
            $getQuest = $QuestRepository->getQuests($user->id);
            // Cache::forget($cacheKey);
            Cache::forget($cacheKey); // Lưu trong cache trong 5 phút
            $getQuestOrder = [];
                    $getQuestOrder[] = $getQuest[0];
                    $getQuestOrder[] = $getQuest[3];
                    $getQuestOrder[] = $getQuest[4];
                    $getQuestOrder[] = $getQuest[5];
                    $getQuestOrder[] = $getQuest[1];
                    $getQuestOrder[] = $getQuest[2];
                    $getQuestOrder[] = $getQuest[6];
                    $getQuestOrder[] = $getQuest[7];
                    $getQuestOrder[] = $getQuest[8];
                    $getQuestOrder[] = $getQuest[9];
            $response = [
                "status" => 200,
                "message" => "success",
                "data" => [
                    'quests' => $getQuestOrder
                ],
                "success" => true
            ];
            return response()->json($response);
        }
    }
    public function activeQuest(Request $request)
    {
        $user = $request->user();
        $QuestRepository = new QuestRepository();
        $questType = $request->input('quest_id');
        $QuestRepository->updateQuest($user, $questType, 1);
    }
    //     $user = $request->user();
    //     $gameId = $request->input('game_id', 0);
    //     if ($gameId > 0) {
    //         // $gameData = Cache::get('data_game_' . $user->id . 'gid' . $gameId);
    //         // if (!$gameData) {
    //         if (true) {
    //             $gameData = Minigame::where("id", $gameId)->where("user_id", $user->id)->first();
    //             $listFlips = json_decode($gameData->list_flips, true);
    //             $dataActionFlip = json_decode($gameData->active_flips, true);
    //             // dump($dataActionFlip);die;
    //             // $choises = $dataActionFlip['choises'];
    //             $waiting = $dataActionFlip['waiting'];
    //             $activeFlips = $dataActionFlip['active_flip'];
    //             $gameStatus = 1;
    //         } else {
    //             // $gameData = json_decode($gameData,true);
    //             // $listFlips = $gameData['list_flips'];
    //             // $dataActionFlip = $gameData['active_flips'];
    //             // // dump($dataActionFlip);die;
    //             // // $choises = $dataActionFlip['choises'];

    //             // $waiting = $dataActionFlip['waiting'];
    //             // $activeFlips = $dataActionFlip['active_flip'];
    //             // $gameStatus = 1;
    //         }
    //         if (!$gameData) {
    //             $response = [
    //                 "status" => 200,
    //                 "message" => "success",
    //                 "data" => [
    //                     'data_flip' => [
    //                         'waiting' => [],
    //                         'active_flip' => [],
    //                         'choises' => [],
    //                         'save_waiting' => []
    //                     ],
    //                     'game_status' => 1
    //                 ],
    //                 "success" => true
    //             ];
    //             return response()->json($response);
    //         }

    //         //check game over
    //         if (count($waiting) >= 6) {
    //             $gameStatus = 0;
    //         }

    //         //check win
    //         // dump($activeFlips);die;
    //         $isWin = true;
    //         foreach ($activeFlips as $element) {
    //             if ($element['active'] < 2) {
    //                 $isWin = false;
    //                 break;
    //             }
    //         }
    //         if ($isWin) {
    //             $gameStatus = 2;
    //         }

    //         $response = [
    //             "status" => 200,
    //             "message" => "success",
    //             "data" => [
    //                 'data_flip' => $dataActionFlip,
    //                 'game_status' => $gameStatus
    //             ],
    //             "success" => true
    //         ];
    //         return response()->json($response);
    //     } else {
    //         $response = [
    //             "status" => 200,
    //             "message" => "success",
    //             "data" => [
    //                 'data_flip' => [],
    //                 'game_status' => 1
    //             ],
    //             "success" => true
    //         ];
    //         return response()->json($response);
    //     }
    // }

    // public function activeFlip(Request $request)
    // {
    //     $user = $request->user();
    //     $gameId = $request->input('game_id');
    //     $id = $request->input('id');

    //     $colors = [
    //         'white',
    //         'blue',
    //         'red',
    //         'green',
    //         'pink',
    //         'orange'
    //     ];
    //     $listFlips = [];
    //     $activeFlips = [];
    //     $choises = [];
    //     $saveWaiting = [];
    //     $waiting = [];

    //     // lấy thông tin flip

    //     // $gameData = Cache::get('data_game_' . $user->id . 'gid' . $gameId);
    //     // if (!$gameData) {
    //     $gameData = Minigame::where("id", $gameId)->where("user_id", $user->id)->first();

    //     if ($gameData) {
    //         $dataActionFlip =  json_decode($gameData['active_flips'], true);
    //         // dump($dataActionFlip);die;
    //         $choises = $dataActionFlip['choises'];
    //         $waiting = $dataActionFlip['waiting'];
    //         $saveWaiting = $dataActionFlip['save_waiting'] ?? [];
    //         $activeFlips = $dataActionFlip['active_flip'];

    //         if ($gameData->flag == 0) {

    //             $gameData->flag = 1;
    //             $gameData->save();

    //             try {
    //                 // Log::info('Đây là một thông báo thông thường.');
    //                 // $a = 10 / 0;
    //                 $listFlips = json_decode($gameData['list_flips'], true);


    //                 $isWin = true;
    //                 foreach ($activeFlips as $element) {
    //                     if ($element['type'] == 0) {
    //                         $isWin = false;
    //                         break;
    //                     }
    //                 }
    //                 if ($isWin) {
    //                     $gameData->flag = 0;
    //                     $gameData->save();
    //                     $gameStatus = 2;
    //                     $response = [
    //                         "status" => 200,
    //                         "message" => "You win",
    //                         "data" => [
    //                             'data_flip' => $dataActionFlip,
    //                             'game_status' => $gameStatus
    //                         ],
    //                         "success" => true
    //                     ];
    //                     return response()->json($response);
    //                 }

    //                 //kiểm tra thắng trò chơi hay chưa
    //                 if (count($waiting) >= 6) {
    //                     $gameData->flag = 0;
    //                     $gameData->save();
    //                     $response = [
    //                         "status" => 200,
    //                         "message" => "game over",

    //                         "data" => [
    //                             'data_flip' => $dataActionFlip,
    //                             'game_status' => 0
    //                         ],
    //                         "success" => true
    //                     ];
    //                     return response()->json($response);
    //                 }

    //                 // xử lý flip

    //                 // 1. add thông tin ô được chọn
    //                 $typeChoise = $listFlips[$id]['type'];
    //                 $choises[] = $id;
    //                 $activeFlips[$id]['active'] = 1;
    //                 $activeFlips[$id]['type'] = $typeChoise;
    //                 $activeFlips[$id]['color'] = $colors[$typeChoise];

    //                 // 2. kiểm tra đã tìm đủ 3 ô cùng mày không
    //                 $count = 0;
    //                 $result = [];
    //                 foreach ($activeFlips as $key => $item) {
    //                     if ($item['type'] == $typeChoise && $item['active'] != 2) {
    //                         $result[] = $key;
    //                         $count++;

    //                         if ($count == 3) {
    //                             break; // Đã lấy đủ 3 phần tử
    //                         }
    //                     }
    //                 }
    //                 if ($count == 3) {
    //                     $activeFlips[$result[0]]['active'] = $activeFlips[$result[1]]['active'] = $activeFlips[$result[2]]['active'] = 2;
    //                     // xoá 1 phần tử của waiting trùng vs type
    //                     // if ($saveWaiting[2] && $saveWaiting[2] == $typeChoise) {
    //                     //     unset($saveWaiting[2]);
    //                     // }
    //                     if (isset($saveWaiting[2]) && $saveWaiting[2] == $typeChoise) {
    //                         unset($saveWaiting[2]);
    //                     }
    //                     if (isset($saveWaiting[1]) && $saveWaiting[1] == $typeChoise) {
    //                         unset($saveWaiting[1]);
    //                     }
    //                     if (isset($saveWaiting[0]) && $saveWaiting[0] == $typeChoise) {
    //                         unset($saveWaiting[0]);
    //                     }

    //                     $saveWaiting = array_values($saveWaiting);

    //                     $index = array_search($typeChoise, $waiting);
    //                     if ($index !== false) {
    //                         unset($waiting[$index]); // Xoá phần tử tại vị trí $index
    //                     }
    //                     $waiting = array_values($waiting);
    //                 } else {
    //                     $saveWaiting[] = $typeChoise;
    //                 }
    //                 if (count($choises) == 3) {
    //                     if ($saveWaiting !== []) {
    //                         $lastValue = end($saveWaiting);
    //                         $waiting[] = $lastValue;
    //                         $saveWaiting = [];
    //                     }
    //                     $choises = [];
    //                 }

    //                 $dataActionFlip = [
    //                     'active_flip' => $activeFlips,
    //                     'choises' =>  $choises,
    //                     'waiting' => $waiting,
    //                     'save_waiting' => $saveWaiting
    //                 ];
    //                 $gameData->active_flips = json_encode($dataActionFlip);
    //                 $gameData->flag = 0;
    //                 // Cache::put('data_game_' . $user->id . 'gid' . $gameId, json_encode(['list_flips' => $listFlips, 'active_flips' => $dataActionFlip]), now()->addMinutes(20));
    //                 $gameData->save();
    //                 // CHECK GAMEOVER
    //                 $isWin = true;
    //                 foreach ($activeFlips as $element) {
    //                     if ($element['active'] < 2) {
    //                         $isWin = false;
    //                         break;
    //                     }
    //                 }
    //                 if ($isWin) {
    //                     $user->diamond = $user->diamond + 10;
    //                     $user->save();
    //                     $response = [
    //                         "status" => 200,
    //                         "message" => "success",
    //                         "data" => [
    //                             'data_flip' => $dataActionFlip,
    //                             'game_status' => 2,
    //                             'user' => $user
    //                         ],
    //                         "success" => true
    //                     ];
    //                     return response()->json($response);
    //                 } elseif (count($waiting) >= 6) {
    //                     $response = [
    //                         "status" => 200,
    //                         "message" => "game over",

    //                         "data" => [
    //                             'data_flip' => $dataActionFlip,
    //                             'game_status' => 0
    //                         ],
    //                         "success" => true
    //                     ];
    //                     return response()->json($response);
    //                 } else {
    //                     $response = [
    //                         "status" => 200,
    //                         "message" => "success",

    //                         "data" => [
    //                             'data_flip' => $dataActionFlip,
    //                             'game_status' => 1
    //                         ],
    //                         "success" => true
    //                     ];
    //                     return response()->json($response);
    //                 }
    //             } catch (Exception $e) {
    //                 // Trả flag về 0 khi xử lý gặp lỗi
    //                 $gameData->flag = 0;
    //                 $gameData->save();

    //                 // Ghi log lỗi
    //                 // Ghi log lỗi với dòng và tên tệp tin
    //                 Log::error('Lỗi: ' . $e->getMessage() . ' trong tệp ' . $e->getFile() . ' tại dòng ' . $e->getLine());
    //                 $response = [
    //                     "status" => 200,
    //                     "message" => "Xử lý lỗi",
    //                     "data" => [
    //                         'data_flip' => $dataActionFlip,
    //                         'game_status' => 1
    //                     ],
    //                     "success" => false
    //                 ];
    //                 return response()->json($response);
    //             }
    //         } else {
    //             $response = [
    //                 "status" => 200,
    //                 "message" => "Thẻ bài cũ chưa lật xong",
    //                 "data" => [
    //                     'data_flip' => $dataActionFlip,
    //                     'game_status' => 1
    //                 ],
    //                 "success" => false
    //             ];
    //             return response()->json($response);
    //         }
    //     } else {
    //         $response = [
    //             "status" => 200,
    //             "message" => "Trò chơi không tồn tại, hãy ấn bắt đầu để tạo trò chơi mới",
    //             "data" => [
    //                 'data_flip' => [],
    //                 'game_status' => 1
    //             ],
    //             "success" => true
    //         ];
    //         return response()->json($response);
    //     }

    //     //check win

    // }


    // public function reloadFlip(Request $request)
    // {
    //     $user = $request->user();
    //     if (!$user || $user->feathers < 5) {
    //         $response = [
    //             "status" => 200,
    //             "message" => "lông vũ đã hết!",
    //             "data" => ['data_flip' => []],
    //             "success" => false
    //         ];
    //         return response()->json($response);
    //     }
    //     // dump($user);die;
    //     $listFlips = [];
    //     $activeFlips = [];
    //     $colors = [
    //         'white',
    //         'blue',
    //         'red',
    //         'green',
    //         'pink',
    //         'orange'
    //     ];
    //     $type = [
    //         1, 1, 1, 1, 1, 1, 1, 1, 1,
    //         2, 2, 2, 2, 2, 2, 2, 2, 2,
    //         3, 3, 3, 3, 3, 3, 3, 3, 3,
    //         4, 4, 4, 4, 4, 4, 4, 4, 4,
    //         5, 5, 5, 5, 5, 5, 5, 5, 5,
    //     ];
    //     shuffle($type);
    //     for ($i = 0; $i < 45; $i++) {
    //         $activeFlips[] = [
    //             'active' => 0,
    //             'type' => 0
    //         ];
    //         $listFlips[] = [
    //             'active' => 0,
    //             'type' => $type[$i]
    //         ];
    //     }
    //     $dataActionFlip = [
    //         'active_flip' => $activeFlips,
    //         'choises' => [],
    //         'waiting' => []
    //     ];

    //     $minigameData = new Minigame([
    //         'user_id' => $user->id,
    //         'list_flips' => json_encode($listFlips),
    //         'active_flips' => json_encode($dataActionFlip),
    //         'flag' => 0
    //     ]);
    //     $user->feathers = $user->feathers - 5;
    //     $user->save();
    //     $minigameData->save();
    //     // Cache::put('data_game_' . $user->id . 'gid' . $minigameData->id, json_encode(['list_flips' => $listFlips, 'active_flips' => $dataActionFlip]), now()->addMinutes(20));

    //     $response = [
    //         "status" => 200,
    //         "message" => "success",
    //         "data" => [
    //             'data_flip' => $dataActionFlip,
    //             'user' => $user,
    //             'game_id' => $minigameData->id
    //         ],
    //         "success" => true
    //     ];
    //     return response()->json($response);
    // }
}
