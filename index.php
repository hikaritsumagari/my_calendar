<?php
// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// 前月・次月リンクが押された場合は、GET年月を取得
if (isset($_GET['ym'])) {
  $ym = $_GET['ym'];
} else {
  // 今月の年月を表示
  $ym = date('Y-m');
}

// タイムスタンプを作成し、フォーマットチェックする
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
  $ym = date('Y-m');
  $timestamp = strtotime($ym . '-01');
}

// 今日の日付
$today = date('Y-m-j');

// カレンダータイトル作成
$html_title = date('Y年n月', $timestamp);

// 前月・次月の年月
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));

// 該当月の日数を取得
$day_count = date('t', $timestamp);

// １日が何曜日か mktimeを使う
$youbi = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

// カレンダー作成の準備
$weeks = [];
$week = '';

// 第１週目：空のセルを追加
$week .= str_repeat('<td></td>', $youbi - 1);

for ($day = 1; $day <= $day_count; $day++, $youbi++) {

  // 2021-06-1
  $date = $ym . '-' . $day;

  if ($today == $date) {
    // 今日の日付の場合は、class="today"をつける
    $week .= '<td class="today">' . '<a href="diary.php">' . $day;
  } else {
    $week .= '<td>' . '<a href="diary.php">' . $day;
  }
  $week .= '</a>' . '</td>';

  // 週終わり、月終わり
  if ($youbi % 7 == 0 || $day == $day_count) {
    if ($day == $day_count && $youbi % 7 != 0) {
      $week .= str_repeat('<td></td>', 7 - $youbi % 7);
    }

    // weeks配列にtrと$weekを追加する
    $weeks[] = '<tr>' . $week . '</tr>';

    // weekをリセット
    $week = '';
  }
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>カレンダー</title>
  <!-- Bootstrapの読み込み -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- googlefontsの読み込み -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Limelight&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@700&display=swap" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>

<body>
  <div class="flex">
    <div class="container">
      <h3>
        <a href="?ym=<?php echo $prev; ?>"><i class="fas fa-angle-double-left fa-2x"></i></a>
        <?php echo $html_title; ?>
        <a href="?ym=<?php echo $next; ?>"><i class="fas fa-angle-double-right fa-2x"></i></a>
      </h3>
      <table class="table table-bordered">
        <tr>
          <th>月</th>
          <th>火</th>
          <th>水</th>
          <th>木</th>
          <th>金</th>
          <th>土</th>
          <th>日</th>
        </tr>
        <?php
        foreach ($weeks as $week) {
          echo $week;
        }
        ?>
      </table>
    </div>

    <?php
    //リスト入力、出力
    $str = ''; //出力用の空文字
    $file = fopen('data/memo.csv', 'r'); //r読み取り専用

    flock($file, LOCK_EX);
    if ($file) {
      while ($line = fgets($file)) { //fgetsで一行ずつ取得
        $str .= "<li>{$line}</li>"; //取得した$lineを$strへ格納して表示していく
      }
    }
    flock($file, LOCK_UN);
    fclose($file);
    ?>

    <div class="list">
      <form method="post" action="memo.php">
        <input type="textarea" name="myList">
        <button><i class="fas fa-edit"></i></button>
      </form>
      <ul>
        <p><i class="far fa-lightbulb fa-lg"></i> メモ <i class="far fa-lightbulb fa-lg"></i></p>
        <?= $str ?>
      </ul>
    </div>
  </div>



  <script src="https://kit.fontawesome.com/b28496ef11.js" crossorigin="anonymous"></script>


</body>

</html>