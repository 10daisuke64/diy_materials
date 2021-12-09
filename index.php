<?php



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
          <h2 class="section-title">入力フォーム</h2>
          <form class="form" action="" method="post">
            <dl>
              <dt>資材名</dt>
              <dd>
                <select name="material">
                  <option disabled selected>選択してください</option>
                  <option value="shiyoju">針葉樹合板</option>
                  <option value="plaster">石膏ボード</option>
                  <option value="kaku3">45角3m</option>
                  <option value="kaku4">45角4m</option>
                </select>
              </dd>
            </dl>
            <dl>
              <dt>価格</dt>
              <dd class="short">
                <input type="number" name="price" min="0" max="5000"><span>円</span>
              </dd>
            </dl>
            <dl>
              <dt>店名</dt>
              <dd>
                <select name="shop">
                  <option disabled selected>選択してください</option>
                  <option value="nafco">ナフコ</option>
                  <option value="juntendo">ジュンテンドー</option>
                  <option value="nohgata">直方建材</option>
                  <option value="other">その他</option>
                </select>
              </dd>
            </dl>
          </form>
        </div>
      </section>

      <section class="section">
        <div class="wrapper">
          <h2 class="section-title">価格変動</h2>
          <div class="result-price" id="js-result-price"></div>
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
    <script src="./js/script.js"></script>
    <!-- //script -->
  </body>
</html>
