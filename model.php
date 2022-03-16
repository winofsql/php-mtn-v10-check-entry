<?php
// **************************
// 入力チェック
// **************************
function check_entry( $mysqli ) {

    if( $_POST["kanri"] == "" ) {
        return true;
    }

    $query =<<<QUERY
select
    社員コード,
    氏名
from
    社員マスタ
where
    社員コード = '{$_POST["kanri"]}'
QUERY;

    $result = $mysqli->query( $query );
    $row = $result->fetch_array( MYSQLI_BOTH );

    return $row;
}

// **************************
// 社員コードで存在チェック
// **************************
function check( $mysqli ) {

    $query =<<<QUERY
select
    A.社員コード,
    A.氏名,
    A.フリガナ,
    A.所属,
    A.性別,
    A.給与,
    A.手当,
    A.管理者,
    B.氏名 as 管理者名,
    DATE_FORMAT(A.生年月日, '%Y-%m-%d') as 生年月日
from
    社員マスタ A
    left outer join
        社員マスタ B
    on A.管理者 = B.社員コード
where
    A.社員コード = '{$_POST["scode"]}'
QUERY;

    $result = $mysqli->query( $query );
    $row = $result->fetch_array( MYSQLI_BOTH );

    return $row;
}

// **************************
// 更新処理
// **************************
function insert( $mysqli ) {

    if ( $_POST["teate"] == ""  ) {
        $_POST["teate"] = "NULL";
    }

    if ( $_POST["kanri"] == ""  ) {
        $_POST["kanri"] = "NULL";
    }
    else {
        $_POST["kanri"] = "'{$_POST["kanri"]}'";
    }


    $query = <<<QUERY

insert into 社員マスタ 
    (社員コード
    ,氏名
    ,フリガナ
    ,所属
    ,性別
    ,給与
    ,手当
    ,管理者
    ,生年月日
    )
    values('{$_POST["scode"]}'
    ,'{$_POST["sname"]}'
    ,'{$_POST["fname"]}'
    ,'{$_POST["syozoku"]}'
    ,{$_POST["seibetsu"]}
    ,{$_POST["kyuyo"]}
    ,{$_POST["teate"]}
    ,{$_POST["kanri"]}
    ,'{$_POST["birth"]}'
    )

QUERY;

    $mysqli->query( $query );

}


function update( $mysqli ) {

    if ( $_POST["teate"] == ""  ) {
        $_POST["teate"] = "NULL";
    }

    if ( $_POST["kanri"] == ""  ) {
        $_POST["kanri"] = "NULL";
    }
    else {
        $_POST["kanri"] = "'{$_POST["kanri"]}'";
    }


    $query = <<<QUERY

update 社員マスタ set 

氏名 = '{$_POST["sname"]}',
フリガナ = '{$_POST["fname"]}',
所属 = '{$_POST["syozoku"]}',
性別 = {$_POST["seibetsu"]},
給与 = {$_POST["kyuyo"]},
手当 = {$_POST["teate"]},
管理者 = {$_POST["kanri"]},
生年月日 = '{$_POST["birth"]}'

where 社員コード = '{$_POST["scode"]}'

QUERY;

    $mysqli->query( $query );

}

// **************************
// デバッグ表示
// **************************
function debug_print() {

    print "<pre class=\"m-5\">";
    print_r( $_GET );
    print_r( $_POST );
    print_r( $_SESSION );
    print_r( $_FILES );
    print "</pre>";

}
