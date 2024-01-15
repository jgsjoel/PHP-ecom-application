<?php


class Common
{

    public static $x;
    public static $button_count;

    public static function checker($query)
    {
        if (Common::$x == null) {
            Common::$x = true;
            return $query .= "WHERE ";
        } elseif (Common::$x == true) {
            return $query .= " AND ";
        }
    }

    public static function getButtonCount($product_count, $limit)
    {

        $remender = $product_count / $limit - intval($product_count / $limit);

        if ($remender == 0) {
            Common::$button_count = $product_count / $limit;
            return Common::$button_count;
        } else {
            Common::$button_count = intval($product_count / $limit) + 1;
            return Common::$button_count;
        }
    }
}
