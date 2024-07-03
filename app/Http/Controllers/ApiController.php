<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Api\AnalysisRequest;

use App\Models\News;

class ApiController extends Controller
{
    //
    public function analysis(AnalysisRequest $request) {
        $input = $request->validated();
        $data = $this->accessYahooApi($input['text']);//var_dump($data);
        $nouns = $this->filterNouns($data);
        
        $model = new News();
        $news = $model->getSameNounsNews($input['text'], $nouns);
//var_dump($news);
        return response()->json($news);
    }


    private function accessYahooApi ($text) {
        $data_json = json_encode(array(
            "id"        => time(),
            "jsonrpc"   => "2.0",
            "method"    => "jlp.maservice.parse",
            "params"    => array("q" => $text)
        ));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'User-Agent: Yahoo AppID: ' . config('app.yahoo_api_key')
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'https://jlp.yahooapis.jp/MAService/V2/parse');
        $json = curl_exec($ch);
        $result = json_decode($json);
        curl_close($ch);

        return $result;
    }
    

    private function filterNouns($data) {//var_dump($data);
        $nouns = [];
        foreach ($data->result->tokens as $value) {
            if ($value[3] === '名詞' && $value[4] !== '数詞' && mb_strlen($value[0], 'UTF-8') > 1) {
                $nouns[] = $value[0];
            }
        }

        return $nouns;
    }

}
