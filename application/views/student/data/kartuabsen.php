<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Animated Gradient Border</title>



    <style>
        .card {

            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 300px;
            margin: auto;
            text-align: center;
        }

        .container {
            padding: 0 16px;
        }

        .title {
            color: grey;
            font-size: 18px;
        }

        button {
            border: none;
            outline: 0;
            display: inline-block;
            padding: 8px;
            color: white;
            background-color: #000;
            text-align: center;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
        }

        a {
            text-decoration: none;
            font-size: 22px;
            color: black;
        }

        button:hover,
        a:hover {
            opacity: 0.7;
        }
    </style>

</head>

<body>

    <div class="card">
        <img src="<?= $img ?>" alt="John" style="width:100%">
        <div class="container">
            <h1><?= $user['nama_siswa'] ?></h1>
            <p class="title"><?= $user['nis_siswa'] ?></p>
        </div>
    </div>



</body>

</html>