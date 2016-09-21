<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
                background-color: #e74c3c;
                animation: bg-color 10s infinite;
                -webkit-animation: bg-color 10s infinite;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
            
            a {
                color: #fff;
                text-decoration: none;
            }
            
            @-webkit-keyframes bg-color {
                0% { background-color: #e74c3c; }
                20% { background-color: #f1c40f; }
                40% { background-color: #1abc9c; }
                60% { background-color: #3498db; }
                80% { background-color: #9b59b6; }
                100% { background-color: #e74c3c; }
            }
            @keyframes bg-color {
                0% { background-color: #e74c3c; }
                20% { background-color: #f1c40f; }
                40% { background-color: #1abc9c; }
                60% { background-color: #3498db; }
                80% { background-color: #9b59b6; }
                100% { background-color: #e74c3c; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title"><a href="/auth/login">Laravel 5</a></div>
            </div>
        </div>
    </body>
</html>
