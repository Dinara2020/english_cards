<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Words extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function getWord(int $id)
    {
        return Words::where('id', '=', $id)->first();
    }

    public static function getStatistic(): array
    {
        $statistic = [];
        $wordsAll = Words::where('status', '!=', 'delete');
        $wordsDone = Words::where('status', '=', 'done');
        $wordsLearn = Words::where('status', '=', 'learn');
        $statistic['all'] = $wordsAll->count();
        $statistic['done'] = $wordsDone->count();
        $statistic['learn'] = $wordsLearn->count();
        return $statistic;
    }

    public static function getWords()
    {
        return Words::select('id as key','word as value')->get()->toArray();
    }
    public static function getMaxId() {
        return Words::max('id');
    }


}
