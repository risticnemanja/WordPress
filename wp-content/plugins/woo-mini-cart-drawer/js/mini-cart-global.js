( function( $ ) {
    jQuery( document ).ready(function( $ ) {
        $("#mini-cart-review").on("click",function (e) {
            e.preventDefault();
            var url = $(this).attr("href");
            $.getJSON(url);
            $(this).closest(".notice.apbd-notice-st1").remove();
        });

        $("body").on("click",'.apbd-thickbox',function(e) {
            e.preventDefault();

            tb_show("", $(this).attr('href'));
            return false;
        });
        $("body").on("click",'.apbd-remove-nt',function(e) {
            e.preventDefault();
            try {
                var url = $(this).attr('href');
                if(url.length>0) {
                    $.getJSON(url);
                }
            }catch(e){
                console.log(e.message);
            }
            $(this).closest('.notice').fadeOut();
        });
    });


} )( jQuery );