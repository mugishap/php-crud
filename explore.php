<?php
include './connection.php';
include './checkloggedin.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link type="text/css" href="global.css" rel="stylesheet">
    <link type="text/css" href="tailwind.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <title>Explore | PicPi</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="shortcut icon" href="picpi.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kurale&family=Ubuntu:wght@300&display=swap" rel="stylesheet">

</head>

<body>
    <div class="navbar shadow-2xl mb-8 p-2 w-full h-12  flex items-center justify-around">
        <div class="flex items-center justify-center">
            <img class="w-8 h-8" src="picpi.png" alt="">
            <a href='home.php' class="picpi">PicPi</a>
        </div>
        <div>
            <form action="search.php" method='POST' class="flex items-center justify-center">
                <input required type="text" name='name' class="p-1 bg-[#ddd] rounded" placeholder="Search">
                <button type="submit" name="search" class="btn btn-outline-primary material-icons text-md">search</button>
            </form>
        </div>
        <ul class="flex flex-row items-center justify-center list-none">
            <li class="mr-4 cursor-pointer"><a title="Home" class="bx bx-home-alt bx-sm" href="home.php"></a></li>

            <li class="mr-4 cursor-pointer"><a title="Explore" class="bx bx-compass bx-sm" href="explore.php"></a></li>
            <li class="mr-4 cursor-pointer"><a title="New post" class="bx bx-add-to-queue bx-sm" href="newpost.php"></a></li>
            <li class="mr-4 cursor-pointer"><a href='activity.php' class='bx bx-bell bx-sm'></a></li>
            <li class="mr-4 cursor-pointer"><a title="Messages" href="users.php" class="material-icons">send</a></li>

            <li class="mr-4 cursor-pointer">
                <form action="logout.php" method="GET"><button title="Logout" class="material-icons" name="logout" type="submit">logout</button></form>
            </li>
            <li class="mr-4 cursor-pointer"><a href="account.php"><img src="<?= $profile ?>" class="object-cover w-10 h-10 rounded-full" alt=""></a></li>
        </ul>
    </div>

    <div>
        <?php

        $getMostPopularPosts = mysqli_query($connection, "SELECT p.post_id,p.username,p.caption,c.commenter_username,comment,liker_id FROM posts p INNER JOIN likes l USING(post_id) INNER JOIN comments c USING(post_id) ORDER BY  (SELECT COUNT(l.like_id) FROM likes l);");
        ?>
    </div>
</body>

</html>