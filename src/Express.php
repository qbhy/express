<?php

namespace Qbhy\Express;

use GuzzleHttp\Client;
use Exception;

class Express
{

    /**
     * @var Client
     */
    static $http = null;


    /**
     * @param string $postId
     * @param string $type
     * @return mixed|string
     */
    public static function query($postId, $type = '')
    {
        $type = $type === '' ? self::queryType($postId) : $type;
        if (is_null($type)) {
            return "无用的快递单号: $postId 。";
        }
        $url = "http://www.kuaidi.com/index-ajaxselectcourierinfo-$postId-$type.html";
//        $url = "https://www.kuaidi100.com/query?type=$type&postid=$postId&id=1&valicode=&temp=0.005566359421234068";
        $data = static::$http->request('get', $url)->getBody();
        return \GuzzleHttp\json_decode($data, true);
    }


    public static function queryType($postId)
    {

        if (!(static::$http instanceof Client)) {
            static::$http = new Client();
        }
        $data = \GuzzleHttp\json_decode(static::$http->request('get', "http://www.kuaidi100.com/autonumber/autoComNum?text=$postId")->getBody(), true);
        if (count($data['auto']) > 0) {
            return $data['auto'][0]['comCode'];
        } else {
            return null;
        }
    }


}