<?php

/*

  ╔═╗╔╦╗╔═╗╔╦╗
  ║ ║ ║ ╠╣ ║║║ http://otshelnik-fm.ru
  ╚═╝ ╩ ╚  ╩ ╩

 */


// подключаем настройки
require_once('inc/settings.php');


/* great packer's
 *  https://cssminifier.com/
 *  http://dean.edwards.name/packer/
 *
 */
//
// подключим стили и скрипт
add_action( 'rcl_enqueue_scripts', 'tc_load_resource', 10 );
function tc_load_resource() {
    // все нужно только в кабинете
    if ( ! rcl_is_office() )
        return false;

    rcl_enqueue_style( 'tc_style', rcl_addon_url( 'assets/style.min.css', __FILE__ ) );
    rcl_enqueue_script( 'tc_script', rcl_addon_url( 'assets/scripts.min.js', __FILE__ ), false, true );
}

// объявим поддержку аватарки и модального окна (подробная информация)
add_action( 'rcl_addons_included', 'tc_template_options', 10 );
function tc_template_options() {
    rcl_template_support( 'avatar-uploader' );
    rcl_template_support( 'modal-user-details' );
}

// "Подробная информация"
function tc_user_info() {
    // не нужна она при допе user-info-tab
    if ( rcl_exist_addon( 'user-info-tab' ) )
        return;

    // поддержка настройки допа Friends Cabinet Access
    if ( rcl_exist_addon( 'friends-cabinet-access' ) && rcl_get_option( 'fca_info', 'yes' ) == 'yes' )
        return;

    // скрипт диалогового окна
    rcl_dialog_scripts();

    $out = '<span title="Подробная информация" onclick="rcl_get_user_info(this);return false;" class="tc_usr_info">';
    $out .= '<i class="rcli fa-info"></i>';
    $out .= '</span>';

    echo $out;
}

// в чужом кабинете покажем над всеми кнопками кнопку возвращения к себе в кабинет
add_filter( 'rcl_content_area_menu', 'tc_home_button_on_menu' );
function tc_home_button_on_menu( $menu ) {
    if ( ! is_user_logged_in() )
        return $menu;

    global $user_ID;

    $button = '';

    // не в своем ЛК
    if ( ! rcl_is_office( $user_ID ) ) {
        global $rcl_user_URL;
        $button = '<span class="rcl-tab-button">';
        $button .= rcl_get_button( 'В свой кабинет', $rcl_user_URL, array( 'icon' => 'fa-home', 'id' => 'tc_home_button' ) );
        $button .= '</span>';
    }
    return $button . $menu;
}

// регистрируем 2 области виджетов
add_action( 'widgets_init', 'tc_sidebar_before' );
function tc_sidebar_before() {
    register_sidebar( array(
        'name'          => "RCL: Сайдбар над личным кабинетом",
        'id'            => 'tc_sidebar_before',
        'description'   => 'Выводится только в личном кабинете',
        'before_title'  => '<h3 class="tc_title_before">',
        'after_title'   => '</h3>',
        'before_widget' => '<div class="tc_cabinet_sidebar_before">',
        'after_widget'  => '</div>'
    ) );
}

add_action( 'rcl_area_before', 'tc_add_sidebar_area_before' );
function tc_add_sidebar_area_before() {
    if ( function_exists( 'dynamic_sidebar' ) ) {
        dynamic_sidebar( 'tc_sidebar_before' );
    }
}

add_action( 'widgets_init', 'tc_sidebar_after' );
function tc_sidebar_after() {
    register_sidebar( array(
        'name'          => "RCL: Сайдбар под личным кабинетом",
        'id'            => 'tc_sidebar_after',
        'description'   => 'Выводится только в личном кабинете',
        'before_title'  => '<h3 class="tc_title_after">',
        'after_title'   => '</h3>',
        'before_widget' => '<div class="tc_cabinet_sidebar_after">',
        'after_widget'  => '</div>'
    ) );
}

add_action( 'rcl_area_after', 'tc_add_sidebar_area_after' );
function tc_add_sidebar_area_after() {
    if ( function_exists( 'dynamic_sidebar' ) ) {
        dynamic_sidebar( 'tc_sidebar_after' );
    }
}

// меню для автора
function tc_author_menu( $user_lk ) {
    global $user_ID;

    // если чужой кабинет
    if ( ! rcl_is_office( $user_ID ) )
        return false;

    $out = '<div id="tc_amenu" class="tc_author_menu">';
    $out .= '<i class="tc_clck rcli fa-chevron-down"></i>';
    $out .= '<div class="tc_dropdown">';
    if ( ! rcl_exist_addon( 'user-info-tab' ) ) {
        $out .= '<div class="tc_line tc_ava">';
        $out .= '<a class="tc_ava_upload" title="Загрузка аватара" url="#"><i class="rcli fa-download"></i><span>Загрузить аватарку</span><input id="userpicupload" accept="image/*" name="userpicupload" type="file"></a>';
        $out .= '</div>';
    }
    if ( rcl_exist_addon( 'profile' ) ) {
        $out .= '<div class="tc_line">';
        // если активен доп - ajax загрузка ред. профиля
        if ( rcl_exist_addon( 'user-info-tab' ) ) {
            $out        .= '<a class="rcl-ajax" data-post="' . uit_ajax_data( $user_lk, $uit_tab_id = 'profile' ) . '" href="?tab=profile"><i class="rcli fa-pencil"></i><span>Редактировать профиль</span></a>';
        } else {
            $out .= '<a href="?tab=profile"><i class="rcli fa-pencil"></i><span>Редактировать профиль</span></a>';
        }
        $out .= '</div>';
    }
    if ( current_user_can( 'activate_plugins' ) ) {
        $out .= '<div class="tc_line">';
        $out .= '<a href="' . admin_url() . '"><i class="rcli fa-external-link-square"></i><span>В админку</span></a>';
        $out .= '</div>';
    }
    $out .= '<div class="tc_line">';
    $out .= '<a href="' . wp_logout_url( '/' ) . '"><i class="rcli fa-sign-out"></i><span>Выход</span></a>';
    $out .= '</div>';
    $out .= '</div>';
    $out .= '</div>';

    echo $out;
}

// имя автора. Оно является ссылкой на главную страницу (примем за факт что ui tab главная)
function tc_username( $user_lk ) {
    // хук, сработает перед именем
    do_action( 'tc_pre_username' );

    $name = get_the_author_meta( 'display_name', $user_lk );
    if ( rcl_exist_addon( 'user-info-tab' ) ) {
        $out        = '<a class="rcl-ajax tc_author_name" data-post="' . uit_ajax_data( $user_lk, $uit_tab_id = 'user-info' ) . '" href="?tab=user-info">' . $name . '</a>';
    } else {
        $out = '<a class="tc_author_name" href="?home">' . $name . '</a>';
    }
    echo $out;
}

//////////////////////////////////
//          Customizer          //
//////////////////////////////////////////////////////////////////////////////////
// подключим кастомайзер в зависимости от настроек
add_action( 'init', 'tc_connect_customizer' );
function tc_connect_customizer() {
    if ( rcl_get_option( 'tc_cstmzr', 0 ) != 1 )
        return false;

    require_once 'inc/customizer.php';
}
