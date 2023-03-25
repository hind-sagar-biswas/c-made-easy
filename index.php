<?php require_once './scripts/includes/config.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C for HSC | The code raptors</title>

    <link rel="stylesheet" href="./assets/css/style.css">

    <script src="https://kit.fontawesome.com/c9fec141b0.js" crossorigin="anonymous"></script>
</head>

<?php
$logTemp = "<a href='./log.php' id='log'><i class='fa-solid fa-right-to-bracket'></i></a>";
if ($loggedIn) {
    $imageDIR = $BASE_URL . 'assets/image/';
    if ($_SESSION['profile_pic'] != 'default.user.png') $imageDIR = $imageDIR . 'uploads/';
    $pic_path = $imageDIR . $_SESSION['profile_pic'];
    $logTemp = "
       <a href='./user.php' id='user'><img src='$pic_path' alt=''><span>" . $_SESSION['username'] . "</span></a>
       <a href='./log.php?l=logout' id='log'><i class='fa-solid fa-right-from-bracket'></i></a>
    ";
}

?>

<body>
    <div id="loader">
        <div class="lds-grid">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <center id="main-cont">
        <div id="abs">
            <?= $logTemp ?>
            <a href="./ide.php" id="start-code"><i class="fa-solid fa-code"></i> <span class="hide-screen">ONLINE EDITOR</span></a>
        </div>
        <p id="banner">
            <span id="logo"><i class="fa-solid fa-c"></i></span>
            <br>
            <span id="prog"> <span class="blue">{</span>PROGRAMMING<span class="blue">}</span> </span>
        </p>
        <div id="explanation">
            <p>
                C programming is a high-level programming language used to create computer programs. It was created in the
                early 1970s
                and is still widely used today. C allows programmers to write efficient code that can run on a variety of
                hardware
                platforms.
                <br><br>
                <span class="hide-screen">
                    The language provides low-level access to memory, which makes it suitable for developing operating systems,
                    device
                    drivers, and other system software. It is also used in applications that require high performance, such as
                    video games
                    and image processing.
                    <br><br>

                    In summary, C programming is a versatile language that can be used for a wide range of programming tasks,
                    from writing
                    low-level system software to creating high-performance applications.
                </span>
            </p>
        </div>
        <div id="actions">
            <a id="blue" href="./cheatsheet.php" target="_blank" rel="noopener noreferrer"><button>CHEATSHEET</button></a>
            <a id="red" href="./problems.php" target="_blank" rel="noopener noreferrer"><button>PROBLEMS</button></a>
            <a id="green" href="./test.php" target="_blank" rel="noopener noreferrer"><button>TESTS</button></a>
        </div>

    </center>
    <footer>
        <p>A PROJECT OF <a href="http://coderaptors.epizy.com/" target="_blank">THE CODE RAPTORS</a></p>
    </footer>

    <script>
        window.addEventListener("load", () => {
            document.getElementById('loader').classList.add('hidden');
        });
    </script>
</body>

</html>