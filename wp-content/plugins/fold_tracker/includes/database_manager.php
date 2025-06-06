<?php
namespace AboveTheFoldTracker;

use WP_Error;

class DatabaseManager {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'atf_tracking';
    }

    public function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $this->table_name (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            visit_time DATETIME NOT NULL,
            screen_size VARCHAR(50) NOT NULL,
            links TEXT NOT NULL,
            PRIMARY KEY (id),
            INDEX visit_time (visit_time)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    public function save_tracking_data(array $links, string $screen_size): bool|WP_Error {
        global $wpdb;

        $data = [
            'visit_time' => current_time('mysql'),
            'screen_size' => $screen_size,
            'links' => wp_json_encode($links)
        ];

        $format = ['%s', '%s', '%s'];

        $result = $wpdb->insert($this->table_name, $data, $format);

        if (false === $result) {
            return new WP_Error('db_insert_error', 'Failed to save tracking data');
        }

        return true;
    }

    public function get_tracking_data(int $days = 7): array {
        global $wpdb;

        $query = $wpdb->prepare(
            "SELECT * FROM $this->table_name WHERE visit_time >= %s ORDER BY visit_time DESC",
            date('Y-m-d H:i:s', strtotime("-$days days"))
        );

        return $wpdb->get_results($query, ARRAY_A);
    }

    public function cleanup_old_data() {
        global $wpdb;

        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM $this->table_name WHERE visit_time < %s",
                date('Y-m-d H:i:s', strtotime('-7 days'))
            )
        );
    }
}
?>