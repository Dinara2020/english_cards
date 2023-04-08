<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    public static function getAll(int $offset, ?array $filters = []) {
        $query = Words::select('*')->skip($offset)->take(32);
        if ($filters) {
            foreach ($filters as $filter) {
                $query->status((string)$filter);
            }
        }

        return $query->get();
    }

    public static function scopeStatus(Builder $query, string $status) {
        return $query->orWhere('status', '=', $status);
    }


}
