<?php

namespace App\Repositories;

use App\Models\MinigameQuests;
use Illuminate\Support\Carbon;
use App\Models\LogActivity;
use App\Models\UserInvite;
use App\Repositories\LogRepository;

class QuestRepository
{
    protected $listQuest = [];

    public function __construct()
    {
        // Khởi tạo danh sách mảng ở đây hoặc bạn có thể gán giá trị mặc định
        $this->listQuest = [
            [
                'name' => 'Điểm danh đến trường hàng ngày 1',
                'type' => '0',
                'total_attempts' => 1,
                'current_attempts' => 0,
                'is_reward' => 0,
                'diamond_reward' => 5
            ],
            [
                'name' => 'Mời 10 phù thủy đi học chung',
                'type' => '1',
                'total_attempts' => 10,
                'current_attempts' => 0,
                'is_reward' => 0,
                'diamond_reward' => 10
            ],
            [
                'name' => 'Được 10 phù thủy khác nhau rủ đi học chung',
                'type' => '2',
                'total_attempts' => 10,
                'current_attempts' => 0,
                'is_reward' => 0,
                'diamond_reward' => 10
            ],
            [
                'name' => 'Tham gia lớp thể thao phù thủy tại Nhà Thi Đấu Xoẹt Xoẹt mỗi ngày',
                'type' => '3',
                'total_attempts' => 1,
                'current_attempts' => 0,
                'is_reward' => 0,
                'diamond_reward' => 5
            ],
            [
                'name' => 'Chiến thắng thử thách tại Nhà Thi Đấu Xoẹt Xoẹt',
                'type' => '4',
                'total_attempts' => 3,
                'current_attempts' => 0,
                'is_reward' => 0,
                'diamond_reward' => 15
            ],
            [
                'name' => 'Ghé thăm Thư Viện Toàn Tri mỗi ngày',
                'type' => '5',
                'total_attempts' => 1,
                'current_attempts' => 0,
                'is_reward' => 0,
                'diamond_reward' => 5
            ],
            [
                'name' => 'Hoàn thành 6 nhiệm vụ đầu tiên',
                'type' => '6',
                'total_attempts' => 1,
                'current_attempts' => 0,
                'is_reward' => 0,
                'diamond_reward' => 5
            ],
            [
                'name' => 'Thu thập được 5 lông kỳ lân/ngày',
                'type' => '7',
                'total_attempts' => 5,
                'current_attempts' => 0,
                'is_reward' => 0,
                'diamond_reward' => 5
            ],
            [
                'name' => 'Thu thập được 15 lông kỳ lân/ngày',
                'type' => '8',
                'total_attempts' => 15,
                'current_attempts' => 0,
                'is_reward' => 0,
                'diamond_reward' => 5
            ],
            [
                'name' => 'Thắp sáng 1 mảnh mosaic ở  sảnh trường bằng cách điểm danh 3 ngày liên tiếp ',
                'type' => '9',
                'total_attempts' => 1,
                'current_attempts' => 0,
                'is_reward' => 0,
                'diamond_reward' => 10
            ],
            // Thêm các quest khác tùy ý
        ];
    }

    public function getQuests($userId)
    {
        $questData = MinigameQuests::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->first();
            // dump( Carbon::today());
            // dump($questData);die;
        if ($questData) {
            // tìm dữ liệu được mời của bản thân

            $quests = json_decode($questData->quests, true);
            $count = UserInvite::where('friend_id', $userId)
                ->whereDate('created_at', Carbon::today())
                ->count();
            if ($quests[2]["current_attempts"] < $quests[2]["total_attempts"] && $quests[2]["current_attempts"] < $count) {
                $quests[2]["current_attempts"] = $count;
                $questData->quests =  json_encode($quests);
                $questData->save();
            }
        } else {
            $newQuest = new MinigameQuests();
            $newQuest->user_id = $userId;  // Thiết lập user_id cho quest mới
            $newQuest->quests = json_encode($this->listQuest);
            $newQuest->save();
            $quests = $this->listQuest;
        }
        return  $quests;
    }


    public function updateQuest($user, $questType, $record)
    {
        $userId = $user->id;
        $questData = MinigameQuests::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if (!$questData) {
            $questData = new MinigameQuests();
            $questData->user_id = $userId;  // Thiết lập user_id cho quest mới
            $questData->quests = json_encode($this->listQuest);
            $questData->save();
        }
        $listQuest = json_decode($questData->quests, true);
        // dump($listQuest);die;
        if ($listQuest && $listQuest[$questType]) {
            if ($listQuest[$questType]['current_attempts'] < $listQuest[$questType]['total_attempts']) {
                $listQuest[$questType]['current_attempts'] = min($listQuest[$questType]['current_attempts'] + $record, $listQuest[$questType]['total_attempts']);
                $questData->quests = json_encode($listQuest);
                
                if ($listQuest[$questType]['current_attempts'] >= $listQuest[$questType]['total_attempts']) {
                    // lưu lịch sử hoạt động
                    $LogRepository = new LogRepository();
                    $LogRepository->saveLogActivity($user, 2, "Hoàn thành nhiệm vụ " . ($questType + 1) . " tại bảng thử thách.");
                    $newLog = new LogActivity();
                    $newLog->user_id = $userId;


                    if ($questType < 6 && $listQuest[6]['current_attempts'] < 1) {
                        $checkQuest6 = true;
                        for ($i = 0; $i < 6; $i++) {
                            if ($listQuest[$i]['current_attempts'] < $listQuest[$questType]['total_attempts']) {
                                // dump($listQuest[$i]);
                                $checkQuest6 = false;
                            }
                        }
                        // dump($checkQuest6);die;
                        if ($checkQuest6) {
                            $listQuest[6]['current_attempts'] = 1;
                            $questData->quests = json_encode($listQuest);
                            
                            // lưu lịch sử hoạt động
                            $LogRepository = new LogRepository();
                            $LogRepository->saveLogActivity($user, 2, "Hoàn thành nhiệm vụ " . (6 + 1) . " tại bảng thử thách.");
                            $newLog = new LogActivity();
                            $newLog->user_id = $userId;
                        }
                    }
                }
                $questData->save();
            }
        }
    }

    public function rewardQuest($user, $questType, $record)
    {
        $userId = $user->id;
        $questData = MinigameQuests::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if (!$questData) {
            $questData = new MinigameQuests();
            $questData->user_id = $userId;  // Thiết lập user_id cho quest mới
            $questData->quests = json_encode($this->listQuest);
            $questData->save();
        }
        $listQuest = json_decode($questData->quests, true);
        // dump($listQuest);die;
        if ($listQuest && $listQuest[$questType] && $listQuest[$questType]['current_attempts'] >= $listQuest[$questType]['total_attempts']) {
            $listQuest[$questType]['is_reward'] = 1;
            $questData->quests = json_encode($listQuest);
            $questData->save();
            return $listQuest;
        }
    }
    public function createQuest($userId)
    {
    }
    // public function saveWord2($wordData,$translateData,$logImportId,$languageISOTranslate,$projectId){
    //     $special_chars = '/[%$+\*\'\"\“<>#]/';
    //     $special_cn_chars = '[\%\$\+\*\'\"\“\<\>\#]';
    //     $languageId = $wordData['language_id'];
    //     $language = Languages::find($languageId);

    //     $word = $wordData['data'];
    //     $description = $wordData['description'];

    //     $languageTranslateId = $translateData['language_id'];
    //     $languageTranslate = Languages::find($languageTranslateId);
    //     $translate = $translateData['data'];
    //     $descriptionTranslate = $translateData['description'];
    //     $description = $description ?? $descriptionTranslate ?? "";
    //     $translateDescription = $descriptionTranslate ?? $description ?? "";
    //     $words = new Words();
    //     $translate = trim($translate);
    //     if($languageTranslate->iso_code == "CN"){
    //         $translate = str_replace(" ", "", $translate);
    //     }
    //     if (preg_match($special_chars, $word) ) {
    //         echo("special_chars");
    //         return;
    //     }
    //     if (strpos($word, "\\n") !== false) {
    //         echo("suyệt n");
    //         return;
    //     }
    //     if (strpos($translate, "\\n") !== false) {

    //         echo("suyệt n");
    //         return;
    //     }
    //     if($languageISOTranslate == "CN"){
    //         mb_regex_encoding("UTF-8");
    //         if (mb_ereg($special_cn_chars, $translate)) {

    //         echo("special_cn_chars");
    //             return; 
    //         }
    //     }else{
    //         if(preg_match($special_chars, $translate)){
    //             echo("special_chars");
    //             return; 
    //         }
    //     }
    //     $words->saveWithTranslation($languageId, $languageTranslateId, $word, $translate, $description, $translateDescription, $logImportId,$projectId);
    //     // lưu phiên bảng tiếng việt
    //     $words->saveWithTranslation($languageId, $languageId, $word, $word, $description, $description, $logImportId,$projectId);
    // }
}
