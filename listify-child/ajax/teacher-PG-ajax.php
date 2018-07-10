<?php

header('Content-Type: application/json');
include("../../../../wp-load.php");

$aResult = array();

if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($aResult['error']) ) {

    switch($_POST['functionname']) {
        //Add a passport function
        case 'insert_teacherPG':
            //Check again if there is a passport title (should not happened because we already check it in JavaScript)
        	if( !isset($_POST['teacherPGTitle']) ) { $aResult['error'] = 'No title!'; }

            //Check again if there is a passport language (same as title)
			else if( !isset($_POST['teacherPGLanguage']) ) { $aResult['error'] = 'No language!'; }

            //Check again if there is a passport student (same as title)
			else if( !isset($_POST['PGTeacher']) ) { $aResult['error'] = 'No student!'; }

            //If everything is good, we create the passport
            else {
            	$PG_information = array(
				    'post_title' => $_POST['teacherPGTitle'],
				    'post_content' => "",
				    'post_type' => 'teacher_portfolio',
				    'post_status' => 'publish',
				    'meta_input'   => array(
				        '_passport' 			=> array(),
				        '_passport_language' 	=> $_POST['teacherPGLanguage'],
				        '_teacher'				=> $_POST['PGTeacher']
				    )
				);

                //If the passport is well inserted
				if ( $postID = wp_insert_post( $PG_information ) ) {
                    //We redirect to the single passport page
					$aResult['redirectLink'] = get_post_permalink( $postID );
				} else {
					$aResult['error'] = 'Can\'t insert the passport in database, try later!';
				}
			}
            break;

        //Update a passport (competencies form)
        case 'update_teacherPG':
            //Check if the current passport exists
        	if( !isset($_POST['post']) ) { $aResult['error'] = 'No profiling grid!'; }

            //We update the post meta (checkboxes)
        	else if( update_post_meta( $_POST['post'], "teacher_portfolio", $_POST['teacherPGChecked'] ) ){
        		
        	} else {
                $aResult['error'] = 'Can\'t update the profiling grid, try later!';
            }
        	break;

        //Delete a passport
        case 'delete_teacherPG':
            //Check if the passport exists
        	if( !isset($_POST['post']) ) { $aResult['error'] = 'No profiling grid!'; }

        	else{
                //If the passports has a thumbnail
                if( has_post_thumbnail( $_POST['post'] ) ){
                    $attachment_id = get_post_thumbnail_id( $_POST['post'] );
                    //We delete the thumbnail and the associated file
                    if ( wp_delete_attachment( $attachment_id, true ) ){
                		
                    } else {
                        $aResult['error'] = 'Attachement deletion impossible! Try later.';
                    }
                }

                //Then we delete the post
                if( wp_delete_post( $_POST['post'] ) ){
                    //And we remove the directory that contains the thumbnail file (if it exists)
                    $wp_upload_dir = wp_upload_dir();
                    $uploaddir = $wp_upload_dir['basedir'] . '/portfolios/'. get_current_user_id() . '/' . $_POST['post'] . '/';

                    if ( file_exists($uploaddir) ){
                        rmdir( $uploaddir );
                    }

                    $aResult['redirectLink'] = get_permalink( get_page_by_path( 'teacher_portfolio' ) );
                } else {
                    $aResult['error'] = 'Post deletion impossible! Try later.';
                }
        	}

        	break;

        //Add or change the passport thumbnail
        case 'passport_thumbnail':
            //If the passport have a thumbnail
            if( has_post_thumbnail( $_POST['post'] ) ){
                //We first delete the file of the previous thumbnail
                $attachment_id = get_post_thumbnail_id( $_POST['post'] );
                if ( wp_delete_attachment( $attachment_id, true ) ){
                    //Then we add the new one
                    $files = array();
                    if(isset($_FILES)){

                        global $current_user;
                        get_currentuserinfo();

                        $files = array();
                        $wp_upload_dir = wp_upload_dir();

                        $uploaddir = $wp_upload_dir['basedir'] . '/portfolios/'. get_current_user_id() . '/' . $_POST['post'] . '/';

                        if (!file_exists($uploaddir))
                            mkdir($uploaddir, 0777, true);

                        foreach($_FILES as $file){

                            if( move_uploaded_file( $file['tmp_name'], $uploaddir .basename( $file['name'] ) ) ){
                                // $filename should be the path to a file in the upload directory.
                                $filename = 'portfolios/' . get_current_user_id() . '/' . $_POST['post'] . '/' . basename( $file['name'] ) ;
                                 
                                // The ID of the post this attachment is for.
                                $parent_post_id = $_POST['post'];
                                 
                                // Check the type of file. We'll use this as the 'post_mime_type'.
                                $filetype = wp_check_filetype( basename( $filename ), null );
                                 
                                // Prepare an array of post data for the attachment.
                                $attachment = array(
                                    'guid'           => $wp_upload_dir['baseurl'] . '/portfolios/'. get_current_user_id() . '/' . $_POST['post'] . '/' . basename( $filename ), 
                                    'post_mime_type' => $filetype['type'],
                                    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                                    'post_content'   => '',
                                    'post_status'    => 'inherit'
                                );
                                
                                // Insert the attachment.
                                $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
                                 
                                // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                                 
                                // Generate the metadata for the attachment, and update the database record.
                                $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );

                                wp_update_attachment_metadata( $attach_id, $attach_data );
                                 
                                set_post_thumbnail( $parent_post_id, $attach_id );
                                
                                
                            } else{
                                $aResult['error'] = 'Error move uploaded file!';
                            }

                        }
                    }
                } else {
                    $aResult['error'] = 'Attachement deletion impossible! Try later.';
                }
            } 
            //If it's the first thumbnail, we just add the thumbnail and creates the repository that will contain the file
            else {
                $files = array();
                if(isset($_FILES)){

                    global $current_user;
                    get_currentuserinfo();

                    $files = array();
                    $wp_upload_dir = wp_upload_dir();

                    $uploaddir = $wp_upload_dir['basedir'] . '/portfolios/'. get_current_user_id() . '/' . $_POST['post'] . '/';

                    if (!file_exists($uploaddir))
                        mkdir($uploaddir, 0777, true);

                    foreach($_FILES as $file){

                        if( move_uploaded_file( $file['tmp_name'], $uploaddir .basename( $file['name'] ) ) ){
                            // $filename should be the path to a file in the upload directory.
                            $filename = 'portfolios/' . get_current_user_id() . '/' . $_POST['post'] . '/' . basename( $file['name'] ) ;
                             
                            // The ID of the post this attachment is for.
                            $parent_post_id = $_POST['post'];
                             
                            // Check the type of file. We'll use this as the 'post_mime_type'.
                            $filetype = wp_check_filetype( basename( $filename ), null );
                             
                            // Prepare an array of post data for the attachment.
                            $attachment = array(
                                'guid'           => $wp_upload_dir['baseurl'] . '/portfolios/'. get_current_user_id() . '/' . $_POST['post'] . '/' . basename( $filename ), 
                                'post_mime_type' => $filetype['type'],
                                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                                'post_content'   => '',
                                'post_status'    => 'inherit'
                            );
                            
                            // Insert the attachment.
                            $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
                             
                            // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                            require_once( ABSPATH . 'wp-admin/includes/image.php' );
                             
                            // Generate the metadata for the attachment, and update the database record.
                            $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );

                            wp_update_attachment_metadata( $attach_id, $attach_data );
                             
                            set_post_thumbnail( $parent_post_id, $attach_id );
                            
                            
                        } else{
                            $aResult['error'] = 'Error move uploaded file!';
                        }

                    }
                }
            } 

            break;

        //Upload evidence
        case 'action_upload_files':

          if(isset($_FILES))
          {
              global $current_user;
              get_currentuserinfo();

              $error = false;
              $files = array();

              $uploaddir = plugin_dir_path( dirname( __FILE__ ) ) . '../../../uploads/profiling-grids/'.$_POST['type_user'].'/';
              $uploaddir = $uploaddir.get_current_user_id().'/';

              if (!file_exists($uploaddir))
                mkdir($uploaddir, 0777, true);

              foreach($_FILES as $file)
              {
                  if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
                  {
                      update_post_meta($_POST['post_ID'], $_POST['tab'], basename($file['name']));
                      $files[] = basename($file['name']);
                  }
                  else
                  {
                      $error = true;
                  }
              }
              $aResult = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
          }

            break;

        case 'action_delete_evidence':
            $dir = wp_upload_dir();
            $file = "";
            $error = false;

            if( unlink( $dir['basedir'] . '/profiling-grids/' . $_POST['type_user'] . '/' . get_current_user_id() . '/' . get_post_meta($_POST['post_ID'],$_POST['tab'],true) ) )
              {
                $file = get_post_meta( $_POST['post_ID'],$_POST['tab'],true );
                delete_post_meta( $_POST['post_ID'], $_POST['tab'] );
              }
              else
              {
                $error = true;
              }
              $aResult = ($error) ? array('error' => 'There was an error deleting your files') : array('file' => $file);
            break;

        case 'action_upload_evidence':

          if(isset($_FILES))
          {
              global $current_user;
              get_currentuserinfo();

              $error = false;
              $files = array();
              $dir = wp_upload_dir();

              $uploaddir = $dir['basedir'] . '/profiling-grids/' . $_POST['type_user'] . '/' . get_current_user_id() . '/';

              if (!file_exists($uploaddir))
                mkdir($uploaddir, 0777, true);

              foreach($_FILES as $file)
              {
                  if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
                  {
                      update_post_meta($_POST['post_ID'], $_POST['tab'], basename($file['name']));
                      $files[] = basename($file['name']);
                  }
                  else
                  {
                      $error = true;
                  }
              }
              $aResult = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
          }
            break;

        //Add or change the PG thumbnail
        case 'PG_thumbnail':
            //If the PG have a thumbnail
            if( has_post_thumbnail( $_POST['post'] ) ){
                //We first delete the file of the previous thumbnail
                $attachment_id = get_post_thumbnail_id( $_POST['post'] );
                if ( wp_delete_attachment( $attachment_id, true ) ){
                    //Then we add the new one
                    $files = array();
                    if(isset($_FILES)){

                        global $current_user;
                        get_currentuserinfo();

                        $files = array();
                        $wp_upload_dir = wp_upload_dir();

                        $uploaddir = $wp_upload_dir['basedir'] . '/profiling-grids/teacher-files/'. get_current_user_id() . '/' . $_POST['post'] . '/';

                        if (!file_exists($uploaddir))
                            mkdir($uploaddir, 0777, true);

                        foreach($_FILES as $file){

                            if( move_uploaded_file( $file['tmp_name'], $uploaddir .basename( $file['name'] ) ) ){
                                // $filename should be the path to a file in the upload directory.
                                $filename = '/profiling-grids/teacher-files/' . get_current_user_id() . '/' . $_POST['post'] . '/' . basename( $file['name'] ) ;
                                 
                                // The ID of the post this attachment is for.
                                $parent_post_id = $_POST['post'];
                                 
                                // Check the type of file. We'll use this as the 'post_mime_type'.
                                $filetype = wp_check_filetype( basename( $filename ), null );
                                 
                                // Prepare an array of post data for the attachment.
                                $attachment = array(
                                    'guid'           => $wp_upload_dir['baseurl'] . '/profiling-grids/teacher-files/'. get_current_user_id() . '/' . $_POST['post'] . '/' . basename( $filename ), 
                                    'post_mime_type' => $filetype['type'],
                                    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                                    'post_content'   => '',
                                    'post_status'    => 'inherit'
                                );
                                
                                // Insert the attachment.
                                $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
                                 
                                // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                                 
                                // Generate the metadata for the attachment, and update the database record.
                                $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );

                                wp_update_attachment_metadata( $attach_id, $attach_data );
                                 
                                set_post_thumbnail( $parent_post_id, $attach_id );
                                
                                
                            } else{
                                $aResult['error'] = 'Error move uploaded file!';
                            }

                        }
                    }
                } else {
                    $aResult['error'] = 'Attachement deletion impossible! Try later.';
                }
            } 
            //If it's the first thumbnail, we just add the thumbnail and creates the repository that will contain the file
            else {
                $files = array();
                if(isset($_FILES)){

                    global $current_user;
                    get_currentuserinfo();

                    $files = array();
                    $wp_upload_dir = wp_upload_dir();

                    $uploaddir = $wp_upload_dir['basedir'] . '/profiling-grids/teacher-files/'. get_current_user_id() . '/' . $_POST['post'] . '/';

                    if (!file_exists($uploaddir))
                        mkdir($uploaddir, 0777, true);

                    foreach($_FILES as $file){

                        if( move_uploaded_file( $file['tmp_name'], $uploaddir .basename( $file['name'] ) ) ){
                            // $filename should be the path to a file in the upload directory.
                            $filename = '/profiling-grids/teacher-files/' . get_current_user_id() . '/' . $_POST['post'] . '/' . basename( $file['name'] ) ;
                             
                            // The ID of the post this attachment is for.
                            $parent_post_id = $_POST['post'];
                             
                            // Check the type of file. We'll use this as the 'post_mime_type'.
                            $filetype = wp_check_filetype( basename( $filename ), null );
                             
                            // Prepare an array of post data for the attachment.
                            $attachment = array(
                                'guid'           => $wp_upload_dir['baseurl'] . '/profiling-grids/teacher-files/'. get_current_user_id() . '/' . $_POST['post'] . '/' . basename( $filename ), 
                                'post_mime_type' => $filetype['type'],
                                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                                'post_content'   => '',
                                'post_status'    => 'inherit'
                            );
                            
                            // Insert the attachment.
                            $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
                             
                            // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                            require_once( ABSPATH . 'wp-admin/includes/image.php' );
                             
                            // Generate the metadata for the attachment, and update the database record.
                            $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );

                            wp_update_attachment_metadata( $attach_id, $attach_data );
                             
                            set_post_thumbnail( $parent_post_id, $attach_id );
                            
                            
                        } else{
                            $aResult['error'] = 'Error move uploaded file!';
                        }

                    }
                }
            } 

            break;

        case 'action_delete_thumbnail':
            $dir = wp_upload_dir();
            $error = false;

            if( unlink( $dir['basedir'] . $_POST['thumbnail_name'] ) )
              {
                wp_delete_attachment( $_POST['thumbnail_id'], true );
              }
              else
              {
                $error = true;
              }
              $aResult = ($error) ? array('error' => 'There was an error deleting your thumbnail') : array('file' => $file);
            break;

        default:
           $aResult['error'] = 'Not found function '.$_POST['functionname'].' !';
           break;
    }

}

echo json_encode($aResult);