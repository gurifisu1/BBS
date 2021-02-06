<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
    <!--【投稿フォーム】-->
    <form action = "" method = "post" name = "postform">
        【　投稿フォーム　】<br>
        名前：　　　　<input type = "text" name = "name" placeholder = "名前" value = "<?php echo $edit_name; ?>"><br>
        コメント：　　<input type = "text" name = "comment" placeholder = "コメント" value = "<?php echo $edit_comment; ?>"><br>
        パスワード：　<input type = "text" name = "post_pass" placeholder = "パスワード"><br>
        <input type = "hidden" name = "editNo" value = "<?php echo $edit_number; ?>">
        <input type = "submit" name = "submit" value = "送信">
    </form><br>
    <!--【削除フォーム】-->
    <form action = "" method = "post" name = "deleteform">
        【　削除フォーム　】<br>
        投稿番号：　　<input type = "text" name = "delete_num" placeholder = "削除したい投稿番号"><br>
        パスワード：　<input type = "text" name = "delete_pass" placeholder = "パスワード"><br>
        <input type = "submit" name = "submit" value = "削除">
    </form><br>
    <!-- 【編集フォーム】 -->
    <form action = "" method = "post" name = "editform">
        【　編集フォーム　】<br>
        投稿番号：　　<input type = "text" name = "edit_num" placeholder = "編集したい投稿番号"><br>
        パスワード：　<input type = "text" name = "edit_pass" placeholder = "パスワード"><br>
        <input type = "submit" name = "submit" value = "編集">
    </form><br>
    <hr>
    【投稿一覧】<br>
        <?php
            //データベース接続処理
            $dsn = 'mysql:dbname=xxxxxxxxxxxxxx;host=localhost';
            $user = 'xxxxxxxxxxxxxx';
            $password = 'xxxxxxxxxxxxxx';
            $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            //テーブル作成処理
            $sql = "CREATE TABLE IF NOT EXISTS mission_test"
            ." ("
            . "id INT AUTO_INCREMENT PRIMARY KEY,"
            . "name char(32),"
            . "comment TEXT,"
            . "datetime DATETIME,"
            . "password TEXT,"
            .");";
            $stmt = $pdo->query($sql);
            //投稿処理
            if ($_POST ["submit"] == "送信" && !empty ($_POST ["name"]) && !empty ($_POST ["comment"]) && !empty ($_POST ["post_pass"])) {
                $name = $_POST ["name"];
                $comment = $_POST ["comment"];
                $postpass = $_POST ["post_pass"];
                date_default_timezone_set ("Asia/Tokyo");
                $date = date ("Y/m/d H:i:s");
                // 非編集モード
                if (empty ($_POST ["editNo"])) {
                    $sql = $pdo -> prepare("INSERT INTO mission_test (name, comment, datetime, password) VALUES (:name, :comment, :datetime, :password)");
                    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                    $sql -> bindParam(':datetime', $date, PDO::PARAM_STR);
                    $sql -> bindParam(':password', $postpass, PDO::PARAM_STR);
                    $sql -> execute();
                } 
            }
            //テーブル表示処理
            $sql = 'SELECT * FROM mission_test';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                echo $row['id'].' '. $row['name'].' '. $row['comment'].' '. date("Y/m/d H:i:s", strtotime($row['datetime'])). '<br>';
            }
        ?>
</body>
</html>