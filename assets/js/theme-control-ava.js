/* global RclUploaders */

// загрузка авы
rcl_add_action( 'rcl_footer', 'tclAva' );
function tclAva() {
    var tclUploader = RclUploaders.get( 'rcl_avatar' );
    if ( undefined === tclUploader )
        return;

    tclUploader.afterDone = function( e, data ) {
        jQuery( '#tcl_ava img, .rcb_right_menu .avatar, .uit_avatar img' ).attr( 'srcset', '' )
            .attr( 'src', data.result.src.thumbnail )
            .load()
            .animateCss( 'zoomIn' );

        rcl_do_action( 'rcl_success_upload_cover', data );
    };

    tclUploader.animateLoading = function( status ) {
        status ? rcl_preloader_show( jQuery( 'body:not(.uit_run) .tcl_right, .uit_avatar' ) ) : rcl_preloader_hide();
    };
}