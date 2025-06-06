<?php
namespace AboveTheFoldTracker;

use WP_Error;

class AboveTheFoldTracker {
    private $db_manager;
    private $admin_page;

    public function __construct(DatabaseManager $db_manager, AdminPage $admin_page) {
        $this->db_manager = $db_manager;
        $this->admin_page = $admin_page;
    }

    public function init() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_ajax_atf_track', [$this, 'handle_tracking']);
        add_action('wp_ajax_nopriv_atf_track', [$this, 'handle_tracking']);
        add_action('admin_menu', [$this->admin_page, 'register_admin_page']);
        add_action('init', [$this->db_manager, 'create_table']);
        $this->schedule_cleanup();
    }

    public function enqueue_scripts() {
        if (is_front_page()) {
            wp_enqueue_script(
                'atf-tracker',
                plugin_dir_url(__DIR__) . 'assets/js/tracker.js',
                [],
                '1.0.0',
                true
            );
            wp_localize_script('atf-tracker', 'atfTracker', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('atf_tracker_nonce')
            ]);
        }
    }

    public function handle_tracking() {
        check_ajax_referer('atf_tracker_nonce', 'nonce');

        if (!isset($_POST['links']) || !isset($_POST['screen_size'])) {
            wp_send_json_error('Missing required data', 400);
            return;
        }

        $links = json_decode(sanitize_text_field(wp_unslash($_POST['links'])), true);
        $screen_size = sanitize_text_field(wp_unslash($_POST['screen_size']));

        if (empty($links) || !is_array($links)) {
            wp_send_json_error('Invalid links data', 400);
            return;
        }

        $result = $this->db_manager->save_tracking_data($links, $screen_size);

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message(), 500);
            return;
        }

        wp_send_json_success();
    }

    private function schedule_cleanup() {
        if (!wp_next_scheduled('atf_cleanup_event')) {
            wp_schedule_event(time(), 'daily', 'atf_cleanup_event');
        }
        add_action('atf_cleanup_event', [$this->db_manager, 'cleanup_old_data']);
    }
}
?>