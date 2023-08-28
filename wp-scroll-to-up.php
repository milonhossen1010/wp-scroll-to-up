<?php
/*
    Plugin Name:        Wp Scroll to Up
    Description:        Wp Scroll to Up plugin allows the visitor to easily scroll back to the top of the page.
    Author:             Milon Hossen
    Author URI:         https://milonpc.com
    Plugin URI:         https://wordpress.org/plugins/wp-scroll-to-up/
    Version:            1.0.0
    Requires at least:  5.2
    Requires PHP:       7.2
    License:            GPLv2 or later
    License URI:        http://www.gnu.org/licenses/gpl-2.0.html
    Update URI:         https://github.com/milonhossen1010
    Text domain:        wpstu
*/

// Scripts load
function wpstu_enqueue_scripts() {
    wp_enqueue_style("wpstu-css", plugins_url("assets/css/wpstu.css", __FILE__));
    wp_enqueue_script("wpstu-js", plugins_url("assets/js/wpstu.js", __FILE__), ['jquery'], true, true);
}
add_action( "wp_enqueue_scripts", "wpstu_enqueue_scripts");

// Admin css load
function wpstu_admin_scripts()  {
    wp_enqueue_style("wpstu-css", plugins_url("assets/css/wpstu-admin.css", __FILE__));
}
add_action( "admin_enqueue_scripts", "wpstu_admin_scripts" );

// ScrollUp script 
add_action( "wp_footer",  function(){ ?>
<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery.scrollUp({
        animation: 'slide'
    });

});
</script>
<?php
});


// Plugin customize option
 function wpstu_options_page(){
    add_menu_page("Scroll to Up", "Scroll to Up", "manage_options", "wpstu_option", "wpstu_option_callback", "dashicons-arrow-up-alt");
 }

 add_action( "admin_menu", "wpstu_options_page" );

 //Option function
 function wpstu_option_callback(){ ?>
<div class="wrap">
    <div class="wpstu-box">
        <h1>Customize</h1>
        <form action="options.php" method="post">
            <?php wp_nonce_field("update-options")  ?>
            <div class="field-group">
                <label for="color-option">Background Color</label>
                <input  placeholder="Insert your color code" type="text" class="regular-text" name="color-option"
                    value="<?php echo get_option("color-option", "#202020")  ?>">
            </div>

            <div class="field-group">
                <label for="radius-option">Border Radius</label>
                <input type="text" class="regular-text" name="radius-option" placeholder="0px"
                    value="<?php echo get_option("radius-option", "0px")  ?>">
            </div>

            <input type="hidden" name="action" value="update">
            <input type="hidden" name="page_options" value="color-option, radius-option">
            <?php submit_button(); ?>
        </form>
    </div>
</div>
<?php }


// Custom style  
add_action( "wp_head",  function(){ ?>
    <style>
        #scrollUp {
            background-color: <?= get_option("color-option") ?>;
            border-radius:<?= get_option("radius-option") ?>;
        }
    </style>
    <?php
    });
?>