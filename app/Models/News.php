<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;



class News extends Model
{
    use HasFactory;

    protected $table = 'news';
    protected $primaryKey = 'id';

    public function getAllNews() {
        $records = $this::all();
        $news = [];
        $this->orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('day', 'asc')->chunk(100, function (Collection $lists) use (&$news) {
            foreach ($lists as $list) {
                $news[$list->year][] = $list;
            }
        });

        return $news;
    }


    public function getSameNounsNews($text, $nouns)
    {
        $news = [];
        foreach ($nouns as $value) {
            $news[$value] = $this::where('context', 'like', "%{$value}%")
            ->where('context', '<>', $text)
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->orderBy('day', 'asc')
            ->get();
        }

        return $news;
    }
}
