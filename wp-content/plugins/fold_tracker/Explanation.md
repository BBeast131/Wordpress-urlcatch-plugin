Above The Fold Tracker Plugin - Explanation

Problem Statement

The goal is to create a WordPress plugin that tracks which hyperlinks are visible above the fold on a website's homepage when a visitor loads the page. The plugin should store this data (visible links and screen size) for each visit over the past 7 days and provide a dashboard for the website owner to view this information. This enables the owner to optimize the homepage layout based on recent visitor data.

Technical Specification

The plugin is structured as a WordPress plugin with the following components:





Main Plugin File (index.php): Initializes the plugin, loads dependencies, and instantiates the core class.



Core Class (tracker.php): Handles script enqueuing, AJAX endpoint for tracking, and schedules data cleanup.



Database Manager (class-database-manager.php): Manages database operations, including table creation, data storage, retrieval, and cleanup.



Admin Page (class-admin-page.php): Creates a WordPress admin dashboard to display tracking data.



JavaScript (tracker.js): Runs on the homepage to detect visible links and screen size, sending data via AJAX.

Workflow





Frontend Tracking:





On homepage load, tracker.js identifies hyperlinks visible in the viewport using getBoundingClientRect().



It captures the screen size (window.innerWidth x window.innerHeight).



Data is sent to the server via an AJAX POST request to the atf_track endpoint.



Backend Processing:





The AboveTheFoldTracker class handles the AJAX request, verifies the nonce, and sanitizes input.



The DatabaseManager stores the data in a custom WordPress database table (wp_atf_tracking).



Data Management:





A custom table stores visit time, screen size, and JSON-encoded links.



A daily cron job (atf_cleanup_event) deletes data older than 7 days.



Admin Dashboard:





The AdminPage class creates a menu page displaying a table of visits with timestamps, screen sizes, and visible links.



Extensibility:





Namespaced OOP structure (PSR-4) for maintainability.



Modular design allows adding features like analytics or export functionality.

Technical Decisions and Rationale





WordPress Plugin vs. PHP App: Chose a WordPress plugin for seamless integration with WordPress sites, leveraging its ecosystem (e.g., AJAX, cron, admin UI). A standalone PHP app would require manual script integration, increasing complexity for users.



OOP with PSR-4: Used namespaced classes for modularity and future scalability. Procedural code was avoided except where WordPress APIs require it (e.g., dbDelta).



Custom Database Table: Opted for a custom table over post meta for performance, as it handles structured data efficiently and supports indexing.



AJAX for Data Collection: Ensures asynchronous data submission without impacting page load. Nonce verification prevents unauthorized requests.



Daily Cleanup Cron: Uses WordPress cron to manage data retention, ensuring compliance with the 7-day requirement without manual intervention.



No Global Variables: All data is encapsulated within classes to avoid namespace pollution.



Dynamic Content Handling: The JavaScript dynamically detects visible links, accommodating dynamic homepage content (e.g., via shortcodes or page builders).



PHPCS and Testing (Bonus Points):





Code follows WordPress coding standards (PSR-2 compatible) for PHPCS compliance.



Unit tests were not implemented due to time constraints but are planned for key methods (e.g., save_tracking_data, get_visible_links). PHPUnit with WP_Mock is recommended.



CI setup (e.g., GitHub Actions with PHPCS and PHPUnit) is described in the README but not implemented here.



WordPress 6.0+ Compatibility: Ensured compatibility with modern WordPress versions using standard APIs.



Package Template: Followed a standard WordPress plugin structure (inspired by xAI’s template), with clear file organization.

How the Solution Meets the User Story





Tracks Above-the-Fold Links: The JavaScript identifies visible hyperlinks on page load, capturing their href and text.



Records Screen Size: Captures viewport dimensions for context.



7-Day Data Retention: Stores data in a database and automatically removes entries older than 7 days.



Admin Dashboard: Provides a clear, tabular view of visit data, accessible only to users with manage_options capability.



Optimization Support: The dashboard enables website owners to analyze which links are most visible, informing layout decisions.

Future Improvements





Add export functionality for data analysis.



Implement filters for screen size or date ranges in the admin dashboard.



Add unit and integration tests using PHPUnit.



Set up CI with GitHub Actions for PHPCS and testing.



Enhance JavaScript to handle dynamic content changes (e.g., via IntersectionObserver).

Setup Instructions





Clone the GitHub repo (to be created).



Place the plugin folder in wp-content/plugins/.



Activate the plugin in WordPress.



Visit the homepage to start tracking.



View data under ATF Tracker in the admin menu.

For a GitHub repo, create a new repository, add these files, and initialize with a commit. Use a .github/workflows/ci.yml for CI (PHPCS, PHPUnit). See the WordPress Plugin Handbook for deployment details.