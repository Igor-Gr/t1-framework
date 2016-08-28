<?php

namespace Elision\Http;


class Request
{

    public static function originRequest()
    {
        $headers = getallheaders();
        if (isset($headers['Origin'])) {
            return header('Access-Control-Allow-Origin: ' . $headers['Origin']);
        }
    }

    public static function getIp()
    {
        if (isset($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        } else {
            return false;
        }
    }

    public static function getIsAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * Присваивает атрибутам класса значения введенные в поля форм
     *
     * @param $model
     * @return mixed
     */
    public static function setFormValuesInClassAttributes($model)
    {
        $data = $_POST;

        foreach ($model as $classKey => $classValue) {
            foreach ($data as $postKey => $postValue) {
                for ($i = 0; $i < count($data); $i++) {
                    if ($classKey == $postKey) {
                        $model->$classKey = $postValue;
                    }
                }
            }
        }
        return $model;
    }
    
    public static function getHomeUrl()
    {
        return "/";
    }
}