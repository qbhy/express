<?php

namespace Qbhy\Express;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Express
{

    /**
     * @var Client
     */
    static $http = null;


    /**
     * 查快递方法
     *
     * @param string $postId 快递单号
     * @param string $type   手动指定快递类型
     *
     * @throws ExpressException
     * @return array
     */
    public static function query($postId, $type = '', $phone = '')
    {
        $type = $type === '' ? self::queryType($postId) : $type;
        if (is_null($type)) {
            throw new ExpressException("无用的快递单号: {$postId} 。");
        }

        $url  = "https://www.kuaidi100.com/query?type={$type}&postid={$postId}&id=1&valicode=&temp=0.625568512055451&phone={$phone}";
        $data = static::getHttp()->request('GET', $url)->getBody();
        return \GuzzleHttp\json_decode($data, true);
    }

    /**
     * @return Client
     */
    public static function getHttp()
    {
        if (!(static::$http instanceof Client)) {
            static::$http = new Client([
                RequestOptions::HEADERS => [
                    'Referer'         => 'https://www.kuaidi100.com/',
                    'User-Agent'      => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
                    'Accept-Language' => 'zh,zh-CN;q=0.9,en;q=0.8',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Connection'      => 'keep-alive',
                ]
            ]);
        }
        return self::$http;
    }

    /**
     * 查询快递类型方法
     *
     * @param string $postId 快递单号
     *
     * @throws ExpressException
     * @return null|string
     */
    public static function queryType($postId)
    {
        $data = \GuzzleHttp\json_decode(static::getHttp()->request('get', "http://www.kuaidi100.com/autonumber/autoComNum?text=$postId")->getBody(), true);
        if (count($data['auto']) > 0) {
            return $data['auto'][0]['comCode'];
        } else {
            return null;
        }
    }


}