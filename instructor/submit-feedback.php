<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

// Check if the form is submitted
if (isset($_POST['quiz_file_id']) && isset($_POST['feedback'])) {
    $quiz_file_id = $_POST['quiz_file_id'];
    $feedback = $_POST['feedback'];

    // Update the feedback in the quiz_files table
    $stmt = $conn->prepare("UPDATE quiz_files SET feedback = ? WHERE id = ?");
    $stmt->bind_param("si", $feedback, $quiz_file_id);

    if ($stmt->execute()) {
        echo "<script>alert('Feedback submitted successfully'); window.location.href='view-quiz.php?quiz_id=" . $_GET['quiz_id'] . "&course_id=" . $_GET['course_id'] . "';</script>";
    } else {
        echo "<script>alert('Failed to submit feedback'); window.location.href='view-quiz.php?quiz_id=" . $_GET['quiz_id'] . "&course_id=" . $_GET['course_id'] . "';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
