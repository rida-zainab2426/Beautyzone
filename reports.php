<?php
session_start();
// Check if admin is logged in (uncomment in production)
// if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//     header('Location: admin_login.php');
//     exit();
// }

require_once 'config.php'; // Includes your database configuration

$message = '';
$error = '';
$report_type = $_POST['report_type'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($report_type)) {
    try {
        if ($report_type == 'top_selling_products') {
            $stmt = $pdo->query("
                SELECT
                    p.product_id,
                    p.name AS product_name,
                    c.name AS category_name,
                    SUM(oi.quantity) AS units_sold,
                    SUM(oi.quantity * oi.price_at_purchase) AS total_revenue
                FROM
                    order_items oi
                JOIN
                    products p ON oi.product_id = p.product_id
                JOIN
                    categories c ON p.category_id = c.category_id
                GROUP BY
                    p.product_id, p.name, c.name
                ORDER BY
                    total_revenue DESC
                LIMIT 10
            ");
            $report_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['report_data'] = $report_data;
            $_SESSION['report_type'] = 'top_selling_products';
            $message = "Top 10 Selling Products report generated.";

        } elseif ($report_type == 'top_clients') {
            $stmt = $pdo->query("
                SELECT
                    sm.member_id AS user_id,
                    sm.username AS client_name,
                    sm.email,
                    sm.created_at AS client_registration_date,
                    COUNT(o.order_id) AS total_orders,
                    SUM(o.total_amount) AS total_spent
                FROM
                    site_members sm
                JOIN
                    orders o ON sm.member_id = o.member_id
                GROUP BY
                    sm.member_id, sm.username, sm.email, sm.created_at
                ORDER BY
                    total_spent DESC
                LIMIT 10
            ");
            $report_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['report_data'] = $report_data;
            $_SESSION['report_type'] = 'top_clients';
            $message = "Top 10 Clients report generated.";
        } else {
            $error = "Invalid report type selected.";
        }
    } catch (PDOException $e) {
        $error = "Database error generating report: " . $e->getMessage();
    }
}

// Redirect back to admin_dashboard.php with a message
header("Location: admin_dashboard.php#reports" . ($message ? '&msg_report=' . urlencode($message) : '') . ($error ? '&err_report=' . urlencode($error) : ''));
exit();
?>