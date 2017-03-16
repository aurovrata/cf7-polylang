<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://syllogic.in
 * @since      1.0.0
 *
 * @package    Cf7_Polylang
 * @subpackage Cf7_Polylang/admin/partials
 */
global $polylang;
//add a hidden field with the post type
$post_type = WPCF7_ContactForm::post_type;
?>
<script type="text/html" id="polylang-metabox">
  <div id="ml_box" class="postbox ">
    <button type="button" class="handlediv button-link" aria-expanded="true">
      <span class="screen-reader-text">Toggle panel: Languages</span>
      <span class="toggle-indicator" aria-hidden="true"></span>
    </button>
    <h2 class="hndle ui-sortable-handle"><span>Languages</span></h2>
    <input type="hidden" id="post_type" name="post_type" value="wpcf7_contact_form" />
    <div class="inside">

<?php
$polylang->filters_post->post_language();
//file:polylang/admin/admin-filters-post.php
?>
    </div>
  </div>
</script>
<script type="text/javascript">
  ( function( $ ) {
    $(document).ready( function(){
      var metabox = $('#polylang-metabox').html();
      $('div#postbox-container-1').prepend(metabox);
    } );
  } )( jQuery );
</script>
