/* global wp, Rcl */
wp.customize('tcl_bbck', function (value) {
    jQuery('.tcl_bmenu,.pager-item:not(.type-separator) > *,.recall-button:not(.active)').css('background', Rcl.tclBck);
    value.bind(function (to) {
        jQuery('.tcl_bmenu,.pager-item:not(.type-separator) > *,.recall-button:not(.active)').css('background', to);
    });
});
wp.customize('tcl_bbrd', function (value) {
    jQuery('.tcl_bmenu,.pager-item:not(.type-separator) > *,.recall-button:not(.active)').css('border', '2px solid ' +Rcl.tclBrd);
    value.bind(function (to) {
        jQuery('.tcl_bmenu,.pager-item:not(.type-separator) > *,.recall-button:not(.active)').css('border', '2px solid '+to);
    });
});
wp.customize('tcl_bclr', function (value) {
    jQuery('.tcl_bmenu,.pager-item:not(.type-separator) > *,.recall-button:not(.active)').css('color', Rcl.tclClr);
    value.bind(function (to) {
        jQuery('.tcl_bmenu,.pager-item:not(.type-separator) > *,.recall-button:not(.active)').css('color', to);
    });
});


wp.customize('tcl_babck', function (value) {
    jQuery('.pager-item.type-current > *,.recall-button[class*="active"],input[type="submit"].recall-button').css('background', Rcl.tclBckA);
    value.bind(function (to) {
        jQuery('.pager-item.type-current > *,.recall-button[class*="active"],input[type="submit"].recall-button').css('background', to);
    });
});
wp.customize('tcl_babrd', function (value) {
    jQuery('.pager-item.type-current > *,.recall-button[class*="active"],input[type="submit"].recall-button').css({'border':Rcl.tclBrdA,'color':'#fff'});
    value.bind(function (to) {
        jQuery('.pager-item.type-current > *,.recall-button[class*="active"],input[type="submit"].recall-button').css('border', '2px solid '+to);
    });
});