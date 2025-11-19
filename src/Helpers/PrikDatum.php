<?php

namespace mmerlijn\msgRepo\Helpers;

use Carbon\Carbon;
use mmerlijn\msgRepo\Msg;

class PrikDatum
{
    public static function get(Msg $msg, ?Carbon $today=null):?Carbon
    {
        $date = $msg->order->start_date; //carbon or null
        if (!$today) {
            $today = Carbon::now();
        }
        if(!$date){
            $obs = $msg->order->getObservationByTestcode("ZZ");
            $date = $obs?->value ?: null;
        }
        return self::CheckDateField($date, $today);
        
    }
    public static function set(Msg &$msg, Carbon $date):void
    {
        $observation = new \mmerlijn\msgRepo\Observation(
            type: 'DT',
            value: $date->format('Ymd'),
            test: new \mmerlijn\msgRepo\TestCode(
                code: 'ZZ',
                value: '"gewenste afnamedatum"',
                source: "99zdl",
            ),
        );
        $msg->order->addObservation($observation);
        $msg->order->start_date = $date;
    }
    public static function reset(Msg &$msg):void
    {
        $msg->order->filterTestCodes(['YY','ZZ']);
        $msg->order->start_date = null;
    }

    public static function CheckDateField(null|string|Carbon $date, Carbon $today): ?Carbon
    {
        if(!$date){
            return null;
        }
        if ($date instanceof Carbon) {
            if($date->isBefore($today)){
                return null;
            }else{
                return $date;
            }
        }
        $month = ['januari' => 1, 'jan' => 1, 'februari' => 2, 'feb' => 2, 'maart' => 3, 'maa' => 3, 'mrt' => 3, 'april' => 4, 'apr' => 4, 'mei' => 5, 'juni' => 6, 'jun' => 6, 'juli' => 7, 'jul' => 7, 'augustus' => 8, 'aug' => 8, 'september' => 9, 'sep' => 9, 'spt' => 9, 'sept' => 9, 'oktober' => 10, 'okt' => 10, 'november' => 11, 'nov' => 11, 'december' => 12, 'dec' => 12];
        $days = ['graag', 'morgen', 'maandag', 'ma', 'dinsdag', 'di', 'woensdag', 'wo', 'woe', 'donderdag', 'do', 'vrijdag', 'vr', 'vrij', 'zaterdag', 'za', 'zondag', 'zo'];
        $dt = str_replace(["  ", "   "], " ", $date);
        $e = preg_split("/\/|-| |\./", $dt);

        //teksten verwijderen uit opmerking
        $i = 0;
        $Length_old = count($e);
        $Length_nieuw = 0;
        while (count($e) > 3 AND $Length_old != $Length_nieuw) {
            $Length_old = count($e);
            if (in_array(strtolower($e[$i]), $days) OR !is_numeric($e[$i])) {
                array_shift($e);
            }
            $Length_nieuw = count($e);
        }
        //teksten na een datum verwijderen
        if (count($e) > 3) {
            $e = array_slice($e, 0, 3);
        }
        switch (count($e)) {//betreft een gescheiden datum bv door - of /
            case 3:

                //maand is in text
                if (in_array(strtolower($e[1]), array_keys($month))) {
                    $m = $month[strtolower($e[1])];
                    $d = (int)$e[0];
                    $y = (int)$e[2];
                    //string begint met een dag

                } else {
                    //YYYY-mm-dd
                    $m = (int)$e[1];
                    if ((int)$e[0] > (int)$e[2] AND (int)$e[0] > 100) {
                        $d = (int)$e[2];
                        $y = (int)$e[0];

                    } else {//dd-mm-YYYY
                        $d = (int)$e[0];
                        $y = (int)$e[2];
                    }
                }
                if ($y == 0) {
                    $y = (int)$today->format("Y");
                    if ((int)$today->format("n") > $m) {
                        $y++;
                    }
                }
                break;
            case 2:
                if (in_array(strtolower($e[1]), array_keys($month))) {
                    $m = $month[strtolower($e[1])];
                } else {
                    $m = (int)$e[1];
                }
                $d = (int)$e[0];
                $y = (int)$today->format("Y");
                if ((int)$today->format("n") > $m) {
                    $y++;
                }
                break;
            case 1:
                switch (strlen($e[0])) {
                    case 6: //ddmmyy
                        $d = (int)substr($e[0], 0, 2);
                        $m = (int)substr($e[0], 2, 2);
                        $y = (int)substr($e[0], 4, 2);
                        break;
                    case 8: //ddmmyyyy of yyyymmdd
                        if ((int)substr($e[0], 0, 3) == 202) { //yyyymmdd
                            $d = (int)substr($e[0], 6, 2);
                            $m = (int)substr($e[0], 4, 2);
                            $y = (int)substr($e[0], 0, 4);
                        } else {
                            $d = (int)substr($e[0], 0, 2);
                            $m = (int)substr($e[0], 2, 2);
                            $y = (int)substr($e[0], 4, 4);
                        }
                        break;
                    case 4:
                        $d = (int)substr($e[0], 0, 2);
                        $m = (int)substr($e[0], 2, 2);
                        $y = (int)$today->format("Y");
                        if ((int)$today->format("n") > $m) {
                            $y++;
                        }
                        break;
                    default:
                        return null;
                }
                break;
            default:
                return null;
        }
        if ($y < 100) {
            $y = 20 . $y;
        }
        //Het moet wel een geldige datum worden
        //if ($d == 0 OR $m == 0 OR $d > 31 OR $m > 12 OR $y < date("Y") OR $y > (int)$today->format("Y") + 1) {
        if ($d == 0 OR $m == 0 OR $d > 31 OR $m > 12 OR $y > (int)$today->format("Y")+1 OR $y < (int)$today->format("Y") )  {
            return null;
        }

        //datum mag niet in het verleden liggen en niet gelijk zijn aan vandaag
        if ((int)date("Ymd", mktime(0, 0, 0, $m, $d, $y)) <= (int)$today->format("Ymd")) {

            return null;
        }

        //Alles is goed gegaan, we geven de datum terug
        return Carbon::createFromFormat('Y-m-d', date("Y-m-d", mktime(0, 0, 0, $m, $d, $y)));
    }
}