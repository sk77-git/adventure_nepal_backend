<?php
// Include the database connection file
include '../includes/db_connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the response header to JSON
header('Content-Type: application/json');

// Get user's information from the request
$userID = $_GET['user_id'];
$weather = isset($_GET['weather']) ? $_GET['weather'] : null;

// Get user's selected categories
$userCategories = [];
try {
    $userStmt = $pdo->prepare("SELECT categories FROM users WHERE id = :userID");
    $userStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $userStmt->execute();
    $userData = $userStmt->fetch(PDO::FETCH_ASSOC);
    if ($userData) {
        $userCategories = json_decode($userData['categories']);
    }
} catch (PDOException $e) {
    echo json_encode(array('status' => 'failure', 'message' => 'Error fetching user categories', 'body' => null));
    exit();
}

// Query to get activities based on user's categories and weather
try {
    $activityStmt = $pdo->prepare("
    SELECT * 
    FROM activities
    ");

    // Check if user has selected categories
    if (!empty($userCategories)) {
        $activityStmt->execute();
        $activities = $activityStmt->fetchAll(PDO::FETCH_ASSOC);

        // Filter activities based on user categories
        $filteredActivities = array_filter($activities, function ($activity) use ($userCategories) {
            $activityCategories = json_decode($activity['categories']);
            return count(array_intersect($userCategories, $activityCategories)) > 0;
        });

        // If weather is specified, further filter by weather (if activities have weather information)
        if (!is_null($weather)) {
            $filteredActivities = array_filter($filteredActivities, function ($activity) use ($weather) {
                // Adjust this condition based on the structure of your activities table
                // For example, if activities have a 'weathers' column
                $activityWeathers = json_decode($activity['weathers']);
                return in_array($weather, $activityWeathers);
            });
        }

        // Initialize response fields
        $response = array(
            'status' => 'success',
            'message' => '',
            'body' => array()
        );

        // Check if any filtered activities were found
        if (count($filteredActivities) > 0) {
            // Reindex the array numerically
            $response['body'] = array_values($filteredActivities);
            $response['message'] = 'Fetched activities based on user categories and weather';
        } else {
            $response['message'] = 'No activities found based on user categories and weather';
        }
    } else {
        // If user has no selected categories, fetch all activities
        $activityStmt->execute();
        $activities = $activityStmt->fetchAll(PDO::FETCH_ASSOC);

        $response = array(
            'status' => 'success',
            'message' => 'Fetched all activities (user has no selected categories)',
            'body' => $activities
        );
    }

    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode(array('status' => 'failure', 'message' => $e, 'body' => null));
    // You can also log the error for debugging purposes
}
?>
