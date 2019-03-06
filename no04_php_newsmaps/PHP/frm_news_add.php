<?php
	// 啟動 Session
    session_start();
    //Connect
    include_once("conn/_db_Config.php");
    // 判斷是否有登入，未登入者為訪客。

    if (isset($_SESSION['ws_account_id']))
    {
        $struser_id = $_SESSION['ws_account_id'];
    }

    // $account = $_GET["account"];          // 取得URL參數的編號
    $action = $_GET["action"];  // 取得操作種類


    // 執行的操作
    switch ($action) {
        case "add":   // 編輯操作

            $sql = "SELECT  tuserinfo.cuserinfo_id AS id, 
                            tuserinfo.cnicename AS nickname,
                            tuserinfo.caccount AS account,
                            aa.cnewsinfo_id AS newsid,
                            aa.cnewstitle AS title,
                            tassessinfo.cassess AS rate, 
                            COUNT(aa.cnewstitle) AS newspost,
                            aa.clocation_X AS locationX,
                            aa.clocation_Y AS locationY,
                            tnewstaginfo.ctaginfo_id AS tagid,
                            ttaginfo.ctagtype AS tag,
                            aa.cnewsdate AS cdate
                    FROM        tnewsinfo AS aa 
                    LEFT JOIN   tnewsinfo AS bb ON  aa.cuserinfo_id=bb.cuserinfo_id
                    LEFT JOIN   tuserinfo ON tuserinfo.cuserinfo_id=aa.cuserinfo_id
                    LEFT JOIN   tassessinfo ON tassessinfo.cnewsinfo_id=aa.cnewsinfo_id
                    LEFT JOIN 	tnewstaginfo ON tnewstaginfo.cnewsinfo_id=aa.cnewsinfo_id
                    LEFT JOIN 	ttaginfo ON tnewstaginfo.ctaginfo_id=ttaginfo.ctaginfo_id
                    WHERE tuserinfo.cuserinfo_id=".$struser_id."
                    GROUP BY  id, aa.cnewstitle";

            // echo $sql;

            $rows = mysqli_query($db,$sql)or die($conn->error);; // 執行SQL指令

            while ($row = $rows->fetch_assoc()) {			
                $strid = $row["id"];
                $straccount = $row["account"];      		
                $strnickname = $row["nickname"];
                $strtag= $row["tag"];
                $strtagid= $row["tagid"];
                $strdate= $row["cdate"];
            }
        }
    // 顯示編輯表單
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NewsMaps 新增新聞</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/frm_news_add.css">
    <!-- <link rel="stylesheet" href="sass/default.css"> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <style>
         .form-control {
            margin-top: 6px;
        } 
    </style>
  
</head>
<body>
    <div id="wrap">
        <header>
            <!-- <div id="news_nav_area">
                <i class="fas fa-bars"></i>
                <nav>
                    <ul>
                        <li><a href=""><span class="bar_icon"><i class="fas fa-globe-asia"></i></span><span class="bar_descr">哈囉</span></a></li>
                        <li><a href=""><span class="bar_icon"><i class="fas fa-globe-asia"></i></span><span class="bar_descr">哈囉</span></a></li>
                        <li><a href=""><span class="bar_icon"><i class="fas fa-globe-asia"></i></span><span class="bar_descr">哈囉</span></a></li>
                        <li><a href=""><span class="bar_icon"><i class="fas fa-globe-asia"></i></span><span class="bar_descr">哈囉</span></a></li>
                    </ul>
                    <hr>
                    <ul>
                        <li><a href=""><span class="bar_icon"><i class="fas fa-globe-asia"></i></span><span class="bar_descr">國際</span></a></li>
                        <li><a href=""><span class="bar_icon"><i class="fas fa-globe-asia"></i></span><span class="bar_descr">當地</span></a></li>
                        <li><a href=""><span class="bar_icon"><i class="fas fa-globe-asia"></i></span><span class="bar_descr">商業</span></a></li>
                        <li><a href=""><span class="bar_icon"><i class="fas fa-globe-asia"></i></span><span class="bar_descr">科學與科技</span></a></li>
                        <li><a href=""><span class="bar_icon"><i class="fas fa-globe-asia"></i></span><span class="bar_descr">娛樂</span></a></li>
                        <li><a href=""><span class="bar_icon"><i class="fas fa-globe-asia"></i></span><span class="bar_descr">體育</span></a></li>
                        <li><a href=""><span class="bar_icon"><i class="fas fa-globe-asia"></i></span><span class="bar_descr">健康</span></a></li>
                    </ul>
                </nav>
            </div>   -->
            <div id="news_logo_area">
                <div>
                    <a href="index.php"> 
                        <img src="img/logo.png" alt="LOGO">
                    </a>
                </div>
                <div>
                    <a href="index.php">
                        立即發現<br>
                        周邊大小事
                    </a>
                </div>
            </div>   
            <div id="news_toggle_area">
                <label>
                    <a href="frm_news_map.php">
                        <span>地圖版</span>  
                    </a>  
                    <label id="switch">
                            <input id="switchToggle" type="checkbox" onchange="window.location.href='frm_news_map.php'" >
                            <span class="slider round"></span>
                    </label>
                    
                </label>
            </div>
            <div id="news_search_area">
            <div class="container-fluid">
                    <nav class="navbar navbar-light bg-info">
                        <form method="post" action="frm_news_view.php?action=search" class="form-inline w-100 justify-content-center">
                            <input name="search_key" class="form-control mr-sm-2 bg-light w-75" type="search" placeholder="請輸入新聞標題" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0 bg-light" type="submit">Search</button>
                        </form>
                    </nav>
                </div>
            </div>
           
            <?php 
                //將資料庫裡的所有會員資料顯示在畫面上
                $sql =  "SELECT tuserinfo.`cuserinfo_id` AS id, cnicename, caccount, COUNT(cnewstitle) AS newspost
                FROM tuserinfo LEFT JOIN   tnewsinfo ON tuserinfo.cuserinfo_id = tnewsinfo.cuserinfo_id
                WHERE tuserinfo.`cuserinfo_id`='"."$struser_id"."'
                GROUP BY tuserinfo.cuserinfo_id";
                $rows = mysqli_query($db,$sql);
                // while($row = mysql_fetch_row($result)){
                while ($row = $rows->fetch_assoc()) {
                    $pers_id= $row["id"];
                    $pers_account=$row["caccount"];
                    $pers_nickname= $row["cnicename"];
                    $pers_newspost=$row["newspost"];
                }
                    echo 
                "<div id='news_pers_inf_area'>".
                    "<div id='pers_descr'>".
                        "<div id='pers_desc-1'>".
                            "<div id='pers_name'><a href=''><span>".$pers_nickname."</span></a></div>".
                            // "<div id='pers_location'><i class='fas fa-map-marker-alt'></i><a href=''><span>台中市</span></a> </div>".
                            // "<div id='pers_location'>" ;if(isset($_SESSION['ws_account_id'])) { echo "<a href='frm_logout.php'>帳號登出</a>"; };echo "</div>".
                        "</div>".
                        "<div id='pers_desc-2'><span>發布<a href='frm_news_view.php?action=pers&id=".$pers_id."'>".$pers_newspost."</a>則新聞</span></div>".
                        "<div id='pers_location'>" ;if(isset($_SESSION['ws_account_id'])) { echo "<a href='frm_logout.php'>帳號登出</a>"; };echo "</div>".
                    "</div>".
                    "<div id='pers_icon'><a href='frm_news_add.php?action=add&account=".$pers_account."'><span><img src='img/".$pers_id.".png' alt='頭像'></span></a> </div>".
                "</div>";
            
            ?>

        </header>

        
        <main>
            <div id="pers_page_column" >
                <div id="info_show" class="pers_page">
                    <div class="pers_page_caption">
                        <img src="img/background-transparent.png" alt="Hot 新聞" class="transparent_img">
                        <span>
                            基 本 資 訊
                        </span>
                        <span>
                            <a href="#">
                            <!-- 目前尚未有功能 -->
                                <!-- <i class="fas fa-pen-nib"></i> 修改基本資料 -->
                            </a>
                        </span>
                    </div>
                    <div id="info_show_content">
                        <div id="info_show_icon">
                            <?php
                            echo
                            "<img src='img/".$struser_id.".png' alt='icon'>";
                            ?>
                        </div>
                        <div id="info_show_desrc">
                            <?php
                            echo
                            "<span>".$strnickname."</span>".
                            "<span>帳號: ".$straccount."</span>".
                            "<span>創號日期: ".$strdate."</span>".
                            "<div id='info_show_newsposts'>".
                                "<a href='frm_news_view.php?action=pers&id=".$struser_id."'><span>發佈 <span>".$pers_newspost."</span> 則新聞</span></a>".
                            "</div>";
                            ?>
                        </div>
                        
                    </div>
                </div>
                <div id="add_news" class="pers_page">
                    <div class="pers_page_caption">
                        <img src="img/background-transparent.png" alt="Hot 新聞" class="transparent_img">
                        <span>
                            新 增 新 聞
                        </span>
                    </div>
                    <div id="add_news_main">
                        <form action="add_news.php" method="post" id="add_news_form" class="">
                            <div class="editTxt">
                                <label >
                                    <span>標題</span>
                                    <input type="text" name="crttitle" id="postnewstitle" placeholder="輸入您的標題">
                                </label>
                            </div>
                            <!-- <div class="editTxt">
                                <label >
                                    <span>關鍵字</span>
                                    <input type="text" name="" id="" placeholder="#Tags">
                                </label>
                            </div> -->
                            <!-- <div class="editTxt">
                                <label >
                                    <span>分類</span>
                                    <select class="form-control ">
                                        <?php
                                        // $sql_tag="SELECT * FROM ttaginfo";
                                        // $rows_tag=mysqli_query($db,$sql_tag);
                                        // while ($row_tag = $rows_tag->fetch_assoc()) {
                                        // echo 
                                        // "<option value='".$row_tag["ctagtype"]."'>".$row_tag["ctagtype"]."</option>";
                                        // }
                                        ?>
                                    </select>
                                </label>
                            </div> -->

                            <div class="editTxt">
                                <label >
                                    <span>時間日期</span>
                                    <input type="text" name="crttime" id="create_time" value="" placeholder="請選擇時間" onclick="change_time()" >
                                </label>
                            </div>

                            <!-- <div id="location_get" class="editTxt">
                                <div id="forthelabel">
                                    <span id="location_get_title">地點位置</span>
                                    <span id="location_get_descr"><span class="getX"></span><span> , </span><span class="getY"></span></span>
                                    <input type="hidden" id="positionX" name="positionX" value="">
                                    <input type="hidden" id="positionY" name="positionY" value="">
                                    <div>
                                        <input type="button" value="Google Maps定位" id="location_get_btn">
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="upload_img_row">
                                <div id="upload_img_title" class="">                                
                                    <span>上傳圖片</span>
                                </div>
                                <div id="upload_img">
                                    <div id="upload_img_items">
                                        <p class="upload_img_item"></p>
                                        <hr>
                                        <p class="upload_img_item">321231</p>
                                    </div>    
                                    <input type="button" value="瀏覽上傳" class="upload_img_btn">                            
                                </div>
                            </div> -->
                            <!-- <div class="editTxt">
                                    <span>文字編輯器</span>
                            </div> -->
                            <div id="review">
                                <div class='form-group pl-4 font-weight-bold mt-3'>
                                    <label for='exampleFormControlTextarea1'>新聞內容</label>
                                    <textarea class='form-control' name='crtcontent' id='exampleFormControlTextarea1' rows='8'></textarea>
                                </div>
                            </div>
                            <div class="okBtn">
                              
                            <input type="submit"  value="修 改 完 成 ， 發 佈 新 聞" name="" id="postnewsbtn" class="" >
                            <script>
                                
                            </script>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
            <div id="recommand_column">
                <div id="class_tags">
                    <div id="class_tags_caption">
                        <img src="img/background-transparent.png" alt="分類標籤" class="transparent_img">
                        <span>分類標籤</span>
                    </div>
                    <div id="class_tags_content">
                        <ul>
                        <?php
                        $sql_tag =  "SELECT ctaginfo_id AS tagid,
                                            ctagtype AS tag
                                    FROM    ttaginfo
                                    LIMIT 10";
                                $rows_tag = mysqli_query($db,$sql_tag);
                                // while($row = mysql_fetch_row($result)){
                                while ($row_tag = $rows_tag->fetch_assoc()) 
                            echo "<li><a href='frm_news_view.php?action=class&tags=".$row_tag["tagid"]."'><span>".$row_tag["tag"]."</span></a></li>";
                        ?>
                            <!-- <li><a href=""><span>影視娛樂</span></a></li>
                            <li><a href=""><span>揪團好康</span></a></li>
                            <li><a href=""><span>交通路況</span></a></li>
                            <li><a href=""><span>天氣氣候</span></a></li>
                            <li><a href=""><span>生活優惠</span></a></li>
                            <li><a href=""><span>藝文展覽</span></a></li>
                            <li><a href=""><span>比賽活動</span></a></li>
                            <li><a href=""><span>幼童親子</span></a></li>
                            <li><a href=""><span>寵物友善</span></a></li>
                            <li><a href=""><span>社會狀況</span></a></li> -->
                        </ul>
                    </div>
                </div>
                <div id="recommand_top5">
                    <div id="recommand_top5_caption">
                        <img src="img/background-transparent.png" alt="本周TOP5" class="transparent_img">
                        <span>本周TOP5</span>
                    </div>
                    <div id="recommand_top5_content">
                    <?php
                        $sql = "SELECT  tuserinfo.cuserinfo_id AS id, 
                                        tuserinfo.cnicename AS nickname,
                                        tuserinfo.caccount AS account,
                                        aa.cnewsinfo_id AS newsid,
                                        aa.cnewstitle AS title,
                                        tassessinfo.cassess AS rate, 
                                        COUNT(aa.cnewstitle) AS newspost,
                                        aa.clocation_X AS locationX,
                                        aa.clocation_Y AS locationY,
                                        tnewstaginfo.ctaginfo_id AS tagid,
                                        ttaginfo.ctagtype AS tag
                                FROM        tnewsinfo AS aa 
                                LEFT JOIN   tnewsinfo AS bb ON  aa.cuserinfo_id=bb.cuserinfo_id
                                LEFT JOIN   tuserinfo ON tuserinfo.cuserinfo_id=aa.cuserinfo_id
                                LEFT JOIN   tassessinfo ON tassessinfo.cnewsinfo_id=aa.cnewsinfo_id
                                LEFT JOIN 	tnewstaginfo ON tnewstaginfo.cnewsinfo_id=aa.cnewsinfo_id
                                LEFT JOIN 	ttaginfo ON tnewstaginfo.ctaginfo_id=ttaginfo.ctaginfo_id
                                GROUP BY  id, aa.cnewstitle 
                                ORDER BY rand()
                                LIMIT 5";
                                $rows = mysqli_query($db,$sql);
                                // while($row = mysql_fetch_row($result)){
                                while ($row_recommand = $rows->fetch_assoc()) 
                                echo
                        "<div class='recommand_top5_news'>".
                            "<div class='recommand_top5_news_class'><a href='frm_news_view.php?action=class&tags=".$row_recommand["tagid"]."'><span>".$row_recommand["tag"]."</span></a></div>".
                            "<div class='recommand_top5_news_title'><a href='frm_news_detail.php?action=view&newsid=".$row_recommand["newsid"]."'><span>".$row_recommand["title"]."</span></a></div>".
                        "</div>".
                        "<hr class='recommand_top5_news_hr'>";

                        ?>
                        
                    </div>
                    
                </div>
                <footer>
                    <img src="img/background-transparent.png" alt="Copyright" class="transparent_img">
                    <p>
                        2018APP系統開發及資訊安全實務班<br
                        >Copyright © 2018NewsMap <br>
                        All rights reseved <br>
                        Programming by CHANG,PEI-LIN <br>
                        LAI,WEN-HUNG WU,MENG-YU
                    </p>
                </footer>
            </div>
        </main>
    </div>
    <script>
        function change_time(){
            var month=new Date().getMonth()+1
            document.getElementById('create_time').value= new Date().getFullYear()+"-"+month+"-"+new Date().getDate()
            document.getElementById('create_time').setAttribute("disabled","disabled");
        }
        $('#postnewsbtn').click(function () {
            var month=new Date().getMonth()+1;
            var fulltime=new Date().getFullYear()+"-"+month+"-"+new Date().getDate();
            $("#create_time").val(fulltime);
            
            $(this).attr("disable", "disable");
        
            var errMsg = [];

            if ($('#postnewstitle').val() == '') { errMsg.push("標題忘記寫了><"); }
            
            if ($('#exampleFormControlTextarea1').val() == '') { errMsg.push("忘記寫內容了><"); }
                                                
            if (errMsg.length>0) { 
                alert(errMsg.join('\n')); $(this).removeAttr("disabled"); return false; 
                }
            // else { return true; }
            
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>




