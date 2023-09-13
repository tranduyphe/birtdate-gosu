<?php

namespace App\Repositories;

use App\Models\MinigameQuests;
use Illuminate\Support\Carbon;
use App\Models\LogActivity;
use App\Models\UserInvite;
use App\Models\SanhHopHep;
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
                'current_attempts' => 1,
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
                'name' => 'Thu thập được 5 Lông Phượng Hoàng/ngày',
                'type' => '7',
                'total_attempts' => 5,
                'current_attempts' => 0,
                'is_reward' => 0,
                'diamond_reward' => 5
            ],
            [
                'name' => 'Thu thập được 15 Lông Phượng Hoàng/ngày',
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
        //kiểm tra đã tồn tại user trong sảnh họp hẹp chưa
        $SanhHopHepData = SanhHopHep::where('user_id', $userId)
            ->first();
        $currentAttempts9 = 0;
        $isReward9 = 0;

        $today = Carbon::today();

        // Lấy ngày hôm qua
        $yesterday = Carbon::yesterday();

        // Lấy ngày 2 ngày trước
        $twoDaysAgo = Carbon::yesterday()->subDays(1);
        if ($SanhHopHepData) {
            $currentAttempts9 = 1;
            $isReward9 = $SanhHopHepData->is_reward_quest;
        } else {

            // Thực hiện truy vấn trong bảng minigame_quest
            $count = MinigameQuests::where('user_id', $userId)
                ->where(function ($query) use ($yesterday, $twoDaysAgo) {
                    $query->whereDate('created_at', $yesterday)
                        ->orWhereDate('created_at', $twoDaysAgo);
                })
                ->count();
            // dump($yesterday);
            // dump($twoDaysAgo);
            // dump($count);die;
            if ($count >= 2) {
                $currentAttempts9 = 1;
                // Lấy ngày hôm nay
                // dump("check today");
                // dump($today);die;
                SanhHopHep::updateOrInsert(
                    ['user_id' => $userId, 'created_at' => $today],
                    ['user_id' => $userId]
                );
            }
        }

        $questData = MinigameQuests::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->first();
        if ($questData) {
            $quests = json_decode($questData->quests, true);
            $quests[9]["current_attempts"] = $currentAttempts9;
            $quests[9]["is_reward"] = $isReward9;

            $count = UserInvite::where('friend_id', $userId)
                ->whereDate('created_at', $today)
                ->count();
            if ($quests[2]["current_attempts"] < $quests[2]["total_attempts"] && $quests[2]["current_attempts"] < $count) {
                $quests[2]["current_attempts"] = $count;
                $questData->quests =  json_encode($quests);
                $questData->save();
            }
        } else {

            //nên sửa lại thành creater or update nếu created_at = ngày hôm nay
            $quests = $this->listQuest;
            $quests[9]["current_attempts"] = $currentAttempts9;
            $quests[9]["is_reward"] = $isReward9;
            $newQuest = new MinigameQuests();
            $newQuest->user_id = $userId;  // Thiết lập user_id cho quest mới
            $newQuest->quests = json_encode($quests);
            $newQuest->save();

            $quests = $quests;
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
        SanhHopHep::updateOrInsert(
            ['user_id' => $userId],
            ['user_id' => $userId, 'is_reward_quest' => 1]
        );
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
