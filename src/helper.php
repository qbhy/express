<?php
/**
 * User: qbhy
 * Date: 2019-04-01
 * Time: 15:06
 */

namespace Qbhy\Express;

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