<?php

/* /////////////////////////
   /   Limit Upload Size   /
   ///////////////////////// */

// Limit the upload size limit to 1MB for any users who are not an administrator.
function limit_upload_size_limit_for_non_admin( $limit ) {
  if ( ! current_user_can( 'manage_options' ) ) {
    $limit = '1000000'; // 1mb in bytes
  }
  return $limit;
}
add_filter( 'upload_size_limit', 'limit_upload_size_limit_for_non_admin' );