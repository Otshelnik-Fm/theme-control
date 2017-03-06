/* global wp */
wp.customize('tc_menu_bckgrnd', function (value) {
    value.bind(function (to) {
        jQuery('#lk-menu .rcl-tab-button .recall-button:not(.active)').css('background', to);
    });
});
wp.customize('tc_menu_border', function (value) {
    value.bind(function (to) {
        jQuery('#lk-menu .rcl-tab-button .recall-button:not(.active)').css('border-bottom', '2px solid '+to);
    });
});
wp.customize('tc_menu_color', function (value) {
    value.bind(function (to) {
        jQuery('#lk-menu .rcl-tab-button .recall-button').css('color', to);
    });
});


wp.customize('tc_menu_bckgrnd_active', function (value) {
    value.bind(function (to) {
        jQuery('#lk-menu .rcl-tab-button .recall-button.active').css('background', to);
    });
});
wp.customize('tc_menu_border_active', function (value) {
    value.bind(function (to) {
        jQuery('#lk-menu .rcl-tab-button .recall-button.active').css('border-bottom', '2px solid '+to);
    });
});