<?php 

namespace App\Libraries;


class Uuid
{

    public function generate_uuid_product()
    {
        return 'P'.date('ymd');
    }

    public function decode_uuid_product($values)
    {
        return substr($values,4);
    }

    public function generate_uuid($values)
    {
        $t=explode(" ",microtime());
        return sprintf( '%08s-%06x-%08s-%04s-%04x%04x',
            $this->getClientIp(),
            $values,
            substr("00000000".dechex($t[1]),-8),
            substr("0000".dechex(round($t[0]*65536)),-4),
            mt_rand(0,0xffff), mt_rand(0,0xffff)
        );
    }

    public function decode_uuid($uuid)
    {
        $rez=Array();
        $u=explode("-",$uuid);
        if(is_array($u)&&count($u)==5) {
            $rez=Array(
                'ip'=> $this->clientIPFromHex($u[0]),
                'valueId'=>$u[1],
                'unixtime'=>hexdec($u[2]),
                'micro'=>(hexdec($u[3])/65536)
            );
        }
        return $rez;
    }

    private function getClientIp()
    {
        $hex="";
        $ip = getEnv("REMOTE_ADDR");
        $part=explode('.', $ip);
        for ($i=0; $i<=count($part)-1; $i++) {
            $hex.=substr("0".dechex($part[$i]),-2);
        }
        return $hex;
    }

    private function clientIPFromHex($hex) {
        $ip="";
        if(strlen($hex)==8) {
            $ip.=hexdec(substr($hex,0,2)).".";
            $ip.=hexdec(substr($hex,2,2)).".";
            $ip.=hexdec(substr($hex,4,2)).".";
            $ip.=hexdec(substr($hex,6,2));
        }
        return $ip;
    }

}