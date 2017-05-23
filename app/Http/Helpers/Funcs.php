<?php

if (! function_exists('isPost')) {
    /**
     * Whether or not the POST request
     *
     * @return boolean
     */
    function isPost()
    {
        return isset($_SERVER['REQUEST_METHOD']) && 'POST' === $_SERVER['REQUEST_METHOD'];
    }
}

if (! function_exists('isAjax')) {
    /**
     * Whether or not the AJAX request
     *
     * @return boolean
     */
    function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
                || (isset($_REQUEST['X-Requested-With'])
                && $_REQUEST['X-Requested-With'] == 'XMLHttpRequest');
    }
}

if (! function_exists('toArray')) {
    function toArray($value)
    {
        return json_decode(json_encode($value), true);
    }
}