<?php
$config;
$mailconfig;

class Config
{
    public static function load()
    {
        global $config, $mailconfig;

        if ($config == null) {
            $config = json_decode(file_get_contents(dirname(__FILE__) . '/config.json'));
            $config->mailconfig = dirname(__FILE__) . '/' . $config->mailconfig;
            $mailconfig = json_decode(file_get_contents($config->mailconfig));
        }
    }

    public static function save()
    {
        global $config, $mailconfig;
        file_put_contents($config->mailconfig, Config::beautify_json(json_encode($mailconfig, JSON_UNESCAPED_SLASHES)));
    }

    private function beautify_json($json) {

        $result      = '';
        $pos         = 0;
        $strLen      = strlen($json);
        $indentStr   = '  ';
        $newLine     = "\n";
        $prevChar    = '';
        $outOfQuotes = true;

        for ($i=0; $i<=$strLen; $i++) {

            // Grab the next character in the string.
            $char = substr($json, $i, 1);

            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;

                // If this character is the end of an element,
                // output a new line and indent the next line.
            } else if(($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos --;
                for ($j=0; $j<$pos; $j++) {
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
                    $pos ++;
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

?>