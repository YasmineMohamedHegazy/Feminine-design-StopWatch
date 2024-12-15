
<?php
include 'connect.php';

$host = 'localhost'; // Change if necessary
$dbname = 'stopwatch_app';
$username = 'your_username';
$password = 'your_password';


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input data
    $input = json_decode(file_get_contents('php://input'), true);
    $alarm_time = $input['alarm_time'];
    $message = $input['message'];

    // Insert the alarm into the database
    $stmt = $conn->prepare("INSERT INTO alarm (alarm_time, message) VALUES (:alarm_time, :message)");
    $stmt->bindParam(':alarm_time', $alarm_time);
    $stmt->bindParam(':message', $message);
    $stmt->execute();

    // Return the ID of the inserted alarm
    echo json_encode(['id' => $conn->lastInsertId()]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve all alarms
    $stmt = $conn->prepare("SELECT * FROM alarm");
    $stmt->execute();
    $alarms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($alarms);
}
?>
