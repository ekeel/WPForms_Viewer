<?php
/**
 * Description: Adds filters to query_vars allowing for capturing wpfformid & wpfentryid using get_query_var.
 * User:        ekeel
 * Date:        2/4/2019
 * Time:        1:44 PM
 * Filters:
 *              query_vars .= wpfformid
 *              query_vars .= wpfentryid
 */

function wpfv_register_query_vars($qvars) {
//    $qvars = array('wpfformid', 'wpfentryid');
    $qvars[] .= 'wpfformid';
    $qvars[] .= 'wpfentryid';
    return $qvars;
}

add_filter('query_vars', 'wpfv_register_query_vars');