/**
 *  This function do an ajax call to the function searchBadges (searchBadges_ajax_handler).
 */
function searchBadges() {

    var e = document.getElementById("target-selection");
    var target = e.options[e.selectedIndex].text;
    var e = document.getElementById("target-level");
    var level = e.options[e.selectedIndex].text;
    alert(target+" "+level);
    jQuery.post(ajaxurl, {
        action: "searchBadges",
        target: target, level: level
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