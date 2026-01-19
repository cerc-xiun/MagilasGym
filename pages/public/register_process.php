<?php
header('Content-Type: application/json');
session_start();
require_once '../../config/db.php';

$response = ['success' => false, 'message' => '', 'errors' => []];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF Check
    if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['success' => false, 'message' => 'Invalid security token. Please refresh the page.']);
        exit;
    }
    
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    
    // Default values for new registrations
    $role = 'member';
    $status = 'pending';
    
    // Validation
    if (empty($fullname)) {
        $response['errors']['fullname'] = 'Full name is required';
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['errors']['email'] = 'Valid email is required';
    }
    
    // Simple phone validation
    if (empty($phone)) {
        $response['errors']['phone'] = 'Phone number is required';
    } elseif (!preg_match('/^[0-9+ ]+$/', $phone)) {
         $response['errors']['phone'] = 'Invalid phone number format';
    }

    // Check for duplicates
    if (empty($response['errors'])) {
        try {
            $checkSql = "SELECT email, phone FROM membership_applications WHERE email = :email OR phone = :phone";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->execute([':email' => $email, ':phone' => $phone]);
            $results = $checkStmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $row) {
                if ($row['email'] === $email) {
                    $response['errors']['email'] = 'Email address is already registered.';
                }
                if ($row['phone'] === $phone) {
                    $response['errors']['phone'] = 'Phone number is already registered.';
                }
            }
        } catch (PDOException $e) {
            // Keep silent about DB errors during check, or log them. 
            // Failing safe here means we might allow a duplicate try which will fail at INSERT if unique constraint exists,
            // or just rely on this check. Ideally we'd log this.
        }
    }

    // File Upload Handling
    $photoPath = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['photo']['name'];
        $filetype = $_FILES['photo']['type'];
        $filesize = $_FILES['photo']['size'];
        
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        // Server-side MIME check
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($_FILES['photo']['tmp_name']);
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($mime, $allowedMimes)) {
             $response['errors']['photo'] = 'Invalid file type (MIME mismatch).';
        }
        
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
             $response['errors']['photo'] = 'Invalid file format. JPG, JPEG, PNG, GIF only.';
        }
        
        if ($filesize > 5 * 1024 * 1024) { // 5MB
             $response['errors']['photo'] = 'File size exceeds 5MB limit';
        }
        
        if (empty($response['errors'])) {
             $uploadDir = '../../uploads/applications/';
             if (!file_exists($uploadDir)) {
                 mkdir($uploadDir, 0777, true);
             }
             
             // Generate unique filename
             $newFilename = uniqid('app_') . '.' . $ext;
             $destination = $uploadDir . $newFilename;
             
             if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                 $photoPath = 'uploads/applications/' . $newFilename;
             } else {
                 $response['errors']['photo'] = 'Failed to upload image';
             }
        }
    } else {
         $response['errors']['photo'] = 'Profile photo is required';
    }
    
    // Database Insertion
    if (empty($response['errors'])) {
        try {
            // Note: role and status have defaults in DB, but we allow explicit setting here for clarity
            $sql = "INSERT INTO membership_applications (fullname, email, phone, photo_path, role, status) VALUES (:fullname, :email, :phone, :photo_path, :role, :status)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':photo_path', $photoPath);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':status', $status);
            
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Application submitted successfully!';
            } else {
                $response['message'] = 'Database error: Could not save application.';
            }
        } catch (PDOException $e) {
            error_log("DB Registration Error: " . $e->getMessage());
            $response['message'] = 'System Application Error. Please try again later.';
        }
    } else {
        $response['message'] = 'Please fix the errors below.';
    }
    
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
