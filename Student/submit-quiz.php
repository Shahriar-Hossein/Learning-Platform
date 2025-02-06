<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

// Function to send JSON response
function send_response($status, $message) {
    echo json_encode(['status' => $status, 'message' => $message]);
    exit();
}

// Check if the form is submitted via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['quiz_file']) && isset($_POST['quiz_id']) && isset($_POST['course_id'])) {
    // Get form data
    $quiz_id = $_POST['quiz_id'];
    $course_id = $_POST['course_id'];
    $student_email = $_SESSION['student_email']; // Assuming the student's email is stored in the session

    // Check if the file is uploaded and valid
    $file_name = $_FILES['quiz_file']['name'];
    $file_tmp = $_FILES['quiz_file']['tmp_name'];
    $file_size = $_FILES['quiz_file']['size'];
    $file_error = $_FILES['quiz_file']['error'];

    // Check if there was no error uploading the file
    if ($file_error === 0) {
        // Define allowed file types
        $allowed_types = ['pdf', 'docx', 'txt']; // Add more types if needed
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Check if file type is allowed
        if (in_array($file_ext, $allowed_types)) {
            // Define upload directory
            $upload_dir = '../uploads/quiz_submissions/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist
            }

            // Generate a unique file name to prevent overwriting
            $unique_file_name = uniqid('', true) . '.' . $file_ext;
            $file_destination = $upload_dir . $unique_file_name;

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($file_tmp, $file_destination)) {
                // Check if the student has already submitted the quiz
                $stmt = $conn->prepare("SELECT * FROM quiz_files WHERE quiz_id = ? AND student_id = (SELECT id FROM student WHERE email = ?)");
                $stmt->bind_param("is", $quiz_id, $student_email);
                $stmt->execute();
                $result = $stmt->get_result();

                // If student has already submitted the quiz, update the record; otherwise, insert new record
                if ($result->num_rows > 0) {
                    // Update the existing submission
                    $stmt = $conn->prepare("UPDATE quiz_files SET file_link = ? WHERE quiz_id = ? AND student_id = (SELECT id FROM student WHERE email = ?)");
                    $stmt->bind_param("sis", $file_destination, $quiz_id, $student_email);
                    if ($stmt->execute()) {
                        send_response('success', 'Your quiz file has been updated successfully.');
                    } else {
                        send_response('error', 'There was an error updating your quiz file.');
                    }
                } else {
                    // Insert a new record for the submission
                    $stmt = $conn->prepare("INSERT INTO quiz_files (quiz_id, student_id, file_link) VALUES (?, (SELECT id FROM student WHERE email = ?), ?)");
                    $stmt->bind_param("iss", $quiz_id, $student_email, $file_destination);
                    if ($stmt->execute()) {
                        send_response('success', 'Your quiz file has been submitted successfully.');
                    } else {
                        send_response('error', 'There was an error submitting your quiz file.');
                    }
                }

                $stmt->close();
            } else {
                send_response('error', 'There was an error moving the file.');
            }
        } else {
            send_response('error', 'Invalid file type. Only PDF, DOCX, and TXT files are allowed.');
        }
    } else {
        send_response('error', 'There was an error uploading your file.');
    }
} else {
    send_response('error', 'Invalid request.');
}

$conn->close();
?>
