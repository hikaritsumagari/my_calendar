<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>いいこと日記</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        html {
            font-family: 'M PLUS Rounded 1c', sans-serif;
        }
    </style>
</head>

<body>
    <a href="index.php" class="back"><i class="fas fa-calendar-alt fa-lg"></i> カレンダーへ戻る</a>
    <div class="flex">
        <div class="diaryIn">
            <form action="diary_create.php" method="POST">
                <div>
                    <input type="date" name="diaryDate">
                </div>
                <textarea name="diary" id="" cols="50" rows="20"></textarea>
                <div>
                    <button><i class="fas fa-mug-hot fa-lg"></i></button>
                </div>
            </form>
        </div>

        <?php
        $str = ''; //出力用の空文字
        $file = fopen('data/diary.csv', 'r'); //r読み取り専用

        flock($file, LOCK_EX);
        if ($file) {
            while ($line = fgets($file)) { //fgetsで一行ずつ取得
                $str .= "<li>{$line}</li>"; //取得した$lineを$strへ格納して表示していく
            }
        }
        flock($file, LOCK_UN);
        fclose($file);
        ?>

        <div class="dialyOut">
            <ul>
                <p><i class="fas fa-mug-hot fa-lg"></i> いいこと日記 <i class="fas fa-mug-hot fa-lg"></i></p>
                <?= $str ?>
            </ul>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/b28496ef11.js" crossorigin="anonymous"></script>
</body>

</html>