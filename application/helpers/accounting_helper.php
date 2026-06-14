<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('ind_money_format')) {
    /**
     * Formats a number to Indian Currency System (Lakhs/Crores grouping)
     * e.g., 1234567.89 -> 12,34,567.89
     *
     * @param float $amount
     * @param bool $with_symbol
     * @return string
     */
    function ind_money_format($amount, $with_symbol = false) {
        $is_negative = false;
        if ($amount < 0) {
            $is_negative = true;
            $amount = abs($amount);
        }
        
        // Round to 2 decimal places
        $amount = round($amount, 2);
        
        // Split into integer and decimal parts
        $parts = explode('.', $amount);
        $num = $parts[0];
        $decimal = isset($parts[1]) ? $parts[1] : '00';
        if (strlen($decimal) == 1) {
            $decimal .= '0';
        }

        // Format integer part according to Indian numbering system
        $last_three = substr($num, -3);
        $rest = substr($num, 0, -3);
        if ($rest != '') {
            $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);
            $formatted_num = $rest . ',' . $last_three;
        } else {
            $formatted_num = $last_three;
        }

        $result = $formatted_num . '.' . $decimal;
        if ($is_negative) {
            $result = '-' . $result;
        }
        
        if ($with_symbol) {
            return '₹' . $result;
        }
        return $result;
    }
}
