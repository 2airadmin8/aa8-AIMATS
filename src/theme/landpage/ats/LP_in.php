<?php
if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
    require_once( '/var/www/vhosts/air-admin8.co.jp/httpdocs/aa82022/wp-load.php' );
    $cname = $_POST['cname'];
    $position = $_POST['position'];
    $name = $_POST['name'];
    $tell = $_POST['tell'];
    $email = $_POST['email'];
//var_dump($cname);
//var_dump($position);
//var_dump($name);
//var_dump($tell);
//var_dump($email);exit();
    $P=array();
    $headers=array();
    $P["form_RecType"]="";//ビジネスパートナーについて
    $P["form_TypeCont"]="";//ビジネスパートナーについて
    $P["form_BusiType"]="";
    $P["form_PartType"]="";
    $P["form_ProdType"]="";
    $P["form_Typedeti"]="";


    $P["form_name"]=$name;//お名前
    $P["form_c_name"]=$cname;//会社／団体名
    $P["form_position"]=$position;//部署名・役職名
    $P["form_email"]=$email;//E-Mailアドレス
    $P["form_tell"]=$tell;//TEL
    $headers[] = 'From: 株式会社AirAdmin8 <airadmin8@air-admin8.co.jp>';
    $mail_content= "";
    //自動返信用メッセージ
    $mail_content = <<< EOM
{$P['form_name']} 様

この度は「TSRソリューションズ株式会社」ホームページより
お問い合わせ頂きありがとうございました。

このメールは送信確認用の自動返信メールです。
内容をご確認させて頂きまして、担当者より折り返しご連絡させて頂きます。

※尚、５営業日過ぎても連絡が無い場合は大変お手数でございますが
もう一度ご送信頂くかお電話にてお問合せ下さいますようお願いいたします。

ーーーーーーーーーーーーーーーーーーーーー
お問合せ内容

助成金申請お問合せフォーム

■お名前
{$P['form_name']}

■フリガナ
{$P['form_hurigana']}

■会社／団体名
{$P['form_c_name']}

■会社／団体名（カナ）
{$P['form_cname_kana']}

■部署名・役職名
{$P['form_position']}

■E-Mailアドレス
{$P['form_email']}

■TEL
{$P['form_tell']}

■住所
〒{$P['form_zip_num']}
{$P['form_address']}

-------------------------------------------------------

■お問合せ内容
{$P['form_contentsarea']}

-------------------------------------------------------

■アンケート
弊社をどのような経緯でお知りになりましたか？
{$P['form_howknow']}

-------------------------------------------------------

■助成金についての情報確認
・社員は雇用保険に加入している2名以上いますか？         {$P['form_hoken_count']}
{$P['form_hoken_count_i']}
・東京都に事業所or本社はありますか？          {$P['form_honsya_flag']}
・東京都税は支払ってますか？         {$P['form_tax_flag']}
・過去に下記の助成金を受給したことがありますか？            {$P['form_grant_accept_item']}
・過去５年間に重大な法令違反等はありませんか？            {$P['form_before_5_holitu']}
・風俗営業等の規制及び業務の適正化等に関する法律に該当する事業ではありませんか？            {$P['form_fuzoku_flag']}
・暴力団及び法人その他の団体の代表者、役員又は使用人その他の従業員若しくは構成員が暴力団員等に該当はではありませんか？         {$P['form_boryoku_flag']}

-------------------------------------------------------

■TSRソリューションズ株式会社
〒169-0075
東京都新宿区高田馬場三丁目23番3号 ORビル　３階、４階
TEL.03-5937-5378(代表)　FAX.03-5937-5379

URL:https://tsrs.co.jp/
                    

EOM;
//    var_dump($mail_content);exit();
    $subject=$name."様（株式会社AirAdmin8・お問い合わせフォーム）";
    wp_mail($P["form_email"], $subject, $mail_content, $headers);

    echo json_encode(['code'=>200,'msg'=>'success']);exit();
}


?>

<!DOCTYPE html>
<html lang="ja" class="wf-loading">
  <head>
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <meta charset="UTF-8" />
    <meta name="format-detection" content="telephone=no" />
    <title>会社HP_弁護士向け基幹システム_PC_特徴2</title>
    <script
      type="text/javascript"
      src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/libs/columb/js/jquery.min.js"
      id="jquery-core-js"
    ></script>
      <link rel="stylesheet" href="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/libs/columb/css/swiper-bundle.min.css" media="all" />
      <link rel="stylesheet" href="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/libs/columb/css/style.css" media="all" />
    <link
      rel="shortcut icon"
      href="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/favicon.png"
    />
      <link rel="stylesheet" href="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/recruit/css/common.css" media="all" />
      <link rel="stylesheet" href="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/landpage/ats/static/css/cwn.css" media="all" />
      <link rel="stylesheet" href="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/landpage/ats/static/css/mobile.css" media="all" />
  </head>

  <body
    class="home page-template-default page page-id-110 body  cookies-set cookies-accepted "
  >
    <div class="body__inner">
      <main class="main">
        <header id="header" class="header header_origin header_front hidden visible-xs">
          <div class="header__inner">
            <div class="header-left">
              <div class="header-logo">
                <a href="https://www.air-admin8.co.jp" class="header-logo__link">
                  <h1 class="header-logo__img-wrapper">
                    <img src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/assets/img/common/footer/footer-nav-top-left__logo.png" alt="Air Admin8" class="header-logo__img">
                  </h1>
                </a>
              </div>
              <nav class="header-nav header-nav_other">
                <ul class="header-nav__list">
                  <li class="header-nav__item">
                    <a href="https://www.air-admin8.co.jp/products" class="header-nav__link">
                      TOP
                    </a>
                  </li>
                  <li class="header-nav__item">
                    <a href="https://www.air-admin8.co.jp/case" class="header-nav__link">
                      機能・特徴
                    </a>
                  </li>
                  <li class="header-nav__item">
                    <a href="https://www.air-admin8.co.jp/company" class="header-nav__link">
                      動画
                    </a>
                  </li>
                  <li class="header-nav__item">
                    <a href="https://www.air-admin8.co.jp/support" class="header-nav__link">
                      強み
                    </a>
                  </li>
                  <li class="header-nav__item">
                    <a href="https://www.air-admin8.co.jp/column" class="header-nav__link">
                      プラン料金
                    </a>
                  </li>
                  <li class="header-nav__item">
                    <a href="https://www.air-admin8.co.jp/column" class="header-nav__link">
                      お申込みの流れ
                    </a>
                  </li>
                  <li class="header-nav__item">
                    <a href="https://www.air-admin8.co.jp/column" class="header-nav__link">
                      よくあるご質問
                    </a>
                  </li>
                  <li class="header-nav__item header-nav__item_contact sp">
                  <a href="#" class="header-nav__link header-nav__link_contact">
                    資料をダウンロード <i></i>
                  </a>
                </li>
                </ul>
              </nav>
            </div>
 

            <div class="header-hum-btn">
              <div class="header-hum-btn__box">
                <div class="header-hum-btn__bar header-hum-btn__bar_top"></div>
                <div class="header-hum-btn__bar header-hum-btn__bar_middle"></div>
                <div class="header-hum-btn__bar header-hum-btn__bar_bottom"></div>
              </div>
            </div>
          </div>
        </header>
       <!--  begin-->
       <div class="lp lp_in">
        <div class="head">
          <div class="flex">
            <div class="flex_item">
                <a href="#"><img src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/landpage/ats/static/images/logo.png" class="logo" /></a>
            </div>
            <ul>
              <li><a href="javascript:;">TOP</a></li>
              <li><a href="javascript:;">機能・特徴</a></li>
              <li><a href="javascript:;">動画</a></li>
              <li><a href="javascript:;">強み</a></li>
              <li><a href="javascript:;">プラン料金</a></li>
              <li><a href="javascript:;">お申込みの流れ</a></li>
              <li><a href="javascript:;">よくあるご質問</a></li>
            </ul>
            <div class="tel">
              <h4>お問い合わせ</h4>
              <h3>03-6665-6968</h3>
              <p>受付時間　9:30～12:00、13:00～17:30(土日祝祭日は除く)</p>
            </div>
          </div>
        </div>
        <div class="result">
          <div class="hd">
<img src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/landpage/ats/static/images/img27.png" class="logo" />
            <span>フォーム送信完了</span>
</div>
<div class="container">
  <div class="bd">
<h3>お問い合わせいただき、ありがとうございます。</h3>
<p>
ご入力いただいた内容を確認のうえ、担当者よりご連絡いたします。<br>
いましばらくお待ちくださいましよう、よろしくお願いいたします。
</p>
<a href="#" class="btn">TOPに戻る</a>
</div>
</div>
        </div>
 
        
        <div class="foot">
          <div class="container">
            <div class="flex">
              <div class="flex_item">
                <ul>
                  <li><a href="#">会社公式HP</a></li>
                  <li><a href="#">プライバシーポリシー</a></li>
                  <li><a href="#">サイトマップ</a></li>
                </ul>
              </div>
              <div>Copyright © Air Admin8 Co., Ltd. All Rights Reserved</div>
            </div>
          </div>
        </div>
      </div>
        <!--  end -->

       
      </main>
      <script
        src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/libs/slick/slick.min.js"
        type="text/javascript"
        charset="utf-8"
      ></script>
      <script
        src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/libs/wow/wow.js"
        type="text/javascript"
        charset="utf-8"
      ></script>
      
      <script src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/libs/columb/js/common.js"
        type="text/javascript"
        charset="utf-8"
      ></script>
        <script src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/recruit/js/swiper-bundle.min.js"></script>
     
    </div>
  </body>
</html>
