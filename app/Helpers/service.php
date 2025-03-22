<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

if (!function_exists('isTestMode')) {
    function isTestMode()
    {
        if (env('APP_MODE') == 'test') {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('envu')) {
    function envu($data = array())
    {
        foreach ($data as $key => $value) {
            if (env($key) === $value) {
                unset($data[$key]);
            }
        }

        if (!count($data)) {
            return false;
        }

        // write only if there is change in content

        $env = file_get_contents(base_path() . '/.env');
        $env = explode("\n", $env);
        foreach ((array) $data as $key => $value) {
            foreach ($env as $env_key => $env_value) {
                $entry = explode("=", $env_value, 2);
                if ($entry[0] === $key) {
                    $env[$env_key] = $key . "=" . (is_string($value) ? '"' . $value . '"' : $value);
                } else {
                    $env[$env_key] = $env_value;
                }
            }
        }
        $env = implode("\n", $env);
        file_put_contents(base_path() . '/.env', $env);
        return true;
    }
}

if (!function_exists('isConnected')) {
    function isConnected()
    {
        $connected = @fsockopen("www.google.com", 80);
        if ($connected) {
            fclose($connected);
            return true;
        }

        return false;
    }
}

if (!function_exists('curlIt')) {

    function curlIt($url, $postData = array())
    {
        $url  = preg_replace("/\r|\n/", "", $url);
        try {
            $response = Http::timeout(3)->acceptJson()->get($url);
            if ($response->successful()) {
                return $response->json();
            }

            return [];
        } catch (\Exception $e) {
            Log::error($e);
        }
        return [
            'goto' => $url . '&from=browser'
        ];
    }
}

if (!function_exists('gv')) {

    function gv($params, $key, $default = null)
    {
        return (isset($params[$key]) && $params[$key]) ? $params[$key] : $default;
    }
}

if (!function_exists('gbv')) {
    function gbv($params, $key)
    {
        return (isset($params[$key]) && $params[$key]) ? 1 : 0;
    }
}

if (!function_exists('active_link')) {
    function active_link($route_or_path, $class = 'active')
    {
        if (request()->route()->getName() == $route_or_path) {
            return $class;
        }

        if (request()->is($route_or_path)) {
            return $class;
        }
        return false;
    }
}

if (!function_exists('active_progress_bar')) {
    function active_progress_bar($route_or_path_arr, $class = 'active')
    {
        return in_array(request()->route()->getName(), $route_or_path_arr) ? $class : false;
    }
}

if (!function_exists('nav_item_open')) {
    function nav_item_open($data, $index, $default_class = 'nav-item-open')
    {
        return in_array($index, $data) ? $default_class : false;
    }
}


if (!function_exists('app_url')) {
    function app_url()
    {
        $saas = config('sgconfig.saas_module_name', 'Saas');
        $module_check_function = config('sgconfig.module_status_check_function', 'moduleStatusCheck');
        if (function_exists($module_check_function) && $module_check_function($saas)) {
            return config('app.url');
        }
        return url('/');
    }
}

if (!function_exists('bytesToSize')) {
    function bytesToSize($size, $precision = 2)
    {
        $size = is_numeric($size) ? $size : 0;

        $base = log($size, 1024);
        $suffixes = array('Bytes', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}


if (!function_exists('verifyUrl')) {
    function verifyUrl($verifier = 'auth')
    {
        if ($verifier == 'auth') {
            $url = config('app.verifier');
        } else {
            $url = config('app.ux_verifier');
        }

        return $url;
    }
}

if (!function_exists('get_school_id')) {
    function get_school_id()
    {
        return app()->bound('school') ? app('school')->id : 1;
    }
}

if (!function_exists('number_to_word')) {
    function number_to_word($data)
    {
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return Str::upper($f->format($data));
    }
}

if (!function_exists('convertNumberToWord')) {
    function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array(
            '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array(
            '', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
        }
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return Str::upper(implode(' ', $words));
    }
}
