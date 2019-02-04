<?php

/*
Plugin Name: WPForms Viewer
Plugin URI: https://github.com/ekeel/WPForms_Viewer
Description: WPForms Viewer is a plugin that allows you to embed WPForms entry lists and single items using shortcodes.
Version: 0.1
Author: ekeel
License: GPL2
*/

// Create an array of files to include.
$php_import_files = array(
    // Filters to import.
    'src/filter/single_entry_filters.php',

    // Shortcodes to import.
    'src/shortcode/list_entries_shortcode.php',
    'src/shortcode/single_entry_shortcode.php'
);

// Include all of the php_import_files.
foreach ($php_import_files as $import_file) {
    include(plugin_dir_path(__FILE__) . $import_file);
}