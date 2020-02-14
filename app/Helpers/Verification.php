<?php
namespace App\Helpers;


class Verification{





    public static function verifyDeudaFospuca($rif)
    {
        $url = 'http://oficinavirtual.fospuca.com/rest/gob/deu_cli/iribarren/' . $rif;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if (curl_exec($curl) === false) {
            echo 'Curl error: ' . curl_error($curl);
        } else {
            $return = curl_exec($curl);
        }
        curl_close($curl);
        if ($return == '"no_cliente"') {
            $return = ['mora_fospuca' => false];
        } else {
            $return = json_decode($return, true);
            if ($return['total_deuda'] == 0) {
                $return['mora_fospuca'] = false;
            } else {
                $return['mora_fospuca'] = true;
            }
            return $return;
        }
    }


}