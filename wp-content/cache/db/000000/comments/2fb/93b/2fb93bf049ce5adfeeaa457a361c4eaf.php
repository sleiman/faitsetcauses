H�V<?php exit; ?>a:6:{s:10:"last_error";s:0:"";s:10:"last_query";s:311:"SELECT ID, COUNT( comment_ID ) AS ccount 

            FROM wp_posts 

            LEFT JOIN wp_comments ON ( comment_post_ID = ID AND comment_approved = '1' AND comment_type='pingback' ) 

            WHERE post_status = 'publish' AND ID IN (12567,12450,12358,12278,12251,12170,12091) 

            GROUP BY ID";s:11:"last_result";a:7:{i:0;O:8:"stdClass":2:{s:2:"ID";s:5:"12091";s:6:"ccount";s:1:"0";}i:1;O:8:"stdClass":2:{s:2:"ID";s:5:"12170";s:6:"ccount";s:1:"0";}i:2;O:8:"stdClass":2:{s:2:"ID";s:5:"12251";s:6:"ccount";s:1:"0";}i:3;O:8:"stdClass":2:{s:2:"ID";s:5:"12278";s:6:"ccount";s:1:"0";}i:4;O:8:"stdClass":2:{s:2:"ID";s:5:"12358";s:6:"ccount";s:1:"0";}i:5;O:8:"stdClass":2:{s:2:"ID";s:5:"12450";s:6:"ccount";s:1:"0";}i:6;O:8:"stdClass":2:{s:2:"ID";s:5:"12567";s:6:"ccount";s:1:"0";}}s:8:"col_info";a:2:{i:0;O:8:"stdClass":13:{s:4:"name";s:2:"ID";s:5:"table";s:8:"wp_posts";s:3:"def";s:0:"";s:10:"max_length";i:5;s:8:"not_null";i:1;s:11:"primary_key";i:1;s:12:"multiple_key";i:0;s:10:"unique_key";i:0;s:7:"numeric";i:1;s:4:"blob";i:0;s:4:"type";s:3:"int";s:8:"unsigned";i:1;s:8:"zerofill";i:0;}i:1;O:8:"stdClass":13:{s:4:"name";s:6:"ccount";s:5:"table";s:0:"";s:3:"def";s:0:"";s:10:"max_length";i:1;s:8:"not_null";i:1;s:11:"primary_key";i:0;s:12:"multiple_key";i:0;s:10:"unique_key";i:0;s:7:"numeric";i:1;s:4:"blob";i:0;s:4:"type";s:3:"int";s:8:"unsigned";i:0;s:8:"zerofill";i:0;}}s:8:"num_rows";i:7;s:10:"return_val";i:7;}