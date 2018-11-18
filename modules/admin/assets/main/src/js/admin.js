var admin = (function($) {

    $(function() {

    });

    return {

        setFriendly : function(readElem, writeElem)
        {
            $(readElem).on('keyup', function()
            {
                $(writeElem).val( admin.nameToUrl( $(this).val() ) );
            });
        },

        nameToUrl: function(name) 
        {
            name = name.replace(/[őóö]/ig,'o');
            name = name.replace(/[űüú]/ig,'u');
            name = name.replace(/[é]/ig,'e');
            name = name.replace(/[á]/ig,'a');
            name = name.replace(/[í]/ig,'i');
            name = name.toLowerCase(); // lowercase
            name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
            name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
            name = name.replace(/[^a-z-0-9]/g, ''); // remove everything that is not [a-z] or -

            return name;
        },

        ckEditor: function( editorElement ){
            CKEDITOR.config.skin = 'moono';

            CKEDITOR.replace( editorElement, {
                 filebrowserBrowseUrl: vars.kcFinderDir+'/browse.php?type=files',
                 filebrowserImageBrowseUrl: vars.kcFinderDir+'/browse.php?type=images',
                 filebrowserFlashBrowseUrl: vars.kcFinderDir+'/browse.php?type=flash',
                 filebrowserUploadUrl: vars.kcFinderDir+'/upload.php?type=files',
                 filebrowserImageUploadUrl: vars.kcFinderDir+'/upload.php?type=images',
                 filebrowserFlashUploadUrl: vars.kcFinderDir+'/upload.php?type=flash'
            });
        },

        iCheck: function(){
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
            $('body').addClass('login-page');
        },

        dropdownToggle: function(clickedElem, targetElem){
            $(clickedElem).on('change', function(){
                if($(this).val() == 'collection_product'){
                    $(targetElem).toggle();
                }else{
                    $(targetElem).hide();
                }
            });
        }
    }
})(jQuery);
 
 