<?php
/**
 * Plugin Name: Interactive Shortcodes for IIP Properties
 * Description: Simple shortcodes to display interactive elements on IIP properties.
 * Version: 2.0.0
 * Author: Scott Gustas
 * License: GPLv2 or later
 */

add_action('wp_enqueue_scripts', 'iip_interactive_scripts');
function iip_interactive_scripts() {
    wp_enqueue_script('iip_interactive_script', plugins_url('js/iip-interactive.js', __FILE__), array('jquery') );
}

add_action('admin_enqueue_scripts', 'iip_interactive_admin_scripts');
function iip_interactive_admin_scripts() {
    wp_enqueue_script('iip_interactive_script_admin', plugins_url('js/iip-interactive-admin.js', __FILE__), array('jquery') );
}

add_action('wp_enqueue_scripts', 'iip_interactive_styles');
function iip_interactive_styles() {
    wp_enqueue_style( 'iip_interactive_style', plugins_url('css/iip-interactive.css', __FILE__) );
}

add_action('admin_enqueue_scripts', 'iip_interactive_admin_styles');
function iip_interactive_admin_styles() {
    wp_enqueue_style( 'iip_interactive_style_admin', plugins_url('css/iip-interactive-admin.css', __FILE__) );
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

    $shortcode = '<style type="text/css">.iip_chatroll{'.$align.': '.$offsetx.'px; bottom: '.$offsety.'px;}.chatroll_topbar{width:'.$width.'px;}</style>';
    $shortcode .= '<div class="iip_chatroll"><div class="chatroll_topbar">'.$title.'<div class="iip_toggle"><div class="iip_one"></div><div class="iip_two"></div></div></div>';
    $shortcode .= '<iframe class="" width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" allowtransparency="true" src="https://'.$domain.'/embed/chat/'.$name.'?id='.$id.'&platform=html"></iframe>';
    $shortcode .= '</div>';
    return $shortcode;
}

add_shortcode('iip_calendar', 'iip_calendar_shortcode');
function iip_calendar_shortcode($atts, $content=null) {
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

    $shortcode = '<style type="text/css">.iip_chatroll{'.$align.': '.$offsetx.'px; bottom: '.$offsety.'px;}.chatroll_topbar{width:'.$width.'px;}</style>';
    $shortcode .= '<div class="iip_chatroll"><div class="chatroll_topbar">'.$title.'<div class="iip_toggle"><div class="iip_one"></div><div class="iip_two"></div></div></div>';
    $shortcode .= '<iframe class="" width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" allowtransparency="true" src="https://'.$domain.'/embed/chat/'.$name.'?id='.$id.'&platform=html"></iframe>';
    $shortcode .= '</div>';
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
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_title"><?php _e('Window Title', 'iip-chatroll'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_title" size="16" maxlength="16" value="Chat" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_width"><?php _e('Width', 'iip-chatroll'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_width" size="5" value="450" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_height"><?php _e('Height', 'iip-chatroll'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_height" size="5" value="350" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_id"><?php _e('ID', 'iip-chatroll'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_id" size="20" value="" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_name"><?php _e('Name', 'iip-chatroll'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_name" size="20" value="" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_domain"><?php _e('Domain', 'iip-chatroll'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_domain" size="40" value="chatroll-cloud-1.com" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_align"><?php _e('Alignment', 'iip-chatroll'); ?></label></td>
                                    <td style="padding: 0 0 10px;">
                                        <select id="chatroll_align">
                                            <option value="right">Right</option>
                                            <option value="left">Left</option>
                                        </select><br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_offsetx"><?php _e('Offset X', 'iip-chatroll'); ?></label></td>
                                    <td style="padding: 0 0 10px;"><input type="text" id="chatroll_offsetx" size="4" value="20" /></td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0 15px 5px 0;"><label for="chatroll_offsety"><?php _e('Offset Y', 'iip-chatroll'); ?></label></td>
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
                </div>

                <div id="calendar" class="tabcontent">
                    <h3><?php _e('Add to Calendar', 'iip-interactive'); ?></h3>
                    <span>
                        <?php _e('Configure your add to calendar button and add it to your post', 'iip-interactive'); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <?php
}
