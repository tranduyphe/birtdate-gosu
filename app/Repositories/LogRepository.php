<?php

namespace App\Repositories;

use App\Models\MinigameQuests;
use Illuminate\Support\Carbon;
use App\Models\LogActivity;
use App\Models\LogItem;

class LogRepository
{
    protected $listQuest = [];

    public function __construct()
    {
    }

    public function saveLogItem($user, $itemType, $record, $reason)
    {
        // save history 
        $newLog = new LogItem();
        $newLog->user_id = $user->id;  // Thiết lập user_id cho quest mới

        if ($itemType == 1) {
            $newLog->old = $user->feathers;
            $newLog->new = $user->feathers + $record;
            $QuestRepository = new QuestRepository();
            $questType = 7;
            $QuestRepository->updateQuest($user, $questType, $record);
            // $questType = 8;
            // $QuestRepository->updateQuest($user, $questType, $record);
        } 
        if ($itemType == 2) {
            $newLog->old = $user->diamond;
            $newLog->new = $user->diamond + $record;
        }
        if ($itemType == 3) {
            $newLog->old = $user->the_tiem_long;
            $newLog->new = $user->the_tiem_long + $record;
        }
        


        $newLog->item_type = $itemType;
        $newLog->reason = $reason;
        $newLog->record = $record;
        $newLog->save();
    }
    public function saveLogItemWithValue($user, $itemType, $record, $oldValue, $newValue, $reason)
    {
        // save history 
        $newLog = new LogItem();
        $newLog->user_id = $user->id;  // Thiết lập user_id cho quest mới

        if ($itemType == 1) {
            $newLog->old = $oldValue;
            $newLog->new = $newValue;
        } elseif ($itemType == 2) {
            $newLog->old = $oldValue;
            $newLog->new = $newValue;
        }

        $newLog->item_type = $itemType;
        $newLog->reason = $reason;
        $newLog->record = $record;
        $newLog->save();
    }


    public function saveLogActivity($user, $activityType, $listItem, $reason)
    {
        $newLog = new LogActivity();
        $newLog->user_id = $user->id;  // Thiết lập user_id cho quest mới

        $newLog->type = $activityType;
        $newLog->log_item = json_encode($listItem);
        $newLog->reason = $reason;
        $newLog->save();
    }
}
