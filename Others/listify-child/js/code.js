/**
 *  This function do an ajax call to the function searchBadges (searchBadges_ajax_handler).
 */
function searchBadges() {

    var tmp = "";

    var e = document.getElementById("target-selection");
    var target = e.options[e.selectedIndex].text;

    var e = document.getElementById("target-level");
    tmp = e.options[e.selectedIndex].value;
    var level = tmp == 0 ? "" : e.options[e.selectedIndex].text;



    jQuery.post(ajaxurl, {
        action: "searchBadges",
        target: target, level: level
    }, function (html) {
        if(html != ""){
            jQuery('#show-search-badge').html(html);
        } else {
            jQuery('#show-search-badge').html(
                '<div class="alert alert-dark alert-dismissible fade show" role="alert">\n' +
                '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '    <span aria-hidden="true">&times;</span>\n' +
                '  </button>\n' +
                '  <strong>No badges found!</strong> You should try to modify the field of the searching.\n' +
                '</div>');
        }

    });
}

/*
function targetLevelChange(valueSelected){
    jQuery.post(ajaxurl, {
        action: "searchBadges",
        searchTerm: searchTerm
    }, function (html) {
        if(html != ""){
            jQuery('#show-search-badge').html(html);
        } else {
            jQuery('#show-search-badge').html(
                "<div class='no-result-search'><h2>Sorry, but there's" +
                " no results!</h2> </div>");
        }

    });
}

jQuery(document).ready(function () {

    jQuery("#target-selection").change(function () {
        var valueSelected = jQuery('#target-selection').find(":selected").text();
        targetLevelChange(valueSelected);
    });

});
*/