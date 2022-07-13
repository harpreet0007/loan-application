<?php
namespace App\Helpers;

class Helper{
    public static function GetTotalWithIntrest($principal,$interest,$term,$term_frequency)
    {
        $total=0;
        for($i = 1;$i<=($term * $term_frequency);$i++)
        {
            $total+= self::GetEmi($principal,$interest,$term,$term_frequency,$i);
        }
        return $total;
    }
    public static function GetEmi($principal,$interest,$term,$term_frequency=12,$which_term)
    {
        $rate = $interest/100/$term_frequency;
        $time = $term*$term_frequency;
        $x= pow(1+$rate,$time);
        $monthly = ($principal*$x*$rate)/($x-1);
        $monthly = round($monthly);
        $k= $time;
        $arr= array();
        $upto = $time;
        $result=self::getEmiTerm($principal,$which_term,$upto,$rate,$monthly,$principal);
        return number_format($result, 2, '.', '');
    }
    public static function getEmiTerm($t,$which_term,$upto,$rate,$monthly,$tl,$i=0){
        $i++;
        if($upto<=0){
            return 0;
        }
        $r = $t*$rate;
        $p = round($monthly-$r);
        $e= round($t-$p);
        if($upto==2){
            $tl= $e;
        }
        if($upto==1){
            $p= $tl;	
            $e= round($t-$p);
            $monthly= round($p+$r);
        }
        if($i==$which_term){
            return $monthly;
        }else{
            $upto--;
           return self::getEmiTerm($e,$which_term,$upto,$rate,$monthly,$tl,$i);
        }
    }
}

