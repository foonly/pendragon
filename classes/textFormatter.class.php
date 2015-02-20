<?php

class textFormatter {
    public static function transform ($text) {
        while (preg_match('/\*\*([^*]*[^ ])\*\*/',$text,$match)) {
            $text = str_replace($match[0],"<strong>{$match[1]}</strong>",$text);
        }
        while (preg_match('/\*([^*]*[^ ])\*/',$text,$match)) {
            $text = str_replace($match[0],"<em>{$match[1]}</em>",$text);
        }

        return $text;
    }
}