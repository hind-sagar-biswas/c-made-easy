<?php require_once './scripts/includes/config.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="./assets/prism/prism.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/tests.css">

    <script src="https://kit.fontawesome.com/c9fec141b0.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="top"></div>
    <?php require_once './scripts/includes/nav.inc.php' ?>
    <div id="starter">
        <p><b class="red">!!</b> Please make sure to read and understand these instructions below before starting the exam.</p>

        <ul>
            <li> The exam timer will start as soon as you click on the button to select marks. The number of total marks available for the exam will be equal to the number of minutes allotted for the exam.</li>

            <li> Each correct answer will be awarded one mark.</li>

            <li> There is no negative marking for incorrect or unattended questions.</li>

            <li> If the time allotted for the exam runs out, the exam will be automatically submitted.</li>

            <li> Please avoid switching to another tab or window during the exam, as doing so will result in the automatic submission of the exam.</li>
        </ul>

        <p id="emotion">Good luck!</p>

        <div id="select-mark">
            <?php if ($loggedIn) : ?>
                START THE EXAM FOR
                <button onclick="startExam(15)">15</button>
                <button onclick="startExam(25)">25</button>
                <button onclick="startExam(50)">50</button>
                <button onclick="startExam(100)">100</button>
                MARKS
            <?php else : ?>
                <span class="red">LOGIN FIRST TO ATTEND A TEST!</span>

            <?php endif; ?>
        </div>
    </div>
    <aside>
        <div id="clock">
            <div id="counter-container">
                <span class="clock-counters" id="hours">00</span> :
                <span class="clock-counters" id="minutes">00</span> :
                <span class="clock-counters" id="seconds">00</span>
            </div>
            <h4>HOURS LEFT</h4>
        </div>
        <div id="stats">
            <div>TOTAL MARKS: <span id="total" class="counter">00</span></div>
            <div>UNANSWERED: <span id="left" class="counter">00</span></div>
        </div>
        <button id="submit">SUBMIT</button>
    </aside>
    <main>
        <form id="test">

        </form>
    </main>
    <a href="#top" id="back-to-top"><i class="fa-solid fa-arrow-up fa-bounce"></i></a>

    <script src="./assets/js/test.js"></script>
    <script src="./assets/js/general.js"></script>
    <script src="./node_modules/he/he.js"></script>
</body>

</html>