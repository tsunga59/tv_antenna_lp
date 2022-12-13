<?php

header("Content-Type:text/html;charset=utf-8");

//error_reporting(0);

##-----------------------------------------------------------------------------------------------------------------##
// サンクスメールのFromメールアドレスを指定してください。 ※ end
// $user_from = '';
$user_from = 'saki@tanakashiki.com';

//管理者へ届くメールのFromメールアドレスを指定してください。 ※ end
// $admin_from = '';
$admin_from = $user_from;

//管理者用送信先メールアドレスを指定して下さい。
//複数人設定したい場合には、行を追加し、メールアドレス部分を変更してください。 ※ end
$admin_to_list   = array();
$admin_to_list[] = 'saki@tanakashiki.com';

// 必須入力項目を設定する(する=1, しない=0)
$requireCheck = 0;
//必須入力項目(入力フォームで指定したname属性の値を指定してください。
$require = array('お名前', '電話番号', 'メールアドレス');

// 【管理者宛】メールのタイトル（件名）
$subject = "【大成アンテナLP】お問い合わせが入りました";

// 【申込者宛】自動返信メールの送信者欄に表示される名前
$refrom_name = "大成アンテナ";

// 【申込者宛】メールのタイトル（件名）
$re_subject = "【大成アンテナ】お問い合わせありがとうございます";


##-----------------------------------------------------------------------------------------------------------------##
$user_name = htmlspecialchars($_POST['お名前']) . ' 様';

//自動返信メールの冒頭の文言 ※日本語部分のみ変更可
$remail_text = <<< TEXT

{$user_name}

お問い合わせありがとうございます。
早急にご返信致しますので今しばらくお待ちください。
TEXT;

//自動返信メールに署名（フッター）を表示(する=1, しない=0)※管理者宛にも表示されます。
$mailFooterDsp = 1;

//上記で「1」を選択時に表示する署名（フッター）（FOOTER〜FOOTER;の間に記述してください）
$mailSignature = <<< FOOTER

********************************************

署名

********************************************
 
FOOTER;


//----------------------------------------------------------------------
//  自動返信メール設定(END)
//----------------------------------------------------------------------


##-----------------------------------------------------------------------------------------------------------------##
if (version_compare(PHP_VERSION, '5.1.0', '>=')) { //PHP5.1.0以上の場合のみタイムゾーンを定義
    date_default_timezone_set('Asia/Tokyo'); //タイムゾーンの設定（日本以外の場合には適宜設定ください）
}

$entryno = random_num();


/*-------------------------------------------------------------------------------------------------------------------
* ★以下設定時の注意点　
* ・値（=の後）は数字以外の文字列（一部を除く）はダブルクオーテーション「"」、または「'」で囲んでいます。
* ・これをを外したり削除したりしないでください。後ろのセミコロン「;」も削除しないください。
* ・また先頭に「$」が付いた文字列は変更しないでください。数字の1または0で設定しているものは必ず半角数字で設定下さい。
* ・メールアドレスのname属性の値が「Email」ではない場合、以下必須設定箇所の「$Email」の値も変更下さい。
* ・name属性の値に半角スペースは使用できません。
*以上のことを間違えてしまうとプログラムが動作しなくなりますので注意下さい。
-------------------------------------------------------------------------------------------------------------------*/


//---------------------------　必須設定　必ず設定してください　-----------------------

//サイトのトップページのURL　※デフォルトでは送信完了後に「トップページへ戻る」ボタンが表示されますので
$site_top = "index.html";


//フォームのメールアドレス入力箇所のname属性の値（name="○○"　の○○部分）
$Email = "メールアドレス";

/*------------------------------------------------------------------------------------------------
以下スパム防止のための設定　
※有効にするにはこのファイルとフォームページが同一ドメイン内にある必要があります
------------------------------------------------------------------------------------------------*/

//スパム防止のためのリファラチェック（フォームページが同一ドメインであるかどうかのチェック）(する=1, しない=0)
$Referer_check = 0;

//リファラチェックを「する」場合のドメイン ※以下例を参考に設置するサイトのドメインを指定して下さい。
$Referer_check_domain = ".com";

//---------------------------　必須設定　ここまで　------------------------------------


//---------------------- 任意設定　以下は必要に応じて設定してください ------------------------


// 管理者宛のメールで差出人を送信者のメールアドレスにする(する=1, しない=0)
// する場合は、メール入力欄のname属性の値を「$Email」で指定した値にしてください。
//メーラーなどで返信する場合に便利なので「する」がおすすめです。
$userMail = 1;

// Bccで送るメールアドレス(複数指定する場合は「,」で区切ってください 例 $BccMail = "aa@aa.aa,bb@bb.bb";)
$BccMail = "";

// 送信確認画面の表示(する=1, しない=0)
$confirmDsp = 0;

// 送信完了後に自動的に指定のページ(サンクスページなど)に移動する(する=1, しない=0)
// CV率を解析したい場合などはサンクスページを別途用意し、URLをこの下の項目で指定してください。
// 0にすると、デフォルトの送信完了画面が表示されます。
$jumpPage = 1;

// 送信完了後に表示するページURL（上記で1を設定した場合のみ）※httpから始まるURLで指定ください。
$thanksPage = "thanks.html";


//----------------------------------------------------------------------
//  自動返信メール設定(START)
//----------------------------------------------------------------------

// 差出人に送信内容確認メール（自動返信メール）を送る(送る=1, 送らない=0)
// 送る場合は、フォーム側のメール入力欄のname属性の値が上記「$Email」で指定した値と同じである必要があります
$remail = 1;


//メールアドレスの形式チェックを行うかどうか。(する=1, しない=0)
//※デフォルトは「する」。特に理由がなければ変更しないで下さい。メール入力欄のname属性の値が上記「$Email」で指定した値である必要があります。
$mail_check = 1;

//------------------------------- 任意設定ここまで ---------------------------------------------


// 以下の変更は知識のある方のみ自己責任でお願いします。


//----------------------------------------------------------------------
//  関数実行、変数初期化
//----------------------------------------------------------------------
$encode = "UTF-8"; //このファイルの文字コード定義（変更不可）

if (isset($_GET)) {
    $_GET = sanitize($_GET);
} //NULLバイト除去//

if (isset($_POST)) {
    $_POST = sanitize($_POST);
} //NULLバイト除去//

if (isset($_COOKIE)) {
    $_COOKIE = sanitize($_COOKIE);
} //NULLバイト除去//

if ($encode == 'SJIS') {
    $_POST = sjisReplace($_POST, $encode);
} //Shift-JISの場合に誤変換文字の置換実行

$funcRefererCheck = refererCheck($Referer_check, $Referer_check_domain); //リファラチェック実行

if (isset($_POST['x'])) {
    unset($_POST['x']);
}

if (isset($_POST['y'])) {
    unset($_POST['y']);
}


//変数初期化
$sendmail   = 0;
$empty_flag = 0;
$post_mail  = '';
$errm       = '';
$header     = '';
$to         = $user_from; //※ end

if ($requireCheck == 1) {
    $requireResArray = requireCheck($require); //必須チェック実行し返り値を受け取る
    $errm            = $requireResArray['errm'];
    $empty_flag      = $requireResArray['empty_flag'];
}

//unset($_POST['個人情報の取り扱いについて同意します。']);

//メールアドレスチェック
if (empty($errm)) {
    foreach ($_POST as $key => $val) {
        if ($val == "confirm_submit") {
            $sendmail = 1;
        }
        if ($key == $Email) {
            $post_mail = h($val);
        }
        if ($key == $Email && $mail_check == 1 && !empty($val)) {
            if (!checkMail($val)) {
                $errm       .= "<p class=\"error_messe\">【" . $key . "】はメールアドレスの形式が正しくありません。</p>\n";
                $empty_flag = 1;
            }
        }
    }
}
//差出人に届くメールをセット
if ($remail == 1) {
    $dsp_name   = '';
    $userBody   = mailToUser($_POST, $dsp_name, $remail_text, $mailFooterDsp, $mailSignature, $encode);
    $reheader   = userHeader($refrom_name, $to, $encode);
    $re_subject = "=?iso-2022-jp?B?" . base64_encode(mb_convert_encoding($re_subject, "JIS", $encode)) . "?=";
}

//管理者宛に届くメールをセット
$adminBody = mailToAdmin($_POST, $subject, $mailFooterDsp, $mailSignature, $encode, $confirmDsp);
$header    = adminHeader($userMail, $admin_from, $BccMail, $to);
$subject   = "=?iso-2022-jp?B?" . base64_encode(mb_convert_encoding($subject, "JIS", $encode)) . "?=";

//管理者宛メールアドレスをセット ※ end
if (!empty($admin_to_list)) {
    $admin_to = ',' . implode(',', $admin_to_list);
}


if (($confirmDsp == 0 || $sendmail == 1) && $empty_flag != 1) {

    //管理者宛メール送信処理　※ end
    mail($admin_to, $subject, $adminBody, $header);

    //ユーザー宛メール送信処理　※ end
    if ($remail == 1) {
        mail($post_mail, $re_subject, $userBody, $reheader);
    }
} else if ($confirmDsp == 1) {

    /*　▼▼▼送信確認画面のレイアウト※編集可　オリジナルのデザインも適用可能▼▼▼　*/
?>

<?php
    /* ▲▲▲送信確認画面のレイアウト　※オリジナルのデザインも適用可能▲▲▲　*/
}

if (($jumpPage == 0 && $sendmail == 1) || ($jumpPage == 0 && ($confirmDsp == 0 && $sendmail == 0))) {

    /* ▼▼▼送信完了画面のレイアウト　編集可 ※送信完了後に指定のページに移動しない場合のみ表示▼▼▼　*/
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <title>送信完了</title>
        <link rel="stylesheet" type="text/css" href="css/form_style.css" media="screen,tv,print" />
        <link rel="alternate" type="application/rss+xml" title="RSS" href="index.xml" />
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <!-- 送信完了画面header -->
        <div id="header">

        </div>
        <!-- 送信完了画面header-->

        <div class="form-complete">
            <?php if ($empty_flag == 1) { ?>
                <h4 style="margin-top:40px; font-size: 20px;">入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
                <div style="color:red; font-size:16px;"><?php echo $errm; ?></div>
                <br /><br /><input class="btn-return" type="button" onClick="history.back()" value="戻る" style="font-size:16px; padding: 8px 40px;">
        </div>
    </body>

    </html>
<?php } else { ?>
    送信ありがとうございました。<br /><br />
    送信は正常に完了しました。<br /><br /><br /><br />
    <a href="<?php echo $site_top; ?>"><img src="images/btn_return_top.png" /></a>
    </div>

    <!-- footer -->
    <div id="footer">
        <div class="wrap">
            <!-- <div id="copyright">Copyright (C) JAPANIST All Rights Reserved.</div> -->
            <div id="copyright">Copyright (C) All Rights Reserved.</div>
        </div>
        <!--wrap-->
    </div>
    <!--footer-->

    <!--  CV率を計測する場合ここにAnalyticsコードを貼り付け -->

    </body>

    </html>
<?php
                /* ▲▲▲送信完了画面のレイアウト 編集可 ※送信完了後に指定のページに移動しない場合のみ表示▲▲▲　*/
            }
        } //確認画面無しの場合の表示、指定のページに移動する設定の場合、エラーチェックで問題が無ければ指定ページヘリダイレクト
        else if (($jumpPage == 1 && $sendmail == 1) || $confirmDsp == 0) {
            if ($empty_flag == 1) { ?>
    <div align="center">
        <h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
        <div style="color:red"><?php echo $errm; ?></div>
        <br /><br /><input class="btn-return" type="button" onClick="history.back()" value="戻る">
    </div>
<?php
            } else {
                header("Location: " . $thanksPage);
            }
        }

        // 以下の変更は知識のある方のみ自己責任でお願いします。

        //----------------------------------------------------------------------
        //  関数定義(START)
        //----------------------------------------------------------------------
        function checkMail($str)
        {
            $mailaddress_array = explode('@', $str);
            if (preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str") && count($mailaddress_array) == 2) {
                return true;
            } else {
                return false;
            }
        }

        function h($string)
        {
            global $encode;

            return htmlspecialchars($string, ENT_QUOTES, $encode);
        }

        function sanitize($arr)
        {
            if (is_array($arr)) {
                return array_map('sanitize', $arr);
            }

            return str_replace("\0", "", $arr);
        }

        //Shift-JISの場合に誤変換文字の置換関数
        function sjisReplace($arr, $encode)
        {
            foreach ($arr as $key => $val) {
                $key              = str_replace('＼', 'ー', $key);
                $resArray[$key] = $val;
            }

            return $resArray;
        }

        //送信メールにPOSTデータをセットする関数
        function postToMail($arr)
        {
            global $entryno;
            $resArray = '';
            //	$resArray .= "【 エントリーNO 】 ".$entryno."\n";

            foreach ($arr as $key => $val) {
                $out = '';
                if (is_array($val)) {
                    foreach ($val as $item) {
                        $out .= $item . ', ';
                    }
                    $out = rtrim($out, ', ');
                } else {
                    $out = $val;
                }
                if (get_magic_quotes_gpc()) {
                    $out = stripslashes($out);
                }
                if ($out != "confirm_submit" && $key != "httpReferer" &&  $key != "confirm_email" ) {
                    $resArray .= "【 " . $key . " 】 " . $out . "\n";
                }
            }

            return $resArray;
        }

        //確認画面の入力内容出力用関数
        function confirmOutput($arr)
        {
            $html = '';
            foreach ($arr as $key => $val) {
                $out = '';
                if (is_array($val)) {
                    foreach ($val as $item) {
                        $out .= $item . ', ';
                    }
                    $out = rtrim($out, ', ');
                } else {
                    $out = $val;
                } //チェックボックス（配列）追記ここまで
                if (get_magic_quotes_gpc()) {
                    $out = stripslashes($out);
                }
                $out = nl2br(h($out)); //※追記 改行コードを<br>タグに変換
                $key = h($key);

                $html .= "<tr><th>" . $key . "</th><td>" . $out;
                $html .= '<input type="hidden" name="' . $key . '" value="' . str_replace(array(
                    "<br />",
                    "<br>"
                ), "", $out) . '" />';
                $html .= "</td></tr>\n";
            }

            return $html;
        }

        //管理者宛送信メールヘッダ
        function adminHeader($userMail, $post_mail, $BccMail, $to)
        {
            $header = '';
            if ($userMail == 1 && !empty($post_mail)) {
                $header = "From: $post_mail\n";
                if ($BccMail != '') {
                    $header .= "Bcc: $BccMail\n";
                }
                $header .= "Reply-To: " . $post_mail . "\n";
            } else {
                if ($BccMail != '') {
                    $header = "Bcc: $BccMail\n";
                }
                $header .= "Reply-To: " . $to . "\n";
            }
            $header .= "Content-Type:text/plain;charset=iso-2022-jp\nX-Mailer: PHP/" . phpversion();

            return $header;
        }

        //管理者宛送信メールボディ
        function mailToAdmin($arr, $subject, $mailFooterDsp, $mailSignature, $encode, $confirmDsp)
        {
            $adminBody = '';
            $adminBody .= "LPからお問い合わせがありました。\n担当者は対応してください。";
            $adminBody .= "\n\n";
            $adminBody .= "＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
            $adminBody .= postToMail($arr); //POSTデータを関数からセット
            $adminBody .= "\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
            $adminBody .= "送信された日時：" . date("Y/m/d (D) H:i:s", time()) . "\n";
            $adminBody .= "送信者のIPアドレス：" . @$_SERVER["REMOTE_ADDR"] . "\n";
            $adminBody .= "送信者のホスト名：" . getHostByAddr(getenv('REMOTE_ADDR')) . "\n";
            if ($confirmDsp != 1) {
                $adminBody .= "問い合わせのページURL：" . @$_SERVER['HTTP_REFERER'] . "\n";
            } else {
                $adminBody .= "問い合わせのページURL：" . @$arr['httpReferer'] . "\n";
            }

            return mb_convert_encoding($adminBody, "JIS", $encode);
        }

        //ユーザ宛送信メールヘッダ
        function userHeader($refrom_name, $to, $encode)
        {
            $reheader = "From: ";
            if (!empty($refrom_name)) {
                $default_internal_encode = mb_internal_encoding();
                if ($default_internal_encode != $encode) {
                    mb_internal_encoding($encode);
                }
                $reheader .= mb_encode_mimeheader($refrom_name) . " <" . $to . ">\nReply-To: " . $to;
            } else {
                $reheader .= "$to\nReply-To: " . $to;
            }
            $reheader .= "\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/" . phpversion();

            return $reheader;
        }

        //ユーザ宛送信メールボディ
        function mailToUser($arr, $dsp_name, $remail_text, $mailFooterDsp, $mailSignature, $encode)
        {
            $userBody   = '';
            $userBody  .= $remail_text;
            $userBody  .= "\n\n";
            $userBody  .= "＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
            $userBody  .= postToMail($arr); //POSTデータを関数からセット
            $userBody  .= "\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
            if ($mailFooterDsp == 1) {
                $userBody .= $mailSignature;
            }

            return mb_convert_encoding($userBody, "JIS", $encode);
        }

        //必須チェック関数
        function requireCheck($require)
        {
            $res['errm']       = '';
            $res['empty_flag'] = 0;
            foreach ($require as $requireVal) {
                $existsFalg = '';
                foreach ($_POST as $key => $val) {
                    if ($key == $requireVal && empty($val)) {
                        $res['errm']       .= "<p class=\"error_messe\">【" . $key . "】は必須入力項目です。</p>\n";
                        $res['empty_flag'] = 1;
                        $existsFalg        = 1;
                        break;
                    } elseif ($requireVal == $key) {
                        $existsFalg = 1;
                        break;
                    }
                }
                /*if ($existsFalg != 1) {
                    $res['errm']       .= "<p class=\"error_messe\">【" . $requireVal . "】が未選択です。</p>\n";
                    $res['empty_flag'] = 1;
                }*/
            }

            return $res; //連想配列で値を返す
        }

        //リファラチェック
        function refererCheck($Referer_check, $Referer_check_domain)
        {
            if ($Referer_check == 1 && !empty($Referer_check_domain)) {
                if (strpos($_SERVER['HTTP_REFERER'], $Referer_check_domain) === false) {
                    return exit('<p align="center">リファラチェックエラー。フォームページのドメインとこのファイルのドメインが一致しません</p>');
                }
            }
        }

        function copyright()
        {
            echo '<a style="display:block;text-align:center;margin:15px 0;font-size:11px;color:#aaa;text-decoration:none" href="http://www.php-factory.net/" target="_blank">- PHP工房 -</a>';
        }

        //ランダム数字を表示させる
        function random_num()
        {
            $suji = '0123456789';
            for ($i = 0; $i < 5; $i++) {
                $len   = mb_strlen($suji);
                $j     = mt_rand(0, $len - 1);
                $num   = $suji[$j];
                $ransu = 0;
                $ransu .= $num;
                //1度で出た数字は対象外にする
                $suji = str_replace($num, "", $suji);
            }

            return $ransu;
        }

//----------------------------------------------------------------------
//  関数定義(END)
//----------------------------------------------------------------------
