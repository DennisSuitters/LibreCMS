<?php

namespace Hp;

//  PROJECT HONEY POT ADDRESS DISTRIBUTION SCRIPT
//  For more information visit: http://www.projecthoneypot.org/
//  Copyright (C) 2004-2018, Unspam Technologies, Inc.
//
//  This program is free software; you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation; either version 2 of the License, or
//  (at your option) any later version.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with this program; if not, write to the Free Software
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
//  02111-1307  USA
//
//  If you choose to modify or redistribute the software, you must
//  completely disconnect it from the Project Honey Pot Service, as
//  specified under the Terms of Service Use. These terms are available
//  here:
//
//  http://www.projecthoneypot.org/terms_of_service_use.php
//
//  The required modification to disconnect the software from the
//  Project Honey Pot Service is explained in the comments below. To find the
//  instructions, search for:  *** DISCONNECT INSTRUCTIONS ***
//
//  Generated On: Fri, 28 Dec 2018 23:03:28 -0500
//  For Domain: bizzyknits.biz
//
//

//  *** DISCONNECT INSTRUCTIONS ***
//
//  You are free to modify or redistribute this software. However, if
//  you do so you must disconnect it from the Project Honey Pot Service.
//  To do this, you must delete the lines of code below located between the
//  *** START CUT HERE *** and *** FINISH CUT HERE *** comments. Under the
//  Terms of Service Use that you agreed to before downloading this software,
//  you may not recreate the deleted lines or modify this software to access
//  or otherwise connect to any Project Honey Pot server.
//
//  *** START CUT HERE ***

define('__REQUEST_HOST', 'hpr6.projecthoneypot.org');
define('__REQUEST_PORT', '80');
define('__REQUEST_SCRIPT', '/cgi/serve.php');

//  *** FINISH CUT HERE ***

interface Response
{
    public function getBody();
    public function getLines(): array;
}

class TextResponse implements Response
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getBody()
    {
        return $this->content;
    }

    public function getLines(): array
    {
        return explode("\n", $this->content);
    }
}

interface HttpClient
{
    public function request(string $method, string $url, array $headers = [], array $data = []): Response;
}

class ScriptClient implements HttpClient
{
    private $proxy;
    private $credentials;

    public function __construct(string $settings)
    {
        $this->readSettings($settings);
    }

    private function getAuthorityComponent(string $authority = null, string $tag = null)
    {
        if(is_null($authority)){
            return null;
        }
        if(!is_null($tag)){
            $authority .= ":$tag";
        }
        return $authority;
    }

    private function readSettings(string $file)
    {
        if(!is_file($file) || !is_readable($file)){
            return;
        }

        $stmts = file($file);

        $settings = array_reduce($stmts, function($c, $stmt){
            list($key, $val) = \array_pad(array_map('trim', explode(':', $stmt)), 2, null);
            $c[$key] = $val;
            return $c;
        }, []);

        $this->proxy       = $this->getAuthorityComponent($settings['proxy_host'], $settings['proxy_port']);
        $this->credentials = $this->getAuthorityComponent($settings['proxy_user'], $settings['proxy_pass']);
    }

    public function request(string $method, string $uri, array $headers = [], array $data = []): Response
    {
        $options = [
            'http' => [
                'method' => strtoupper($method),
                'header' => $headers + [$this->credentials ? 'Proxy-Authorization: Basic ' . base64_encode($this->credentials) : null],
                'proxy' => $this->proxy,
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $body = file_get_contents($uri, false, $context);

        if($body === false){
            trigger_error(
                "Unable to contact the Server. Are outbound connections disabled? " .
                "(If a proxy is required for outbound traffic, you may configure " .
                "the honey pot to use a proxy. For instructions, visit " .
                "http://www.projecthoneypot.org/settings_help.php)",
                E_USER_ERROR
            );
        }

        return new TextResponse($body);
    }
}

trait AliasingTrait
{
    private $aliases = [];

    public function searchAliases($search, array $aliases, array $collector = [], $parent = null): array
    {
        foreach($aliases as $alias => $value){
            if(is_array($value)){
                return $this->searchAliases($search, $value, $collector, $alias);
            }
            if($search === $value){
                $collector[] = $parent ?? $alias;
            }
        }

        return $collector;
    }

    public function getAliases($search): array
    {
        $aliases = $this->searchAliases($search, $this->aliases);
    
        return !empty($aliases) ? $aliases : [$search];
    }

    public function aliasMatch($alias, $key)
    {
        return $key === $alias;
    }

    public function setAlias($key, $alias)
    {
        $this->aliases[$alias] = $key;
    }

    public function setAliases(array $array)
    {
        array_walk($array, function($v, $k){
            $this->aliases[$k] = $v;
        });
    }
}

abstract class Data
{
    protected $key;
    protected $value;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function key()
    {
        return $this->key;
    }

    public function value()
    {
        return $this->value;
    }
}

class DataCollection
{
    use AliasingTrait;

    private $data;

    public function __construct(Data ...$data)
    {
        $this->data = $data;
    }

    public function set(Data ...$data)
    {
        array_map(function(Data $data){
            $index = $this->getIndexByKey($data->key());
            if(is_null($index)){
                $this->data[] = $data;
            } else {
                $this->data[$index] = $data;
            }
        }, $data);
    }

    public function getByKey($key)
    {
        $key = $this->getIndexByKey($key);
        return !is_null($key) ? $this->data[$key] : null;
    }

    public function getValueByKey($key)
    {
        $data = $this->getByKey($key);
        return !is_null($data) ? $data->value() : null;
    }

    private function getIndexByKey($key)
    {
        $result = [];
        array_walk($this->data, function(Data $data, $index) use ($key, &$result){
            if($data->key() == $key){
                $result[] = $index;
            }
        });

        return !empty($result) ? reset($result) : null;
    }
}

interface Transcriber
{
    public function transcribe(array $data): DataCollection;
    public function canTranscribe($value): bool;
}

class StringData extends Data
{
    public function __construct($key, string $value)
    {
        parent::__construct($key, $value);
    }
}

class CompressedData extends Data
{
    public function __construct($key, string $value)
    {
        parent::__construct($key, $value);
    }

    public function value()
    {
        $url_decoded = base64_decode(str_replace(['-','_'],['+','/'],$this->value));
        if(substr(bin2hex($url_decoded), 0, 6) === '1f8b08'){
            return gzdecode($url_decoded);
        } else {
            return $this->value;
        }
    }
}

class FlagData extends Data
{
    private $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function value()
    {
        return $this->value ? ($this->data ?? null) : null;
    }
}

class CallbackData extends Data
{
    private $arguments = [];

    public function __construct($key, callable $value)
    {
        parent::__construct($key, $value);
    }

    public function setArgument($pos, $param)
    {
        $this->arguments[$pos] = $param;
    }

    public function value()
    {
        ksort($this->arguments);
        return \call_user_func_array($this->value, $this->arguments);
    }
}

class DataFactory
{
    private $data;
    private $callbacks;

    private function setData(array $data, string $class, DataCollection $dc = null)
    {
        $dc = $dc ?? new DataCollection;
        array_walk($data, function($value, $key) use($dc, $class){
            $dc->set(new $class($key, $value));
        });
        return $dc;
    }

    public function setStaticData(array $data)
    {
        $this->data = $this->setData($data, StringData::class, $this->data);
    }

    public function setCompressedData(array $data)
    {
        $this->data = $this->setData($data, CompressedData::class, $this->data);
    }

    public function setCallbackData(array $data)
    {
        $this->callbacks = $this->setData($data, CallbackData::class, $this->callbacks);
    }

    public function fromSourceKey($sourceKey, $key, $value)
    {
        $keys = $this->data->getAliases($key);
        $key = reset($keys);
        $data = $this->data->getValueByKey($key);

        switch($sourceKey){
            case 'directives':
                $flag = new FlagData($key, $value);
                if(!is_null($data)){
                    $flag->setData($data);
                }
                return $flag;
            case 'email':
            case 'emailmethod':
                $callback = $this->callbacks->getByKey($key);
                if(!is_null($callback)){
                    $pos = array_search($sourceKey, ['email', 'emailmethod']);
                    $callback->setArgument($pos, $value);
                    $this->callbacks->set($callback);
                    return $callback;
                }
            default:
                return new StringData($key, $value);
        }
    }
}

class DataTranscriber implements Transcriber
{
    private $template;
    private $data;
    private $factory;

    private $transcribingMode = false;

    public function __construct(DataCollection $data, DataFactory $factory)
    {
        $this->data = $data;
        $this->factory = $factory;
    }

    public function canTranscribe($value): bool
    {
        if($value == '<BEGIN>'){
            $this->transcribingMode = true;
            return false;
        }

        if($value == '<END>'){
            $this->transcribingMode = false;
        }

        return $this->transcribingMode;
    }

    public function transcribe(array $body): DataCollection
    {
        $data = $this->collectData($this->data, $body);

        return $data;
    }

    public function collectData(DataCollection $collector, array $array, $parents = []): DataCollection
    {
        foreach($array as $key => $value){
            if($this->canTranscribe($value)){
                $value = $this->parse($key, $value, $parents);
                $parents[] = $key;
                if(is_array($value)){
                    $this->collectData($collector, $value, $parents);
                } else {
                    $data = $this->factory->fromSourceKey($parents[1], $key, $value);
                    if(!is_null($data->value())){
                        $collector->set($data);
                    }
                }
                array_pop($parents);
            }
        }
        return $collector;
    }

    public function parse($key, $value, $parents = [])
    {
        if(is_string($value)){
            if(key($parents) !== NULL){
                $keys = $this->data->getAliases($key);
                if(count($keys) > 1 || $keys[0] !== $key){
                    return \array_fill_keys($keys, $value);
                }
            }

            end($parents);
            if(key($parents) === NULL && false !== strpos($value, '=')){
                list($key, $value) = explode('=', $value, 2);
                return [$key => urldecode($value)];
            }

            if($key === 'directives'){
                return explode(',', $value);
            }

        }

        return $value;
    }
}

interface Template
{
    public function render(DataCollection $data): string;
}

class ArrayTemplate implements Template
{
    public $template;

    public function __construct(array $template = [])
    {
        $this->template = $template;
    }

    public function render(DataCollection $data): string
    {
        $output = array_reduce($this->template, function($output, $key) use($data){
            $output[] = $data->getValueByKey($key) ?? null;
            return $output;
        }, []);
        ksort($output);
        return implode("\n", array_filter($output));
    }
}

class Script
{
    private $client;
    private $transcriber;
    private $template;
    private $templateData;
    private $factory;

    public function __construct(HttpClient $client, Transcriber $transcriber, Template $template, DataCollection $templateData, DataFactory $factory)
    {
        $this->client = $client;
        $this->transcriber = $transcriber;
        $this->template = $template;
        $this->templateData = $templateData;
        $this->factory = $factory;
    }

    public static function run(string $host, int $port, string $script, string $settings = '')
    {
        $client = new ScriptClient($settings);

        $templateData = new DataCollection;
        $templateData->setAliases([
            'doctype'   => 0,
            'head1'     => 1,
            'robots'    => 8,
            'nocollect' => 9,
            'head2'     => 1,
            'top'       => 2,
            'legal'     => 3,
            'style'     => 5,
            'vanity'    => 6,
            'bottom'    => 7,
            'emailCallback' => ['email','emailmethod'],
        ]);

        $factory = new DataFactory;
        $factory->setStaticData([
            'doctype' => '<!DOCTYPE html>',
            'head1'   => '<html><head>',
            'head2'   => '<title></title></head>',
            'top'     => '<body><div align="center">',
            'bottom'  => '</div></body></html>',
        ]);
        $factory->setCompressedData([
            'robots'    => 'H4sIAAAAAAAAA7PJTS1JVMhLzE21VSrKT8ovKVZSSM7PK0nNK7FVysvPzEtJrVCys8GvKrEoOSOzLFUnLT8nJ79cyQ4AQQYC11UAAAA',
            'nocollect' => 'H4sIAAAAAAAAA7PJTS1JVMhLzE21VcrL103NTczM0U3Oz8lJTS7JzM9TUkjOzytJzSuxVdJXsgMAKsBXli0AAAA',
            'legal'     => 'H4sIAAAAAAAAA61aa2_bOBb9vr-CcBaZFEjzaPNcZQq4qdN40DpZ2-mgH2mJtjmVRYOk4_H8-r0P0pIcW9ntbAHHlkRSvK9zz73sjZejXIlU5flcZpkuJr-2TlpiZGymLP3ER24u0_Dow423H_5x4zPh_CpXv7bGpvBvx3Km89W_RGoWVit7KGamMDhLJa0P-8XIzRPBX-HiZvThBmfCjNzAi_bu6F_rg7w5xvsfbo5H9YkwxYY7-Gs4VdsX-BEWWKqR0x6HeiP2907fnSYGvk4vE-EWI7xv_FRZfHR6kSg7o_X3ri4TmqjEyuAdq2QmYOBs-9tM3C4MlRNVeNcsFr7tNBmTMLjqkQBB6KowxVtvZYEjzpMx3vqdd3KEv0vp_0tF6peK3Dn2x4uxdWUP5rCrk9Mk1TIXVuGtHktSvL1npc72964vE_x9wqZycw0u5A4F6XpuUfkn7xMr8fs6cSIjnS08LzSTXqcyStqZSZ0LcEiLV10vtIP3pjyU5uWmUPt7ZxeJ-G4WbLrTk7NEOiGbZcQ1rhKZ0yTnjQWzHQp68zPt7SpZsLTCjIUPo3DWGYp3cp4UE3AI2kQQSSmWiafBu6MYOxWe7fTy7TauGqNDmk6n21d2YeW5tH7FXil14fz20aqilIuEhDpo_bbIdKrpLXnw02YXsyz4RDtW1yKdilwuHW1cFpmYKzs2ZEpQ6VhlitUpczbc2nFWgmXj7WhTkPMp-6xTdQTPrq6TsCEhR-wMz-p1bU-jtv83xPkJqKpb6jtvMaBOalhIp_gbR8wkI5PA79N3Cf9V0q4VM1o4EH3I3k2R900DKBjrxDpaQDEXSRf-vk-6w4f-QLTx7mO7P_wuHuD2u0QMSJNPHwedfz91ekOaeeyzv4PkuxWz07srWsLPDreK5hpbswN1o-aXU43r_KFSLwDlPWspoAGgaHOITKIH2UKTpy2ETFPFNvAc-qm0aswGzBkcVkeNMRETgi4y_Uy7i2ueA-ZZPSHBLbkvrKbEkpPUq068Bc9LOwwe9_curpPbLj6NSzlvdeohilzVbY5E1M9p4t1hswlACvUn7djpSaEgE1JSrKkigu9p4pzakf7i5kMINCM06WNS6L_wfVNZxpRMf_B8s8wVpQ8lCuNFrhyJiLnz5CQ5NlZkAYumyinKIxQ6kEVCTg3I1OxeaLZ3J8ncBvttzcPbv-pDKZInkCecqCCtEiZ4LNMQTC3lnPYaBVnmFmS700SU2ragnnY2Y9cFNxVyPs81STaDR8BFNMOsqmiwwGiXvnJrxIMCN5pMPeOKWYBaCqcK3gVnkgD0agaLH73qse6Fx74GHPMtPGTHUL97cd6WF4FZiCmp__mFhl1gHmoZrcDilSO6GWpxzEqdBG3uCPy4IXTIUmf4-UwQ3Ok0a2l43x4G60Ik9z51e59hnYvzpPe93NDHfqd9u793CYgOf5FxXHIi-dtgvmkg2PNZ0ulX8QSy-soQRrL3jk2emyX73wRvRxQQZeh5INau4tTFSvTKrHiSvL3Hh9lC5gfujViWAD5lHToxCZz4IvgxjTCLqGSgAmoDP9tftms6DZr-0r3t9Aak5qp4vENTMAcRz5qDnjC8B-T8fjGThWD4Btc5O0tECJ2R8VWQSgGODoWt7mrKzucEVRYy-Oc04AqIQNXHBB5BgEKclcsBABbiabBdokmQ6J8R0s8SPVog5AvCaefCG45Et_Cld_-yA6YjHVTES2DDOe_V5SsBDD5IMXo18sdNuar9-PillqckQE4ReJBb6FJ2ACD2EoVpjDYylSH3iJESTL8Z2KF08ry9wAgxV6EqVSWoOWuxm52DanWlXmlOBRBBrF_vIGPHxd4nMizhvJjqWcVsRqg8FE2-5gov9NEHQn9xmTz0P1WVMhGrKnu0aMDd24z5Ghhzo-uHfKN32D8uM8c3WREiQPAWCrp8n1DhZATw0hiC2sVd37f73yiwBkPAr1Lcr53BoP25czCo5sQrLKgAyjqDjhgC1PwcjIEGvxL1rSWNdu9T7fr2oVfVbiRkkCeDDCFAWfXgeFnwEfa7NbdEmblF8LrPYCynVbDLyHEWsVgElEGwAe6uQ6fC4Jt9QJXcRTcDDwXe1ZgxEZjJMH_OQ5pyzDWuE6tfuh8DPKp-2AcbvE9uh7WQBKL4ixM5FoHXG1UHrQb4Ro-sBCZmS04iMwbG1MzmtdcCPUE6oTNmXqG4VySiUkjzdlSoFS4G-sLh5ydHUPOHogpf-45dcoyASmyPuCCioMxhPQIDViO8ECgqiwBAnFU5zG3745dOzWe-UPr9vd4UIe0cQrYjlKU3lXgi2NqW7hssLMDBRquQ1S8huXiY2Fw0HZAnzGIvAa14DXUCu-mSXj9VzAwy9iRdhHYS_MBn7dLOcAfUXijK2KbQqXBYTW8kzEFN7Ie711pYWG0OusNaQNmA1F48Wk6HEtLZwc46KZL9Fs2G_FI2kC6SdLrJxNhbnBiv_Zj87HObYOS-04fy9_KKJrwRwwcxvO-ILl59HYiHOzHo9L_9PL586g67D70NLTH1esEfMOMAP2ZtkB4KR00-x2kJ-3niY8h2bAkq0cRBBYhYcoy2yGEj_OD9Q2YoCz-FEc2JPPICwB4I00b-uQa4YZx0kXhViNCSsDN28g3X2VTL3UO_dt17qKkoNECasQzzdkrwUs5JOXcvMnUoRosAQVNpnxXXeTkUU1ZMZKUFUH0pyJUFSayZMyIiEmDZNI_NlutkCkSMsIkgqyzO0KgEIwFAHO0gzxXN8rFEO-TGJ3YqDdavm7x0Iyf99tTvDmpJH0QAmpUqLm7XAYEJWxcTMa7xQuY_V4lcMtmDGy2oB0OZw0QV7EclIl0NsPALbTTumVL12GiLQSwWCe6W2u9oO2YVh0t32DeSEDMW1A4OBq56U7959adBZ1uWX6sP5pXFPhVvrA2o4GzkhM3gBnk0oDcrHpjpSoS6cN1v-xzZP7AOwp-HfmQ7exdXSac37N5RVu1w8412c9s5-kkEWou7IX4Vdg5a6BC_K-LmVHShb79uK-ZBkeuAjx3oSoXcGlL51riKGZfjubkSEKzRryK3oWxJBzHMqrkGp1Y6Mk_D-V0MyKLO8UaxvAmt-Yrz9N7eP31t92oO8q3GarBN1Fi7sw5JhaA-lkMUoVcWS79DRBpZ8BURNlXU9qK8tCuhCw4c86yp340sLjTB-YoTGiZInEMUCP6U8D9yXkYHljm1yhHwQpGNxqKJUC-CrcWLpN4FSkc9gt5Ln9EFVy8iNn8Wk2lpkFlZWg9LcgdWQPVg92gNJq03IBIPgFDwkucFvQX9uVpBFzNAEfqr6yMcoocktlUyhXTJoIYq4hIOai3LiquB-xoKPm6NjsCCAcVTPNLEW7BpPRZLEIXiEswENA1oCw03xZoTYpqF2O5zE2ZwxxUKFBIDut-lv0_Dzno7P8Mtwi416VLziQnANR7FhtIjNu4iQwI2V94mvfP5SOsNe0ieY2nMtJdLNAgn-eO1zizlAxuaZKlau3_ILGZZgLObTeJIxw2v9wDiFD5YxT4l5U8d-KtfN5ZXjAXNiJNW9IJnBKW7VrcXszM_XEApMK_qDTM7NXSedaU_FbrDIt3wWdjlXOfSa95kpiFxajdlNwHWEcLWVnqMBocTUtWVFruToxXQiJQ3QhsHyAZUw9MuBgS4iKWcJj6wQy1-zctj8K3LVN4V16qYDR12hRmVKJj_CE2NdUODTi-9iagUS6ohd88hPfD5nA9Hc5sfjs8jrk4KIlMRVi4TN8djGiZhXCHQmTDs2YQqOQ-1W_z0uQeKCVa0mcKIdk-0b2-px_D4f4i8yAkRpLluDN60gydEr5YMZFTa2Tc1en7U3Ft5zJV0ZWxRTWz53U5VvGUcjbD5WYVY2XF0E6n_krnAbL7w4bg1ADV2Lzi9hnOQ-AFmrKznQx2q9clRoGTVRfhJvKf0lXX2mhxi4_KYs9srZUalW1T9rM-rKz0HVaRRI4QbNDHgUhZPTLyJdmQec5Lo-vkxh_GzKhZNxCSCC9MfS8FINhEL7gWdJqUWNz85nd9iTl83X3j_vnKMXj6jpFedP7zv9j8F85wlbSpl2ccFUty6mx_Tf8A5pv-4Az_gwX8AzH8fqsUjAAA',
            'style'     => 'H4sIAAAAAAAAAyXMywmAMAwA0FUEr36vrXjsHrGNUAiJNBFaxN09-AZ4m1oj3GFqaLcSPlFIiutDCP4UNncIpW5drtpByUCDAuuoWPLpDauNCaMUsCzsWBj9u81_-QFwFv38WgAAAA',
            'vanity'    => 'H4sIAAAAAAAAA22SwW7bMAyGX4VQrmuctV2AKLYxLMhQDGgTdN1hR9libK2qKFBM3Lz9ZDe9dINAgITE7_8pqRTTeIQWvU_RtC50lVqosYzG2kvZEFvkMUty9lipxrTPHdMxWD1brVbrwVnp9fXNIr6uVV0K57BwMt51oVJC8b3xAtXwOb7CdY4vOW5z15vEFbuuF53IOzsdmW02m5GYvQW4MA4URDfkLYx6YNgZ_ymZkK4SsjusW_LEerZcLtdZWY-eIiUnjoJm9EbcCTPza1mM1LosxP5jFy65x4Mo-GD-Jqsu8rp9m9ZAz3ioVC8SdVEMwzCPTH-wlZ4CniPJnLgrFLTepFSpM8oxeVT1_fb-2_YRdt9h_7j7sd08wd3uYfsb9runsjB12fB_4ceQfb_MW3pRH4k_8wbcGT5hEmTYM0m2kQeHB5SB-HlkZnMnZ9FCc4ZfE2tSm66hGJ-umP5E_Rf4NgkTGwIAAA',
        ]);
        $factory->setCallbackData([
            'emailCallback' => function($email, $style = null){
                $value = $email;
                $display = 'style="display:' . ['none',' none'][random_int(0,1)] . '"';
                $style = $style ?? random_int(0,5);
                $props[] = "href=\"mailto:$email\"";
        
                $wrap = function($value, $style) use($display){
                    switch($style){
                        case 2: return "<!-- $value -->";
                        case 4: return "<span $display>$value</span>";
                        case 5:
                            $id = 'r6s35a';
                            return "<div id=\"$id\">$value</div>\n<script>document.getElementById('$id').innerHTML = '';</script>";
                        default: return $value;
                    }
                };
        
                switch($style){
                    case 0: $value = ''; break;
                    case 3: $value = $wrap($email, 2); break;
                    case 1: $props[] = $display; break;
                }
        
                $props = implode(' ', $props);
                $link = "<a $props>$value</a>";
        
                return $wrap($link, $style);
            }
        ]);

        $transcriber = new DataTranscriber($templateData, $factory);

        $template = new ArrayTemplate([
            'doctype',
            'injDocType',
            'head1',
            'injHead1HTMLMsg',
            'robots',
            'injRobotHTMLMsg',
            'nocollect',
            'injNoCollectHTMLMsg',
            'head2',
            'injHead2HTMLMsg',
            'top',
            'injTopHTMLMsg',
            'actMsg',
            'errMsg',
            'customMsg',
            'legal',
            'injLegalHTMLMsg',
            'altLegalMsg',
            'emailCallback',
            'injEmailHTMLMsg',
            'style',
            'injStyleHTMLMsg',
            'vanity',
            'injVanityHTMLMsg',
            'altVanityMsg',
            'bottom',
            'injBottomHTMLMsg',
        ]);

        $hp = new Script($client, $transcriber, $template, $templateData, $factory);
        $hp->handle($host, $port, $script);
    }

    public function handle($host, $port, $script)
    {
        $data = [
            'tag1' => 'a7268b0ba204f97d27f22b99ffed2e8c',
            'tag2' => '9cb5c699cfbfd85943127f4ec97af546',
            'tag3' => '3649d4e9bcfd3422fb4f9d22ae0a2a91',
            'tag4' => md5_file(__FILE__),
            'version' => "php-".phpversion(),
            'ip'      => $_SERVER['REMOTE_ADDR'],
            'svrn'    => $_SERVER['SERVER_NAME'],
            'svp'     => $_SERVER['SERVER_PORT'],
            'sn'      => $_SERVER['SCRIPT_NAME']     ?? '',
            'svip'    => $_SERVER['SERVER_ADDR']     ?? '',
            'rquri'   => $_SERVER['REQUEST_URI']     ?? '',
            'phpself' => $_SERVER['PHP_SELF']        ?? '',
            'ref'     => $_SERVER['HTTP_REFERER']    ?? '',
            'uagnt'   => $_SERVER['HTTP_USER_AGENT'] ?? '',
        ];

        $headers = [
            "User-Agent: PHPot {$data['tag2']}",
            "Content-Type: application/x-www-form-urlencoded",
            "Cache-Control: no-store, no-cache",
            "Accept: */*",
            "Pragma: no-cache",
        ];

        $subResponse = $this->client->request("POST", "http://$host:$port/$script", $headers, $data);
        $data = $this->transcriber->transcribe($subResponse->getLines());
        $response = new TextResponse($this->template->render($data));

        $this->serve($response);
    }

    public function serve(Response $response)
    {
        header("Cache-Control: no-store, no-cache");
        header("Pragma: no-cache");

        print $response->getBody();
    }
}

Script::run(__REQUEST_HOST, __REQUEST_PORT, __REQUEST_SCRIPT, __DIR__ . '/phpot_settings.php');

