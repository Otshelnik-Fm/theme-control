<?php

/*

  ╔═╗╔╦╗╔═╗╔╦╗
  ║ ║ ║ ╠╣ ║║║ http://otshelnik-fm.ru
  ╚═╝ ╩ ╚  ╩ ╩

 */


/* admin options */
if ( is_admin() ) {
    require_once 'inc/settings.php';
}

/* load */
require_once 'inc/author-menu.php';
require_once 'inc/button-reorder.php';
require_once 'inc/theme-supports.php';


// Константа TCL_THEME.
if ( ! defined( 'TCL_THEME' ) ) {
    define( 'TCL_THEME', __FILE__ );
}


/*
 *  great packer's
 *      https://cssminifier.com/
 *      http://dean.edwards.name/packer/
 *
 */

/* подключим стили и скрипт */
add_action( 'rcl_enqueue_scripts', 'tcl_load_resource', 10 );
function tcl_load_resource() {
    if ( ! rcl_is_office() )
        return;

    rcl_enqueue_style( 'tcl_style', rcl_addon_url( 'assets/css/theme-control.min.css', __FILE__ ) );

    global $user_ID;

    if ( rcl_exist_addon( 'liberty-tabs' ) && rcl_is_office( $user_ID ) )
        return;

    rcl_enqueue_script( 'tcl_script', rcl_addon_url( 'assets/js/theme-control.min.js', __FILE__ ), false, true );
}

// стили кнопок
add_action( 'rcl_enqueue_scripts', 'tcl_load_button_styles', 10 );
function tcl_load_button_styles() {
    if ( ! rcl_is_office() )
        return;

    if ( is_customize_preview() )
        return;

    // стиль типа кнопок:
    $type = rcl_get_option( 'tcl_bttn', 'lite' );

    rcl_enqueue_style( 'tcl_style_bttn', rcl_addon_url( 'assets/css/lk-button-' . $type . '.min.css', __FILE__ ) );
}

add_action( 'plugins_loaded', 'tcl_textdomain', 10 );
function tcl_textdomain() {
    global $locale;

    load_textdomain( 'theme-control', rcl_addon_path( __FILE__ ) . '/languages/theme-control-' . $locale . '.mo' );
}

// "Подробная информация"
function tcl_user_info() {
    // не нужна она при допе user-info-tab
    if ( rcl_exist_addon( 'user-info-tab' ) )
        return;

    // автобот доп и это кабинет автобота
    if ( rcl_exist_addon( 'autobot-cabinet' ) && atbc_is_autobot() )
        return;

    // поддержка настройки допа Friends Cabinet Access
    if ( rcl_exist_addon( 'friends-cabinet-access' ) && rcl_get_option( 'fca_info', 'yes' ) == 'yes' )
        return;

    if ( rcl_get_option( 'tcl_info', '1' ) == 0 )
        return;

    // скрипт диалогового окна
    rcl_dialog_scripts();

    $out = '<button title="' . __( 'Detailed information', 'theme-control' ) . '" onclick="rcl_get_user_info(this);return false;" class="tcl_info tcl_shev tcl_border">';
    $out .= '<i class="rcli fa-info"></i>';
    $out .= '</button>';

    echo $out;
}

// в чужом кабинете покажем над всеми кнопками кнопку возвращения к себе в кабинет
add_filter( 'rcl_content_area_menu', 'tcl_home_button_on_menu' );
function tcl_home_button_on_menu( $menu ) {
    if ( ! is_user_logged_in() )
        return $menu;

    global $user_ID;

    $button = '';

    // не в своем ЛК
    if ( ! rcl_is_office( $user_ID ) ) {
        global $rcl_user_URL;

        $button = '<span class="rcl-tab-button">';
        $button .= rcl_get_button( __( 'Into his office', 'theme-control' ), $rcl_user_URL, array( 'icon' => 'fa-home', 'id' => 'tcl_home_bttn' ) );
        $button .= '</span>';
    }
    return $button . $menu;
}

/* имя автора. Оно является ссылкой на главную страницу (примем за факт что ui tab главная) */
function tcl_username( $user_lk ) {
    // хук, сработает перед именем
    do_action( 'tcl_pre_username' );

    $name = get_the_author_meta( 'display_name', $user_lk );
    if ( rcl_exist_addon( 'user-info-tab' ) ) {
        // автобот доп и это кабинет автобота
        if ( rcl_exist_addon( 'autobot-cabinet' ) && atbc_is_autobot() ) {
            $out = '<a class="tcl_username" href="?home">' . $name . '</a>';
        } else {
            $out        = '<a class="rcl-ajax tcl_username" data-post="' . uit_ajax_data( $user_lk, $uit_tab_id = 'user-info' ) . '" href="?tab=user-info">' . $name . '</a>';
        }
    } else {
        $out = '<a class="tcl_username" href="?home">' . $name . '</a>';
    }

    $out = apply_filters( 'tcl_name', $out );

    echo $out;
}

// аватарка в ЛК
add_action( 'tcl_pre_username', 'tcl_ava_before_name' );
function tcl_ava_before_name() {
    if ( rcl_get_option( 'tcl_ava', '0' ) == 0 )
        return;

    // автобот доп и это кабинет автобота
    if ( rcl_exist_addon( 'autobot-cabinet' ) && atbc_is_autobot() )
        return;

    global $user_LK;

    echo '<div id="tcl_ava" class="tcl_avatar">' . get_avatar( $user_LK, 36, '', 'user_avatar', [ 'class' => 'tcl_border' ] ) . '</div>';
}

// в сети - не в сети
function tcl_user_action() {
    global $rcl_userlk_action;

    $last_action = rcl_get_useraction( $rcl_userlk_action );
    $class       = ( ! $last_action) ? 'online' : 'offline';

    $status = __( 'online', 'theme-control' );
    if ( $last_action )
        $status = __( 'offline', 'theme-control' ) . ' ' . $last_action;

    echo sprintf( '<span class="tcl_status %s">%s</span>', $class, $status );
}

// выведем статус
add_action( 'tcl_before_actions', 'tcl_user_description', 6 );
function tcl_user_description() {
    if ( rcl_get_option( 'tcl_say', '0' ) == 0 )
        return;

    // автобот доп и это кабинет автобота
    if ( rcl_exist_addon( 'autobot-cabinet' ) && atbc_is_autobot() )
        return;

    global $user_LK;

    $desckr = get_the_author_meta( 'description', $user_LK );

    if ( empty( $desckr ) )
        return;

    $des    = wp_strip_all_tags( $desckr );
    $des_br = nl2br( $des );

    echo '<div class="tcl_say"><span>' . $des . '</span>'
    . '<div class="tcl_hid tcl_slide">' . $des_br . '</div></div>';
}

// выкл окно просмотра статуса если статус короткий
add_action( 'wp_footer', 'tcl_check_hypens' );
function tcl_check_hypens() {
    if ( ! rcl_is_office() )
        return;

    if ( rcl_get_option( 'tcl_say', '0' ) == 0 )
        return;

    // автобот доп и это кабинет автобота
    if ( rcl_exist_addon( 'autobot-cabinet' ) && atbc_is_autobot() )
        return;

    global $user_LK;

    $desckr = get_the_author_meta( 'description', $user_LK );

    if ( empty( $desckr ) )
        return;

    $out = '(function($){var b=$(".tcl_say span");'
        . 'function tclSay(){var a=$(b).clone().css({display:"inline",width:"auto",visibility:"hidden"}).appendTo("body");'
        . 'if(a.width()>b.width()){$(".tcl_hid").show()}else{$(".tcl_hid").hide()}a.remove()}'
        . '$(document).ready(function(){tclSay()});$(window).resize(function(){tclSay()})})(jQuery);';

    echo '<script>' . $out . '</script>';
}

/* RAW js */

//(function($) {
//    var el = $(".tcl_say span");
//
//    function tclSay() {
//        var tst = $(el).clone().css({
//            display: "inline",
//            width: "auto",
//            visibility: "hidden"
//        }).appendTo("body");
//        if (tst.width() > el.width()) {
//            $(".tcl_hid").show();
//        } else {
//            $(".tcl_hid").hide();
//        }
//        tst.remove();
//    }
//    $(document).ready(function() {
//        tclSay();
//    });
//    $(window).resize(function() {
//        tclSay();
//    });
//})(jQuery);


/**
 * добавим тип выбранных кнопок
 *
 * @since 2.0
 *
 * @return string   body class button.
 */
add_filter( 'body_class', 'tcl_add_body_class_bttn' );
function tcl_add_body_class_bttn( $classes ) {
    if ( ! rcl_is_office() )
        return $classes;

    $classes[] = 'tcl_b' . rcl_get_option( 'tcl_bttn', 'lite' );

    return $classes;
}

// отменю цвет реколл кнопок и верну что там лишнее
add_action( 'init', 'tcl_delete_rcl_inline_styles' );
function tcl_delete_rcl_inline_styles() {
    if ( ! rcl_is_office() )
        return;

    remove_filter( 'rcl_inline_styles', 'rcl_default_inline_styles', 5, 2 );
}

//
add_filter( 'rcl_inline_styles', 'tcl_button_border_radius', 10 );
function tcl_button_border_radius( $styles ) {
    if ( ! rcl_is_office() )
        return $styles;

    if ( rcl_get_option( 'tcl_brd', '0' ) == 0 )
        return $styles;

    // этот тип кнопок не может иметь радиус
    if ( rcl_get_option( 'tcl_bttn', 'lite' ) == 'prim' )
        return $styles;

    $styles .= '
.pager-item > *,
.recall-button {
    border-radius: ' . rcl_get_option( 'tcl_brd' ) . 'px !important;
}
';

    return $styles;
}

add_filter( 'rcl_inline_styles', 'tcl_button_offset', 10 );
function tcl_button_offset( $styles ) {
    if ( ! rcl_is_office() )
        return $styles;

    $styles .= '
.data-filter,
.rcl-tab-button,
.pager-item > *,
.rcl-subtab-button,
.recall_content_block .rcl-subtab-menu {
    margin: ' . rcl_get_option( 'tcl_mrg', '3' ) . 'px !important;
}
';

    return $styles;
}

// выведем input загрузки аватарки
function tcl_button_avatar_upload() {
    global $user_ID;

    if ( ! rcl_is_office( $user_ID ) )
        return false;

    $uploder = new Rcl_Uploader( 'rcl_avatar', array(
        'multiple'    => 0,
        'crop'        => 1,
        'filetitle'   => 'rcl-user-avatar-' . $user_ID,
        'filename'    => $user_ID,
        'dir'         => '/uploads/rcl-uploads/avatars',
        'image_sizes' => array(
            [
                'height' => 70,
                'width'  => 70,
                'crop'   => 1
            ],
            [
                'height' => 150,
                'width'  => 150,
                'crop'   => 1
            ],
            [
                'height' => 300,
                'width'  => 300,
                'crop'   => 1
            ]
        ),
        'resize'      => array( 1000, 1000 ),
        'min_height'  => 150,
        'min_width'   => 150,
        'max_size'    => rcl_get_option( 'avatar_weight', 1024 )
        ) );

    return $uploder->get_input();
}

// у нас свой js помощник аплоадера авы
if ( ! is_admin() ) {
    add_action( 'init', 'tcl_requene_script', 10 );
}
function tcl_requene_script() {
    global $user_ID;
    if ( rcl_is_office( $user_ID ) ) {
        remove_action( 'rcl_enqueue_scripts', 'rcl_support_avatar_uploader_scripts', 10 );

        rcl_fileupload_scripts();
        rcl_crop_scripts();
    }
}
