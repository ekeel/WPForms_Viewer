# WPForms Viewer
*WPForms Viewer is a plugin that allows you to embed WPForms entry lists and single items using shortcodes.*

## Query Variable Filters
*These query variables are added to the 'query_vars' filter to allow capturing pertinent data using 'get_query_vars()'.*
  
| File | Reg. Function | Var | Description | Notes |
| ---- | ------------- | --- | ----------- | ----- |
| single_entry_filters.php | wpfv_register_query_vars | wpfformid | Allows for capturing the WPForms form id from the query variables in single entry views. | |
| single_entry_filters.php | wpfv_register_query_vars | wpfentryid | Allows for capturing the WPForms entry id from the query variables in single entry views. | |

## Shortcodes
*These shortcodes allow you to add WPForms views to your pages/posts using shortcodes.*

| File | Reg. Function | Parameters | Query Parameters | Usage | Description |
| ---- | ------------- | ---------- | ---------------- | ----- | ----------- |
| list_entries_shortcode.php | wpfv_entries | formid => The ID of the form from WPForms.<br><br>columns => A comma separated list of columns to display in the table.<br><br>single => The page to redirect to for single form entries. | N/A | [wpfv_entries_list formid="<FORM_ID>" columns="<COLUMNS>" single=""] | Allows for displaying WPForms entries in a list on a page via a shortcode. |
| single_entry_shortcode.php | wpfv_entry | N/A | wpfformid => The ID of the form from WPForms.<br><br>wpfentryid => The ID of the entry to display. | [wpfv_single_entry] | Allows for displaying a single WPForms entry on a page via a shortcode. |