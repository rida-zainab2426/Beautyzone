<?php
// admin/db_backup.php
require_once 'includes/header.php'; // Includes config.php and functions.php

if (isset($_POST['backup_db'])) {
    $tables = array();
    $result = $conn->query("SHOW TABLES");
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }

    $backup_sql = '';
    foreach ($tables as $table) {
        $result = $conn->query("SELECT * FROM " . $table);
        $num_fields = $result->field_count;
        $num_rows = $conn->affected_rows;

        $backup_sql .= 'DROP TABLE IF EXISTS ' . $table . ';';
        $row2 = $conn->query("SHOW CREATE TABLE " . $table)->fetch_row();
        $backup_sql .= "\n\n" . $row2[1] . ";\n\n";

        for ($i = 0; $i < $num_fields; $i++) {
            while ($row = $result->fetch_row()) {
                $backup_sql .= 'INSERT INTO ' . $table . ' VALUES(';
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = preg_replace("/\n/", "\\n", $row[$j]);
                    if (isset($row[$j])) {
                        $backup_sql .= '"' . $row[$j] . '"';
                    } else {
                        $backup_sql .= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $backup_sql .= ',';
                    }
                }
                $backup_sql .= ");\n";
            }
        }
        $backup_sql .= "\n\n\n";
    }

    // Save the backup file
    $filename = 'db-backup-' . date('Y-m-d_H-i-s') . '.sql';
    $filepath = __DIR__ . '/../backups/' . $filename; // Create a 'backups' folder outside admin
    
    // Ensure the 'backups' directory exists and is writable
    if (!is_dir(__DIR__ . '/../backups/')) {
        mkdir(__DIR__ . '/../backups/', 0755, true);
    }

    file_put_contents($filepath, $backup_sql);

    if (file_exists($filepath)) {
        $_SESSION['message'] = 'Database backup successful! Saved as: ' . $filename;
        $_SESSION['message_type'] = 'success';
        // Optional: Offer download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($filepath);
        exit();
    } else {
        $_SESSION['message'] = 'Error creating database backup.';
        $_SESSION['message_type'] = 'error';
    }
    redirectTo('db_backup.php');
}
?>

<h1>Database Backup</h1>

<p>Click the button below to create a full backup of your Beautyzone database. The backup file will be saved in the `backups/` directory (relative to your `config.php` file) and will also be offered for download.</p>

<form action="db_backup.php" method="POST">
    <button type="submit" name="backup_db" class="btn"><i class="fas fa-download"></i> Generate & Download Backup</button>
</form>

<h2 style="margin-top: 40px;">Recent Backups</h2>
<?php
$backup_dir = __DIR__ . '/../backups/';
$backup_files = [];
if (is_dir($backup_dir)) {
    $files = scandir($backup_dir);
    foreach ($files as $file) {
        if (preg_match('/^db-backup-.*\.sql$/', $file)) {
            $backup_files[] = $file;
        }
    }
    rsort($backup_files); // Sort by newest first
}

if (empty($backup_files)): ?>
    <p>No backups found yet.</p>
<?php else: ?>
    <table class="data-table">
        <thead>
            <tr>
                <th>Filename</th>
                <th>Size</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (array_slice($backup_files, 0, 10) as $file): // Show last 10 backups ?>
                <?php
                $full_path = $backup_dir . $file;
                $file_size = filesize($full_path); // in bytes
                $file_date = date("Y-m-d H:i:s", filemtime($full_path));
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($file); ?></td>
                    <td><?php echo round($file_size / 1024, 2); ?> KB</td>
                    <td><?php echo htmlspecialchars($file_date); ?></td>
                    <td>
                        <a href="../backups/<?php echo urlencode($file); ?>" class="btn btn-secondary" download><i class="fas fa-download"></i> Download</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php
require_once 'includes/footer.php';
?>