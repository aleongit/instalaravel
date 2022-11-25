<?php

namespace App\Helpers;

use DateTime;


class FormatTime
{   
    //helper per formatar hora -> Fa x (dies, hores, minuts, segons)
    public static function LongTimeFilter($date) {
        //
        $data = new DateTime($date);
        $avui = new DateTime();
        //dd($data->format('Y-m-d H:i:s.u') . " / " . $avui->format('Y-m-d H:i:s.u') );

        $dif = $avui->diff($data);
        //dd( $dif->format('%Y anys %m mesos %d dies, %H hores, %i minuts, %s segons') );

        if ($dif->format('%Y') == '0') {

            if ($dif->format('%m') == '0') {

                if ($dif->format('%d') == '0') {
                    
                    //$resultat = 'Fa menys de 1 dia';
                    if ($dif->format('%H') == '0') {
                        
                        //$resultat = 'Fa menys de 1 hora';
                        if ($dif->format('%i') == '0') {
                            $res = $dif->format('%s');
                            $res == '1'? $res.= ' segon': $res.= ' segons';
        
                        } else {
                            $res = $dif->format('%i');
                            $res == '1'? $res.= ' minut': $res.= ' minuts';
                        }
                    } else {
                        $res = $dif->format('%H');
                        $res == '1'? $res.= ' hora': $res.= ' hores';
                    }
                } else {
                    $res = $dif->format('%d');
                    $res == '1'? $res.= ' dia': $res.= ' dies';
                } 
            } else {
                $res = $dif->format('%m');
                $res == '1'? $res.= ' mes': $res.= ' mesos';
                }
        } else {
            $res = $dif->format('%Y');
            $res == '1'? $res.= ' any': $res.= ' anys';
            }
        return 'Fa ' . $res;
    }
}
