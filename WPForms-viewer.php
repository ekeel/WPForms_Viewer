<?php

/*
Plugin Name: WPForms Viewer
Plugin URI: https://github.com/ekeel/WPForms_Viewer
Description: WPForms Viewer is a plugin that allows you to embed WPForms entry lists and single items using shortcodes.
Version: 0.1
Author: ekeel
License: GPL2
*/

$php_import_files = array(
    'src/filter/single_entry_filters.php',
    'src/shortcode/list_entries_shortcode.php',
    'src/shortcode/single_entry_shortcode.php'
);

foreach ($php_import_files as $import_file) {
    include(plugin_dir_path(__FILE__) . $import_file);
}