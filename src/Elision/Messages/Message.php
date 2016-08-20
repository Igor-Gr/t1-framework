<?php

namespace Elision\Messages;


class Message
{

    public static function parseMessages($message, $value, $field = null)
    {
        
        $data = (array) include 'messages.php';
        $msg = '';

        foreach ($data as $k => $v) {
            if ($message == $k) {
                $msg = str_replace('count', $value, $v);
                if ($field != null) {
                    $msg = str_replace('field', $field, $msg);
                }
                return $msg;
            } else {
                $msg = $message;
            }
        }
        return $msg;
    }
}