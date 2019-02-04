<?php
/**
 * Description: Allows for displaying a single WPForms entry on a page via a shortcode.
 * User:        ekeel
 * Date:        2/4/2019
 * Time:        1:07 PM
 * Usage:       [wpfv_single_entry]
 * Param:       N/A
 * Query Param:
 *              wpfformid  => The ID of the form from WPForms.
 *              wpfentryid => The ID of the entry to display.
 */

function wpfv_entry() {
    global $wpdb;
    global $current_user;

    if(isset($_POST)) {
        if(isset($_POST['data'])) {
            $table = $wpdb->prefix . 'wpforms_entry_meta';

            $data = array(
                'entry_id' => $_POST['entry_id'],
                'data' => nl2br($_POST['data']),
                'user_id' => $_POST['user_id'],
                'form_id' => $_POST['form_id'],
                'type' => $_POST['type'],
                'date' => $_POST['date']
            );

            $format = array(
                '%d',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s'
            );

            $wpdb->insert($table, $data, $format);
        }
    }

    get_currentuserinfo();

    $formid = get_query_var('wpfformid');
    $entryid = get_query_var('wpfentryid');

    if ( empty( $formid )) {
        echo 'Woops...<br>Something went wrong.<br>Could not determine the form ID.';
        return;
    }

    if ( empty( $entryid )) {
        echo 'Woops...<br>Something went wrong.<br>Could not determine the entry ID.';
        return;
    }

    $form = wpforms()->form->get( absint( $formid ) );
    if ( empty( $form ) ) {
        echo 'Woops...<br>Something went wrong.<br>Could retrieve the form.';
        return;
    }

    $ids        = array();
    $ifv        = array();

    $form_data  = !empty( $form->post_content ) ? wpforms_decode( $form->post_content ) : '';
    $entries    = wpforms()->entry->get_entries( array( 'form_id' => absint( $formid ), 'number' => 100000, 'entry_id' => $entryid ) );
    $disallow   = apply_filters( 'wpforms_frontend_entries_table_disallow', array( 'divider', 'html', 'pagebreak', 'captcha' ) );

    echo '<div >';
    echo '<hr>';
    echo '<h3>' . $entryid . '</h3>';

    foreach( $form_data['fields'] as $field ) {
        if ( !in_array( $field['type'], $disallow )) {
            $ids[] = $field['id'];
            $ifv[$field['id']] = $field['label'];
        }
    }

    foreach( $entries as $entry ) {
        $fields = wpforms_decode( $entry->fields );
        foreach( $fields as $field ) {
            if ( in_array( $field['id'], $ids )) {
                echo '<div style="width: 100%; background-color: #E9F1FA; min-height: 20px; margin-top: 6px;"><span style="margin-left: 4px; font-weight:600;">' . $ifv[$field['id']] . '</span></div>';
                echo '<div style="width: 100%; background-color: #FFFFFF; min-height: 20px;"><span style="margin-left: 4px;">' . apply_filters( 'wpforms_html_field_value', wp_strip_all_tags( $field['value'] ), $field, $form_data, 'entry-frontend-table' ) . '</span></div>';
            }
        }
    }

    echo '</div>';

    echo '<hr>';
    echo '<h3>Notes</h3>';

    echo '<div id="new_note">';
    echo '<form id="new_note_form" name="newNoteForm" method="post" action="">';
//    echo '<input type="text" id="data" name="data"/>';
    echo '<textarea id="data" name="data" style="min-height: 90px;"></textarea>';
    echo '<input type="hidden" id="user_id" name="user_id" value="' . $current_user->ID . '"/>';
    echo '<input type="hidden" id="entry_id" name="entry_id" value="' . $entryid . '"/>';
    echo '<input type="hidden" id="form_id" name="form_id" value="' . $formid . '"/>';
    echo '<input type="hidden" id="type" name="type" value="note"/>';
    echo '<input type="hidden" id="date" name="date" value="' . date('Y/m/d H:i:s', time()) . '"/>';
    echo '<input id="submit" name="submit" type="submit" value="Save" />';
    echo '</form>';
    echo '</div>';

    echo '<div id="show_notes">';

    $wem_table = $wpdb->prefix . 'wpforms_entry_meta';
    $usr_table = $wpdb->prefix . 'users';

    $notes = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM `" . $wem_table . "` WHERE `type`='note' AND `entry_id`= %d AND `form_id` = %d ORDER BY `date` DESC", $entryid, $formid)
    );

    foreach ($notes as $note) {
        $uname = $wpdb->get_results(
            $wpdb->prepare("SELECT `display_name` FROM `" . $usr_table . "` WHERE `ID` = %d", $note->user_id)
        );

        if (intval($note->user_id) == $current_user->ID) {
            echo '<div style="min-height: 20px; margin-bottom: 30px;">';
            echo '	<p style="border: 2px solid #E7EFF9; border-radius: 15px 3px 15px 15px; background-color: #E7EFF9; box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">';
            echo '		<span style="margin-left: 4px;"><cite>' . $uname[0]->display_name . '</cite> on <em>' . $note->date . '</em></span><br>';
            echo '		<span style="margin-left: 12px;">' . str_replace("</p>", "<br><br>", str_replace("<p>", "", $note->data)) . '</span>';
            echo '	</p>';
            echo '</div>';
        } else {
            echo '<div style="min-height: 20px; margin-bottom: 30px;">';
            echo '	<p style="border: 2px solid #F1F1F1; border-radius: 3px 15px 15px 15px; background-color: #F1F1F1; box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;">';
            echo '		<span style="margin-left: 4px;"><cite>' . $uname[0]->display_name . '</cite> on <em>' . $note->date . '</em></span><br>';
            echo '		<span style="margin-left: 12px;">' . str_replace("</p>", "<br><br>", str_replace("<p>", "", $note->data)) . '</span>';
            echo '	</p>';
            echo '</div>';
        }
    }
    echo '</div>';
}

add_shortcode('wpfv_single_entry', 'wpfv_entry');