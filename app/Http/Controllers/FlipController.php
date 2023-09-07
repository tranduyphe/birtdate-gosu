<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// use App\Models\Vote;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Cache;
use App\Models\Minigame;
use App\Models\LogItem;
use App\Models\LogActivity;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Repositories\QuestRepository;
use App\Repositories\LogRepository;

class FlipController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('throttle.activeflip')->only('activeFlip');
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
    public function getFlip(Request $request)
    {

        $user = $request->user();

        $gameId = $request->input('game_id', 0);
        if ($gameId > 0) {
            // $gameData = Cache::get('data_game_' . $user->id . 'gid' . $gameId);
            // if (!$gameData) {
            if (true) {
                $gameData = Minigame::where("id", $gameId)->where("user_id", $user->id)->first();
            } else {
                // $gameData = json_decode($gameData,true);
                // $listFlips = $gameData['list_flips'];
                // $dataActionFlip = $gameData['active_flips'];
                // // dump($dataActionFlip);die;
                // // $choises = $dataActionFlip['choises'];

                // $waiting = $dataActionFlip['waiting'];
                // $activeFlips = $dataActionFlip['active_flip'];
                // $gameStatus = 1;
            }
            if (!$gameData) {
                $response = [
                    "status" => 200,
                    "message" => "success",
                    "data" => [
                        'data_flip' => [
                            'waiting' => [],
                            'active_flip' => [],
                            'choises' => [],
                            'save_waiting' => []
                        ],
                        'game_status' => 1
                    ],
                    "success" => true
                ];
                return response()->json($response);
            }

            $listFlips = json_decode($gameData->list_flips, true);
            $dataActionFlip = json_decode($gameData->active_flips, true);
            // dump($dataActionFlip);die;
            // $choises = $dataActionFlip['choises'];
            $waiting = $dataActionFlip['waiting'];
            $activeFlips = $dataActionFlip['active_flip'];
            $gameStatus = 1;
            //check game over
            if (count($waiting) >= 6) {
                $gameStatus = 0;
            }

            //check win
            // dump($activeFlips);die;
            $isWin = true;
            foreach ($activeFlips as $element) {
                if ($element['active'] < 2) {
                    $isWin = false;
                    break;
                }
            }
            if ($isWin) {
                $gameStatus = 2;
            }

            $response = [
                "status" => 200,
                "message" => "success",
                "data" => [
                    'data_flip' => $dataActionFlip,
                    'game_status' => $gameStatus
                ],
                "success" => true
            ];
            return response()->json($response);
        } else {
            $response = [
                "status" => 200,
                "message" => "success",
                "data" => [
                    'data_flip' => [],
                    'game_status' => 1
                ],
                "success" => true
            ];
            return response()->json($response);
        }
    }

    public function activeFlip(Request $request)
    {
        $user = $request->user();
        $gameId = $request->input('game_id');
        $id = $request->input('id');

        $colors = [
            'white',
            'blue',
            'red',
            'green',
            'pink',
            'orange'
        ];
        $listFlips = [];
        $activeFlips = [];
        $choises = [];
        $saveWaiting = [];
        $waiting = [];

        // lấy thông tin flip

        // $gameData = Cache::get('data_game_' . $user->id . 'gid' . $gameId);
        // if (!$gameData) {
        $gameData = Minigame::where("id", $gameId)->where("user_id", $user->id)->first();

        if ($gameData) {
            $dataActionFlip =  json_decode($gameData['active_flips'], true);
            // dump($dataActionFlip);die;
            $choises = $dataActionFlip['choises'];
            $waiting = $dataActionFlip['waiting'];
            $saveWaiting = $dataActionFlip['save_waiting'] ?? [];
            $activeFlips = $dataActionFlip['active_flip'];

            if ($gameData->flag == 0) {

                $gameData->flag = 1;
                $gameData->save();

                try {
                    // Log::info('Đây là một thông báo thông thường.');
                    // $a = 10 / 0;
                    $listFlips = json_decode($gameData['list_flips'], true);


                    $isWin = true;
                    foreach ($activeFlips as $element) {
                        if ($element['type'] == 0) {
                            $isWin = false;
                            break;
                        }
                    }
                    if ($isWin) {
                        $gameData->flag = 0;
                        $gameData->save();
                        $gameStatus = 2;
                        $response = [
                            "status" => 200,
                            "message" => "You win",
                            "data" => [
                                'data_flip' => $dataActionFlip,
                                'game_status' => $gameStatus
                            ],
                            "success" => true
                        ];
                        return response()->json($response);
                    }

                    //kiểm tra thắng trò chơi hay chưa
                    if (count($waiting) >= 6) {
                        $gameData->flag = 0;
                        $gameData->save();
                        $response = [
                            "status" => 200,
                            "message" => "game over",

                            "data" => [
                                'data_flip' => $dataActionFlip,
                                'game_status' => 0
                            ],
                            "success" => true
                        ];
                        return response()->json($response);
                    }

                    // xử lý flip

                    // 1. add thông tin ô được chọn
                    $typeChoise = $listFlips[$id]['type'];
                    $choises[] = $id;
                    $activeFlips[$id]['active'] = 1;
                    $activeFlips[$id]['type'] = $typeChoise;
                    $activeFlips[$id]['color'] = $colors[$typeChoise];

                    // 2. kiểm tra đã tìm đủ 3 ô cùng mày không
                    $count = 0;
                    $result = [];
                    foreach ($activeFlips as $key => $item) {
                        if ($item['type'] == $typeChoise && $item['active'] != 2) {
                            $result[] = $key;
                            $count++;

                            if ($count == 3) {
                                break; // Đã lấy đủ 3 phần tử
                            }
                        }
                    }
                    if ($count == 3) {
                        $activeFlips[$result[0]]['active'] = $activeFlips[$result[1]]['active'] = $activeFlips[$result[2]]['active'] = 2;
                        // xoá 1 phần tử của waiting trùng vs type
                        // if ($saveWaiting[2] && $saveWaiting[2] == $typeChoise) {
                        //     unset($saveWaiting[2]);
                        // }
                        if (isset($saveWaiting[2]) && $saveWaiting[2] == $typeChoise) {
                            unset($saveWaiting[2]);
                        }
                        if (isset($saveWaiting[1]) && $saveWaiting[1] == $typeChoise) {
                            unset($saveWaiting[1]);
                        }
                        if (isset($saveWaiting[0]) && $saveWaiting[0] == $typeChoise) {
                            unset($saveWaiting[0]);
                        }

                        $saveWaiting = array_values($saveWaiting);

                        $index = array_search($typeChoise, $waiting);
                        if ($index !== false) {
                            unset($waiting[$index]); // Xoá phần tử tại vị trí $index
                        }
                        $waiting = array_values($waiting);
                    } else {
                        $saveWaiting[] = $typeChoise;
                    }
                    if (count($choises) == 3) {
                        if ($saveWaiting !== []) {
                            $lastValue = end($saveWaiting);
                            $waiting[] = $lastValue;
                            $saveWaiting = [];
                        }
                        $choises = [];
                    }

                    $dataActionFlip = [
                        'active_flip' => $activeFlips,
                        'choises' =>  $choises,
                        'waiting' => $waiting,
                        'save_waiting' => $saveWaiting
                    ];
                    $gameData->active_flips = json_encode($dataActionFlip);
                    $gameData->flag = 0;
                    // Cache::put('data_game_' . $user->id . 'gid' . $gameId, json_encode(['list_flips' => $listFlips, 'active_flips' => $dataActionFlip]), now()->addMinutes(20));
                    $gameData->save();
                    // CHECK GAMEOVER
                    $isWin = true;
                    foreach ($activeFlips as $element) {
                        if ($element['active'] < 2) {
                            $isWin = false;
                            break;
                        }
                    }
                    if ($isWin) {
                        $this->winGameReward($user,10);
                        // $user->feathers = $user->feathers + 10;
                        // $user->save();
                        // gửi thông tin để cập nhật quest:
                        // $QuestRepository = new QuestRepository();
                        // $questType = 4;
                        // $QuestRepository->updateQuest($user, $questType, 1);


                        $response = [
                            "status" => 200,
                            "message" => "success",
                            "data" => [
                                'data_flip' => $dataActionFlip,
                                'game_status' => 2,
                                'user' => $user
                            ],
                            "success" => true
                        ];
                        return response()->json($response);
                    } elseif (count($waiting) >= 6) {
                        $response = [
                            "status" => 200,
                            "message" => "game over",

                            "data" => [
                                'data_flip' => $dataActionFlip,
                                'game_status' => 0
                            ],
                            "success" => true
                        ];
                        return response()->json($response);
                    } else {
                        $response = [
                            "status" => 200,
                            "message" => "success",

                            "data" => [
                                'data_flip' => $dataActionFlip,
                                'game_status' => 1
                            ],
                            "success" => true
                        ];
                        return response()->json($response);
                    }
                } catch (Exception $e) {
                    // Trả flag về 0 khi xử lý gặp lỗi
                    $gameData->flag = 0;
                    $gameData->save();

                    // Ghi log lỗi
                    // Ghi log lỗi với dòng và tên tệp tin
                    Log::error('Lỗi: ' . $e->getMessage() . ' trong tệp ' . $e->getFile() . ' tại dòng ' . $e->getLine());
                    $response = [
                        "status" => 200,
                        "message" => "Xử lý lỗi",
                        "data" => [
                            'data_flip' => $dataActionFlip,
                            'game_status' => 1
                        ],
                        "success" => false
                    ];
                    return response()->json($response);
                }
            } else {
                $response = [
                    "status" => 200,
                    "message" => "Thẻ bài cũ chưa lật xong",
                    "data" => [
                        'data_flip' => $dataActionFlip,
                        'game_status' => 1
                    ],
                    "success" => false
                ];
                return response()->json($response);
            }
        } else {
            $response = [
                "status" => 200,
                "message" => "Trò chơi không tồn tại, hãy ấn bắt đầu để tạo trò chơi mới",
                "data" => [
                    'data_flip' => [],
                    'game_status' => 1
                ],
                "success" => true
            ];
            return response()->json($response);
        }

        //check win

    }
    public function winGameReward($user,$record){
        // save history 
        $this->saveLogItem($user,1,$record,"chiến thắng thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.");
        // $newLog = new LogItem();
        // $newLog->user_id = $user->id;  // Thiết lập user_id cho quest mới
        // $newLog->old = $user->feathers;
        // $newLog->new = $user->feathers + $record;
        // $newLog->reason = "chiến thắng thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.";
        // $newLog->save();

        $user->feathers = $user->feathers + $record;
        $user->save();
        // gửi thông tin để cập nhật quest:
        $QuestRepository = new QuestRepository();
        $questType = 4;
        $QuestRepository->updateQuest($user, $questType, 1);

    }
    public function saveLogItem($user,$itemType,$record,$reason){
        // save history 
        $LogRepository = new LogRepository();
        $LogRepository->saveLogItem($user,$itemType,$record,$reason);
        // $newLog = new LogItem();
        // $newLog->user_id = $user->id;  // Thiết lập user_id cho quest mới
        
        // if($itemType == 1){
        //     $newLog->old = $user->feathers;
        //     $newLog->new = $user->feathers + $record;
        // }elseif($itemType == 2){
        //     $newLog->old = $user->diamond;
        //     $newLog->new = $user->diamond + $record;
        // }
        
        // $newLog->item_type = $itemType;
        // $newLog->reason = $reason;
        // $newLog->save();
    }
    public function saveLogActivity($user,$activityType,$reason){
        // save history 
        $LogRepository = new LogRepository();
        $LogRepository->saveLogActivity($user,$activityType,$reason);
        // $newLog = new LogActivity();
        // $newLog->user_id = $user->id;  // Thiết lập user_id cho quest mới
        
        // $newLog->type = $activityType;
        // $newLog->reason = $reason;
        // $newLog->save();
    }


    public function reloadFlip(Request $request)
    {
        $user = $request->user();

        if (!$user || $user->diamond < 5) {
            $response = [
                "status" => 200,
                "message" => "lông vũ đã hết!",
                "data" => ['data_flip' => []],
                "success" => false
            ];
            return response()->json($response);
        }
        // dump($user);die;
        $listFlips = [];
        $activeFlips = [];
        $colors = [
            'white',
            'blue',
            'red',
            'green',
            'pink',
            'orange'
        ];
        $type = [
            1, 1, 1, 1, 1, 1, 1, 1, 1,
            2, 2, 2, 2, 2, 2, 2, 2, 2,
            3, 3, 3, 3, 3, 3, 3, 3, 3,
            4, 4, 4, 4, 4, 4, 4, 4, 4,
            5, 5, 5, 5, 5, 5, 5, 5, 5,
        ];
        shuffle($type);
        for ($i = 0; $i < 45; $i++) {
            $activeFlips[] = [
                'active' => 0,
                'type' => 0
            ];
            $listFlips[] = [
                'active' => 0,
                'type' => $type[$i]
            ];
        }
        $dataActionFlip = [
            'active_flip' => $activeFlips,
            'choises' => [],
            'waiting' => []
        ];

        $minigameData = new Minigame([
            'user_id' => $user->id,
            'list_flips' => json_encode($listFlips),
            'active_flips' => json_encode($dataActionFlip),
            'flag' => 0
        ]);
        
        $this->saveLogItem($user,2,-5,"Tham gia thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.");
        $this->saveLogActivity($user,2,"Tham gia thử thách Bài Trùng tại Nhà Thi Đấu Xoẹt Xoẹt.");
        $user->diamond = $user->diamond - 5;
        $user->save();
        $minigameData->save();
        // Cache::put('data_game_' . $user->id . 'gid' . $minigameData->id, json_encode(['list_flips' => $listFlips, 'active_flips' => $dataActionFlip]), now()->addMinutes(20));

        // hoàn thành nhiệm vụ: 3
        $QuestRepository = new QuestRepository();
        $questType = 3;
        $QuestRepository->updateQuest($user, $questType, 1);

        $response = [
            "status" => 200,
            "message" => "success",
            "data" => [
                'data_flip' => $dataActionFlip,
                'user' => $user,
                'game_id' => $minigameData->id
            ],
            "success" => true
        ];
        return response()->json($response);
    }

    //mở quà thư viện toàn tri
    public function activeFlipTvtt(Request $request)
    {
        $user = $request->user();

        if (!$user || $user->diamond < 5) {
            $response = [
                "status" => 200,
                "message" => "lông vũ đã hết!",
                "data" => ['data_flip' => []],
                "success" => false
            ];
            return response()->json($response);
        }
        $this->saveLogItem($user,2,-5,"Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.");
        $this->saveLogActivity($user,2,"Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.");
        $user->diamond = $user->diamond - 5;
        $user->save();

        $itemRandom = [
            [
                'item'=> [['item_id'=>1,'record'=>1]],
                'weight'=>200
            ],
            [
                'item'=> [['item_id'=>1,'record'=>5]],
                'weight'=>200
            ],
            [
                'item'=> [['item_id'=>1,'record'=>10]],
                'weight'=>100
            ],
            [
                'item'=> [['item_id'=>2,'record'=>1]],
                'weight'=>200
            ],
            [
                'item'=> [['item_id'=>2,'record'=>5]],
                'weight'=>200
            ],
            [
                'item'=> [['item_id'=>2,'record'=>10]],
                'weight'=>100
            ],
        ];
        $totalWeight = 0;
        $randomWeight = rand(1, 1000);
        $listItems = [];
        foreach ($itemRandom as $element) {
            $totalWeight = $totalWeight + $element['weight'];
            if ($totalWeight >=$randomWeight) {
                $listItems = $element['item'];
                break;
            }
        }
        foreach ($listItems as $element) {
            if($element['record']>0){
                
                $this->saveLogItem($user,$element['item_id'],$element['record'],"Tham gia thử thách Tích Kỳ tại Thư Viện Toàn Tri.");
                if($element['item_id'] == 1){
                    $user->feathers = $user->feathers + $element['record'];
                }
                if($element['item_id'] == 2){
                    $user->diamond = $user->diamond + $element['record'];
                }
            }
            $user->save();
        }

        $response = [
            "status" => 200,
            "message" => "success",
            "data" => [
                'user' => $user,
                'reward' => $listItems
            ],
            "success" => true
        ];
        return response()->json($response);

    }
}
