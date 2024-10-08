<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";

    $sql = "SELECT * FROM messages WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
            OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                if ($row['outgoing_msg_id'] === $outgoing_id) { // Message sender
                    $output .= '
                                <div class="chat outgoing">
                                    <div class="details">
                                        <p>' . $row['msg'] . '</p>
                                    </div>
                                </div>
                             ';
                } else { // Message receiver
                    $output .= '
                                <div class="chat incomimg">
                                    <div class="details">
                                        <p>' . $row['msg'] . '</p>
                                    </div>
                                </div>
                              ';
                }
            }
        }
        echo $output;
    } else {
        // Handle query error
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("location: ../login.php");
    exit; // Stop further execution
}
?>
