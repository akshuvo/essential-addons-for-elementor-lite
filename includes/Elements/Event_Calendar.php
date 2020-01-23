<?php
namespace Essential_Addons_Elementor\Elements;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Scheme_Typography;
use \Elementor\Widget_Base;

class Event_Calendar extends Widget_Base
{
    use \Essential_Addons_Elementor\Traits\Helper;

    public function get_name()
    {
        return 'eael-event-calendar';
    }

    public function get_title()
    {
        return esc_html__('EA Event Calendar', 'essential-addons-for-elementor-lite');
    }

    public function get_icon()
    {
        return 'eicon-calendar';
    }

    public function get_categories()
    {
        return ['essential-addons-elementor'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'eael_event_section',
            [
                'label' => __('Events', 'essential-addons-for-elementor-lite'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'eael_event_calendar_type',
            [
                'label' => __('Source', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'manual' => __('Manual', 'essential-addons-for-elementor-lite'),
                    'google' => __('Google', 'essential-addons-for-elementor-lite'),
                ],
                'default' => 'manual',
            ]
        );

        $repeater = new Repeater;

        $repeater->start_controls_tabs('eael_event_content_tabs');

        $repeater->start_controls_tab(
            'eaelec_event_info_tab',
            [
                'label' => __('General', 'essential-addons-for-elementor-lite'),
            ]
        );

        $repeater->add_control(
            'eael_event_title',
            [
                'label' => __('Title', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'eael_event_link',
            [
                'label' => __('Link', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://sample-domain.com', 'essential-addons-for-elementor-lite'),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $repeater->add_control(
            'eael_event_all_day',
            [
                'label' => __('All Day', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::SWITCHER,
                'label_block' => false,
                'return_value' => 'yes',
            ]
        );

        $repeater->add_control(
            'eael_event_start_date',
            [
                'label' => __('Start Date', 'plugin-domain'),
                'type' => Controls_Manager::DATE_TIME,
                'default' => date('Y-m-d H:i', current_time('timestamp', 0)),
            ]
        );

        $repeater->add_control(
            'eael_event_end_date',
            [
                'label' => __('End Date', 'plugin-domain'),
                'type' => Controls_Manager::DATE_TIME,
                'default' => date('Y-m-d H:i', strtotime("+5 minute", current_time('timestamp', 0))),
                'condition' => [
                    'eael_event_all_day' => '',
                ],
            ]
        );

        $repeater->add_control(
            'eael_event_bg_color',
            [
                'label' => __('Event Background Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
            ]
        );

        $repeater->add_control(
            'eael_event_text_color',
            [
                'label' => __('Event Text Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR
            ]
        );

        $repeater->add_control(
            'eael_event_border_color',
            [
                'label' => __('Event Border Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'eaelec_event_content_tab',
            [
                'label' => __('Content', 'essential-addons-for-elementor-lite'),
            ]
        );

        $repeater->add_control(
            'eael_event_description',
            [
                'label' => __('Description', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::WYSIWYG,
            ]
        );

        $repeater->end_controls_tab();

        $this->add_control(
            'eael_event_items',
            [
                'label' => __('Events', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['eael_event_title' => 'Event Title'],
                ],
                'title_field' => '{{ eael_event_title }}',
                'condition' => [
                    'eael_event_calendar_type' => 'manual',
                ],

            ]
        );

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_event_google_calendar',
            [
                'label' => __('Google Calendar', 'essential-addons-for-elementor-lite'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'eael_event_calendar_type' => 'google',
                ],
            ]
        );

        $this->add_control(
            'eael_event_google_api_key',
            [
                'label' => __('APi Key', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'description' => sprintf(__('<a href="https://essential-addons.com/elementor/docs/google-api-key/" class="eael-btn" target="_blank">%s</a>', 'essential-addons-for-elementor-lite'), 'Get API Key'),
            ]
        );

        $this->add_control(
            'eael_event_calendar_id',
            [
                'label' => __('Calendar ID', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'description' => sprintf(__('<a href="https://essential-addons.com/elementor/docs/google-calendar-id/" class="eael-btn" target="_blank">%s</a>', 'essential-addons-for-elementor-lite'), 'Get google calendar ID'),
            ]
        );

        $this->add_control(
            'eael_google_calendar_start_date',
            [
                'label' => __('Start Date', 'plugin-domain'),
                'type' => Controls_Manager::DATE_TIME,
                'default' => date('Y-m-d H:i', current_time('timestamp', 0)),
            ]
        );

        $this->add_control(
            'eael_google_calendar_end_date',
            [
                'label' => __('End Date', 'plugin-domain'),
                'type' => Controls_Manager::DATE_TIME,
                'default' => date('Y-m-d H:i', strtotime("+6 months", current_time('timestamp', 0))),
            ]
        );

        $this->add_control(
            'eael_google_calendar_max_result',
            [
                'label' => __('Max Result', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'default' => 10,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_event_calendar_section',
            [
                'label' => __('Calendar', 'essential-addons-for-elementor-lite'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'eael_event_calendar_days_heading',
            [
                'label' => __('Days', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'eael_event_calendar_days_sat',
            [
                'label' => __('Saturday', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Sat',
            ]
        );

        $this->add_control(
            'eael_event_calendar_days_sun',
            [
                'label' => __('Sunday', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Sun',
            ]
        );

        $this->add_control(
            'eael_event_calendar_days_mon',
            [
                'label' => __('Monday', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Mon',
            ]
        );

        $this->add_control(
            'eael_event_calendar_days_tue',
            [
                'label' => __('Tuesday', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Tue',
            ]
        );

        $this->add_control(
            'eael_event_calendar_days_wed',
            [
                'label' => __('Wednesday', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Wed',
            ]
        );

        $this->add_control(
            'eael_event_calendar_days_thu',
            [
                'label' => __('Thursday', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Thu',
            ]
        );

        $this->add_control(
            'eael_event_calendar_days_fri',
            [
                'label' => __('Friday', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Fri',
            ]
        );

        $this->add_control(
            'eael_event_calendar_months_name',
            [
                'label' => __('Months', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'eael_event_calendar_month_jan',
            [
                'label' => __('January', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'January',
            ]
        );

        $this->add_control(
            'eael_event_calendar_month_feb',
            [
                'label' => __('February', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'February',
            ]
        );

        $this->add_control(
            'eael_event_calendar_month_mar',
            [
                'label' => __('March', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'March',
            ]
        );

        $this->add_control(
            'eael_event_calendar_month_apr',
            [
                'label' => __('April', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'April',
            ]
        );

        $this->add_control(
            'eael_event_calendar_month_may',
            [
                'label' => __('May', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'May',
            ]
        );

        $this->add_control(
            'eael_event_calendar_month_jun',
            [
                'label' => __('June', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'June',
            ]
        );

        $this->add_control(
            'eael_event_calendar_month_jul',
            [
                'label' => __('July', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'July',
            ]
        );

        $this->add_control(
            'eael_event_calendar_month_aug',
            [
                'label' => __('August', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'August',
            ]
        );

        $this->add_control(
            'eael_event_calendar_month_sep',
            [
                'label' => __('September', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'September',
            ]
        );

        $this->add_control(
            'eael_event_calendar_month_oct',
            [
                'label' => __('October', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'October',
            ]
        );

        $this->add_control(
            'eael_event_calendar_month_nov',
            [
                'label' => __('November', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'November',
            ]
        );

        $this->add_control(
            'eael_event_calendar_month_dec',
            [
                'label' => __('December', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::TEXT,
                'default' => 'December',
            ]
        );

        $this->add_control(
            'eael_event_calendar_first_day',
            [
                'label' => __('First Day of Week', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '0' => __('Sunday', 'essential-addons-for-elementor-lite'),
                    '1' => __('Monday', 'essential-addons-for-elementor-lite'),
                    '2' => __('Tuesday', 'essential-addons-for-elementor-lite'),
                    '3' => __('Wednesday', 'essential-addons-for-elementor-lite'),
                    '4' => __('Thursday', 'essential-addons-for-elementor-lite'),
                    '5' => __('Friday', 'essential-addons-for-elementor-lite'),
                    '6' => __('Saturday', 'essential-addons-for-elementor-lite'),
                ],
                'default' => '0',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab Started
         */
        $this->start_controls_section(
            'eael_event_calendar_interface',
            [
                'label' => __('Calendar', 'essential-addons-for-elementor-lite'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'eael_event_calendar_border_type',
            [
                'label' => __('Border Type', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => __('None', 'essential-addons-for-elementor-lite'),
                    'solid' => __('Solid', 'essential-addons-for-elementor-lite'),
                    'double' => __('Double', 'essential-addons-for-elementor-lite'),
                    'dotted' => __('Dotted', 'essential-addons-for-elementor-lite'),
                    'dashed' => __('Dashed', 'essential-addons-for-elementor-lite'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-event-calendar-wrapper' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'eael_event_calendar_border_width',
            [
                'label' => esc_html__('Border Width', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .eael-event-calendar-wrapper' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'eael_event_calendar_border_color',
            [
                'label' => __('Border Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eael-event-calendar-wrapper' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'eael_event_calendar_border_radius',
            [
                'label' => esc_html__('Border Radius', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-event-calendar-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'eael_event_calendar_title_color',
            [
                'label' => __('Title Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fc-toolbar h2' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eaelec_title_typography',
                'label' => __('Title Typography', 'essential-addons-for-elementor-lite'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .fc-toolbar h2',
            ]
        );

        $this->add_control(
            'eael_event_calendar_padding',
            [
                'label' => esc_html__('Padding', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .eael-event-calendar-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'eael_event_calendar_today_bg_color',
            [
                'label' => __('Today Background Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fc-unthemed td.fc-today' => 'background: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'eael_event_calendar_button_style',
            [
                'label' => __('Button', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'eael_event_calendar_button_color',
            [
                'label' => __('Button Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fc-toolbar .fc-button' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'eael_event_calendar_button_hover_color',
            [
                'label' => __('Button Hover Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fc-toolbar .fc-button:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'eael_event_calendar_button_active_color',
            [
                'label' => __('Button Active Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fc-toolbar .fc-state-active' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'eael_event_calendar_today_button_color',
            [
                'label' => __('Today Button Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fc-toolbar .fc-today-button' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eaelec_today_button_typography',
                'label' => __('Today Button Typography', 'essential-addons-for-elementor-lite'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .fc-toolbar .fc-today-button',
            ]
        );

        $this->add_control(
            'eael_event_calendar_button_border_radius',
            [
                'label' => esc_html__('Button Radius', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .fc-toolbar .fc-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eaelec_display_options_typography',
                'label' => __('Display Options Typography', 'essential-addons-for-elementor-lite'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} select.eaelec-select-view',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_event_week_interface',
            [
                'label' => __('Weekday', 'essential-addons-for-elementor-lite'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'eael_event_calendar_weekday_bg_color',
            [
                'label' => __('Background Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fc-row table thead:first-child tr:first-child th' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_event_calendar_weekday_typography',
                'label' => __('Typography', 'essential-addons-for-elementor-lite'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .fc-row table thead:first-child tr:first-child th',
            ]
        );

        $this->add_control(
            'eael_event_calendar_weekday_font_color',
            [
                'label' => __('Font Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fc-row table thead:first-child tr:first-child th' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'eael_event_calendar_weekday_alignment',
            [
                'label' => __('Alignment', 'essential-addons-for-elementor-lite'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'essential-addons-for-elementor-lite'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'essential-addons-for-elementor-lite'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'essential-addons-for-elementor-lite'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .fc-row table thead:first-child tr:first-child th' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_event_calendar_date_interface',
            [
                'label' => __('Date', 'essential-addons-for-elementor-lite'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'eael_event_calendar_date_alignment',
            [
                'label' => __('Alignment', 'essential-addons-for-elementor-lite'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'essential-addons-for-elementor-lite'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'essential-addons-for-elementor-lite'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'essential-addons-for-elementor-lite'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .fc-day-number' => 'float: unset',
                    '{{WRAPPER}} .fc-view table thead:first-child tr:first-child td' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_event_calendar_date_typography',
                'label' => __('Typography', 'essential-addons-for-elementor-lite'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .fc-day-number',
            ]
        );

        $this->add_control(
            'eael_event_calendar_date_font_color',
            [
                'label' => __('Font Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fc-day-number' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'eael_event_calendar_date_bg_color',
            [
                'label' => __('Background Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fc-day-number' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'eael_event_calendar_date_margin',
            [
                'label' => esc_html__('Margin', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .fc-day-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'eael_event_calendar_date_padding',
            [
                'label' => esc_html__('Padding', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .fc-day-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'eael_event_calendar_date_border_radius',
            [
                'label' => esc_html__('Border Radius', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .fc-day-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eaelec_event_section',
            [
                'label' => __('Events', 'essential-addons-for-elementor-lite'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eaelec_event_typography',
                'label' => __('Typography', 'essential-addons-for-elementor-lite'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .fc-day-grid-event',
            ]
        );

        $this->add_control(
            'eaelec_event_margin',
            [
                'label' => esc_html__('Margin', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .fc-day-grid-event' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'eaelec_event_padding',
            [
                'label' => esc_html__('Padding', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .fc-day-grid-event' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'eaelec_event_border_radius',
            [
                'label' => esc_html__('Border Radius', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .fc-day-grid-event' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_event_popup',
            [
                'label' => __('Event Popup', 'essential-addons-for-elementor-lite'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'eael_event_popup_title_color',
            [
                'label' => __('Title Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eaelec-modal-header h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_event_popup_title_typography',
                'label' => __('Title Typography', 'essential-addons-for-elementor-lite'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eaelec-modal-header h2',
            ]
        );

        $this->add_control(
            'eael_event_popup_event_date_color',
            [
                'label' => __('Event Date Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eaelec-modal-header span.eaelec-event-date-start' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eaelec-modal-header span.eaelec-event-date-end' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_event_popup_event_date_typography',
                'label' => __('Date Typography', 'essential-addons-for-elementor-lite'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eaelec-modal-header > span.eaelec-event-popup-date',
            ]
        );

        $this->add_control(
            'eael_event_popup_details_color',
            [
                'label' => __('Event Details Color', 'essential-addons-for-elementor-lite'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eaelec-modal-footer a.eaelec-event-details-link' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_event_popup_details_typography',
                'label' => __('Details Typography', 'essential-addons-for-elementor-lite'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eaelec-modal-footer a.eaelec-event-details-link',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $data = [];

        if ($settings['eael_event_calendar_type'] == 'google') {
            $events = $this->get_google_calendar_events();
        } else {
            $events = $settings['eael_event_items'];
        }

        $daysWeek = [
            $settings['eael_event_calendar_days_sun'],
            $settings['eael_event_calendar_days_mon'],
            $settings['eael_event_calendar_days_tue'],
            $settings['eael_event_calendar_days_wed'],
            $settings['eael_event_calendar_days_thu'],
            $settings['eael_event_calendar_days_fri'],
            $settings['eael_event_calendar_days_sat'],
        ];

        $monthNames = [
            $settings['eael_event_calendar_month_jan'],
            $settings['eael_event_calendar_month_feb'],
            $settings['eael_event_calendar_month_mar'],
            $settings['eael_event_calendar_month_apr'],
            $settings['eael_event_calendar_month_may'],
            $settings['eael_event_calendar_month_jun'],
            $settings['eael_event_calendar_month_jul'],
            $settings['eael_event_calendar_month_aug'],
            $settings['eael_event_calendar_month_sep'],
            $settings['eael_event_calendar_month_oct'],
            $settings['eael_event_calendar_month_nov'],
            $settings['eael_event_calendar_month_dec'],
        ];
        echo '<div class="eael-event-calendar-wrapper">';

        if ($events) {
            $i = 0;

            foreach ($events as $event) {
                $data[] = [
                    'id' => $i,
                    'title' => $event["eael_event_title"],
                    'description' => $event["eael_event_description"],
                    'start' => $event["eael_event_start_date"],
                    'end' => date('Y-m-d H:i', strtotime($event["eael_event_end_date"])) . ":01",
                    'borderColor' => $event['eael_event_border_color'],
                    'textColor' => $event['eael_event_text_color'],
                    'color' => $event['eael_event_bg_color'],
                    'url' => $event["eael_event_link"]["url"],
                    'allDay' => $event['eael_event_all_day'],
                    'external' => $event['eael_event_link']['is_external'],
                    'nofollow' => $event['eael_event_link']['nofollow'],
                    'dayNames' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                ];

                $i++;
            }
        }

        echo '<div id="eael-event-calendar-' . $this->get_id() . '" class="eael-event-calendar-cls"
            data-cal_id = "' . $this->get_id() . '"
            data-events="' . htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8') . '"
            data-month_names="' . htmlspecialchars(json_encode($monthNames), ENT_QUOTES, 'UTF-8') . '"
            data-first_day="' . $settings['eael_event_calendar_first_day'] . '"
            data-days_week="' . htmlspecialchars(json_encode($daysWeek), ENT_QUOTES, 'UTF-8') . '"></div>';

            $this->eaelec_load_event_details();
        echo '</div>';
    }

    protected function eaelec_load_event_details()
    {
        echo '<div id="eaelecModal" class="eaelec-modal eael-zoom-in">
            <div class="eael-ec-modal-bg"></div>
            <div class="eaelec-modal-content">
                <div class="eaelec-modal-header">
                    <div class="eaelec-modal-close"><span>&times;</span></div>
                    <h2></h2>
                    <span class="eaelec-event-date-start eaelec-event-popup-date"></span>
                    <span class="eaelec-event-date-end eaelec-event-popup-date"></span>
                </div>
                <div class="eaelec-modal-body">
                    <p></p>
                </div>
                <div class="eaelec-modal-footer">
                    <a class="eaelec-event-details-link">Event Details</a>
                </div>
            </div>
        </div>';
    }

    /**
     * get google calendar events
     *
     * @return array
     */
    public function get_google_calendar_events()
    {
        $settings = $this->get_settings_for_display();
        $api_key = $settings['eael_event_google_api_key'];
        $calendar_id = urlencode($settings['eael_event_calendar_id']);
        $base_url = "https://www.googleapis.com/calendar/v3/calendars/{$calendar_id}/events";

        if (empty($settings['eael_event_google_api_key']) && empty($settings['eael_event_calendar_id'])) {
            return [];
        }

        $start_date = strtotime($settings['eael_google_calendar_start_date']);
        $end_date = strtotime($settings['eael_google_calendar_end_date']);
        $max_results = $settings['eael_google_calendar_max_result'];
        $arg = [
            'key' => $settings['eael_event_google_api_key'],
            'maxResults' => $max_results,
            'timeMin' => urlencode(date('c', $start_date)),
            '$calendar_id' => urlencode($settings['eael_event_calendar_id']),
        ];

        if (!empty($end_date) && $end_date > $start_date) {
            $arg['timeMax'] = urlencode(date('c', $end_date));
        }

        $transient_key = 'eael_google_calendar_' . md5(implode('', $arg));
        $calendar_data = get_transient($transient_key);

        if (!empty($calendar_data)) {
            return $calendar_data;
        }

        $data = wp_remote_retrieve_body(wp_remote_get(add_query_arg($arg, $base_url)));

        if (is_wp_error($data)) {
            return [];
        }

        $data = json_decode($data);

        if (isset($data->items)) {
            foreach ($data->items as $key => $item) {
                $all_day = false;

                if (isset($item->start->date)) {
                    $ev_start_date = $item->start->date;
                    $ev_end_date = $item->end->date;
                    $ev_end_date = date('Y-m-d', strtotime("-1 days", strtotime($ev_end_date)));
                } else {
                    $ev_start_date = $item->start->dateTime;
                    $ev_end_date = $item->end->dateTime;
                }

                $calendar_data[] = [
                    'eael_event_title' => $item->summary,
                    'eael_event_description' => isset($item->description) ? $item->description : '',
                    'eael_event_start_date' => $ev_start_date,
                    'eael_event_end_date' => $ev_end_date,
                    'eael_event_border_color' => '#6231FF',
                    'eael_event_text_color' => '#242424',
                    'eael_event_bg_color' => '#FFF',
                    'eael_event_all_day' => $all_day,
                    'eael_event_link' => [
                        'is_external' => '',
                        'nofollow' => '',
                        'url' => $item->htmlLink,
                    ],
                ];
            }

            set_transient($transient_key, $calendar_data, 1 * HOUR_IN_SECONDS);
        }

        return $calendar_data;
    }
}
