<?php
set_time_limit(0);

// database connection
require_once "db.php";

// sample data
require_once "sample-data.php";

// clear table safely
$pdo->exec("TRUNCATE TABLE search_items");

// SQL insert statement
$sql = "INSERT INTO search_items 
        (title, description, page_name, page_fav_icon_path, page_url, created_at)
        VALUES 
        (:title, :description, :page_name, :icon, :url, :created_at)";

$stmt = $pdo->prepare($sql);

// begin transaction  
$pdo->beginTransaction();

$count = 0;

foreach ($sampleData as $record) {
    $stmt->execute([
        ':title'       => $record['title'],
        ':description' => $record['description'],
        ':page_name'   => $record['page_name'],
        ':icon'        => $record['page_fav_icon_path'],
        ':url'         => $record['page_url'],
        ':created_at'  => $record['created_at']
    ]);

    $count++;

    // Optional progress output (every 100 records)
    if ($count % 100 === 0) {
        echo "Inserted $count records...<br>";
        flush();
    }
}

$pdo->commit();

echo "<h2>Insertion Complete</h2>";
echo "<p>$count records inserted successfully.</p>";
