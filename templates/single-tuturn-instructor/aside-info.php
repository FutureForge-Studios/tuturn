<?php
/**
 * Sidebar
 *
 * @package     Tuturn
 * @subpackage  Tuturn/Templates/Single_tuturn_Instructor
 * @author      Amentotech <info@amentotech.com>
 * @link       https://themeforest.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */
global $current_user, $post, $tuturn_settings;
$teaching_preference = get_post_meta($post_id, 'teaching_preference', true);
$teaching_preference = !empty($teaching_preference) ? ($teaching_preference) : array();
$contact_info = !empty($profile_details['contact_info']) ? $profile_details['contact_info'] : '';
$instructor_user_id = tuturn_get_linked_profile_id($post_id, 'post');
$package_info = apply_filters('tuturn_user_package', $instructor_user_id);
$package_info = !empty($package_info) ? $package_info : array();
$pkg_contact_info = !empty($package_info) ? intval($package_info['contact_info']) : '';
$teach_settings = !empty($tuturn_settings['teach_settings']) ? $tuturn_settings['teach_settings'] : 'default';
$conteact_details = !empty($tuturn_settings['hide_conteact_details']) ? $tuturn_settings['hide_conteact_details'] : false;
$student_package_allow = !empty($tuturn_settings['student_package_option']) ? $tuturn_settings['student_package_option'] : false;
$instructor_package_allow = !empty($tuturn_settings['package_option']) ? $tuturn_settings['package_option'] : false;
?>

<aside class="tu-asidedetail">
    <a href="javascript:void(0)" class="tu-dbmenu"><i class="icon icon-headphones"></i></a>
    <div class="tu-asidebar">
        <?php if (is_user_logged_in()) {
            $current_user = wp_get_current_user();

            // Check if the current user is the instructor or a system admin
            $is_instructor = current_user_can('instructor_capability'); // Replace 'instructor_capability' with the actual capability or role for instructors
            $is_admin = current_user_can('administrator');

            // If the current user is the instructor or an admin, or if it's the instructor viewing their own profile, display contact info
            if ($is_instructor || $is_admin || ($current_user->ID === $instructor_user_id)) {
                if ($pkg_contact_info && is_array($contact_info)) { ?>
                    <div class="tu-contactbox">
                        <h6><?php esc_html_e('Contact details', 'tuturn') ?></h6>
                        <?php if (!empty($contact_info)) { ?>
                            <ul class="tu-listinfo">
                                <?php
                                $phone = !empty($contact_info['phone']) ? esc_html($contact_info['phone']) : '';
                                $skypeid = !empty($contact_info['skypeid']) ? esc_html($contact_info['skypeid']) : '';
                                $website = !empty($contact_info['website']) ? esc_url($contact_info['website']) : '';
                                $email_address = !empty($contact_info['email_address']) ? esc_html($contact_info['email_address']) : '';
                                $whatsapp_number = !empty($contact_info['whatsapp_number']) ? esc_html($contact_info['whatsapp_number']) : '';
                                $website_lebel = tuturn_removeProtocol($website);
                                $webiste_href = 'href="javascript:void(0);"';
                                $subject = "This is subject";
                                $user = get_current_user_id();
                                $user_info = get_userdata($user);
                                $media_urls = tuturn_social_media_lists();
                                if (!empty($website)) {
                                    $webiste_href = 'href="' . esc_url($website) . '" target="_blank"';
                                }

                                $show_conteact_details = 'show';
                                if (!empty($conteact_details)) {
                                    if (is_user_logged_in() && $args['userType'] == 'student' && !empty($student_package_allow)) {
                                        $post_meta_data = array(
                                            'instructor_id' => $instructor_user_id,
                                            'student_id' => $user
                                        );
                                        $previous_order_key_query = tuturn_get_total_posts_by_multiple_meta('shop_order', array('wc-completed'), $post_meta_data);
                                        $show_conteact_details = isset($previous_order_key_query->found_posts) ? intval($previous_order_key_query->found_posts) : 0;
                                        if (empty($show_conteact_details)) {
                                            $show_conteact_details = 'hide';
                                        }
                                    }
                                }

                                if ((!empty($show_conteact_details) && $show_conteact_details === 'hide')
                                    || !is_user_logged_in()
                                    || (empty($args['package_info']['allowed']) &&  $args['userType'] == 'student' && !empty($student_package_allow))
                                    || ($args['userType'] == 'instructor' && $current_user->ID !== $instructor_user_id && !empty($instructor_package_allow))
                                ) {
                                    $whatsapp_number = tuturn_maskPhone($whatsapp_number);
                                    $phone = tuturn_maskPhone($phone);
                                    $skypeid = tuturn_maskSkypeAddress($skypeid);
                                    $email_address = tuturn_maskEmailAddress($email_address);
                                    $website_lebel = tuturn_maskwebisteURL($website_lebel);
                                    $webiste_href = '';
                                }
                                ?>
                                <?php if (!empty($phone)) { ?>
                                    <li>
                                        <span class="tu-bg-maroon"><i class="icon icon-phone-call "></i></span>
                                        <h6><?php echo do_shortcode($phone) ?></h6>
                                    </li>
                                <?php }
                                if (!empty($email_address)) {
                                    $email_link = (is_user_logged_in() && is_email($email_address)) ? "mailto:$email_address" : 'javascript:void(0)';
                                ?>
                                    <li>
                                        <span class="tu-bg-voilet"><i class="icon icon-mail"></i></span>
                                        <?php if (is_user_logged_in()) { ?>
                                            <a href=<?php echo do_shortcode($email_link); ?>><?php echo do_shortcode($email_address) ?></a>
                                        <?php } else { ?>
                                            <h6><?php echo do_shortcode($email_address) ?></h6>
                                        <?php } ?>
                                    </li>
                                <?php }
                                if (!empty($skypeid)) { ?>
                                    <li>
                                        <span class="tu-bg-blue"><i class="fab fa-skype"></i></span>
                                        <h6><?php echo do_shortcode($skypeid) ?></h6>
                                    </li>
                                <?php }
                                if (!empty($whatsapp_number)) { ?>
                                    <li>
                                        <span class="tu-bg-green"><i class="fab fa-whatsapp"></i></span>
                                        <h6><?php echo do_shortcode($whatsapp_number) ?></h6>
                                    </li>
                                <?php }
                                if (!empty($website_lebel)) { ?>
                                    <li>
                                        <span class="tu-bg-orange"><i class="icon icon-printer"></i></span>
                                        <a <?php echo do_shortcode($webiste_href); ?>><?php echo do_shortcode($website_lebel) ?></a>
                                    </li>
                                <?php } ?>
                                <?php
                                if (!empty($media_urls)) {
                                    foreach ($media_urls as $key => $val) {
                                        $media_url = !empty($contact_info[$key]) ? $contact_info[$key] : '';
                                        if (!empty($media_url)) {
                                            $media_href = 'href="' . esc_url($media_url) . '" target="_blank"';
                                            if (!is_user_logged_in() || (empty($args['package_info']['allowed']) &&  $args['userType'] == 'student')) {
                                                $media_url = tuturn_maskwebisteURL($media_url);
                                                $media_href = 'href="javascript:;"';
                                            }

                                            $icon = !empty($val['icon_class']) ? $val['icon_class'] : '';
                                            $bg_class = !empty($val['bg_class']) ? $val['bg_class'] : 'tu-bg-' . $key;
                                ?>
                                            <li>
                                                <span class="<?php echo esc_attr($bg_class); ?>">
                                                    <?php if (!empty($icon)) { ?>
                                                        <i class="<?php echo esc_attr($icon); ?>"></i>
                                                    <?php } ?>
                                                </span>
                                                <a <?php echo do_shortcode($media_href); ?>><?php echo do_shortcode($media_url) ?></a>
                                            </li>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        <?php } ?>
                    </div>
                <?php }
            } else {
                // Display a message to students that they can't access contact info
                ?>
                <div class="tu-unlockfeature text-center">
                    <h6>
                        <?php esc_html_e('You do not have permission to access contact details.', 'tuturn'); ?>
                    </h6>
                </div>
            <?php }
        } else {
            // Display a message to non-logged-in users to encourage them to log in
            $login = tuturn_get_page_uri('login');
            ?>
            <div class="tu-unlockfeature text-center">
                <h6>
                    <?php esc_html_e('Click the button below to login & unlock the contact details', 'tuturn'); ?>
                </h6>
                <a href="<?php echo esc_url($login); ?>" class="tu-primbtn tu-btngreen"><span><?php esc_html_e('Unlock feature', 'tuturn'); ?></span><i class="icon icon-lock"></i></a>
            </div>
        <?php } ?>
    </div>
</aside>
