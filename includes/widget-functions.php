<?php
add_action('widgets_init', create_function('', 'return register_widget("UWP_Social_Login_Widget");'));
class UWP_Social_Login_Widget extends WP_Widget
{

    /**
     * Class constructor.
     */
    function __construct()
    {
        $widget_ops = array(
            'description' => __('Displays Social Login', 'uwp-social'),
            'classname' => 'uwp_progress_users',
        );
        parent::__construct(false, $name = _x('UWP > Social Login', 'widget name', 'uwp-social'), $widget_ops);

    }

    /**
     * Display the widget.
     *
     * @param array $args Widget arguments.
     * @param array $instance The widget settings, as saved by the user.
     */
    function widget($args, $instance)
    {
        echo uwp_social_login_buttons_display($args, $instance);
    }

    function update($new_instance, $old_instance)
    {
        //save the widget
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    function form($instance)
    {
        //widgetform in backend
        $instance = wp_parse_args((array)$instance, array(
            'title' => __('Social Login', 'uwp-social'),
        ));
        $title = strip_tags($instance['title']);
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __("Widget Title:", 'uwp-social'); ?> <input class="widefat"
                                                                                                                     id="<?php echo $this->get_field_id('title'); ?>"
                                                                                                                     name="<?php echo $this->get_field_name('title'); ?>"
                                                                                                                     type="text"
                                                                                                                     value="<?php echo esc_attr($title); ?>"/></label>
        </p>
        <?php
    }

}
