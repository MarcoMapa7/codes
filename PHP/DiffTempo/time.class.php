<?php

  class time{

    public function Time_ago($time_atrás) {
        $time_atrás =  strtotime($time_atrás) ? strtotime($time_atrás) : $time_atrás;
        $time  = time() - $time_atrás;
       switch($time):
        // seconds
        case $time <= 60;
        return ($time == 1) ? "Agora" : $time." segundo(s) atrás";
        // minutes
        case $time >= 60 && $time < 3600;
        return (round($time/60) == 1) ? '1 min atrás' : round($time/60).' mins atrás';
        // hora(s)
        case $time >= 3600 && $time < 86400;
        return (round($time/3600) == 1) ? '1 hour atrás' : round($time/3600).' hora(s) atrás';
        // dias
    	  case $time >= 86400 && $time < 604800;
    	  return (round($time/86400) == 1) ? '1 day atrás' : round($time/86400).' dias atrás';
        // Semana(s)s
        case $time >= 604800 && $time < 2600640;
        return (round($time/604800) == 1) ? '1 Semana(s) atrás' : round($time/604800).' Semana(s)s atrás';
        // meses
        case $time >= 2600640 && $time < 31207680;
        return (round($time/2600640) == 1) ? '1 month atrás' : round($time/2600640).' meses atrás';
        // ano(s)
        case $time >= 31207680;
        return (round($time/31207680) == 1) ? '1 year atrás' : round($time/31207680).' ano(s) atrás' ;

        endswitch;
      }

    public function maliknormalTime($time){
      $str = strtotime($time);
      return date("d-F-Y h:i:s a", $str);
    }

  }
