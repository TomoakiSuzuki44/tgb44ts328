<?php

//phpとMYSQLを接続
$dsn='mysql:dbname=データベース名;host=localhost;charset=utf8';
$user='ユーザー名';
$password='パスワード';
$pdo= new PDO($dsn,$user,$password);


//テーブルの作成(3-2)
$sql="CREATE TABLE tbtest6"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date DATETIME,"
."password char(32)"
.");";
$stmt=$pdo->query($sql);

//フォームから送信された書き込み内容をテーブルに書き込む(2-1,3-5)

//変数定義
$name=$_POST["name"];
$comment=$_POST["comment"];
$delete=$_POST["delete"];
$edit=$_POST["edit"];
$edit2=$_POST["edit2"];
$date=date("Y-m-d H:i:s");
$pass1=$_POST["pass1"];
$pass2=$_POST["pass2"];
$pass3=$_POST["pass3"];

//コメント
if(!empty($name)&&!empty($comment)&&!empty($pass1)&&empty($edit2)){
	$sql=$pdo->prepare("INSERT INTO tbtest6 (name,comment,date,password)VALUES(:name,:comment,:date,:password)");
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql->bindParam(':date',$date,PDO::PARAM_STR);
	$sql->bindParam(':password',$pass1,PDO::PARAM_STR);
	$sql->execute();
}

//削除
if(!empty($delete)&&!empty($pass2)){
	$id=$_POST["delete"];
	$stmt=$pdo->query("select password from tbtest6 where id=$id");
	$result=$stmt->fetch();
	if($result["password"]==$pass2){
		$sql="delete from tbtest6 where id=$id";
		$result2=$pdo->query($sql);
	}
	if($result["password"]!=$pass2){
		echo "パスワードが違います";
	}
}

//編集1
if(!empty($edit)&&!empty($pass3)){
	$id=$_POST["edit"];
	$stmt=$pdo->query("select password from tbtest6 where id=$id");
	$result3=$stmt->fetch();
	if($result3["password"]==$pass3){
		$stmt=$pdo->query("select name from tbtest6 where id=$id");
		$result4=$stmt->fetch();
		$edit_name=$result4['name'];

		$stmt=$pdo->query("select comment from tbtest6 where id=$id");
		$result5=$stmt->fetch();
		$edit_comment=$result5['comment'];

		$stmt=$pdo->query("select password from tbtest6 where id=$id");
		$result6=$stmt->fetch();
		$edit_password=$result6['password'];
	}
	if($result3["password"]!=$pass3){
		echo "パスワードが違います";
	}
}

//編集2
if(!empty($edit2)){
	$id=$_POST["edit2"];
	$nm=$_POST["name"];
	$kome=$_POST["comment"];
	$pass=$_POST["pass1"];
	$sql="update tbtest6 set name='$nm',comment='$kome',password='$pass' where id=$id";
	$result=$pdo->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
</head>

<form method="POST" action="mission_4.php">
<input type="text" placeholder="名前" name="name" value="<?=$edit_name?>"><br>

<input type="text" placeholder="コメント" name="comment" value="<?=$edit_comment?>">
<input type="password" placeholder="パスワード" name="pass1" value="<?=$edit_password?>">
<input type="submit" value="送信"><br><br>

<input type="text" placeholder="削除対象番号" name="delete">
<input type="password" placeholder="パスワード" name="pass2">
<input type="submit" value="削除"><br><br>

<input type="text" placeholder="編集対象番号" name="edit">
<input type="password" placeholder="パスワード" name="pass3">
<input type="submit" value="編集">

<input type="hidden" name="edit2" value="<?=$edit?>"><br>
</form>
</html>

<?php
//phpとMYSQLを接続
$dsn='mysql:dbname=データベース名;host=localhost;charset=utf8';
$user='ユーザー名';
$password='パスワード';
$pdo= new PDO($dsn,$user,$password);

//テーブルの内容を取得して表示する(2-2,3-6)
$sql='SELECT * FROM tbtest6';
$results=$pdo->query($sql);
foreach($results as $row){
	echo $row['id'].' ';
	echo $row['name'].' ';
	echo $row['comment'].' ';
	echo $row['date'].'<br>';
}
?>