<?php
include './connection.php';
$userid = $_GET['userid'];
if (!$userid || $userid == '') {
?>
    <script>
        window.location.replace('/php-crud/login.html')
    </script>
<?php
    return;
}
$getIds = mysqli_query($connection, "SELECT user_id FROM users WHERE user_id='$userid'");
if (mysqli_num_rows($getIds) != 1) {
?>
    <script>
        window.location.replace('/php-crud/login.html')
    </script>
<?php
    return;
}
$today = date('Y-m-d H:i');
$query = mysqli_query($connection, 'SELECT * FROM posts ORDER BY post_id DESC');
$getuser = mysqli_query($connection, "SELECT * FROM users WHERE user_id='$userid'");
list($userid, $firstname, $lastname, $telephone, $profile, $gender, $nationality, $username, $email,, $role) = mysqli_fetch_array($getuser);

$toFollowUsername = $_POST['toFollowUsername'];
$getToFollow = mysqli_query($connection, "SELECT user_id,profile FROM users WHERE username='$toFollowUsername'");
if (!$getToFollow) return;
list($toFollowId, $toFollowProfile) = mysqli_fetch_array($getToFollow);
$status =  $_POST['status'];
echo $status;
if ($status === 'follow') {
    $addToFollowing = mysqli_query($connection, "INSERT INTO following_$username(following_id,following_username,following_profile) values('$toFollowId','$toFollowUsername','$toFollowProfile');");
    $addToFollowers = mysqli_query($connection, "INSERT INTO followers_$toFollowUsername(follower_id,follower_username,follower_profile) values('$userid','$username','$profile');");
} else if ($status === 'unfollow') {
    $removeFromFollowing = mysqli_query($connection, "DELETE FROM following_$username WHERE following_id='$toFollowId' AND following_username='$toFollowUsername' AND following_profile='$toFollowProfile'");
    $removeFromFollowers = mysqli_query($connection, "DELETE FROM followers_$toFollowUsername WHERE follower_id='$userid' AND follower_username='$username' AND follower_profile='$profile'");
}

?>