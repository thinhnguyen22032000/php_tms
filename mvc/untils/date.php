
<?php
class DateLib
{
    static function isWeekend($date)
    {
        $weekDay = date('w', strtotime($date));
        return ($weekDay == 0 || $weekDay == 6);
    }
    static function partial_day($count_day, $partial_day)
    {
        switch ($partial_day) {
            case 'mor':
                return $count_day / 2;
                break;
            case 'aft':
                return $count_day / 2;
            default:
                return $count_day;
                break;
        }
    }
    static function duration($start, $end, $partial_day)
    {
        $begin = new DateTime($start);
        $end   = new DateTime($end);
        $countDay = 0;
        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            if (!DateLib::isWeekend($i->format("Y-m-d"))) {
                $countDay++;
            }
        }
        return DateLib::partial_day($countDay, $partial_day);
    }
}
