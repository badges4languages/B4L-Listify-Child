<?php

header('Content-Type: application/json');
include("../../../../wp-load.php");

$aResult = array();

if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($aResult['error']) ) {

    switch($_POST['functionname']) {
        case 'insert_passport':
        	if( !isset($_POST['passportTitle']) ) { $aResult['error'] = 'No title!'; }

			else if( !isset($_POST['passportLanguage']) ) { $aResult['error'] = 'No language!'; }

			else if( !isset($_POST['passportStudent']) ) { $aResult['error'] = 'No student!'; }

            else {
            	$passport_information = array(
				    'post_title' => $_POST['passportTitle'],
				    'post_content' => "",
				    'post_type' => 'passport',
				    'post_status' => 'publish',
				    'meta_input'   => array(
				        '_passport' 			=> array(),
				        '_passport_language' 	=> $_POST['passportLanguage'],
				        '_student'				=> $_POST['passportStudent']
				    )
				);

				if ( $postID = wp_insert_post( $passport_information ) ) {
					$aResult['redirectLink'] = get_post_permalink( $postID );
				} else {
					$aResult['error'] = 'Can\'t insert the passport in database, try later!';
				}
			}
            break;

        case 'update_passport':
        	if( !isset($_POST['post']) ) { $aResult['error'] = 'No passport!'; }

        	else if( update_post_meta( $_POST['post'], "_passport", $_POST['passportChecked'] ) ){
        		
        	} else {
                $aResult['error'] = 'Impossible to update, try later!';
            }
        	break;

        case 'delete_passport':
        	if( !isset($_POST['post']) ) { $aResult['error'] = 'No passport!'; }

        	else{
                if( has_post_thumbnail( $_POST['post'] ) ){
                    $attachment_id = get_post_thumbnail_id( $_POST['post'] );
                    if ( wp_delete_attachment( $attachment_id, true ) ){
                		
                    } else {
                        $aResult['error'] = 'Attachement deletion impossible! Try later.';
                    }
                }

                if( wp_delete_post( $_POST['post'] ) ){
                    $wp_upload_dir = wp_upload_dir();
                    $uploaddir = $wp_upload_dir['basedir'] . '/portfolios/'. get_current_user_id() . '/' . $_POST['post'] . '/';

                    if ( file_exists($uploaddir) ){
                        rmdir( $uploaddir );
                    }

                    $aResult['redirectLink'] = get_permalink( get_page_by_path( 'passport' ) );
                } else {
                    $aResult['error'] = 'Post deletion impossible! Try later.';
                }
        	}

        	break;

        case 'passport_thumbnail':
            if( has_post_thumbnail( $_POST['post'] ) ){
                $attachment_id = get_post_thumbnail_id( $_POST['post'] );
                if ( wp_delete_attachment( $attachment_id, true ) ){
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
            } else {
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

        default:
           $aResult['error'] = 'Not found function '.$_POST['functionname'].' !';
           break;
    }

}

echo json_encode($aResult);