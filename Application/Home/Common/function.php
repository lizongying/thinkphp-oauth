<?php
/**
 * Author: Michael
 * Date: 2016/1/28
 * Time: 17:42
 */

/**
 * ¼ÓÃÜ
 * @param string $password
 * @return bool|false|string
 */
function passwordHash($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}