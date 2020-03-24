<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * В этом ЛК больше зон для вывода информации
 * И я все кнопки реколл из зоны actions перенес в свою
 * в связи с чемпотребовалось некоторые кнопки, которые регистрируют сторонние дополнения - также переносить
 *
 * Данный файл содержит в себе все эти переносы
 *
 */


/* некоторые хуки отменим - для переноса кнопок */
add_action( 'init', 'tcl_remove_actions', 5 );
function tcl_remove_actions() {
    if ( ! is_user_logged_in() && ! rcl_is_office() )
        return;

    // кнопка чёрный список
    remove_action( 'init', 'rcl_add_block_black_list_button', 10 );

    // кнопка feed подписаться/отписаться
    remove_action( 'init', 'rcl_add_block_feed_button' );

    // кнопку допа подарки перенесем
    remove_action( 'init', 'rcl_add_block_presents_button' );

    // подарки про - офф
    remove_action( 'init', 'pp_add_block_button' );

    // кнопка друзья
    remove_action( 'rcl_area_actions', 'frnd_get_actions_cabinet', 51 );
}

// это залогиненный и в чужом ЛК
function tcl_is_other_lk() {
    if ( ! is_user_logged_in() )
        return false;

    global $user_ID;

    // в своем ЛК
    if ( ! rcl_is_office( $user_ID ) ) {
        return true;
    }

    return false;
}

/* отвяжем кнопки actions WP-Recall от хука и повесим его на свой */
remove_action( 'rcl_area_actions', 'rcl_apply_filters_area_actions', 10 );
add_action( 'tcl_after_actions', 'tcl_move_actions_button', 100 );
function tcl_move_actions_button() {
    echo apply_filters( 'rcl_content_area_actions', '' );
}

// кнопку "чёрный список" перенесем
add_action( 'tcl_after_actions', 'tcl_blacklist_button', 200 );
function tcl_blacklist_button() {
    if ( ! tcl_is_other_lk() || rcl_exist_addon( 'friends-recall' ) )
        return;

    global $user_LK;

    // кнопка чёрный список
    echo '<span class="rcl-tab-button">' . rcl_user_black_list_button( $user_LK ) . '</span>';
}

// кнопка feed подписаться/отписаться
add_action( 'tcl_after_actions', 'tcl_feed_actions_button', 200 );
function tcl_feed_actions_button() {
    if ( ! tcl_is_other_lk() || ! rcl_exist_addon( 'feed' ) )
        return;

    global $user_LK;

    echo '<span class="rcl-tab-button">' . rcl_add_feed_button( $user_LK ) . '</span>';
}

// кнопка друзья
add_action( 'tcl_after_actions', 'tcl_friend_button', 201 );
function tcl_friend_button() {
    if ( ! is_user_logged_in() || ! rcl_exist_addon( 'friends-recall' ) )
        return;

    echo frnd_get_actions_cabinet();
}

// кнопка подарки
add_action( 'tcl_after_actions', 'tcl_presents_button', 200 );
function tcl_presents_button() {
    if ( ! is_user_logged_in() || ! rcl_exist_addon( 'presents' ) )
        return;

    if ( ! tcl_is_other_lk() )
        return;

    global $user_LK;

    echo '<span class="rcl-tab-button">' . add_presents_button_lk( $user_LK ) . '</span>';
}

// кнопка подарки PRO
add_action( 'tcl_after_actions', 'tcl_presents_pro_button', 200 );
function tcl_presents_pro_button() {
    if ( ! is_user_logged_in() || ! rcl_exist_addon( 'presents-pro' ) )
        return;

    if ( ! tcl_is_other_lk() )
        return;

    global $user_LK;

    echo '<span class="rcl-tab-button">' . pp_add_button_lk( $user_LK ) . '</span>';
}
