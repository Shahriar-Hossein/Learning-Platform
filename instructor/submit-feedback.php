<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

// Check if the form is submitted
if (isset($_POST['quiz_file_id']) && isset($_POST['score'])) {
    $id = $_POST['quiz_file_id'];
    $score = (int) $_POST['score']; // Ensure score is an integer

    // Determine feedback based on score
    if ($score >= 80) {
        $feedback = "Very Satisfactory";
    } elseif ($score >= 60) {
        $feedback = "Satisfactory";
    } elseif ($score >= 40) {
        $feedback = "Good";
    } else {
        $feedback = "Bad";
    }
    // Update the feedback in the quiz_files table
    $stmt = $conn->prepare("UPDATE quiz_files SET feedback = ?, score= ? WHERE id = ?");
    $stmt->bind_param("sii", $feedback, $score, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Score submitted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to submit score.']);
    }

    $stmt->close();
}
$conn->close();
?>
