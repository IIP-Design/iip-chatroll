<?php
/**
 * Plugin Name: Interactive Shortcodes for IIP Properties
 * Description: Simple shortcodes to display interactive elements on IIP properties.
 * Version: 2.0.0
 * Author: Scott Gustas
 * Text Domain: iip-interactive
 * License: GPLv2 or later
 */

add_action('wp_enqueue_scripts', 'iip_interactive_scripts');
function iip_interactive_scripts() {
    wp_register_script('iip_interactive_script', plugins_url('js/iip-interactive.js', __FILE__), array('jquery') );
    wp_enqueue_script('addtocalendar', plugins_url('js/ouical.js', __FILE__) );
}

add_action('admin_enqueue_scripts', 'iip_interactive_admin_scripts');
function iip_interactive_admin_scripts() {
    wp_enqueue_script('iip_interactive_script_admin', plugins_url('js/iip-interactive-admin.js', __FILE__), array('jquery', 'jquery-ui-datepicker') );
    wp_enqueue_script('jquery_timepicker', plugins_url('js/jquery.timepicker.min.js', __FILE__) );
}

add_action('wp_enqueue_scripts', 'iip_interactive_styles');
function iip_interactive_styles() {
    wp_enqueue_style( 'iip_interactive_style', plugins_url('css/iip-interactive.css', __FILE__) );
    wp_enqueue_style( 'addtocalendar_css', plugins_url('css/atc.css', __FILE__) );
}

add_action('admin_enqueue_scripts', 'iip_interactive_admin_styles');
function iip_interactive_admin_styles() {
    wp_enqueue_style( 'iip_interactive_style_admin', plugins_url('css/iip-interactive-admin.css', __FILE__) );
    wp_enqueue_style( 'jquery_ui_css', plugins_url('css/jquery-ui.min.css', __FILE__) );
    wp_enqueue_style( 'jquery_ui_theme', plugins_url('css/jquery-ui-theme.css', __FILE__) );
    wp_enqueue_style( 'jquery_timepicker_css', plugins_url('css/jquery.timepicker.min.css', __FILE__) );
}

add_shortcode('iip_chatroll', 'iip_chatroll_shortcode');
function iip_chatroll_shortcode($atts, $content=null) {
    extract(shortcode_atts(
            array(
                  'title' => 'Chat',
                  'width' => '450',
                  'height' => '350',
                  'id' => '',
                  'name' => '',
                  'domain' => 'chatroll-cloud-1.com',
                  'align' => 'right',
                  'offsetx' => '20',
                  'offsety' => '0'
                  ), $atts
            ));

    wp_enqueue_script('iip_interactive_script');

    $shortcode = '<style type="text/css">.iip_chatroll{'.$align.': '.$offsetx.'px; bottom: '.$offsety.'px;}.chatroll_topbar{width:'.$width.'px;}</style>';
    $shortcode .= '<div class="iip_chatroll"><div class="chatroll_topbar">'.$title.'<div class="iip_toggle"><div class="iip_one"></div><div class="iip_two"></div></div></div>';
    $shortcode .= '<iframe class="" width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" allowtransparency="true" src="https://'.$domain.'/embed/chat/'.$name.'?id='.$id.'&platform=html"></iframe>';
    $shortcode .= '</div>';
    return $shortcode;
}

add_shortcode('iip_countdown', 'iip_countdown_shortcode');
function iip_countdown_shortcode($atts, $content=null) {
    extract(shortcode_atts(
            array(
                  'date' => '',
                  'time' => '',
                  'text' => 'true',
                  'width' => '500',
                  'zone' => 'UTC'
                  ), $atts
            ));

    wp_enqueue_script('iip_interactive_script');
    
    $datetime = $date . ' ' . $time;
    $display = date_i18n('l, F jS, Y '.__('\a\t', 'iip-interactive') .' g:i A T', strtotime($datetime));

    $shortcode = '<div class="iip_countdown"><input type="hidden" id="countdatetime" value="'.$date.' '.$time.' ' . $zone . '" /><div id="clockwrap"><div id="clockdiv" style="width:'.$width.'px">';
    if ( $text === 'true' ) $shortcode .= '<h1>'.$display.'</h1>';
    $shortcode .= '<div><span class="days"></span><div class="smalltext">'. __('Days', 'iip-interactive') . '</div></div> ';
    $shortcode .= '<div><span class="hours"></span><div class="smalltext">'. __('Hours', 'iip-interactive') . '</div></div> ';
    $shortcode .= '<div><span class="minutes"></span><div class="smalltext">'. __('Minutes', 'iip-interactive') . '</div></div> ';
    $shortcode .= '<div><span class="seconds"></span><div class="smalltext">'. __('Seconds', 'iip-interactive') . '</div></div>';
    $shortcode .= '</div></div></div>';

    return $shortcode;
}

add_shortcode('iip_calendar', 'iip_calendar_shortcode');
function iip_calendar_shortcode($atts, $content=null) {
    extract(shortcode_atts(
            array(
                  'title' => 'IIP Interactive Event',
                  'duration' => '60',
                  'address' => '',
                  'description' => '',
                  'text' => 'Add Event to My Calendar',
                  'date' => '',
                  'time' => '',
                  'zone' => 'UTC'
                  ), $atts
            ));
    
    wp_enqueue_script('iip_interactive_script');

    $shortcode = '<input type="hidden" id="caltitle" value="'.$title.'" />';
    $shortcode .= '<input type="hidden" id="calduration" value="'.$duration.'" />';
    $shortcode .= '<input type="hidden" id="caladdress" value="'.$address.'" />';
    $shortcode .= '<input type="hidden" id="caldescription" value="'.$description.'" />';
    $shortcode .= '<input type="hidden" id="caltext" value="'.$text.'" />';
    $shortcode .= '<input type="hidden" id="caldatetime" value="'.$date.' '.$time.' '.$zone.'" />';
    $shortcode .= '<div id="iip_calendar"></div>';

    return $shortcode;
}

/*
    TinyMCE
*/

add_action('media_buttons_context', 'iip_interactive_tinymce_button');

// Add content for inserting a chatroll
add_action('admin_footer', 'iip_interactive_tinymce');

// TinyMCE Button for the shortcode
function iip_interactive_tinymce_button($context) {
    $container_id = 'add_interactive_form';
    $title = __('Interactive Items', 'iip-interactive');

    $context .= "<a class='thickbox button' title='{$title}' id='add_interactive'
    href='#TB_inline?width=600&height=800&inlineId={$container_id}'> Add Interactive Item</a>";

    return $context;
}

function iip_interactive_tinymce() {
    ?>
    <div id="add_interactive_form" style="display:none;" class="thickbox" >
        <div class="wrap">
            <div><div class="tab">
                  <button class="tablinks active" onclick="openTab(event, 'chatroll')">Chatroll</button>
                  <button class="tablinks" onclick="openTab(event, 'countdown')">Countdown</button>
                  <button class="tablinks" onclick="openTab(event, 'calendar')">Add to Calendar</button>
                </div>

                <div id="chatroll" class="tabcontent default">
                    <div>
                        <h3><?php _e('Insert Chatroll', 'iip-interactive'); ?></h3>
                        <span>
                            <?php _e('Configure your Chatroll and add it to your post', 'iip-interactive'); ?>
                        </span>
                    </div>
                    <div>
                        <table>
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_title"><?php _e('Window Title', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_title" size="16" maxlength="16" value="Chat" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_width"><?php _e('Width', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_width" size="5" value="450" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_height"><?php _e('Height', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_height" size="5" value="350" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_id"><?php _e('ID', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_id" size="20" value="" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_name"><?php _e('Name', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_name" size="20" value="" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_domain"><?php _e('Domain', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_domain" size="40" value="chatroll-cloud-1.com" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_align"><?php _e('Alignment', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;">
                                        <select id="chatroll_align">
                                            <option value="right">Right</option>
                                            <option value="left">Left</option>
                                        </select><br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_offsetx"><?php _e('Offset X', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_offsetx" size="4" value="20" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_offsety"><?php _e('Offset Y', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_offsety" size="4" value="0" /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <input type="button" class="button-primary" value="<?php _e('Insert Chatroll', 'iip-interactive'); ?>" onclick="insertChatroll();"/>
                        <a class="button" style="color:#bbb;" href="#" onclick="tb_remove(); return false;"><?php _e('Cancel', 'iip-interactive'); ?></a>
                    </div>
                </div>

                <div id="countdown" class="tabcontent">
                    <h3><?php _e('Countdown', 'iip-interactive'); ?></h3> 
                    <span>
                        <?php _e('Configure your countdown and add it to your post', 'iip-interactive'); ?>
                    </span>
                    <div>
                        <table>
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="countdown_date"><?php _e('Set Date', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input id="countdown_date" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="countdown_time"><?php _e('Set Time', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input id="countdown_time" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="countdown_zone"><?php _e('Set Timezone', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input id="countdown_zone" maxlength="6" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="countdown_width"><?php _e('Set Width (in pixels)', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input id="countdown_width" maxlength="4" value="500" /> px</td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="countdown_text"><?php _e('Date Text', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;">
                                        <select id="countdown_text">
                                            <option value="true" default>Show</option>
                                            <option value="false">Hide</option>
                                        </select><br/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <input type="button" class="button-primary" value="<?php _e('Insert Countdown', 'iip-interactive'); ?>" onclick="insertCountdown();"/>
                        <a class="button" style="color:#bbb;" href="#" onclick="tb_remove(); return false;"><?php _e('Cancel', 'iip-interactive'); ?></a>
                    </div>
                </div>

                <div id="calendar" class="tabcontent">
                    <h3><?php _e('Add to Calendar', 'iip-interactive'); ?></h3>
                    <span>
                        <?php _e('Configure your add to calendar button and add it to your post', 'iip-interactive'); ?>
                    </span>
                    <div>
                        <table>
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="calendar_title"><?php _e('Event Title', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="calendar_title" value="IIP Live Event" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="calendar_duration"><?php _e('Duration (in minutes)', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="calendar_duration" maxlength="4" value="60" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="calendar_address"><?php _e('Address/URL', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="calendar_address" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="calendar_description"><?php _e('Event Description', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="calendar_description" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="calendar_text"><?php _e('Button Text', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="calendar_text" size="24" maxlength="24" value="Add Event to My Calendar" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="calendar_date"><?php _e('Set Date', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input id="calendar_date" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="calendar_time"><?php _e('Set Time', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input id="calendar_time" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="calendar_zone"><?php _e('Set Timezone', 'iip-interactive'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input id="calendar_zone" maxlength="6" /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <input type="button" class="button-primary" value="<?php _e('Insert Add to Calendar', 'iip-interactive'); ?>" onclick="insertCalendar();"/>
                        <a class="button" style="color:#bbb;" href="#" onclick="tb_remove(); return false;"><?php _e('Cancel', 'iip-interactive'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
