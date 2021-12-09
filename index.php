<?php
if(!empty($_POST)){
  date_default_timezone_set('Asia/Tokyo');
  $post_time = date('Y/m/d');
  $writeArray = [$post_time,$_POST["shop"],$_POST["price"]];

  var_dump($writeArray);

  $file = fopen('./csv/data_utf8.csv', 'a');
  flock($file, LOCK_EX);
  fputcsv($file, $writeArray);
  flock($file, LOCK_UN);
  fclose($file);

  // 二重送信対策
  header('Location:index.php');
  exit();
}

$dataArray = [];
$file = fopen('./csv/data_utf8.csv', 'r');
flock($file, LOCK_EX);
if ($file) {
  while ($line = fgetcsv($file)) {
    // 空行の判定
    if( implode($line) != null && !empty($line) ){
      // 時間文字列をsecondsへ変換
      $line[0] = strtotime($line[0]);
      $dataArray[] = $line;
    }
  }
}
flock($file, LOCK_UN);
fclose($file);
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>DIY資材の価格変動</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <!-- header -->
    <header class="header">
      <div class="wrapper">
        <div class="header-inner">
          <h1 class="header__logo">DIY資材の価格変動</h1>
        </div>
      </div>
    </header>
    <!-- //header -->

    <!-- main -->
    <main>

      <section class="section">
        <div class="wrapper">
          <h2 class="section-title">針葉樹合板の価格を登録</h2>

          <form class="form" action="" method="post">
            <div class="radio">
              <label>
                <input type="radio" name="shop" value="nafco">
                <img src="./img/nafco_logo.svg" width="24" height="24">
              </label>
              <label>
                <input type="radio" name="shop" value="juntendo">
                <img src="./img/juntendo.png" width="22" height="22">
              </label>
            </div>
            <div class="price">
              <input type="number" name="price" min="0" max="5000"><span>円</span>
            </div>
            <input class="submit" type="submit" value="登録">
          </form>

        </div>
      </section>

      <!-- <section class="section">
        <div class="wrapper">
          <h2 class="section-title">過去の記録</h2>
          <div class="result-past">
            <div class="result-past__item result-max" id="js-result-max"></div>
            <div class="result-past__item result-min" id="js-result-min"></div>
            <div class="result-past__item result-recent" id="js-result-recent"></div>
          </div>
        </div>
      </section> -->

      <section class="section">
        <div class="wrapper">
          <h2 class="section-title">針葉樹合板の価格変動</h2>
          <canvas class="result-price" id="js-result-price" height="350"></canvas>
        </div>
      </section>

    </main>
    <!-- //main -->

    <!-- footer -->
    <footer class="footer">
      <p class="footer__copy"><small>&copy 2021 Daisuke Sumida</small></p>
    </footer>
    <!-- //footer -->

    <!-- script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js"></script>

    <script type="text/javascript">

      // jsonへ変換
      const dataArray = <?=json_encode($dataArray)?>;
      // 時系列に変換
      dataArray.sort(function(first, second){
        if ( first[0] > second[0] ){
          return 1;
        } else if ( first[0] < second[0] ){
          return -1;
        } else {
          return 0;
        }
      });
      console.log(dataArray);

      // 時間表示の変換
      function convertTimestampToDate(timestamp) {
        const _d = timestamp ? new Date(timestamp * 1000) : new Date();
        const Y = _d.getFullYear();
        const m = (_d.getMonth() + 1).toString().padStart(1, '0');
        const d = _d.getDate().toString().padStart(1, '0');
        const H = _d.getHours().toString().padStart(2, '0');
        const i = _d.getMinutes().toString().padStart(2, '0');
        const s = _d.getSeconds().toString().padStart(2, '0');
        return `${m}/${d}`;
      }

      // データ配列へ変換
      const nafcoArray = [];
      const jutendoArray = [];

      dataArray.forEach(function (data) {
        if ( data[1] == "nafco" ) {
          let nafco_inner_array = {
            x: convertTimestampToDate(data[0]),
            y: Number(data[2])
          };
          nafcoArray.push(nafco_inner_array);
        } else if ( data[1] == "juntendo" ) {
          let jutendo_inner_array = {
            x: convertTimestampToDate(data[0]),
            y: Number(data[2])
          };
          jutendoArray.push(jutendo_inner_array);
        }
      });

      // グラフのデータ
      const chart_data = {
        datasets: [
          {
            label: 'ナフコ',
            data: nafcoArray,
            borderColor: '#4293f7',
            backgroundColor: '#90bff9',
            yAxisID: 'y',
            tension: 0.3,
            fill: false,
          },
          {
            label: 'ジュンテンドー',
            data: jutendoArray,
            borderColor: '#fc4d4d',
            backgroundColor: '#ff8585',
            yAxisID: 'y',
            tension: 0.3,
            fill: false,
          }
        ]
      };

      // グラフのオプション
      const config = {
        type: 'line',
        data: chart_data,
        options: {
          responsive: true,
          interaction: {
            mode: 'index',
            intersect: false
          },
          plugins: {
            legend: {
              labels: {
                font: {
                  size: 10,
                  family: "'Noto Sans JP', sans-serif",
                  weight: '700'
                }
              }
            }
          },
          stacked: false,
          scales: {
            xAxis: {
              grid: {
                borderColor: '#777777',
              },
              ticks: {
                font: {
                  size: 10,
                  family: "'Noto Sans JP', sans-serif",
                }
              }
            },
            y: {
              type: 'linear',
              display: true,
              position: 'left',
              suggestedMin: 600,
              suggestedMax: 2000,
              grid: {
                borderColor: '#777777',
              },
              ticks: {
                font: {
                  size: 10,
                  family: "'Noto Sans JP', sans-serif",
                },
                callback: function(value){
      		        return  value + '円'
      	        }
              },
            }
          }
        }
      };
      const myChart = new Chart(
        document.getElementById('js-result-price'),
        config
      );
    </script>
    <!-- //script -->
  </body>
</html>
