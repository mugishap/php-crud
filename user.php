<?php

include './connection.php';
$userid = $_GET['userid'];
if (!$userid || $userid == '') {
?>
    <script>
        window.location.replace('/myapp/PHP-Crud/login.html')
    </script>
<?php
    return;
}
$getIds = mysqli_query($connection, "SELECT user_id FROM users WHERE user_id='$userid'");
if (mysqli_num_rows($getIds) != 1) {
?>
    <script>
        window.location.replace('/myapp/PHP-Crud/login.html')
    </script>
<?php
    return;
}
$getuser = mysqli_query($connection, "SELECT * FROM users WHERE user_id='$userid'");
list(, $firstName, $lastName, $telephone, $profile, $gender, $nationality, $username, $email,, $role) = mysqli_fetch_array($getuser);

$searchedusername = $_GET['username'];
$query = mysqli_query($connection, "SELECT * FROM users WHERE username='$searchedusername'");
list($searcheduserid, $firstName, $lastName, $telephone, $searchedprofile, $gender, $nationality,, $email,,) = mysqli_fetch_array($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">



    <link type="text/css" href="global.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <script>
        const popup = (src, postid) => {
            const overlay = document.querySelector('.theoverlay')
            overlay.style.display = 'flex'
            overlay.innerHTML = `<i class="material-icons cursor-pointer" style="font-size:2em;color:white;" onclick="removepopup()">close</i>
            <div class="flex flex-col items-center h-5/12 justify-center p-2 bg-white rounded w-1/5">
                <a class="w-full flex items-center justify-center" href="home.php?userid=<?= $userid ?>#${postid}">
                    <button type="button" class="text-white bg-blue-500 rounded p-1 w-10/12 m-2 hover:bg-blue-600">
                    View full post
                    </button>
                </a>
                <img class="w-full h-10/12" src="${src}" alt="" />
            </div>`
        }
        const removepopup = () => {
            const overlay = document.querySelector('.theoverlay')
            overlay.innerHTML = ''
            overlay.style.display = 'none'
        }
    </script>
    <title><?= $username ?> | PicPi</title>
    <link rel="shortcut icon" href="picpi.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kurale&family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="w-screen h-[80vh] flex flex-col items-center">
    <div class="navbar shadow-2xl mb-8 p-2 w-full h-12  flex items-center justify-around">
        <div class="flex items-center justify-center">
            <img class="w-8 h-8" src="picpi.png" alt="">
            <a href='home.php?userid=<?= $userid ?>' class="picpi">PicPi</a>
        </div>
        <div>
            <form action="search.php?userid=<?= $userid ?>" method='POST' class="flex items-center justify-center">
                <input type="text" name='name' class="p-1 bg-[#ddd] rounded" placeholder="Search">
                <button type="submit" name="search" class="btn btn-outline-primary material-icons text-md">search</button>
            </form>
        </div>
        <ul class="flex flex-row items-center justify-center list-none">
            <li class="mr-4 cursor-pointer"><a title="Home" class="bx bx-home-alt bx-sm" href="home.php?userid=<?= $userid ?>"></a></li>
            <li class="mr-4 cursor-pointer"><a title="New post" class="bx bx-add-to-queue bx-sm" href="newpost.php?userid=<?= $userid ?>"></a></li>
            <li class="mr-4 cursor-pointer"><a title="Logout" class="material-icons" href="login.html">logout</a></li>
            <li class="mr-4 cursor-pointer"><a href="account.php?userid=<?= $userid ?>"><img src="<?= $profile ?>" class="object-cover w-10 h-10 rounded-full" alt=""></a></li>
        </ul>
    </div>
    <div class="flex border-box p-2 items-center bg-gray-200 rounded-xl w-2/3 justify-center h-1/2">
        <div class="w-2/3 flex items-center justify-center">
            <img class="object-cover w-48 h-48 rounded-full" src="<?= $searchedprofile ?>" alt="">
        </div>
        <form class="flex flex-col items-center justify-center w-3/5">
            <div class="flex w-10/12 items-center justify-between">
                <label>Names: </label>
                <input type="text" disabled class="bg-transparent" value='<?= $firstName . " " . $lastName ?>'>
            </div>
            <div class="flex w-10/12 items-center justify-between">
                <label>Username: </label>
                <input type="text" disabled class="bg-transparent" value='<?= $searchedusername ?>'>
            </div>
            <div class="flex w-10/12 items-center justify-between ">
                <label>Country: </label>
                <input type="text" disabled class="bg-transparent" value='<?= $nationality ?>'>
            </div>
            <div class="flex w-10/12 items-center justify-between ">
                <label>Telephone: </label>
                <input type="text" disabled class="bg-transparent" value='<?= $telephone ?>'>
            </div>
            <div class="flex w-10/12 items-center justify-between ">
                <label>Gender: </label>
                <input type="text" disabled class="bg-transparent" value='<?= $gender ?>'>
            </div>
            <div class="flex w-10/12 items-center justify-between ">
                <label>Email: </label>
                <input type="text" disabled class="bg-transparent" value='<?= $email ?>'>
            </div>
        </form>
    </div>
    <h2><?= $searchedusername ?>'s posts</h2>
    <div class="grid border-box  p-4 grid-cols-4 bg-gray-200 mt-2 rounded-xl w-2/3 h-1/3 overflow-y-scroll">
        <?php
        $getUserPosts = mysqli_query($connection, "SELECT u.user_id,u.username,p.post_id,p.image,p.caption FROM users u INNER JOIN posts p ON u.username=p.username WHERE u.username='$searchedusername' ORDER BY p.post_id DESC");
        while (list($posterid,, $postid, $image, $caption) = mysqli_fetch_array($getUserPosts)) {

        ?>
            <img onclick="popup('<?= $image ?>',<?= $postid ?>)" key='<?= $postid ?>' class="cursor-pointer object-cover m-2 rounded w-48 h-32" src="<?= $image ?>">
        <?php
        }
        ?>
    </div>
    <div class="theoverlay flex-col w-screen absolute items-center z-100 bg-[#00000057] h-screen items-center justify-center " style="display: none;">

</body>

</html>