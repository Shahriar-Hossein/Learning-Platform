<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once('../dbConnection.php');

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Get the logged-in student ID
$student_id = $_SESSION['student_id'];

// Read the JSON payload
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['course_id'], $data['rating'])) {
    $course_id = $data['course_id'];
    $rating = (int)$data['rating'];
    $review = isset($data['review']) ? trim($data['review']) : null;

    // Check if the rating is within the valid range
    if ($rating < 1 || $rating > 5) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid rating value']);
        exit;
    }

    // Check if the student has already rated this course
    $sql = "SELECT id FROM course_rating WHERE course_id = ? AND student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $course_id, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the existing rating and review
        $update_sql = "UPDATE course_rating SET rating = ?, review = ? WHERE course_id = ? AND student_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("isii", $rating, $review, $course_id, $student_id);
        if ($update_stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Rating updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update the rating']);
        }
        $update_stmt->close();
    } else {
        // Insert a new rating and review
        $insert_sql = "INSERT INTO course_rating (course_id, student_id, rating, review) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iiis", $course_id, $student_id, $rating, $review);
        if ($insert_stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Rating submitted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to submit the rating']);
        }
        $insert_stmt->close();
    }
    $stmt->close();
    // Update the average rating in the course table
    $update_course_sql = "
        UPDATE course 
        SET rating = (
            SELECT AVG(rating) 
            FROM course_rating 
            WHERE course_id = ?
        )
        WHERE id = ?";
    $update_course_stmt = $conn->prepare($update_course_sql);
    $update_course_stmt->bind_param("ii", $course_id, $course_id);
    if (!$update_course_stmt->execute()) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update the course rating']);
    }
    $update_course_stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

$conn->close();
