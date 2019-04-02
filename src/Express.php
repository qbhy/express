<?php

namespace Qbhy\Express;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Express
{
    private $secret;

    public function __construct($secret)
    {
        $this->secret = $secret;
    }

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
     * @return array
     */
    public function query($postId, $type = 'auto')
    {
        $url  = "http://q.kdpt.net/api?id={$this->secret}&com={$type}&nu={$postId}&show=json";
        $data = $this::getHttp()->request('GET', $url)->getBody();
        return @\GuzzleHttp\json_decode($data, true);
    }

    /**`
     * @return Client
     */
    public static function getHttp()
    {
        if (!(static::$http instanceof Client)) {
            $agents = [
                'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.163 Safari/535.1',
                'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:6.0) Gecko/20100101 Firefox/6.0',
                'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50',
                'Opera/9.80 (Windows NT 6.1; U; zh-cn) Presto/2.9.168 Version/11.50',
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.3; .NET4.0C; Tablet PC 2.0; .NET4.0E)',
                'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; InfoPath.3)',
                'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; GTB7.0)',
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
                'Mozilla/5.0 (Windows; U; Windows NT 6.1; ) AppleWebKit/534.12 (KHTML, like Gecko) Maxthon/3.0 Safari/534.12',
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.3; .NET4.0C; .NET4.0E)',
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.3; .NET4.0C; .NET4.0E; SE 2.X MetaSr 1.0)',
                'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.3 (KHTML, like Gecko) Chrome/6.0.472.33 Safari/534.3 SE 2.X MetaSr 1.0',
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.3; .NET4.0C; .NET4.0E)',
                'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/13.0.782.41 Safari/535.1 QQBrowser/6.9.11079.201',
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.3; .NET4.0C; .NET4.0E) QQBrowser/6.9.11079.201',
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)',
            ];
//            $fakeIp       = random_int(1, 254) . '.' . random_int(1, 254) . '.' . random_int(1, 254) . '.' . random_int(1, 254);
            static::$http = new Client([
                RequestOptions::HEADERS => [
                    'Referer'          => 'https://www.kuaidi100.com/',
                    'User-Agent'       => $agents[random_int(0, count($agents) - 1)],
                    'Accept-Language'  => 'zh,zh-CN;q=0.9,en;q=0.8',
                    'Accept-Encoding'  => 'gzip, deflate, br',
                    'Connection'       => 'keep-alive',
                    'X-Requested-With' => 'XMLHttpRequest',
                    'Host'             => 'www.kuaidi100.com',
                    //                    'x-forword-for'    => $fakeIp,
                    'Cookie'           => 'Hm_lvt_22ea01af58ba2be0fec7c11b25e88e6c=1554091249,1554099878; WWWID=WWW095E883265EF9D8F762C82F669FCF6EB; Hm_lpvt_22ea01af58ba2be0fec7c11b25e88e6c=1554107822'
                ],
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
        $data = \GuzzleHttp\json_decode(static::getHttp()->request('get', "http://www.kuaidi100.com/autonumber/autoComNum?text={$postId}")->getBody(), true);
        if (count($data['auto']) > 0) {
            return $data['auto'][0]['comCode'];
        } else {
            return null;
        }
    }


}