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

    public function saveLogItem($user,$itemType,$record,$reason)
    {
        // save history 
        $newLog = new LogItem();
        $newLog->user_id = $user->id;  // Thiết lập user_id cho quest mới
        
        if($itemType == 1){
            $newLog->old = $user->feathers;
            $newLog->new = $user->feathers + $record;
        }elseif($itemType == 2){
            $newLog->old = $user->diamond;
            $newLog->new = $user->diamond + $record;
        }
        
        $newLog->item_type = $itemType;
        $newLog->reason = $reason;
        $newLog->record = $record;
        $newLog->save();
    }

    public function saveLogActivity($user,$activityType,$reason)
    {
        $newLog = new LogActivity();
        $newLog->user_id = $user->id;  // Thiết lập user_id cho quest mới
        
        $newLog->type = $activityType;
        $newLog->reason = $reason;
        $newLog->save();
    }
    
}
