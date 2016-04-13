<?php
/**
 * InteractiveVarDump
 *
 * @copyright  "Copyright" © 2o16 Apr, by Rafael Cieslik ( woodrow.shigeru@gmx.net )
 * @version    1.0.1
 * @url        https://github.com/WoodrowShigeru/InteractiveVarDump
 */


require_once "InteractiveVarDump/InteractiveVarDump_Tree.class.php";
 
 
$ivd_initialized = FALSE;
 
 
function ivd( $subject, $pretext = false ) {
 
    global $ivd_initialized;
 
    if (!$ivd_initialized) {
         // apply necessary includes.
 
        echo '<style type="text/css">';
            include "ivd.css";
        echo '</style>';
 
        echo '<script type="text/javascript">';
            include "jquery.js";
        echo '</script>';
 
        echo '<script type="text/javascript">';
            include "ivd.js";
        echo '</script>';
 
        $ivd_initialized = TRUE;
    }
 
    if ($pretext) {
        echo $pretext .':<br />';
    }
 
    $tree = new InteractiveVarDump_Tree($subject);
    echo $tree->display();
}
 
 
 // set up some aliases.
function dump( $subject, $pretext = false ) {
    ivd($subject, $pretext);
}

