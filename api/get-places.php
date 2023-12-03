<?php
// Include the database connection file
include '../includes/db_connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the response header to JSON
header('Content-Type: application/json');

// Get user's information from the request
$userID = $_GET['user_id'];
$currentLat = floatval($_GET['lat']);
$currentLang = floatval($_GET['long']);
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

// Query to get nearby places based on user's categories, location, and weather
try {
    $stmt = $pdo->prepare("
    SELECT * 
    FROM places
    WHERE 
        ( 
            lat BETWEEN :minLat AND :maxLat AND
            `long` BETWEEN :minLong AND :maxLong
        )
	");

    $minLat = $currentLat - 1.0;
    $maxLat = $currentLat + 1.0;
	$minLong = $currentLang - 1.0;
	$maxLong = $currentLang + 1.0;

	$stmt->bindValue(':minLong', $minLong, PDO::PARAM_STR);
	$stmt->bindValue(':maxLong', $maxLong, PDO::PARAM_STR);
    $stmt->bindValue(':minLat', $minLat, PDO::PARAM_STR);
    $stmt->bindValue(':maxLat', $maxLat, PDO::PARAM_STR);

    // Check if user has selected categories
    if (!empty($userCategories)) {
        $stmt->execute();
        $places = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Filter places based on user categories
        $filteredPlaces = array_filter($places, function ($place) use ($userCategories) {
            $placeCategories = json_decode($place['categories']);
            return count(array_intersect($userCategories, $placeCategories)) > 0;
        });

        // If weather is specified, further filter by weather
        if (!is_null($weather)) {
            $filteredPlaces = array_filter($filteredPlaces, function ($place) use ($weather) {
                $placeWeathers = json_decode($place['weathers']);
                return in_array($weather, $placeWeathers);
            });
        }

        // Initialize response fields
		$response = array(
			'status' => 'success',
			'message' => '',
			'body' => array()
		);

		// Check if any filtered places were found
		if (count($filteredPlaces) > 0) {
			// Reindex the array numerically
			$response['body'] = array_values($filteredPlaces);
			$response['message'] = 'Fetched places based on user categories, location, and weather';
		} else {
			$response['message'] = 'No places found based on user categories, location, and weather';
		}

		echo json_encode($response);

    } else {
        // If user has no selected categories, fetch all places without applying category filters
        $stmt = $pdo->prepare("SELECT * FROM places");
        $stmt->execute();
        $allPlaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = array(
            'status' => 'success',
            'message' => 'Fetched all places (user has no selected categories)',
            'body' => $allPlaces
        );

        echo json_encode($response);
    }
} catch (PDOException $e) {
    echo json_encode(array('status' => 'failure', 'message' => $e, 'body' => null));
    // You can also log the error for debugging purposes
}
?>
