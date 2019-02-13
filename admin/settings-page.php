<?php

if (!is_admin()) {
    header('HTTP/1.0 403 Forbidden');
    die;
}
if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
}

class Bible_Press_Forms_Options
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_plugin_settings_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_plugin_settings_menu()
    {
        // add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function )
        add_options_page('Bible Press', 'Bible Press', 'manage_options', 'bible-press-plugin', array($this, 'create_plugin_settings_page'));
    }

    public function create_plugin_settings_page()
    {
        ?>
<div class="wrap">

    <h2>Settings</h2>

    <form method="post" action="options.php">
    <?php
        settings_fields('bible_press_options');
        do_settings_sections('bible-press-main-settings-section');
        ?>
    <?php submit_button('Save Changes');?>
    </form>

 

	<?php
if (isset($_POST['import_button']) && check_admin_referer('import_button')) {
            $options = get_option('bible_press_options');
            $filename = $options['import_filename'];
            import_button_action($filename);
        }
        ?>
		<form action="options-general.php?page=bible-press-plugin" method="post">
			<p><?php esc_html__('Use this section to upload a new Bible database into your WordPress site.', 'bible-press' );?><br />
               <?php esc_html__('It must be a SQL database with a .sql extension. ', 'bible-press' );?></p>
			<?php	wp_nonce_field('import_button');?>
			<input type="hidden" value="true" name="import_button" />
			<?php	submit_button('Import Database', 'secondary');?>
		</form>

</div>
	<?php
}

    public function register_settings()
    {

        // add_settings_section( $id, $title, $callback, $page )
        add_settings_section(
            'bible_press_section_main',
            'Bible Press Settings',
            array($this, 'bible_press_section_main'),
            'bible-press-main-settings-section'
        );

        // add_settings_field( $id, $title, $callback, $page, $section, $args )
        add_settings_field(
            'page_title',
            esc_html__( 'Page Title', 'bible-press' ),
            array($this, 'bible_press_callback_field_text'),
            'bible-press-main-settings-section',
            'bible_press_section_main',
            ['id' => 'page_title', 'label' => 'Custom title for the displayed Bible page']
        );

        add_settings_field(
            'old_testament_title',
            esc_html__( 'Old Testament Title', 'bible-press' ),
            array($this, 'bible_press_callback_field_text'),
            'bible-press-main-settings-section',
            'bible_press_section_main',
            ['id' => 'old_testament_title', 'label' => 'Custom title for the Old Testament']
        );

        add_settings_field(
            'new_testament_title',
            esc_html__( 'New Testament Title', 'bible-press' ),
            array($this, 'bible_press_callback_field_text'),
            'bible-press-main-settings-section',
            'bible_press_section_main',
            ['id' => 'new_testament_title', 'label' => 'Custom title for the New Testament']
        );

        add_settings_field(
            'custom_style',
            esc_html__( 'Custom Style', 'bible-press' ),
            'bible_press_callback_field_radio',
            'bible_press',
            'bible_press_section_main',
            ['id' => 'custom_style', 'label' => 'Custom CSS found in the public/bible-press.css file']
        );

        // register_setting( string $option_group, string $option_name, array $args = array() )
        register_setting(
            'bible_press_options',
            'bible_press_options',
            'bible_press_callback_options_validate'
        );

        // add_settings_section( $id, $title, $callback, $page )
        add_settings_section(
            'bible_press_section_import',
            'Import Database',
            array($this, 'bible_press_section_import'),
            'bible-press-import-settings-section'
        );

        // add_settings_field( $id, $title, $callback, $page, $section, $args )
        add_settings_field(
            'import_filename',
            esc_html__( 'Import Filename', 'bible-press' ),
            array($this, 'bible_press_callback_import'),
            'bible-press-main-settings-section',
            'bible_press_section_main',
            //'bible-press-import-settings-section',
            //'bible_press_section_import',
            ['id' => 'import_filename', 'label' => 'Database filename for import']
        );

        // register_setting( string $option_group, string $option_name, array $args = array() )
        register_setting(
            'bible_press_import_options',
            'bible_press_import_options',
            'bible_press_callback_import_options_validate'
        );

    }

    public function bible_press_section_main()
    {
        echo '<p>Bible Press Settings.</p>';
    }

    /// callback: text field
    public function bible_press_callback_field_text($args)
    {
        $options = get_option('bible_press_options', bible_press_options_default());

        $id = isset($args['id']) ? $args['id'] : '';
        $label = isset($args['label']) ? $args['label'] : '';
        $value = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';

        echo '<input id="bible_press_options_' . $id . '" name="bible_press_options[' . $id . ']" type="text" size="40" value="' . $value . '"><br />';
        echo '<label for="bible_press_options_' . $id . '">' . $label . '</label>';
    }

    // callback: radio field
    public function bible_press_callback_field_radio($args)
    {

        $options = get_option('bible_press_options', bible_press_options_default());

        $id = isset($args['id']) ? $args['id'] : '';
        $label = isset($args['label']) ? $args['label'] : '';

        $selected_option = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';

        $radio_options = array(

            'enable' => 'Enable custom styles',
            'disable' => 'Disable custom styles',

        );

        foreach ($radio_options as $value => $label) {

            $checked = checked($selected_option === $value, true, false);

            echo '<label><input name="bible_press_options[' . $id . ']" type="radio" value="' . $value . '"' . $checked . '> ';
            echo '<span>' . $label . '</span></label><br />';

        }
    }

    public function bible_press_callback_options_validate($arr_input)
    {
        $options = get_option('bible_press_options');
        if (isset($input['page_title'])) {
            $options['page_title'] = sanitize_text_field($arr_input['page_title']);
        }
        if (isset($input['old_testament_title'])) {
            $options['old_testament_title'] = sanitize_text_field($arr_input['old_testament_title']);
        }
        if (isset($input['new_testament_title'])) {
            $options['new_testament_title'] = sanitize_text_field($arr_input['new_testament_title']);
        }
        // custom style
        $radio_options = array(
            'enable' => 'Enable custom styles',
            'disable' => 'Disable custom styles',
        );
        if (!isset($input['custom_style'])) {
            $input['custom_style'] = null;
        }
        if (!array_key_exists($input['custom_style'], $radio_options)) {
            $input['custom_style'] = null;
        }
        return $options;
    }

    public function bible_press_callback_import_options_validate($arr_input)
    {
        //    $options = get_option('bible_press_import_options');
        $options = get_option('bible_press_options');
        if (isset($input['import_filename'])) {
            $options['import_filename'] = sanitize_text_field($arr_input['import_filename']);
        }
        return $options;
    }

    public function bible_press_section_import()
    {
        echo '<p>Use this section to upload a new Bible database into your WordPress site.<br />  It must be a SQL database with a .sql extension. </p>';
    }

    public function bible_press_callback_import($args)
    {
        //    $options = get_option('bible_press_import_options', bible_press_import_default() );
        $options = get_option('bible_press_options', bible_press_options_default());
        $id = isset($args['id']) ? $args['id'] : '';
        $label = isset($args['label']) ? $args['label'] : '';
        $value = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';

        //    echo '<input id="bible_press_import_options_'. $id .'" name="bible_press_import_options['. $id .']" type="text" size="40" value="'. $value .'"><br />';
        //    echo '<label for="bible_press_import_options_'. $id .'">'. $label .'</label>';
        echo '<input id="bible_press_options_' . $id . '" name="bible_press_options[' . $id . ']" type="text" size="40" value="' . $value . '"><br />';
        echo '<label for="bible_press_options_' . $id . '">' . $label . '</label>';

    }

} // end of Class

?>
