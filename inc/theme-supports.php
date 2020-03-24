<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// объявим поддержку аватарки и модального окна (подробная информация)
add_action( 'rcl_addons_included', 'tcl_template_options', 10 );
function tcl_template_options() {
    rcl_template_support( 'avatar-uploader' );
    rcl_template_support( 'modal-user-details' );
}

/*
 *
 *  Виджеты:
 *
 */


/* регистрируем 2 области виджетов */
add_action( 'widgets_init', 'tcl_sidebar_before' );
function tcl_sidebar_before() {
    register_sidebar( array(
        'name'          => __( 'RCL: Sidebar above your personal account', 'theme-control' ),
        'id'            => 'tcb_box',
        'description'   => __( 'Output only in your personal account', 'theme-control' ),
        'before_title'  => '<h3 class="tcb_ttl">',
        'after_title'   => '</h3>',
        'before_widget' => '<div class="tcb_wget">',
        'after_widget'  => '</div>'
    ) );
}

add_action( 'rcl_area_before', 'tcl_add_sidebar_area_before' );
function tcl_add_sidebar_area_before() {
    if ( function_exists( 'dynamic_sidebar' ) ) {
        dynamic_sidebar( 'tcb_box' );
    }
}

add_action( 'widgets_init', 'tcl_sidebar_after' );
function tcl_sidebar_after() {
    register_sidebar( array(
        'name'          => __( 'RCL: Sidebar under your personal account', 'theme-control' ),
        'id'            => 'tca_box',
        'description'   => __( 'Output only in your personal account', 'theme-control' ),
        'before_title'  => '<h3 class="tca_ttl">',
        'after_title'   => '</h3>',
        'before_widget' => '<div class="tca_wget">',
        'after_widget'  => '</div>'
    ) );
}

add_action( 'rcl_area_after', 'tcl_add_sidebar_area_after' );
function tcl_add_sidebar_area_after() {
    if ( function_exists( 'dynamic_sidebar' ) ) {
        dynamic_sidebar( 'tca_box' );
    }
}

/*
 *
 *  Кастомайзер:
 *
 */


//////////////////////////////////
//          Customizer          //
//////////////////////////////////////////////////////////////////////////////////
// подключим кастомайзер в зависимости от настроек
add_action( 'init', 'tcl_connect_customizer' );
function tcl_connect_customizer() {
    if ( rcl_get_option( 'tcl_bttn', 'lite' ) == 'cstmz' ) {
        include_once dirname( TCL_THEME ) . '/inc/customizer.php';
    }
}
