<?php
/**
 * Instructor appointment
 *
 * @package     Tuturn
 * @subpackage  Tuturn/Templates/Single_tuturn_Instructor
 * @author      Amentotech <info@amentotech.com>
 * @link        https://themeforest.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $post, $current_user, $tuturn_settings;
if (!empty($args) && is_array($args)) {
    extract($args);
}
$loggedInUser = $current_user->ID;
$userType = apply_filters('tuturnGetUserType', $loggedInUser);
$booking_option = !empty($tuturn_settings['booking_option']) ? $tuturn_settings['booking_option'] : 'yes';

if ($userType != 'student') {
    return;
}

$instructor_profileID = !empty($post->ID) ? $post->ID : 0;
$instructor_id = tuturn_get_linked_profile_id($instructor_profileID, 'post');
/* total week days */
$week_days = apply_filters('tuturnGetWeekDays', '');
$day_time = apply_filters('tuturnAppointmentTime', '');
$time_format = get_option('time_format');
?>
<div class="tu-serviceswizard-parent">
    <div class="tu-serviceswizard tu-hastip">
        <!-- embed code here -->
    </div>
</div>
<script type="text/template" id="tmpl-tu-book-appointment-step2">
    <div class="tu-tabswrapper">
        <div class="tu-bookingstep1">
            <div class="tu-boxtitle">
                <h4><?php esc_html_e('Please select booking details', 'tuturn'); ?></h4>
            </div>
            <form id="tu-booking-slots-filter-form" class="tu-themeform">
                <fieldset>
                    <div class="tu-themeform__wrap">
                        <div class="form-group form-group-half">
                            <div class="tu-calendergrid">
                                <div class="tu-placeholderholder">
                                    <label class="tu-label"><?php esc_html_e('I need a service from', 'tuturn') ?></label>
                                    <div class="tu-calendar">
                                        <input type="text" name="tu_start_date" class="datepicker form-control tu-form-input tu-startDate-picker tu-input-field" placeholder=" " required>
                                        <div class="tu-placeholder">
                                            <span><?php esc_html_e('Starting date', 'tuturn') ?></span>
                                            <em>*</em>
                                        </div>
                                    </div>
                                </div>
                                <div class="tu-placeholderholder">
                                    <label class="tu-label"><?php esc_html_e('Till date', 'tuturn') ?></label>
                                    <div class="tu-calendar">
                                        <input type="text" name="tu_end_date" class="datepicker form-control tu-form-input tu-endDate-picker tu-input-field" placeholder=" " required>
                                        <div class="tu-placeholder">
                                            <span><?php esc_html_e('Ending date', 'tuturn') ?></span>
                                            <em>*</em>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-half">
                            <div class="tu-calendergrid">
                                <div class="tu-placeholderholder">
                                    <label class="tu-label"><?php esc_html_e('Hours in between', 'tuturn') ?></label>
                                    <div class="tu-select">
                                        <select id="tu-start-time-filter" data-placeholder="<?php esc_attr_e('Starting time', 'tuturn'); ?>" name="tu_start_time" data-placeholderinput="<?php esc_attr_e('Starting time', 'tuturn') ?>" class="form-control tu_start_time" required>
                                            <option label="<?php esc_attr_e('Starting time', 'tuturn'); ?>"></option>
                                            <?php foreach ($day_time as $key_time => $time_val) {
                                                $time_val = date($time_format, strtotime('2022-01-01' . $time_val));
                                            ?>
                                                <option value="<?php echo esc_attr($key_time); ?>"><?php echo esc_html($time_val); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="tu-placeholderholder">
                                    <label class="tu-label"><?php esc_html_e('To time', 'tuturn') ?></label>
                                    <div class="tu-select">
                                        <select id="tu-end-time-filter" data-placeholder="<?php esc_attr_e('Select end time', 'tuturn'); ?>" data-placeholderinput="<?php esc_attr_e('Ending time', 'tuturn') ?>" name="tu_end_time" class="form-control tu_end_time" required>
                                            <option label="<?php esc_attr_e('Select end time', 'tuturn'); ?>"></option>
                                            <?php foreach ($day_time as $key_time => $time_val) {
                                                $time_val = date($time_format, strtotime('2022-01-01 ' . $time_val));
                                            ?>
                                                <option value="<?php echo esc_attr($key_time); ?>"><?php echo esc_html($time_val); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="tu-label"><?php esc_html_e('Select days', 'tuturn') ?></label>
                            <?php if (!empty($week_days)) { ?>
                                <ul class="tu-daysfilter">
                                    <?php foreach ($week_days as $key_day => $day_val) { ?>
                                        <li>
                                            <div class="tu-check tu-checksm">
                                                <input type="checkbox" name="weekDays[]" value="<?php echo esc_attr($key_day); ?>" id="<?php echo esc_attr($key_day); ?>">
                                                <label for="<?php echo esc_attr($key_day); ?>">
                                                    <?php echo esc_html($day_val); ?>
                                                </label>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <a href="javascript:void(0);" class="tu-primbtn-lg" data-student_id="<?php echo esc_attr($current_user->ID); ?>" data-instructor_profile_id="<?php echo esc_attr($post->ID); ?>" id="tu-filter-days-booking-slots"><span><?php esc_html_e('Show availability', 'tuturn') ?></span><i class="icon icon-search"></i></a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="tu-bookingstep2"></div>
        <div class="tu-bookingstep3"></div>
        <div class="tu-bookingstep4"></div>
    </div>
</script>
<script type="text/template" id="tmpl-tu-book-appointment-filter">
    <div class="tu-boxtitle">
        <h4><?php esc_html_e('Available slots', 'tuturn'); ?></h4>
    </div>
    <div class="tu-appointlist tu-liststyle1 tu-notfoundmessage"></div>
    <div class="tu-paginav"></div>
</script>
<script type="text/template" id="tmpl-tu-book-appointment-list">
    <# if (data.appointments) { #>
        <ul class="tu-liststyle1 tu-liststyle2 tu-liststyle3 tu-liststyle4">
            <# _.each(data.appointments, function(appointment) { #>
                <li data-day="<?php echo date("l", strtotime("2022-01-01")); ?>" data-daykey="<?php echo date("N", strtotime("2022-01-01")); ?>" data-date="<?php echo date("Y-m-d", strtotime("2022-01-01")); ?>" data-time="<?php echo date("H:i", strtotime("2022-01-01")); ?>">
                    <div class="tu-listflex">
                        <div class="tu-appointinfo">
                            <span class="tu-appointdate">
                                <?php esc_html_e('Appointment Date:', 'tuturn'); ?>
                                <strong><?php echo date("l, F j, Y", strtotime("2022-01-01")); ?></strong>
                            </span>
                            <span class="tu-appointtime">
                                <?php esc_html_e('Appointment Time:', 'tuturn'); ?>
                                <strong><?php echo date("H:i", strtotime("2022-01-01")); ?> - <?php echo date("H:i", strtotime("2022-01-01")); ?></strong>
                            </span>
                            <span class="tu-appointservice">
                                <?php esc_html_e('Service:', 'tuturn'); ?>
                                <strong><?php echo esc_html('Service Name'); ?></strong>
                            </span>
                            <span class="tu-appointinstructor">
                                <?php esc_html_e('Instructor:', 'tuturn'); ?>
                                <strong><?php echo esc_html('Instructor Name'); ?></strong>
                            </span>
                        </div>
                        <div class="tu-actionbox">
                            <a href="javascript:void(0);" class="tu-primbtn tu-primbtn-sml tu-bookappointment" data-toggle="modal" data-instructor_id="<?php echo esc_attr($instructor_id); ?>" data-student_id="<?php echo esc_attr($current_user->ID); ?>" data-appoinment_id="<?php echo esc_attr($appointment->ID); ?>" data-appoinment_date="<?php echo date("l, F j, Y", strtotime("2022-01-01")); ?>" data-appoinment_time="<?php echo date("H:i", strtotime("2022-01-01")); ?> - <?php echo date("H:i", strtotime("2022-01-01")); ?>" data-service_name="<?php echo esc_attr('Service Name'); ?>" data-instructor_name="<?php echo esc_attr('Instructor Name'); ?>"><?php esc_html_e('Book Appointment', 'tuturn'); ?><i class="icon icon-next"></i></a>
                        </div>
                    </div>
                </li>
            <# }); #>
        </ul>
    <# } else { #>
        <p class="tu-notfound"><?php esc_html_e('No appointments available for the selected criteria.', 'tuturn'); ?></p>
    <# } #>
</script>
<script type="text/template" id="tmpl-tu-book-appointment-confirm">
    <div class="tu-boxtitle">
        <h4><?php esc_html_e('Confirm Appointment', 'tuturn'); ?></h4>
    </div>
    <div class="tu-appointmentconfirm">
        <div class="tu-appointmentinfo">
            <span class="tu-appointdate">
                <?php esc_html_e('Appointment Date:', 'tuturn'); ?>
                <strong><?php echo date("l, F j, Y", strtotime("2022-01-01")); ?></strong>
            </span>
            <span class="tu-appointtime">
                <?php esc_html_e('Appointment Time:', 'tuturn'); ?>
                <strong><?php echo date("H:i", strtotime("2022-01-01")); ?> - <?php echo date("H:i", strtotime("2022-01-01")); ?></strong>
            </span>
            <span class="tu-appointservice">
                <?php esc_html_e('Service:', 'tuturn'); ?>
                <strong><?php echo esc_html('Service Name'); ?></strong>
            </span>
            <span class="tu-appointinstructor">
                <?php esc_html_e('Instructor:', 'tuturn'); ?>
                <strong><?php echo esc_html('Instructor Name'); ?></strong>
            </span>
        </div>
        <div class="tu-actionbox">
            <a href="javascript:void(0);" class="tu-primbtn tu-primbtn-lg" data-instructor_id="<?php echo esc_attr($instructor_id); ?>" data-student_id="<?php echo esc_attr($current_user->ID); ?>" data-appoinment_id="<?php echo esc_attr(123); ?>"><?php esc_html_e('Confirm Appointment', 'tuturn'); ?><i class="icon icon-next"></i></a>
        </div>
    </div>
</script>
