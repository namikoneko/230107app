<?php
ini_set('display_errors', 1);

require_once '../libs/flight/Flight.php';
require_once '../libs/Parsedown.php';

require_once ("../libs/blade/BladeOne.php");
use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new BladeOne($views,$cache,BladeOne::MODE_DEBUG);
Flight::set('blade', $blade);


Flight::route('/datasTop', function(){//################################################## datasTop
    $filter = Flight::request()->query->filter;

    $db = new PDO('sqlite:./data.db');

    switch($filter){
        case "LvOne":
            $stmt = $db->prepare("select * from data where level like 1 and kzm = 0 order by updated desc");
        break;

        case "LvSort":
            $stmt = $db->prepare("select * from data where level <> '' and kzm = 0 order by level, updated desc");
        break;

        case "kzm":
            $stmt = $db->prepare("select * from data where kzm <> 0 order by kzm desc");
        break;

        default;
            $stmt = $db->prepare("select * from data where linkTo = '[]' and kzm = 0 order by updated desc");
        break;
    }

//    $db = new PDO('sqlite:./data.db');
    $stmt->execute();

$rows = makeRows($stmt);
/*

*/
    $rows = markdownParse($rows);

  $blade = Flight::get('blade');//


    if($filter == "kzm"){
          echo $blade->run("datasTopKzm",array("rows"=>$rows)); //
    }else{
      echo $blade->run("datasTop",array("rows"=>$rows)); //
    }
});

Flight::route('/dataInsExeTop', function(){//################################################## dataInsExe

    $title = Flight::request()->data->title;

if($title == ""){
    $title = date('Y-m-d');
}
    $text = Flight::request()->data->text;

    $db = new PDO('sqlite:./data.db');
    $stmt = $db->prepare("insert into data (date,title,text,updated,linkTo,linked,sort,kzm) values (?,?,?,?,?,?,?,?)");
    $array = array(date('Y-m-d'),$title,$text,time(),"[]","[]",0,0);

    $stmt->execute($array);

    Flight::redirect('/datasTop');

});

Flight::route('/catUp/@id', function($id){
    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("update data set updated = ? where id = ?");
    $array = array(time(), $id);
    $stmt->execute($array);

    Flight::redirect('/datasTop');
});

Flight::route('/datas/@id', function($id){//################################################## datas@catId

//echo "datas";

    $db = new PDO('sqlite:./data.db');

//echo "z";

    $sql = "select * from data where id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($id));




    $rows = makeRows($stmt);
    $mainRow = $rows[0];
    $mainRowText = $mainRow["text"];
    $mainRow = markdownParseOne($mainRow);

//linkToの処理
$linkToObj = json_decode($mainRow["linkTo"]);

$whereIn = implode(",",$linkToObj);

    $stmt = $db->prepare("select * from data where id in (" . $whereIn . ") and kzm = 0 order by sort desc, updated desc");
    $stmt->execute();

$linkToRows = makeRows($stmt);


//linkedの処理
$linkedObj = json_decode($mainRow["linked"]);

//$sql = "select * from data where id in (";






$whereIn = implode(",",$linkedObj);

//ページング
  $page = Flight::request()->query->page;

  $records = 50;//1ページあたりのレコード数

  if($page === 0){//全表示

    $stmt = $db->prepare("select * from data where id in (" . $whereIn . ") and kzm = 0 order by sort desc, updated desc");
    $stmt->execute();

  }else{

        if($page == null){//$pageに数値がなければ1
            $page = 1;
        }

        $offsetNum = ($page - 1) * $records;
        //$sql = "select * from data where id in (" . $whereIn . ") and kzm = 0 order by sort desc, updated desc  limit 2";
        $sql = "select * from data where id in (" . $whereIn . ") and kzm = 0 order by sort desc, updated desc limit ? offset ?";

        $stmt = $db->prepare($sql);
        //$stmt->execute();

        $stmt->execute(array($records, $offsetNum));

            //echo "b";
  }


    $linkedRows = makeRows($stmt);
    $linkedRows = markdownParse($linkedRows);


  $blade = Flight::get('blade');//
  echo $blade->run("datas",array("mainRow"=>$mainRow,"linkToRows"=>$linkToRows,"linkedRows"=>$linkedRows,"mainRowText"=>$mainRowText,"page"=>$page)); //


});

Flight::route('/dataInsExe', function(){//################################################## dataInsExe

    $linkToId = Flight::request()->data->linkToId;//いわゆるid

    $title = Flight::request()->data->title;

if($title == ""){
    $title = date('Y-m-d');
}
    $text = Flight::request()->data->text;

    $db = new PDO('sqlite:./data.db');
    $stmt = $db->prepare("insert into data (date,title,text,updated,linkTo,linked,sort,kzm) values (?,?,?,?,?,?,?,?)");
    $array = array(date('Y-m-d'),$title,$text,time(),"[" . $linkToId . "]","[]",0,0);

    $stmt->execute($array);

//ここから親レコードのlinkedを入力
    $stmt = $db->prepare("select * from data where id = ?");//親レコードを取得
    $stmt->execute(array($linkToId));

    $rows = makeRows($stmt);
    $row = $rows[0];//親レコード

    $stmt = $db->prepare("select max(id) from data");//newRecordのidを取得、ver2
    //$stmt = $db->prepare("select count(*) from data");//newRecordのidを取得、ver1

    $stmt->execute();
    $newRecordId = $stmt->fetchColumn();

    $linkedObj = json_decode($row["linked"]);
    $linkedObj[] = (int)$newRecordId;
    $linkedStr = json_encode($linkedObj);

    $stmt = $db->prepare("update data set linked = ? where id = ?");//更新
    $stmt->execute(array($linkedStr,$linkToId));

    Flight::redirect('/datas/' . $linkToId);
});

Flight::route('/dataUpdExe', function(){//################################################## dataUpdExe
    $mainRowId = Flight::request()->data->mainRowId;
    $id = Flight::request()->data->id;

    $title = Flight::request()->data->title;//
    $text = Flight::request()->data->text;
    $level = Flight::request()->data->level;//
    $sort = Flight::request()->data->sort;//


    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("update data set title = ?,text = ?,level = ?,sort = ? where id = ?");
    $array = array($title, $text, $level, $sort, $id);
    $stmt->execute($array);

    Flight::redirect('/datas/' . $mainRowId);
});

Flight::route('/dataUp/@mainId/@id', function($mainId,$id){//################################################## dataUp
    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("update data set updated = ? where id = ?");
    $array = array(time(), $id);
    $stmt->execute($array);

    Flight::redirect('/datas/' . $mainId);
});

Flight::route('/dataKzm/@mainId/@id', function($mainId,$id){//################################################## dataUp
    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("update data set kzm = ? where id = ?");
    $array = array(date('Y-m-d'), $id);
    $stmt->execute($array);

    Flight::redirect('/datas/' . $mainId);
});

Flight::route('/dataKzmBack/@id', function($id){//################################################## dataUp
    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("update data set kzm = ? where id = ?");
    $array = array(0, $id);
    $stmt->execute($array);

    Flight::redirect('/datasTop?filter=kzm');
});



Flight::route('/dataUpdExeAddLink', function(){//################################################## dataUpdExe
    $id = Flight::request()->data->id;

    $addLink = Flight::request()->data->addLink;

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("select linkTo from data where id = ?");
    $array = array($id);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $row = $rows[0];//

    $linkToObj = json_decode($row["linkTo"]);
    $linkToObj[] = (int)$addLink;
    $linkToStr = json_encode($linkToObj);

    $stmt = $db->prepare("update data set linkTo = ? where id = ?");//更新
    $stmt->execute(array($linkToStr,$id));

//ここから親レコードのlinkedを入力
    $stmt = $db->prepare("select * from data where id = ?");//親レコードを取得
    $stmt->execute(array($addLink));

    $rows = makeRows($stmt);
    $row = $rows[0];//親レコード

    $linkedObj = json_decode($row["linked"]);
    $linkedObj[] = (int)$id;
    $linkedStr = json_encode($linkedObj);

    $stmt = $db->prepare("update data set linked = ? where id = ?");//更新
    $stmt->execute(array($linkedStr,$addLink));

    Flight::redirect('/datas/' . $id);
});

Flight::route('/dataUpdExeDelLink', function(){//################################################## dataUpdExe
    $id = Flight::request()->data->id;

    $delLink = Flight::request()->data->delLink;

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("select linkTo from data where id = ?");
    $array = array($id);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $row = $rows[0];//

    $linkToObj = json_decode($row["linkTo"]);
    $delLinkOrder = array_search($delLink,$linkToObj);
    array_splice($linkToObj,$delLinkOrder,1);//linkToから削除
//var_dump($linkToObj);
    $linkToStr = json_encode($linkToObj);

    $stmt = $db->prepare("update data set linkTo = ? where id = ?");//更新
    $stmt->execute(array($linkToStr,$id));

//ここから親レコードのlinkedを削除
    $stmt = $db->prepare("select * from data where id = ?");//親レコードを取得
    $stmt->execute(array($delLink));

    $rows = makeRows($stmt);
    $row = $rows[0];//親レコード

    $linkedObj = json_decode($row["linked"]);
    $delLinkOrder = array_search($id,$linkedObj);
    array_splice($linkedObj,$delLinkOrder,1);
    $linkedStr = json_encode($linkedObj);

    $stmt = $db->prepare("update data set linked = ? where id = ?");//更新
    $stmt->execute(array($linkedStr,$delLink));

    Flight::redirect('/datas/' . $id);
/*
*/

});


Flight::route('/find', function(){//################################################## dataUpdExe
    $titleOrText = Flight::request()->query->titleOrText;
    $word = Flight::request()->query->word;

    $db = new PDO('sqlite:data.db');

if($titleOrText == 1){
    $stmt = $db->prepare("select * from data where title like ?");
    $array = array("%{$word}%");
    $stmt->execute($array);
}else{
    $stmt = $db->prepare("select * from data where text like ?");
    $array = array("%{$word}%");
    $stmt->execute($array);
}

    $rows = makeRows($stmt);
    $rows = markdownParse($rows);

  $blade = Flight::get('blade');//

if($titleOrText == 1){
  echo $blade->run("datasTop",array("rows"=>$rows)); //
}else{
  echo $blade->run("findText",array("rows"=>$rows)); //
}




});



function makeRows($stmt){
    $i = 0;
    $rows = [];
    while($row = $stmt->fetch()){
        $row["i"] = $i;
        $rows[$i] = $row;
        $i++;
    }
    return $rows;
}

function markdownParse($rows){
  $parse = new Parsedown();
  $parse->setBreaksEnabled(true);
  $parse->setMarkupEscaped(false);
  $i = 0;
   foreach($rows as $row){
     $rows[$i]["text"] = $parse->text($row["text"]);
     $rows[$i]["rawText"] = $row["text"];//元のテキスト
     $i++;
   }
  return $rows;
}

function markdownParseOne($row){
  $parse = new Parsedown();
  $parse->setBreaksEnabled(true);
  $parse->setMarkupEscaped(false);
  $row["text"] = $parse->text($row["text"]);
  $row["rawText"] = $row["text"];//元のテキスト
  return $row;
}

Flight::start();
