<?php
include_once "config.php"; // Assuming the database connection is included here
// Ensure the session contains the user's unique ID
if (isset($_SESSION['unique_id'])) {
    $outgoing_id = $_SESSION['unique_id']; // Set outgoing_id from the session
} else {
    die("User is not logged in!"); // Handle the error appropriately
}

// Fetch the list of users
$sql = mysqli_query($conn, "SELECT * FROM users");
$output = "";

if (mysqli_num_rows($sql) == 1) {
    $output .= "No users are available to chat";
} elseif (mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
        // Define the SQL query to fetch messages for both incoming and outgoing messages
        $sql2 = "SELECT * FROM messages WHERE (
                    (incoming_msg_id = {$row['unique_id']} AND outgoing_msg_id = {$outgoing_id})
                    OR (outgoing_msg_id = {$row['unique_id']} AND incoming_msg_id = {$outgoing_id})
                ) ORDER BY msg_id DESC LIMIT 1";

        $query2 = mysqli_query($conn, $sql2);

        // Check if the query failed
        if (!$query2) {
            die("SQL query failed: " . mysqli_error($conn)); // Output the SQL error
        }

        $row2 = mysqli_fetch_assoc($query2);

        if (mysqli_num_rows($query2) > 0) {
            $result = $row2['msg'];
        } else {
            $result = "No message available";
        }

        // Trimming message if words are more than 28 characters
        (strlen($result) > 20) ? $msg = substr($result, 0, 1) : $msg = $result;

        // Start outputting the HTML content with the fetched data
        $output .= '
            <a href="chat.php?user_id='. $row['unique_id'] .'">
                <div class="content">
                    <img src="php/images/'. $row['img'] .'" alt="User Image">
                    <div class="details">
                        <span>'. $row['fname'] . " " . $row['lname'] .'</span>
                        <p>'.$msg.'</p>
                    </div>
                </div>
                <div class="status-dot"><i class="fas fa-circle"></i></div>
            </a>';
    }
}

echo $output;
?>
