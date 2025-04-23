<?php

namespace App\Services;

use App\Models\BoardMember;
use App\Models\Commission;
use App\Models\OldBoards;

class AboutUsService
{

    public function getAboutUsData(){
        $boards = BoardMember::all();
        $oldboards = OldBoards::all();
        $commissions = Commission::all();
        return [
            'boards' => $boards,
            'oldboards' => $oldboards,
            'commissions' => $commissions
        ];
    }
}
