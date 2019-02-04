# WPForms Viewer
*WPForms Viewer is a plugin that allows you to embed WPForms entry lists and single items using shortcodes.*

![alt demo-image-4](https://github.com/ekeel/WPForms_Viewer/raw/master/md_content/dem-form-4.png)

## How It Works
WPForms Viewer uses the database tables created by WPForms to display your data. There are no additional tables/DBs created.

The entry data is not mutable using this plugin, however the meta data for the entries can be appended to. Meaning, you can add notes to the entries that will appear in both the custom and default admin views.

## Capabilities
| Name | Status | Description |
| ---- | ------ | ----------- |
| Entry List | MVP | Display a list of entries for a WPForms form from the DB in a searchable list on a page/post using a shortcode. |
| Singe Entry | MVP | Display a single WPForms form entry on a page/post using a shortcode with query variables.<br>There is an included notes section where new notes can be added. |

## Query Variable Filters
*These query variables are added to the 'query_vars' filter to allow capturing pertinent data using 'get_query_vars()'.*
  
| Reg. Function | Var | Description |
| ------------- | --- | ----------- |
| wpfv_register_query_vars | wpfformid | Allows for capturing the WPForms form id from the query variables in single entry views. |
| wpfv_register_query_vars | wpfentryid | Allows for capturing the WPForms entry id from the query variables in single entry views. |

## Shortcodes
*These shortcodes allow you to add WPForms views to your pages/posts using shortcodes.*

| Reg. Function | Parameters | Query Parameters | Usage | Description |
| ------------- | ---------- | ---------------- | ----- | ----------- |
| wpfv_entries | formid => The ID of the form from WPForms.<br><br>columns => A comma separated list of columns to display in the table.<br><br>single => The page to redirect to for single form entries. | N/A | [wpfv_entries_list formid="<FORM_ID>" columns="<COLUMNS>" single=""] | Allows for displaying WPForms entries in a list on a page via a shortcode. |
| wpfv_entry | N/A | wpfformid => The ID of the form from WPForms.<br><br>wpfentryid => The ID of the entry to display. | [wpfv_single_entry] | Allows for displaying a single WPForms entry on a page via a shortcode. |

## Demo Images
*WPForms Form*
![alt demo-image-1](https://github.com/ekeel/WPForms_Viewer/raw/master/md_content/dem-form-1.png)

*WPForms List View*
![alt demo-image-2](https://github.com/ekeel/WPForms_Viewer/raw/master/md_content/dem-form-2.png)

*WPForms Single Entry*
![alt demo-image-3](https://github.com/ekeel/WPForms_Viewer/raw/master/md_content/dem-form-3.png)

*WPForms Single Entry w/ Notes*
![alt demo-image-4](https://github.com/ekeel/WPForms_Viewer/raw/master/md_content/dem-form-4.png)