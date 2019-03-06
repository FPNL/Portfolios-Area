<?php
	include_once("conn/_db_Config.php");
	// 啟動 Session
    session_start();
    //先給地圖#map_column有個東西
    $locationX=25.0336962;
    $locationY=121.5643673;
    //如果是有東西丟過來，就接網址列，傳送給#map_column
    
    if (isset($_GET["action"])){
        $action = $_GET["action"];
    
    switch ($action) {
        case "search":
            $locationX= $_GET["X"];
            $locationY= $_GET["Y"];
    }}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NewsMaps新聞 地圖版</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="css/frm_news_map.css">
    <!-- <link rel="stylesheet" href="css/default.css"> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <style>
        /* Handle on hover */
    #news_pops_column::-webkit-scrollbar-thumb:hover {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
        background-image: -webkit-linear-gradient(330deg, #f6d365 0%, #fda085 100%);
        background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%); }

    #news_pops_column::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
        background-color: #F5F5F5;
        border-radius: 10px; }

    #news_pops_column::-webkit-scrollbar {
        width: 12px;
        background-color: #F5F5F5; }

    #news_pops_column::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
        background-image: -webkit-linear-gradient(330deg, #e0c3fc 0%, #8ec5fc 100%);
        background-image: linear-gradient(120deg, #e0c3fc 0%, #8ec5fc 100%); }
    
    </style>
</head>
<body>
    <div id="wrap">
        <header>
            <div id="news_nav_area">
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
            </div>  
            <div id="news_logo_area">
                <div>
                    <a href="index.php"> 
                        <img src="img/logo.jpg" alt="LOGO">
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
                    <a href="index.php">
                        <span>地圖版</span>  
                    </a>  
                    <label id="switch">
                            <input id="switchToggle" type="checkbox" onchange="window.location.href='index.php'" checked>
                            <span class="slider round"></span>
                    </label>
                    
                </label>
            </div>
            <div id="news_search_area">
                <div class="container-fluid">
                    <nav class="navbar navbar-light bg-info">
                        <form class="form-inline">
                            <input class="form-control mr-sm-2 bg-light" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0 bg-light" type="submit">Search</button>
                        </form>
                    </nav>
                </div>
            </div>
        <?php //This is for personal innformation on the right up corner!
            $id="";
            $nickname="";
            $newspost="";
            //此判斷為判定觀看此頁有沒有權限
            //說不定是路人或不相關的使用者
            //因此要給予排除
            if(!isset($_SESSION[ws_account_id]))
            {   
                echo 
                "<div id='news_pers_inf_area'>".
                    "<div id='pers_descr'>".
                        "<div id='pers_desc-1'>".
                        "<div id='pers_name'><a href='frm_login.php'><span>訪客</span></a></div>".
                            // "<div id='pers_location'><i class='fas fa-map-marker-alt'></i><a href=''><span>台中市</span></a> </div>".
                        "</div>".
                        // "<div id='pers_desc-2'><span>發布<a href=''>0</a>則新聞</span></div>".
                    "</div>".
                    "<div id='pers_icon'><a href='frm_login.php'><span><img src='img/0.png' alt='頭像'></span></a> </div>".
                "</div>";
                
            }else{
                
                $struser_id = $_SESSION[ws_account_id];
                //將資料庫裡的所有會員資料顯示在畫面上
                // $sql = "SELECT tuserinfo.`cuserinfo_id` AS id, cnicename, COUNT(cnewstitle) AS newspost
                //         FROM `tuserinfo` LEFT JOIN tnewsinfo ON tuserinfo.cuserinfo_id = tnewsinfo.cuserinfo_id
                //         WHERE tuserinfo.cuserinfo_id=".$struser_id.
                //         "GROUP BY tuserinfo.cuserinfo_id, cnicename";
                $sql =  "SELECT tuserinfo.`cuserinfo_id` AS id, cnicename, COUNT(cnewstitle) AS newspost
                        FROM tuserinfo LEFT JOIN   tnewsinfo ON tuserinfo.cuserinfo_id = tnewsinfo.cuserinfo_id
                        WHERE tuserinfo.`cuserinfo_id`='"."$struser_id"."'
                        GROUP BY tuserinfo.cuserinfo_id, cnicename";
                $rows = mysqli_query($db,$sql);
                // while($row = mysql_fetch_row($result)){
                while ($row = $rows->fetch_assoc()) {
                    $id= $row["id"];
                    $nickname= $row["cnicename"];
                    $newspost=$row["newspost"];
                }
                    echo 
                "<div id='news_pers_inf_area'>".
                    "<div id='pers_descr'>".
                        "<div id='pers_desc-1'>".
                            "<div id='pers_name'><a href='frm_news_add.php?action=add'><span>".$nickname."</span></a></div>".
                            // "<div id='pers_location'><i class='fas fa-map-marker-alt'></i><a href=''><span>台中市</span></a> </div>".
                            // "<div id='pers_location'>" ;if(isset($_SESSION[ws_account_id])) { echo "<a href='frm_logout.php'>帳號登出</a>"; };echo "</div>".
                        "</div>".
                        "<div id='pers_desc-2'><span>發布<a href=''>".$newspost."</a>則新聞</span></div>".
                        "<div id='pers_location'>" ;if(isset($_SESSION[ws_account_id])) { echo "<a href='frm_logout.php'>帳號登出</a>"; };echo "</div>".
                    "</div>".
                    "<div id='pers_icon'><a href='frm_news_add.php?action=add'><span><img src='img/".$id.".png' alt='頭像'></span></a> </div>".
                "</div>";
            }
        ?>


        </header>

     
        <main> 
            <div id="map_column">
            <?php
                echo
                "<iframe".
                "id='maps'".
                "frameborder='0' style='border:0'".
                "src='https://www.google.com/maps/embed/v1/view?key=AIzaSyAY_TwkTuFMdT8db9foLLvdF1s91bF5v3Q&zoom=16&center=".$locationX.",".$locationY." allowfullscreen>'".
                "</iframe>";
            ?>
                <!-- Embed崁入式的，沒有控制項，最簡單的，下方有JS方法，可是此法都無有問題，無法往下測試 上方是PHP寫法 -->
                <!-- <iframe
                    frameborder="0" 
                    style="border:0"
                    src="https://www.google.com/maps/embed/v1/view?key=AIzaSyAY_TwkTuFMdT8db9foLLvdF1s91bF5v3Q&zoom=14&center=25.033952,121.564360">
                </iframe> -->
            </div>
            
            <div id="news_pops_column">
                <!-- <div id="news_order_bar">
                    <div id="order_button">
                        <i class="fas fa-bars"></i>
                        <ul>
                            <li><a href=""><span>影視娛樂</span></a></li>
                            <li><a href=""><span>揪團好康</span></a></li>
                            <li><a href=""><span>交通路況</span></a></li>
                            <li><a href=""><span>天氣氣候</span></a></li>
                            <li><a href=""><span>生活優惠</span></a></li>
                            <li><a href=""><span>藝文展覽</span></a></li>
                            <li><a href=""><span>比賽活動</span></a></li>
                            <li><a href=""><span>幼童親子</span></a></li>
                            <li><a href=""><span>寵物友善</span></a></li>
                            <li><a href=""><span>社會狀況</span></a></li>
                        </ul>
                    </div>
                </div> -->
                <div id="news_post">
                <?php
                    $page = $_GET["page"];
                    if($page == ""){
                        $page = 1;
                    }
                    if(is_numeric($page)) {
                        $page_size = 9;
                        $res = $db->query(" SELECT  tuserinfo.cuserinfo_id AS id, 
                                                    tuserinfo.cnicename AS nickname,
                                                    aa.cnewstitle AS title,
                                                    tassessinfo.cassess AS rate, 
                                                    COUNT(aa.cnewstitle) AS newspost,
                                                    aa.clocation_X AS locationX,
                                                    aa.clocation_Y AS locationY,
                                                    tnewstaginfo.ctaginfo_id,
                                                    ttaginfo.ctagtype
                                            FROM        tnewsinfo AS aa 
                                            LEFT JOIN   tnewsinfo AS bb ON  aa.cuserinfo_id=bb.cuserinfo_id
                                            LEFT JOIN   tuserinfo ON tuserinfo.cuserinfo_id=aa.cuserinfo_id
                                            LEFT JOIN   tassessinfo ON tassessinfo.cnewsinfo_id=aa.cnewsinfo_id
                                            LEFT JOIN 	tnewstaginfo ON tnewstaginfo.cnewsinfo_id=aa.cnewsinfo_id
                                            LEFT JOIN 	ttaginfo ON tnewstaginfo.ctaginfo_id=ttaginfo.ctaginfo_id
                                            GROUP BY  id, aa.cnewstitle");
                        $row_count = $res->num_rows;
                        $page_num = ceil($row_count / $page_size);
                        $offset = ($page - 1) * $page_size;
                        $res = $db->query("SELECT  tuserinfo.cuserinfo_id AS id, 
                                                    tuserinfo.cnicename AS nickname,
                                                    aa.cnewstitle AS title,
                                                    tassessinfo.cassess AS rate, 
                                                    COUNT(aa.cnewstitle) AS newspost,
                                                    aa.clocation_X AS locationX,
                                                    aa.clocation_Y AS locationY,
                                                    tnewstaginfo.ctaginfo_id,
                                                    ttaginfo.ctagtype AS official_tag
                                            FROM        tnewsinfo AS aa 
                                            LEFT JOIN   tnewsinfo AS bb ON  aa.cuserinfo_id=bb.cuserinfo_id
                                            LEFT JOIN   tuserinfo ON tuserinfo.cuserinfo_id=aa.cuserinfo_id
                                            LEFT JOIN   tassessinfo ON tassessinfo.cnewsinfo_id=aa.cnewsinfo_id
                                            LEFT JOIN 	tnewstaginfo ON tnewstaginfo.cnewsinfo_id=aa.cnewsinfo_id
                                            LEFT JOIN 	ttaginfo ON tnewstaginfo.ctaginfo_id=ttaginfo.ctaginfo_id
                                            GROUP BY  id, aa.cnewstitle
                                            LIMIT $offset,$page_size");
                        while ($row = $res->fetch_assoc()) {
                        echo 
                        "<div class='news_pop'>".
                        "<div class='news_class'><a href='http://localhost/project2inPHP/frm_list_map.php?action=class&tag=".$row["official_tag"]."'><span class='news_clss_span'>居家生活</span></a> </div>".
                        "<div class='news_title'><a href=''><span>".$row["title"]."</span></a></div>".
                        "<div class='news_icon_bar'>".
                            "<div class='news_distance news_icon_items'>".
                                "<div class='news_distance_icon news_icon'><i class='fas fa-map-marker-alt'></i></div>".
                                "<div class='news_distance_descr news_descr'><a href='frm_news_map.php?action=search&X=".$row["locationX"]."&Y=".$row["locationY"]."' onclick='initMap(".$row["locationX"].",".$row["locationY"].")' ><span>".$row["locationX"]."</span> </a></div>".
                                // "<script>".
                                // "var map;".
                                // "function initMap(location_x=25.0339031,location_y=121.5623212) {".
                                // "var position = {".
                                //     "lat: location_x,".
                                //     "lng: location_y".
                                // "};".
                                // "var map = new google.maps.Map(document.getElementById('map_column'), {".
                                //     "zoom: 18,".
                                //     "center: position".
                                // "});".
                                // "var marker = new google.maps.Marker({".
                                //     "position: position,".
                                //     "map: map".
                                // "});".
                                // "}".
                                // "</script>".
                            "</div>".
                            "<div class='news_views news_icon_items'>".
                                "<div class='news_views_icon news_icon'><i class='fas fa-eye'></i></div>".
                                "<div class='news_views_descr news_descr'><span>20</span></div>".
                            "</div>".
                            "<div class='news_rate news_icon_items'>".
                                "<div class='news_rate_icon news_icon'><i class='far fa-star'></i></div>".
                                "<div class='news_rate_descr news_descr'><span>".$row["rate"]."</span></div>".
                            "</div>".
                            "</div>".
                        "</div>".
                        "<hr class='news_hr'>";
                        }
                    }
                    echo "<div id='news_pops_pages' >";
                        if($page != 1) {
                            echo "<div>".
                                        "<a href=frm_news_map.php?page=".($page - 1)."><span>上一頁</span></a>".
                                "</div>" ;              //如果表達式不是直接的變量，必須計算出來之後使用.連接
                        }
                            echo "<div id='page'>".
                                    "<ul>";
                        for($i=1;$i<=$page_num;$i++){
                                        echo "<li><a href=frm_news_map.php?page=".$i."><span>$i</span></a></li>";
                                    }
                            echo    "</ul>".
                                "</div>";

                        if($page < $page_num) {
                            echo "<div>".
                                "<a href=frm_news_map.php?page=".($page + 1)."><span>下一頁</span></a>".
                            "</div>";
                        }
                    echo "</div>";
                ?>
                </div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>

<!-- <script>
        function clickmaps($x,$y){
    document.getElementById('maps').attributes("src","https://www.google.com/maps/embed/v1/view?key=AIzaSyAY_TwkTuFMdT8db9foLLvdF1s91bF5v3Q&zoom=16&center=25.033952,121.564360");
    }
</script>

<script>
  var map;

function initMap(location_x=25.0339031,location_y=121.5623212) {
  var position = {
    lat: location_x,
    lng: location_y
  };
  var map = new google.maps.Map(document.getElementById('map_column'), {
    zoom: 18,
    center: position
  });
  var marker = new google.maps.Marker({
    position: position,
    map: map
  });
  }
</script> -->

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAY_TwkTuFMdT8db9foLLvdF1s91bF5v3Q&callback=initMap"async defer>
</script>

    
