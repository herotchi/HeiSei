<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\News;

class ImportTextFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import_textfile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'textfile_import_database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $entries = [];
        
        for ($i = 1989; $i <= 2019 ; $i++) { 
            // テキストファイルのパスを指定
            $filePath = storage_path("app/{$i}.txt");

            // ファイルが存在するか確認
            if (!file_exists($filePath)) {
                $this->error('File not found.');
                return;
            }

            $file_contents = file_get_contents($filePath);
            $lines = explode(PHP_EOL, $file_contents);

            // 正規表現パターンを定義
            $pattern = '/(\d{1,2})月(\d{1,2})?日?\s*-\s*(.*)/u';

            // 日付と記事を抽出する
            foreach ($lines as $line) {
                if (preg_match($pattern, $line, $matches)) {
                    // 月の部分を取得
                    $month = $matches[1];
                    // 日の部分を取得
                    $day = $matches[2] !== '' ? $matches[2] : null;
                    // 記事の部分を取得
                    $context = $matches[3];

                    $entries[$i][] = [
                        "month" => $month, 
                        "day" => $day,
                        "context" => $context
                    ];
                }
            }
            
        }

        try {
            DB::transaction(function () use ($entries) {
                foreach ($entries as $year => $entry) {
                    foreach ($entry as $line) {
                        $news = new News();
                        $news->year = $year;
                        $news->month = $line['month'];
                        $news->day = $line['day'];
                        $news->context = $line['context'];
                        $news->save();
                    }
                }
            });

            $this->info('Data imported successfully.');

        } catch (\Exception $e) {
            // エラーメッセージを表示
            $this->error('Failed to import data: ' . $e->getMessage());
        }
    }
        
}
