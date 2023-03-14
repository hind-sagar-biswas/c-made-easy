<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cheatsheet | C Programming for HSC</title>

    <link rel="stylesheet" href="./assets/css/cheatsheet.css">


    <link rel="stylesheet" href="./vs/editor/editor.main.css" />
    <script src="./vs/loader.js"></script>
    <script src="./vs/editor/editor.main.nls.js"></script>
    <script src="./vs/editor/editor.main.js"></script>


</head>

<body>
    <nav>
        <div id="logo"><a href="index.html"><span class="blue bold courier">{</span><span class="bold">C</span><span class="blue bold courier">}</span></a></div>
        <div id="menu">
            <a href="./cheatsheet.php" class="nav-link">Cheatsheet</a>
            <a href="#" class="nav-link">Exersice</a>
            <a href="./ide.php" class="nav-link active">IDE</a>
        </div>
    </nav>
    <div class="container">
        <div id="editor"></div>
        <div class="console" id="console-container">
            <div id="toolbar">
                <input type="text" name="stdin" id="stdin" placeholder="Expected Input">
                <button id="execute">EXECUTE CODE</button>
            </div>
            <div id="console"></div>
        </div>
    </div>
    <script src="./assets/js/compiler.js"></script>


</body>

</html>