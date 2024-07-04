<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Api\YahooRequest;
use App\Http\Requests\Api\YoutubeRequest;

use App\Models\News;

use Google_Client;
use Google_Service_YouTube;

class ApiController extends Controller
{
    //
    public function yahoo(YahooRequest $request) {
        $input = $request->validated();
        $data = $this->accessYahooApi($input['text']);
        $nouns = $this->filterNouns($data);
        
        $model = new News();
        $news = $model->getSameNounsNews($input['text'], $nouns);

        return response()->json($news);
    }


    public function youtube(YoutubeRequest $request) {
        $input = $request->validated();

        $client = new Google_Client();
        $client->setApplicationName('HeiSei');
        $client->setDeveloperKey(config('app.youtube_api_key'));

        $youtube = new Google_Service_YouTube($client);
        $params = [
            'q'             => "{$input['keyword']}",
            'type'          => 'video',
            'maxResults'    => 4,
        ];

        try {
            $videos = $youtube->search->listSearch('id', $params);    
        } catch (Google_Service_Exception $e) {
            $response['errors']  = $e->getMessage();
            throw new HttpResponseException(response()->json($response));
        } catch (Google_Exception $e) {
            $response['errors']  = $e->getMessage();
            throw new HttpResponseException(response()->json($response));
        }

        $idList = [];
        foreach ($videos['items'] as $video) {
            $idList[] = $video['id']['videoId'];
        }

        return response()->json(['idList' => $idList]);
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
