<?php
    function getFromUrl($url, $method = 'GET')
    {
        $ch = curl_init();
        $agent = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0)';

        switch(strtoupper($method))
        {
            case 'GET':
                curl_setopt($ch, CURLOPT_URL, $url);
                break;

            case 'POST':
                $info = parse_url($url);
                $url = $info['scheme'] . '://' . $info['host'] . $info['path'];
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $info['query']);
                break;

            default:
                return false;
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    require_once 'parsecsv-for-php/parsecsv.lib.php';

    header('Content-type:text/html;charset=utf-8');

    $csv = new parseCSV();
    $csv->encoding('euc-kr', 'UTF-8');
    $csv->parse('store_data.csv');

    $data = $csv->data;
    $length = count($data);

    for($i = 0; $i < $length; $i++) {
        echo('<br>');

        echo("위도 : '".$csv->data[$i]["위도"]."' ");
        echo("경도 : '".$csv->data[$i]["경도"]."' ");

        if($csv->data[$i]["위도"] && $csv->data[$i]["위도"]) {
            echo("continue");
            continue;
        }

        $addr = "";
        $tmp = $data[$i]["지번주소"];
        $tmp = trim($tmp);
        echo("지번주소 : '".$tmp."' ");
        if(strcmp($tmp, "") != 0) {
            $addr = $tmp;
        }

        $tmp = $data[$i]["도로명주소"];
        $tmp = trim($tmp);
        echo("도로명주소 : '".$tmp."' ");
        if(strcmp($tmp, "") != 0) {
            $addr = $tmp;
        }

        if(strcmp($addr, "") != 0) {
            echo(" -> ");

            $addr = urlencode($addr);
            $url = "https://apis.daum.net/local/geo/addr2coord?apikey=15cb592fbb45aa138cc902dbc2d9b5bf&q='$addr'&output=json";
            $html = getFromUrl($url, 'GET');
            $json = json_decode($html, true);

            $csv->data[$i]["위도"] = $json["channel"]["item"][0]["lat"];
            $csv->data[$i]["경도"] = $json["channel"]["item"][0]["lng"];

            echo($csv->data[$i]["위도"].", ".$csv->data[$i]["경도"]);

            $csv->encoding('UTF-8', 'euc-kr');
            $csv->save();
            $csv->encoding('euc-kr', 'UTF-8');
        }
    }
?>
