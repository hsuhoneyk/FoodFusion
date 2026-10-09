<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli("127.0.0.1", "root", "", "foodfusion_db", 3306);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $exception) {
    http_response_code(503);
    exit("<h1>FoodFusion is temporarily unavailable</h1>
    <p>The database service is not running. Please start MySQL in the XAMPP Control Panel, then refresh this page.</p>");
}
