<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * Меню автора
 *
 */


/* выводим блок "меню автора" */
function tcl_author_menu( $user_lk ) {
    global $user_ID;

    // если чужой кабинет
    if ( ! rcl_is_office( $user_ID ) )
        return false;

    $out = '<button id="tcl_amenu" class="tcl_usrm tcl_shev tcl_border">';
    $out .= '<i class="tcl_clck rcli fa-chevron-down"></i>';
    $out .= '<div class="tcl_down tcl_slide">';

    $data  = '';
    $datas = apply_filters( 'tcl_user_items', $data, $user_lk );

    $out .= $datas;

    $out .= '</div>';
    $out .= '</button>';

    echo $out;
}

// в меню автора обработчик пунктов меню
function tcl_author_menu_add_item( $datas ) {
    foreach ( $datas as $id_icon => $icon ) {
        $class = (isset( $icon['class'] )) ? $icon['class'] : '';

        $out = '<div id="' . $id_icon . '" class="tcl_line rcl-tab-button ' . $class . '">';

        if ( isset( $icon['url'] ) ) {
            $url = isset( $icon['url'] ) ? $icon['url'] : '#';

            $out .= '<a class="recall-button" href="' . $url . '">';
        }

        $out .= '<i class="rcli ' . $icon['icon'] . '" aria-hidden="true"></i>';
        $out .= '<span>';

        if ( isset( $icon['label'] ) ) {
            $out .= $icon['label'];
        }

        $out .= '</span>';

        if ( isset( $icon['url'] ) ) {
            $out .= '</a>';
        }

        $out .= '</div>';
    }

    return $out;
}

// 1 пункт "Меню автора" - "Загрузить аватарку"
add_filter( 'tcl_user_items', 'tcl_author_menu_item_ava', 12 );
function tcl_author_menu_item_ava( $data ) {
    if ( ! rcl_exist_addon( 'user-info-tab' ) ) {
        $data .= '<div class="tcl_line rcl-tab-button tcl_load">';
        $data .= '<label class="recall-button" for="rcl-uploader-input-rcl_avatar"><i class="rcli fa-download" aria-hidden="true"></i><span>' . __( 'Upload avatar', 'theme-control' ) . '</span></label>';

        $data .= tcl_button_avatar_upload();

        $data .= '</div>';
    }

    return $data;
}

// 2 пункт "Меню автора" - "Редактировать профиль"
add_filter( 'tcl_user_items', 'tcl_author_menu_item_profile', 24, 2 );
function tcl_author_menu_item_profile( $data, $user_lk ) {
    if ( rcl_exist_addon( 'profile' ) ) {
        $data .= '<div class="tcl_line rcl-tab-button">';
        // если активен доп - ajax загрузка ред. профиля
        if ( rcl_exist_addon( 'user-info-tab' ) ) {
            $data       .= '<a class="recall-button rcl-ajax" data-post="' . uit_ajax_data( $user_lk, $uit_tab_id = 'profile' ) . '" href="?tab=profile"><i class="rcli fa-pencil"></i><span>' . __( 'Edit your profile', 'theme-control' ) . '</span></a>';
        } else {
            $data .= '<a class="recall-button" href="' . rcl_format_url( get_author_posts_url( $user_lk ), 'profile' ) . '"><i class="rcli fa-pencil"></i><span>' . __( 'Edit your profile', 'theme-control' ) . '</span></a>';
        }
        $data .= '</div>';
    }

    return $data;
}

// 3 пункт "Меню автора" - "В админку"
add_filter( 'tcl_user_items', 'tcl_author_menu_item_console', 36 );
function tcl_author_menu_item_console( $data ) {
    if ( current_user_can( 'activate_plugins' ) ) {
        $datas['tcl_console'] = [
            'url'   => admin_url(),
            'icon'  => 'fa-external-link-square',
            'label' => __( 'To the admin panel', 'theme-control' ),
        ];

        $data .= tcl_author_menu_add_item( $datas );
    }

    return $data;
}

// 4 пункт "Меню автора" - "Выход"
add_filter( 'tcl_user_items', 'tcl_author_menu_item_logout', 48 );
function tcl_author_menu_item_logout( $data ) {
    $datas['tcl_logout'] = [
        'url'   => wp_logout_url( '/' ),
        'icon'  => 'fa-sign-out',
        'label' => __( 'Logout', 'theme-control' ),
    ];

    $data .= tcl_author_menu_add_item( $datas );

    return $data;
}
