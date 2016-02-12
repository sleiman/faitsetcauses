<?php

/**
  This script will show how to extract
  all sort of Archive (Tar, Gzip, Zip) etc..
  
*/
require 'ArchiveExtractor.class.php';

/* Init. ArchiveExtractor Object */
$archExtractor=new ArchiveExtractor();

/* Extract */
//                             -Archive       -Path
$extractedFileList=$archExtractor->extractArchive("Desktop.zip",".");
?>
<pre>
  <?php print_r($extractedFileList); ?>
</pre>
