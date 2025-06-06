<?php
namespace AboveTheFoldTracker;

class AdminPage {
    private $db_manager;

    public function __construct() {
        $this->db_manager = new DatabaseManager();
    }

    public function register_admin_page() {
        add_menu_page(
            'Above The Fold Tracker',
            'ATF Tracker',
            'manage_options',
            'atf-tracker',
            [$this, 'render_admin_page'],
            'dashicons-visibility',
            80
        );
    }

    public function render_admin_page() {
        $data = $this->db_manager->get_tracking_data();
        ?>
        <div class="wrap">
            <h1>Above The Fold Tracker</h1>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Visit Time</th>
                        <th>Screen Size</th>
                        <th>Visible Links</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data)) : ?>
                        <tr><td colspan="3">No data available</td></tr>
                    <?php else : ?>
                        <?php foreach ($data as $row) : ?>
                            <tr>
                                <td><?php echo esc_html($row['visit_time']); ?></td>
                                <td><?php echo esc_html($row['screen_size']); ?></td>
                                <td>
                                    <?php
                                    $links = json_decode($row['links'], true);
                                    if (is_array($links)) {
                                        echo '<ul>';
                                        foreach ($links as $link) {
                                            echo '<li><a href="' . esc_url($link['href']) . '">' . esc_html($link['text']) . '</a></li>';
                                        }
                                        echo '</ul>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
?>