<?php
/**
 * User: qbhy
 * Date: 2019-04-01
 * Time: 15:06
 */

namespace Qbhy\Express;

if (!function_exists('express')) {
    /**
     * 查询快递信息
     *
     * @param        $postId ,单号
     * @param string $type   ,快递类型
     * @param string $phone  ,手机号
     *
     * @return array
     */
    function express($postId, $type = '', $phone = '')
    {
        return Express::query($postId, $type, $phone);
    }
}

if (!function_exists('express_type')) {
    /**
     * 查询快递类型
     *
     * @param $postId
     *
     * @return string|null
     */
    function express_type($postId)
    {
        return Express::queryType($postId);
    }
}