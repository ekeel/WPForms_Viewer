<?php
/**
 * Description: Allows for displaying WPForms entries in a list on a page via a shortcode.
 * User:        ekeel
 * Date:        2/4/2019
 * Time:        11:58 AM
 * Usage:       [wpfv_entries_list formid="<FORM_ID>" columns="<COLUMNS>" single=""]
 * Param:
 *              FORM_ID => The ID of the form from WPForms
 *              COLUMNS => A comma separated list of columns to display in the table.
 *              SINGLE  => The page to redirect to for single form entries.
 * Query Param: N/A
 */

function wpfv_entries($atts) {
    $atts = shortcode_atts(array(
        'formid' => '',
        'columns' => '',
        'single' => ''
    ), $atts);

    if (empty($atts['formid']) || empty($atts['columns']) || empty($atts['single']) || !function_exists('wpforms')) {
        echo 'Woops...<br>Something went wrong.';
        return;
    }

    $show_fields = explode(",", $atts['columns']);

    $form = wpforms()->form->get(absint($atts['formid']));
    if(empty($form)) {
        echo 'Woops...<br>Could not retrieve the form related to FORM_ID: ' . $atts['formid'];
        return;
    }

    $form_data = !empty($form->post_content) ? wpforms_decode($form->post_content) : '';

    $entries = wpforms()->entry->get_entries(array('form_id' => absint($atts['formid']), 'number' => 100000));

    $disallow  = apply_filters( 'wpforms_frontend_entries_table_disallow', array( 'divider', 'html', 'pagebreak', 'captcha' ) );

    $ids = array();

    ob_start();

    echo '<div style="min-height: 80px; height:auto; height: 400px; overflow-x:auto;">';
    echo '<table class="wpforms-frontend-entries" id="myTable" style="border-collapse: collapse; width: 100%;">';
    echo '<thead><tr>';
    echo '<th style="border: 0px solid #dddddd; text-align: left; padding: 8px;">' . ' ';
    echo '<th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . 'ID';

    foreach( $form_data['fields'] as $field ) {
        if ( !in_array( $field['type'], $disallow ) ) {
            if (in_array($field['label'], $show_fields)) {
                $ids[] = $field['id'];
                echo '<th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . sanitize_text_field( $field['label'] ) . '</th>';
            }
        }
    }

    echo '</tr></thead>';

    echo '<tbody>';

    foreach( $entries as $entry ) {
        echo '<tr>';

        echo '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><a href="' . get_site_url() . '/' . $atts['single'] . '/?wpfformid=' . absint( $atts['formid'] ) . '&wpfentryid=' . $entry->entry_id . '">View</a>';
        echo '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . $entry->entry_id;

        $fields = wpforms_decode( $entry->fields );

        foreach( $fields as $field ) {
            if ( in_array( $field['id'], $ids ) ) {
                echo '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . apply_filters( 'wpforms_html_field_value', wp_strip_all_tags( $field['value'] ), $field, $form_data, 'entry-frontend-table' );
            }
        }

        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';

    $output = ob_get_clean();
    return $output;
}

add_shortcode('wpfv_entries_list', 'wpfv_entries');