/*
	This is the file that contain my JS functions.
*/

//Toggle button to display or not (by clicking) the search form in the archive badge page
function toggle_filter_form() {
    var x = document.getElementById("filter-form");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function toggle_passport_form() {
    var x = document.getElementById("add-passport-form");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

//Add a new passport
var btnAddPassport = "#new-passport-form";
jQuery(document).on("submit", btnAddPassport, function (event) {
    jQuery(btnAddPassport).prop('disabled', true);
    event.preventDefault();

    var title = jQuery("#passportTitle").val();
    var userID = jQuery("#user").val();
    var e = document.getElementById("passportLanguage");
	var language = e.options[e.selectedIndex].value;
	var functionUrl = ajax_function_path.ajaxFunctionURL;

	if( title == '' ){
		jQuery("#error-content").html('Please enter a title.');
	} else if( language == 'Select' ){
		jQuery("#error-content").html('Please select a language.');
	} else if( userID == null ){
		jQuery("#error-content").html('No user.');
	} else{
		jQuery.ajax({
		    type: "POST",
		    url: functionUrl+"/passport-ajax.php",
		    dataType: 'json',
		    data: {
		    	functionname: 'insert_passport',
		    	passportTitle: title, 
		    	passportLanguage: language,
		    	passportStudent: userID
		    },
		    success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                	window.location.href = obj.redirectLink;
	            }
	            else {
	                console.log(obj.error);
	            }
            },
            error : function(resultat, statut, erreur){
            	jQuery("#error-content").html("AJAX ERROR");
       		}
		});
	}
});

//Save the passport
var btnSavePassport = "#save-passport-form";
jQuery(document).on("submit", btnSavePassport, function (event) {
	jQuery("#error-content").html( '' );
    jQuery(btnSavePassport).prop('disabled', true);
    event.preventDefault();

    var e = document.getElementsByName("passport[]");
    var checkedValues = [];
    var id = jQuery("#postID").val();
    var functionUrl = ajax_function_path.ajaxFunctionURL;

    if( id == null ){
		jQuery("#error-content").html('This passport doesn\'t exist.');
	} else {
		for(var i=0; e[i]; ++i){
	        if(e[i].checked){
	      		checkedValues.push( e[i].value );
	      	}
		}

		jQuery.ajax({
		    type: "POST",
		    url: functionUrl+"/passport-ajax.php",
		    dataType: 'json',
		    data: {
		    	functionname: 'update_passport',
		    	passportChecked: checkedValues, 
		    	post: id
		    },
		    success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                	location.reload();
	            }
	            else {
	                console.log(obj.error);
	            }
            },
            error : function(resultat, statut, erreur){
            	jQuery("#error-content").html("AJAX ERROR");
       		}
		});


	}  
});

//Delete the passport
var btnDeletePassport = "#delete-passport-form";
jQuery(document).on("submit", btnDeletePassport, function (event) {
	jQuery("#error-content").html( '' );
    jQuery(btnDeletePassport).prop('disabled', true);
    event.preventDefault();

    var id = jQuery("#postID").val();
    var functionUrl = ajax_function_path.ajaxFunctionURL;

    if( id == null ){
		jQuery("#error-content").html('This passport doesn\'t exist.');
	} else {
		jQuery.ajax({
		    type: "POST",
		    url: functionUrl+"/passport-ajax.php",
		    dataType: 'json',
		    data: {
		    	functionname: 'delete_passport',
		    	post: id
		    },
		    success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                	window.location.href = obj.redirectLink;
	            }
	            else {
	                console.log(obj.error);
	            }
            },
            error : function(resultat, statut, erreur){
            	jQuery("#error-content").html("AJAX ERROR");
       		}
		});


	}  
});

//Upload thumbnail's passport
var btnThumbnailPassport = "#thumbnail-passport-form";
jQuery(document).on("submit", btnThumbnailPassport, function (event) {
	jQuery("#error-content").html( '' );
    jQuery(btnThumbnailPassport).prop('disabled', true);
    event.preventDefault();

    var id = jQuery("#postID").val();
    var files = document.getElementById('thumbnail').files

    var data = new FormData();
    jQuery.each(files, function(key, value)
    {
        data.append(key, value);
    });
    data.append("functionname", "passport_thumbnail");
    data.append("post", id); 

    
    var functionUrl = ajax_function_path.ajaxFunctionURL;

    if( id == null ){
		jQuery("#error-content").html('This passport doesn\'t exist.');
	} else if (typeof files == 'undefined' || files.length <= 0) {
		jQuery("#error-content").html('Please select a file.');
	} else {
		jQuery("#result_upload_files").html("Please wait. Uploading...");
		jQuery.ajax({
		    type: "POST",
		    url: functionUrl+"/passport-ajax.php",
		    dataType: 'json',
		    data: data,
		    cache: false,
		    processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
		    success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    location.reload();
	            }
	            else {
	                jQuery("#result_upload_files").html(obj.error);
	            }
            },
            error : function(resultat, statut, erreur){
            	jQuery("#result_upload_files").html("AJAX ERROR");
       		}
		});


	}  
});