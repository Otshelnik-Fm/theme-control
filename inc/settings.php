<?php

if ( ! defined( 'ABSPATH' ) )
    exit;


add_filter( 'rcl_options', 'tcl_addon_options' );
function tcl_addon_options( $options ) {
    // создаем блок
    $options->add_box( 'tcl_box_id', array(
        'title' => __( 'Theme Control Settings', 'theme-control' ),
        'icon'  => 'fa-address-card-o'
    ) );

    // создаем группу 1
    $options->box( 'tcl_box_id' )->add_group( 'tcl_group_1', array(
        'title' => __( 'Buttons in your account', 'theme-control' )
    ) )->add_options( array(
        [
            'title'   => __( 'Appearance of buttons in your account:', 'theme-control' ),
            'type'    => 'radio',
            'slug'    => 'tcl_bttn',
            'values'  => [ 'lite' => 'Lite', 'fill' => 'Fill', 'prim' => 'Prime', 'cstmz' => __( 'Configure in the Customizer', 'theme-control' ) ],
            'default' => 'lite',
            'help'    => __( 'Here you can customize the appearance of buttons.', 'theme-control' ) . '<br>'
            . __( 'There are 3 preset button types:', 'theme-control' ) . '<br><br>'
            . '<strong>Lite</strong> - ' . __( 'Backgroundless buttons with dark text. And the active and hover state will have a color stroke from the set WP-Recall color .', 'theme-control' ) . '<br><br>'
            . '<strong>Fill</strong> - ' . __( 'Backgroundless buttons with dark text. And the active and in the state of guidance will be filled with color from the set color of WP-Recall.', 'theme-control' ) . '<br><br>'
            . '<strong>Prime</strong> - ' . __( 'Backgroundless buttons, and text color from WP-Recall.', 'theme-control' ) . ' '
            . __( 'The active and hover state will have a border at the bottom of the color from the set WP-Recall color.', 'theme-control' ) . '<br><br>'
            . __( 'If you selected the option "Configure in the Customizer" - go to the admin panel "Appearance" - "Customize" - "Theme Control Settings"', 'theme-control' ) . '<br/>'
            . __( 'Go to your personal account there and start configuring the button visually.', 'theme-control' ) . '<br/><br/>'
            . __( 'This option is useful for those who do not know how to edit css styles themselves, and the existing options are not suitable.', 'theme-control' ),
            'notice'  => __( 'Default: "Lite"', 'theme-control' ),
        ],
        [
            'title'      => __( 'Button rounding, in px:', 'theme-control' ),
            'type'       => 'runner',
            'slug'       => 'tcl_brd',
            'value_min'  => 0,
            'value_max'  => 12,
            'value_step' => 1,
            'default'    => 0,
            'help'       => __( 'You can make the buttons rounded.', 'theme-control' ) . '<br>'
            . __( 'Set the rounding radius of the buttons (in pixels), if necessary.', 'theme-control' ) . '',
            'notice'     => __( 'Default: "0px"', 'theme-control' ),
        ],
        [
            'title'      => __( 'Indent buttons, in px:', 'theme-control' ),
            'type'       => 'runner',
            'slug'       => 'tcl_mrg',
            'value_min'  => 0,
            'value_max'  => 6,
            'value_step' => 1,
            'default'    => 3,
            'help'       => __( 'Now the buttons are indented from each other by 3 pixels.', 'theme-control' ) . '<br>'
            . __( 'You can increase it or remove it completely if necessary.', 'theme-control' ),
            'notice'     => __( 'Default: "3px"', 'theme-control' ),
        ],
    ) );


    // создаем группу 2
    $options->box( 'tcl_box_id' )->add_group( 'tcl_group_2', array(
        'title' => __( 'Additionally', 'theme-control' )
    ) )->add_options( array(
        [
            'title'   => __( 'Show your profile picture in your account?', 'theme-control' ),
            'type'    => 'radio',
            'slug'    => 'tcl_ava',
            'values'  => [ 0 => __( 'No', 'theme-control' ), 1 => __( 'Yes', 'theme-control' ) ],
            'default' => 0,
            'help'    => __( 'If you do not have the addon <a href="https://codeseller.ru/products/user-info-tab/" target="_blank">User Info Tab</a> - you can enable the display of the avatar next to the name', 'theme-control' ),
            'notice'  => __( 'Default: "No"', 'theme-control' ) . '<hr>',
        ],
        [
            'title'   => __( 'Showing the "Detailed information" button?', 'theme-control' ),
            'type'    => 'radio',
            'slug'    => 'tcl_info',
            'values'  => [ 1 => __( 'Yes', 'theme-control' ), 0 => __( 'No', 'theme-control' ) ],
            'default' => 1,
            'help'    => __( 'Here you can disable the display of the "Detailed information" button.', 'theme-control' ) . '<br>'
            . __( 'Useful for example if you have an addon <a href="https://codeseller.ru/products/display-profile-field/" target= "_blank">Display Profile Field</a>', 'theme-control' ),
            'notice'  => __( 'Default: "Yes"', 'theme-control' ),
        ],
        [
            'title'   => __( 'Show status in your account?', 'theme-control' ) . '',
            'type'    => 'radio',
            'slug'    => 'tcl_say',
            'values'  => [ 0 => __( 'No', 'theme-control' ), 1 => __( 'Yes', 'theme-control' ) ],
            'default' => 0,
            'help'    => __( 'If a user fills in the "Status" field in their profile and tells them a few words about themselves, this information will be displayed under their name at the top of the profile as a single line.', 'theme-control' ) . '<br>'
            . __( 'When you hover over this line, the full status appears on top', 'theme-control' ),
            'notice'  => __( 'Default: "No"', 'theme-control' ),
        ]
    ) );

    if ( ! rcl_exist_addon( 'user-info-tab' ) ) {
        $mess = rcl_get_notice( [
            'type' => 'success', // info,success,warning,error,simple
            'icon' => 'fa-address-card-o',
            'text' => '<a href="https://codeseller.ru/products/theme-control-sn-pack/" target="_blank">Theme Control SN Pack</a> - ' . __( 'Социальная сеть - как в ВК', 'theme-control' )
            ] );

        // создаем группу 3
        $options->box( 'tcl_box_id' )->add_group( 'tcl_group_3', array(
            'title' => ''
        ) )->add_options( array(
            [
                'type'    => 'custom',
                'content' => $mess
            ]
        ) );
    }


    // кастомный блок саморекламы
    $inline_style = '
<style>
#tcl_box_id-options-box::before {
    color: #5292b9;
    content: "THEME CONTROL";
    display: block;
    font-size: 20px;
    font-weight: bold;
    margin: 9px 12px 14px;
    line-height: 1;
}
#options-group-tcl_group_3 {
    border: none;
    padding: 0;
}
#options-group-tcl_group_4 {
    background: linear-gradient(180deg, #f8ffd9 0%,#ffe3e3 100%);
    border-color: #b6dbd5;
    box-shadow: 6px 6px 12px -6px #aaa;
    margin-top: 18px;
}
#options-group-tcl_group_4 > span {
    color: #1a4479;
    background: transparent;
    font-size: 20px;
    font-weight: bold;
}
</style>
';

    $my_adv = '<div style="font-size:16px;margin:15px 0 0;line-height: normal;">';
    $my_adv .= __( "Don't forget that you can", 'theme-control' ) . ':<br><br>';
    $my_adv .= '1. ' . __( 'Customize the button color via WordPress Customizer, if the suggested design options do not suit you.', 'theme-control' ) . '<br><br>';
    $my_adv .= '2. ' . __( 'Select options for the personal account menu buttons - display them horizontally or vertically.', 'theme-control' ) . '<br><br>';
    $my_adv .= '3. ' . __( 'Work with widgets. Your personal account has widget areas - there you can place widgets, shortcodes, any text information (news, for example, or announcement).', 'theme-control' ) . '<br><br>';
    $my_adv .= __( 'For more information, see the tab', 'theme-control' ) . ' '
        . '<strong><a href="https://codeseller.ru/products/theme-control/?product-section=FAQ" title="' . __( 'Go', 'theme-control' ) . '" target="_blank">"FAQ"</a></strong>';
    $my_adv .= ' <small>(' . __( 'link will open in a new window', 'theme-control' ) . ')</small>';
    $my_adv .= '</div>';

    // создаем группу 3
    $options->box( 'tcl_box_id' )->add_group( 'tcl_group_4', array(
        'title' => __( 'Useful information:', 'theme-control' )
    ) )->add_options( array(
        [
            'type'    => 'custom',
            'content' => $inline_style . $my_adv
        ]
    ) );

    return $options;
}
