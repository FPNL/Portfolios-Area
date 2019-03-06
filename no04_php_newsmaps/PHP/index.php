<?php
	include_once("conn/_db_Config.php");
	// 啟動 Session
	session_start();
    // 判斷是否有登入，未登入者為訪客。
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NewsMaps新聞</title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/index.css">
    <!-- <link rel="stylesheet" href="css/default.css"> -->
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
                        <img src="img/logo.png" alt="Incorrect Path">
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
            
        <?php //This is for personal innformation on the left up corner!
        //此判斷為判定觀看此頁有沒有權限
        //說不定是路人或不相關的使用者
        //因此要給予排除
        if(!isset($_SESSION['ws_account_id']))
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
            // echo $_SESSION['ws_account_id'];
            $struser_id = $_SESSION['ws_account_id'];
            //將資料庫裡的所有會員資料顯示在畫面上
            // $sql = "SELECT tuserinfo.`cuserinfo_id` AS id, cnicename, COUNT(cnewstitle) AS newspost
            //         FROM `tuserinfo` LEFT JOIN tnewsinfo ON tuserinfo.cuserinfo_id = tnewsinfo.cuserinfo_id
            //         WHERE tuserinfo.cuserinfo_id=".$struser_id.
            //         "GROUP BY tuserinfo.cuserinfo_id, cnicename";
            $sql_pers =  "SELECT  tuserinfo.cuserinfo_id AS id, 
                                tuserinfo.cnicename AS nickname,
                                tuserinfo.caccount AS account,
                                COUNT(tnewsinfo.cnewstitle) AS newspost
                        FROM    tuserinfo 
                        LEFT JOIN   tnewsinfo  ON tuserinfo.cuserinfo_id=tnewsinfo.cuserinfo_id
                        WHERE tuserinfo.cuserinfo_id=".$struser_id."
                        GROUP BY  id";


            $rows_pers = mysqli_query($db,$sql_pers);
            // while($row = mysql_fetch_row($result)){
            while ($row_pers = $rows_pers->fetch_assoc()){
            
                echo 
            "<div id='news_pers_inf_area'>".
                "<div id='pers_descr'>".
                    "<div id='pers_desc-1'>".
                        "<div id='pers_name'><a href='frm_news_add.php?action=add'><span>".$row_pers["nickname"]."</span></a></div>".
                        // "<div id='pers_location'><i class='fas fa-map-marker-alt'></i><a href=''><span>台中市</span></a> </div>".
                        // "<div id='pers_location'>" ;if(isset($_SESSION[ws_account_id])) { echo "<a href='frm_logout.php'>帳號登出</a>"; };echo "</div>".
                    "</div>".
                    "<div id='pers_desc-2'><span>發布<a href='frm_news_view.php?action=pers&id=".$row_pers["id"]."'>".$row_pers["newspost"]."</a>則新聞</span></div>".
                    "<div id='pers_location'>" ;if(isset($_SESSION['ws_account_id'])) { echo "<a href='frm_logout.php'>帳號登出</a>"; };echo "</div>".
                "</div>".
                // if $img[3] != zero{return;}    Image DB [0]=id [1]=Username [2]=Original name [3]=Changed name (default 0)
                //     else{$id=0;}
                "<div id='pers_icon'><a href='frm_news_add.php?action=add'><span><img src='img/".$row_pers["id"].".png' alt='頭像'></span></a> </div>".
            "</div>";
            }
        }
        ?>
        


        </header>
        <main> 
            <div id="news_post">
                <div id="news_headlines_column">
                    <div id="news_headlines_caption">
                        <img src="img/background-transparent.png" alt="Newsmap Hot 新聞" class="transparent_img">
                        <span>
                            Hot 新聞
                        </span>
                        <span>
                            <a href="#">
                            </a>
                        </span>
                    </div>
                    <div id="news_headlines">
                <?php 
                

                    $res = $db->query(" SELECT  tuserinfo.cuserinfo_id AS id, 
                                                tuserinfo.cnicename AS nickname,
                                                aa.cnewsinfo_id AS newsid,
                                                tuserinfo.caccount AS account,
                                                aa.cnewstitle AS title,
                                                tassessinfo.cassess AS rate, 
                                                COUNT(aa.cnewstitle) AS newspost,
                                                aa.clocation_X AS locationX,
                                                aa.clocation_Y AS locationY,
                                                tnewstaginfo.ctaginfo_id AS tagid,
                                                ttaginfo.ctagtype AS tag,
                                                tmediainfo.cmediafile AS img
                                        FROM        tnewsinfo AS aa 
                                        LEFT JOIN   tnewsinfo AS bb ON  aa.cuserinfo_id=bb.cuserinfo_id
                                        LEFT JOIN   tuserinfo ON tuserinfo.cuserinfo_id=aa.cuserinfo_id
                                        LEFT JOIN   tassessinfo ON tassessinfo.cnewsinfo_id=aa.cnewsinfo_id
                                        LEFT JOIN 	tnewstaginfo ON tnewstaginfo.cnewsinfo_id=aa.cnewsinfo_id
                                        LEFT JOIN 	ttaginfo ON tnewstaginfo.ctaginfo_id=ttaginfo.ctaginfo_id
                                        LEFT JOIN 	tmediainfo ON aa.cnewsinfo_id=tmediainfo.cnewsinfo_id
                                        -- WHERE tassessinfo.cassess>=3
                                        GROUP BY  id, aa.cnewstitle
                                        -- ORDER BY tassessinfo.cassess DESC
                                        ORDER BY rand() DESC
                                        LIMIT 3");

                    $strcount = "18";
                    while ($row = $res->fetch_assoc()) {
                    echo
                    "<div id='headlines_1' class='news_headline'>".
                        "<div class='news_headlines_img'>".
                            "<a href='frm_news_detail.php?action=view&newsid=".$row["newsid"]."'>".
                                "<img src='upload/".$row["img"]."' alt='Not Correct path'>".
                            "</a>".
                        "</div>".
                        "<div class='news_headline_main'>";
                        if ($row["tag"] !=""){
                            echo
                            "<div class='news_class'><a href='frm_news_view.php?action=class&tags=".$row["tagid"]."'><span class='news_clss_span'>".$row["tag"]."</span></a> </div>";
                        }
                        else{
                            echo 
                            "<div class='news_class'><a href='frm_news_view.php?action=class&tags=".$row["tagid"]."'><span class='news_clss_span'>尚未分類</span></a> </div>";
                        }
                        echo
                            "<div class='news_title'><a href='frm_news_detail.php?action=view&newsid=".$row["newsid"]."'><span class='news_title_span'>".$row["title"]."</span></a></div>".
                            "<div class='news_icon_bar'>".
                                "<div class='news_distance news_icon_items'>".
                                    "<div class='news_distance_icon news_icon'>".
                                        "<i class='fas fa-map-marker-alt'></i>".
                                    "</div>".
                                    // 沒有距離設置，且沒有超聯結是故意的
                                    "<div class='news_distance_descr news_descr'><span>500 Km</span></div>".
                                "</div>".
                                "<div class='news_views news_icon_items'>".
                                    "<div class='news_views_icon news_icon'>".
                                        "<i class='fas fa-eye'></i>".
                                    "</div>".
                                    //沒有設置計數器
                                    "<div class='news_views_descr news_descr'><span>500</span></div>".
                                "</div>".
                                "<div class='news_rate news_icon_items'>".
                                    "<div class='news_rate_icon news_icon'>".
                                        "<i class='far fa-star'></i>".
                                    "</div>".
                                    "<div class='news_rate_descr news_descr'><span>".$row["rate"]."</span></div>".
                                "</div>".
                            "</div>".
                        "</div>".
                    "</div>";}
                    ?> 
                        
                    </div>
                </div>
                
                <div id="news_pops_column">
                     <div id="news_pop_caption">
                        <img src="img/background-transparent.png" alt="newsmap即時新聞" class="transparent_img">
                        <span>
                            即時新聞
                        </span>
                        <span>
                            <a href="#">
                                See more+
                            </a>
                        </span>
                    </div>
                    
                    <!--    -------------lorem start ----------------- -->
                <?php
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                }
                else {
                    $page = 1;
                }


                if(is_numeric($page)) {
                    $page_size = 9;
                    $res = $db->query(" SELECT  tuserinfo.cuserinfo_id AS id, 
                                                tuserinfo.cnicename AS nickname,
                                                tuserinfo.caccount AS account,
                                                aa.cnewsinfo_id AS newsid,
                                                aa.cnewstitle AS title,
                                                tassessinfo.cassess AS rate, 
                                                COUNT(aa.cnewstitle) AS newspost,
                                                aa.clocation_X AS locationX,
                                                aa.clocation_Y AS locationY,
                                                aa.cnewsdate AS date,
                                                tnewstaginfo.ctaginfo_id AS tagid,
                                                ttaginfo.ctagtype AS tag,
                                                tmediainfo.cmediafile AS img
                                        FROM        tnewsinfo AS aa 
                                        LEFT JOIN   tnewsinfo AS bb ON  aa.cuserinfo_id=bb.cuserinfo_id
                                        LEFT JOIN   tuserinfo ON tuserinfo.cuserinfo_id=aa.cuserinfo_id
                                        LEFT JOIN   tassessinfo ON tassessinfo.cnewsinfo_id=aa.cnewsinfo_id
                                        LEFT JOIN 	tnewstaginfo ON tnewstaginfo.cnewsinfo_id=aa.cnewsinfo_id
                                        LEFT JOIN 	ttaginfo ON tnewstaginfo.ctaginfo_id=ttaginfo.ctaginfo_id
                                        LEFT JOIN 	tmediainfo ON aa.cnewsinfo_id=tmediainfo.cnewsinfo_id
                                        GROUP BY  id, aa.cnewstitle
                                        ORDER BY aa.cnewsdate DESC ");



                    $row_count = $res->num_rows;
                    $page_num = ceil($row_count / $page_size);
                    $offset = ($page - 1) * $page_size;
                    $res = $db->query(" SELECT  tuserinfo.cuserinfo_id AS id, 
                    tuserinfo.cnicename AS nickname,
                    tuserinfo.caccount AS account,
                    aa.cnewsinfo_id AS newsid,
                    aa.cnewstitle AS title,
                    tassessinfo.cassess AS rate, 
                    COUNT(aa.cnewstitle) AS newspost,
                    aa.clocation_X AS locationX,
                    aa.clocation_Y AS locationY,
                    aa.cnewsdate AS date,
                    tnewstaginfo.ctaginfo_id AS tagid,
                    ttaginfo.ctagtype AS tag,
                    tmediainfo.cmediafile AS img
            FROM        tnewsinfo AS aa 
            LEFT JOIN   tnewsinfo AS bb ON  aa.cuserinfo_id=bb.cuserinfo_id
            LEFT JOIN   tuserinfo ON tuserinfo.cuserinfo_id=aa.cuserinfo_id
            LEFT JOIN   tassessinfo ON tassessinfo.cnewsinfo_id=aa.cnewsinfo_id
            LEFT JOIN 	tnewstaginfo ON tnewstaginfo.cnewsinfo_id=aa.cnewsinfo_id
            LEFT JOIN 	ttaginfo ON tnewstaginfo.ctaginfo_id=ttaginfo.ctaginfo_id
            LEFT JOIN 	tmediainfo ON aa.cnewsinfo_id=tmediainfo.cnewsinfo_id
            GROUP BY  id, aa.cnewstitle
            ORDER BY aa.cnewsdate DESC 
                                        LIMIT $offset,$page_size");

                    while ($row = $res->fetch_assoc()) {
                        echo
                    "<div class='news_pop'>".
                        "<div class='news_pop_img'><a href='frm_news_detail.php?action=view&newsid=".$row["newsid"]."'><img src='upload/".$row["img"]."' alt='沒有正確的圖片路徑'></a></div>".
                        "<div class='news_pop_main'>";
                        if ($row["tagid"] !=""){
                            echo
                            "<div class='news_class'><a href='frm_news_view.php?action=class&tags=".$row["tagid"]."'><span class='news_clss_span'>".$row["tag"]."</span></a> </div>";
                        }
                        else{
                            // echo "";
                        }
                        echo
                            "<div class='news_title'><a href='frm_news_detail.php?action=view&newsid=".$row["newsid"]."'><span>".$row["title"]."</span></a></div>".
                            "<div class='news_icon_bar'>".
                                "<div class='news_distance news_icon_items'>".
                                    "<div class='news_distance_icon news_icon'>".
                                        "<i class='fas fa-map-marker-alt'></i>".
                                    "</div>".
                                    "<div class='news_distance_descr news_descr'>".
                                        "<a href='frm_news_map.php?action=search&X=".$row["locationX"]."&Y=".$row["locationY"]."'>".
                                            "<span>50220 Km</span>".
                                        "</a>".
                                    "</div>".
                                "</div>".
                                "<div class='news_views news_icon_items'>".
                                    "<div class='news_views_icon news_icon'>".
                                        "<i class='fas fa-eye'></i>".
                                    "</div>".
                                    "<div class='news_views_descr news_descr'>".
                                        "<span>".
                                            "20".
                                        "</span>".
                                    "</div>".
                                "</div>".
                                "<div class='news_rate news_icon_items'>".
                                    "<div class='news_rate_icon news_icon'>".
                                        "<i class='far fa-star'></i>                                   ".
                                    "</div>".
                                    "<div class='news_rate_descr news_descr'>".
                                        "<span>".$row["rate"]."</span>".
                                    "</div>".
                                "</div>".
                            "</div>".
                        "</div>".
                        "<div class='pers_card'>".
                            "<div class='pers_card_img'><a href='frm_news_view.php?action=pers&id=".$row["id"]."'><img src='img/".$row["id"].".png' alt='Not correct path'></a></div>".
                            "<div class='pers_card_name pers_card_items'>".
                                "<a href='frm_news_view.php?action=pers&id=".$row["id"]."'><span>".$row["nickname"]."</span></a>".
                            "</div>".
                            "<div class='pers_card_info'>".
                                "<div class='pers_card_post pers_card_items'>".
                                    "<span><i class='far fa-newspaper'></i></span>".
                                    "<a href='frm_news_view.php?action=pers&id=".$row["id"]."'><span>".$row["newspost"]."</span></a>".
                                "</div>".
                                "<div class='pers_card_rate pers_card_items'><i class='far fa-star'></i><span>".$row["rate"]."</span></div>".
                            "</div>".
                        "</div>".
                    "</div>".
                    "<hr class='news_hr'>";
                        }
                    }
                    echo "<div id='news_pops_pages' >";
                    if($page != 1) {
                        echo "<div>".
                                    "<a href=index.php?page=".($page - 1)."><span>上一頁</span></a>".
                            "</div>" ;              //如果表達式不是直接的變量，必須計算出來之後使用.連接
                    }
                        echo "<div id='page'>".
                                "<ul>";
                    for($i=1;$i<=$page_num;$i++){
                                    echo "<li><a href=index.php?page=".$i."><span>$i</span></a></li>";
                                }
                        echo    "</ul>".
                            "</div>";

                    if($page < $page_num) {
                        echo "<div>".
                            "<a href=index.php?page=".($page + 1)."><span>下一頁</span></a>".
                        "</div>";
                    }
                    echo                    "</div>";
                ?>
                    <!--    -------------lorem end ----------------- -->
                </div>
            </div>
            <div id="recommand_column">
                <div id="class_tags">
                    <div id="class_tags_caption">
                        <img src="img/background-transparent.png" alt="newsmaps分類標籤" class="transparent_img">
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
                        </ul>
                    </div>
                </div>
                <div id="recommand_top5">
                    <div id="recommand_top5_caption">
                        <img src="img/background-transparent.png" alt="newsmaps本周TOP5" class="transparent_img">
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
        $(function(){
            var len = 30; // 超過50個字以"..."取代
            $(".news_title_span").each(function(i){
                if($(this).text().length>len){
                    $(this).attr("title",$(this).text());
                    var text=$(this).text().substring(0,len-1)+"...";
                    $(this).text(text);
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>


