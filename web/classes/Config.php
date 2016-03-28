<?php
require_once('Net/SSH2.php');

class Config
{
    public static $config;
    public static $mailconfig;

    public static function load()
    {
        if (self::$config == null) {
            self::$config = json_decode(file_get_contents(dirname(__FILE__) . '/../config.json'));
            self::$mailconfig = json_decode(self::remote_load());
        }
    }

    private static function remote_load()
    {
        $output = self::remote_command('sudo cat ' . self::$config->mailconfig);
        return $output;
    }

    private static function remote_command($command)
    {
        $ssh = new NET_SSH2(self::$config->ssh_host);

        if (!$ssh->login(self::$config->ssh_user, self::$config->ssh_pass)) {
            return null;
        }

        $output = $ssh->exec("$command");

        unset($ssh, $command);
        return $output;
    }

    public function save()
    {
        self::remote_save();
        self::reload();
    }

    private static function remote_save()
    {
        $configString = self::getConfigJson();
        $output = self::remote_command("echo '$configString' | sudo tee " . self::$config->mailconfig . " > /dev/null");
        if ($output != '') {
            die("Remote Error: $output");
        }
    }

    private static function getConfigJson()
    {
        return JsonFormatter::format(json_encode(self::$mailconfig, JSON_UNESCAPED_SLASHES));
    }

    public function reload()
    {
        self::remote_reload();
    }

    private static function remote_reload()
    {
        $output = self::remote_command('sudo ajenti-ipc vmail apply');
        if (strpos($output, '200 OK') === -1) {
            die ("Remote Error: " . $output);
        }
    }
}