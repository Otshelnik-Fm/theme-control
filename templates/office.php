<?php
/*  Шаблон дополнения Theme Control https://codeseller.ru/products/theme-control/
    Если вам нужно внести изменения в данный шаблон - скопируйте его в папку /wp-content/wp-recall/templates/
    - сделайте там в нем нужные вам изменения и он будет подключаться оттуда
    Подробно работа с шаблонами описана тут: https://codeseller.ru/?p=11632
*/
?>
<?php global $user_LK; ?>

<div id="tcl_top">
    <div class="tcl_top_header"><?php do_action('rcl_area_top'); ?></div>
    <div class="tcl_top_content">
        <div class="tcl_title">
            <div class="tcl_name">
                <div class="tcl_name_left">
                    <?php tc_author_menu($user_LK); ?>
                    <?php tc_username($user_LK); ?>
                </div>
                <div class="rcl-action"><?php rcl_action(); ?><?php tc_user_info(); ?></div>
            </div>
        </div>

        <div class="tcl_top_footer">
            <span id="avatar-upload-progress"></span>
            <div id="tc_counters" class="tc_bttn_counters">
                <?php do_action('rcl_area_counters'); ?>
            </div>
        </div>

        <div id="tc_actions" class="tcl_bttn_actions"><?php do_action('rcl_area_actions'); ?></div>

    </div>
</div>

<div id="rcl-tabs">
    <div id="tc_main_menu"><?php do_action('rcl_area_menu'); ?></div>
    <div class="tcl_content">
        <?php do_action('rcl_area_tabs'); ?>
    </div>
</div>

