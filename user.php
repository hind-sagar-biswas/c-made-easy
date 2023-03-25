<?php
require_once './scripts/includes/config.inc.php';

$user = array();
if ($loggedIn && (!isset($_GET['u']) || $_GET['u'] == $_SESSION['username'])) {
    $user['id'] = $_SESSION['user_id'];
    $user['username'] = $_SESSION['username'];
} elseif (isset($_GET['u'])) {
    $reqUsername = $_GET['u'];
    if (!$logger->check_user_exists($reqUsername, 'username')) redirect_to('root');
    $user['id'] = $logger->get_user_id($reqUsername);
    $user['username'] = $reqUsername;
} else redirect_to('root');

$imageDIR = $BASE_URL . 'assets/image/';

$fetchedUser = $logger->fetch_user_details($user['id']);
$fetchedUser['name'] = $fetchedUser['first_name'] . " " . $fetchedUser['last_name'];
if ($fetchedUser['profile_pic'] != 'default.user.png') $imageDIR = $imageDIR . 'uploads/';
$fetchedUser['pic_path'] = $imageDIR . $fetchedUser['profile_pic'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C for HSC | The code raptors</title>

    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/cheatsheet.css">
    <link rel="stylesheet" href="./assets/css/user.css">

    <script src="https://kit.fontawesome.com/c9fec141b0.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php require_once './scripts/includes/nav.inc.php' ?>

    <div id="main-cont">
        <div id="banner">
            <div id="user">
                <img src="<?= $fetchedUser['pic_path'] ?>" alt="<?= $fetchedUser['name'] ?>" id="profile-pic">
                <div id="details">
                    <div class="row">
                        <?php if ($loggedIn && $_SESSION['user_id'] == $fetchedUser['id']) : ?>
                            <a href="#"><i class="fa-solid fa-pen-to-square"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <h1 id="user-full-name"><?= $fetchedUser['name'] ?></h1>
                        <p><i id="username">@<?= $fetchedUser['username'] ?></i></p>
                    </div>
                    <div class="row mobile-hidden">
                        <div><strong id="test-count"><?= $fetchedUser['test_count'] ?></strong> Tests Taken</div>
                        <div>
                            <strong id="average" class="<?php
                                                        if ($fetchedUser['delta_average_mark'] < 0) echo "green";
                                                        elseif ($fetchedUser['delta_average_mark'] > 0) echo "red";
                                                        ?>">
                                <?= $fetchedUser['average_mark'] ?>%
                            </strong> Average Scode
                        </div>
                        <div><strong id="highest"><?= $fetchedUser['highest_mark'] ?>%</strong> Highest Score</div>
                    </div>
                </div>
            </div>
            <div class="row pc-hidden">
                <div><strong id="test-count"><?= $fetchedUser['test_count'] ?></strong> Tests Taken</div>
                <div>
                    <strong id="average" class="<?php
                                                if ($fetchedUser['delta_average_mark'] < 0) echo "green";
                                                elseif ($fetchedUser['delta_average_mark'] > 0) echo "red";
                                                ?>">
                        <?= $fetchedUser['average_mark'] ?>%
                    </strong> Average Scode
                </div>
                <div><strong id="highest"><?= $fetchedUser['highest_mark'] ?>%</strong> Highest Score</div>
            </div>
        </div>
        <div id="progress"></div>
        <br>
        <?php if ($loggedIn && $_SESSION['user_id'] == $fetchedUser['id']) : ?>
            <div id="user-limits">
                <p><b>Account type:</b> FREE</p>
                <p><small>Upgrade your account to get unlimited usage!</small></p>
                <table>
                    <caption>Usage limits</caption>
                    <tr>
                        <th></th>
                        <th>Usage Left</th>
                        <th>Limit</th>
                        <th>Resets in</th>
                    </tr>
                    <tr>
                        <td>Tests</td>
                        <td>0</td>
                        <td>2</td>
                        <td>12 days</td>
                    </tr>
                    <tr>
                        <td>Compiler</td>
                        <td>4</td>
                        <td>5</td>
                        <td>2 days</td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="./node_modules/plotly.js-dist/plotly.js"></script>
    <script src="./assets/js/general.js"></script>
    <script src="./assets/js/user.js"></script>
</body>

</html>