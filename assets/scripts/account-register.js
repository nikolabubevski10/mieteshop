jQuery(function(){

    //jQuery(document).ready(function() {
        jQuery('#afreg_select_user_role option[value="customer"]').attr("selected", "selected");
        jQuery('#afreg_select_user_role option[value=""]').remove();
    //});

    /*
    jQuery("input[type=file]").filestyle({ 
        image: "wp-content/themes/mieteshop/assets/images/choose-file-1.jpg",
        imageheight : 40,
        imagewidth : 150,
        width : 250
    });
    */

    jQuery(".jfilestyle").jfilestyle({text: "Επιλογή αρχείου: ", theme: 'black', buttonBefore: true});


/*
    jQuery('select[name=register_role]').on('change', 
    function () {
        // hide all optional elements
        jQuery('.fieldStudentPaso').hide();
        jQuery('.fieldETEemployeeCode').hide();

            
        jQuery("select[name=register_role] option:selected").each(function () {
            var value = jQuery(this).val();
            if(value == "students") {
                jQuery('.fieldStudentPaso').show();

            } else if(value == "teachers") {
                //jQuery('.fieldETEemployeeCode').show();              
            
            } else if(value == "ete_employees") {
                jQuery('.fieldETEemployeeCode').show();
            
            }

        });

        return false;
    }
    )
*/   
})
