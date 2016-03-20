<?php

class Config
{
    public static $config;
    public static $mailconfig;

    public static function load()
    {
        if (Config::$config == null) {
            Config::$config = json_decode(file_get_contents(dirname(__FILE__) . '/../config.json'));
            Config::$config->mailconfig = dirname(__FILE__) . '/../' . Config::$config->mailconfig;
            Config::$mailconfig = json_decode(file_get_contents(Config::$config->mailconfig));
        }
    }

    public static function save()
    {
        file_put_contents(Config::$config->mailconfig,
            Config::beautify_json(json_encode(Config::$mailconfig, JSON_UNESCAPED_SLASHES)));
    }

    private function beautify_json($json)
    {

        $result = '';
        $pos = 0;
        $strLen = strlen($json);
        $indentStr = '  ';
        $newLine = "\n";
        $prevChar = '';
        $outOfQuotes = true;

        for ($i = 0; $i <= $strLen; $i++) {

            // Grab the next character in the string.
            $char = substr($json, $i, 1);

            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;

                // If this character is the end of an element,
                // output a new line and indent the next line.
            } else if (($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos--;
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            // Add the character to the result string.
            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line.
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            $prevChar = $char;
        }

        return $result;
    }
}