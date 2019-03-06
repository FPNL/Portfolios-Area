<?php

session_start();
//Connect
include_once("conn/_db_Config.php");

    $newsid = $_GET["newsid"];          // 取得URL參數的編號
    $action = $_GET["action"];  // 取得操作種類
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    }
    else {
        $page = 1;
    }
    if (isset($_SESSION['ws_account_id'])) {
        $struser_id = $_SESSION['ws_account_id'];
    }
    else {
        $struser_id = "1";
    }
    // 執行的操作
    switch ($action) {
        case "view": // 更新操作
            // 取得欄位資料
            $sql_read ="SELECT  tuserinfo.cuserinfo_id AS id, 
                                tuserinfo.cnicename AS nickname,
                                tuserinfo.caccount AS account,
                                aa.cnewsinfo_id AS newsid,
                                aa.cnewstitle AS title,
                                aa.`cnewscontent` AS content,
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
                        WHERE aa.cnewsinfo_id=".$newsid." 
                        GROUP BY  id, aa.cnewstitle";
    // echo $sql."<br>";
            $rows_read = mysqli_query($db,$sql_read);

            while ($row_read = $rows_read->fetch_assoc()) {
                $id_read=$row_read["id"];
                $nickname_read=$row_read["nickname"];
                $account_read=$row_read["account"];
                $newsid_read=$row_read["newsid"];
                $title_read=$row_read["title"];
                $content_read=$row_read["content"];
                $rate_read=$row_read["rate"];
                $newspost_read=$row_read["newspost"];
                $locationX_read=$row_read["locationX"];
                $locationY_read=$row_read["locationY"];
                $tagid_read=$row_read["tagid"];
                $tag_read=$row_read["tag"];
                $tag_date=$row_read["cdate"];
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
    <title>NewsMaps新聞內容</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/newscontent.css">
    <!-- <link rel="stylesheet" href="sass/default.css"> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <style>
       @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);

        fieldset, label { 
            margin: 0; 
            padding: 0; 
            /* width: 100%; */
        }
        /****** Style Star Rating Widget *****/

        .rating { 
        border: none;
        /* float: left; */
        }

        .rating > input { display: none; } 
        .rating > label:before { 
        margin: 4px;
        font-size: 24pt;
        font-family: FontAwesome;
        display: inline-block;
        content: "\f005";
        }

        .rating > .half:before { 
        content: "\f089";
        position: absolute;
        }

        .rating > label { 
        color: #ddd; 
        float: right; 
        }

        /***** CSS Magic to Highlight Stars on Hover *****/

        .rating > input:checked ~ label, /* show gold star when clicked */
        .rating:not(:checked) > label:hover, /* hover current star */
        .rating:not(:checked) > label:hover ~ label { color: #fe0f6d;  } /* hover previous stars in list */

        .rating > input:checked + label:hover, /* hover current star when changing rating */
        .rating > input:checked ~ label:hover,
        .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
        .rating > input:checked ~ label:hover ~ label { color: #f94d91;  } 

        .form-control {
            margin-top: 6px;
        } 
        #pers_location a {
  color: #fff;
}
    </style>
</head>
<body  style="background-color:#f6f6f6;">
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
            
            
            //將資料庫裡的所有會員資料顯示在畫面上
            // $sql = "SELECT tuserinfo.`cuserinfo_id` AS id, cnicename, COUNT(cnewstitle) AS newspost
            //         FROM `tuserinfo` LEFT JOIN tnewsinfo ON tuserinfo.cuserinfo_id = tnewsinfo.cuserinfo_id
            //         WHERE tuserinfo.cuserinfo_id=".$struser_id.
            //         "GROUP BY tuserinfo.cuserinfo_id, cnicename";
            $sql_pers =  "SELECT  tuserinfo.cuserinfo_id AS id, 
                            tuserinfo.cnicename AS nickname,
                            tuserinfo.caccount AS account,
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
                    WHERE tuserinfo.cuserinfo_id=".$struser_id."
                    GROUP BY  id, aa.cnewstitle
                    LIMIT 1";


            $rows_pers = mysqli_query($db,$sql_pers);
            // while($row = mysql_fetch_row($result)){
            while ($row_pers = $rows_pers->fetch_assoc()) {
            
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
        }}
        ?>


        </header>
        <main> 
            <div id="news_content_column">
                <div id="news_content_caption">
                    <span>
                        <?php echo $title_read; ?>
                    </span>
                </div>
                <div id="news_content_main">
                    <div id="news_content_main_1">
                        <div id="public_date"><span><?php echo $tag_date; ?></span></div>
                        <div id="return_list"><a href=""><span></span></a></div>
                    </div>
                    <div id="news_content_main_2">
                        <?php
                        echo
                        "<div id='news_class'><a href='frm_news_view.php?action=class&tags=".$tagid_read."'><span class='news_clss_span'>".$tag_read."</span></a> </div>"
                        ?>
                        <div id="news_icon_bar">
                            <div class="news_distance news_icon_items">
                                <div class="news_distance_icon news_icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="news_distance_descr news_descr">
                                    <a><span>450 KM</span></a>
                                </div>
                            </div>
                            <div class="news_views news_icon_items">
                                <div class="news_views_icon news_icon">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="news_views_descr news_descr">
                                    <span>
                                        20
                                    </span>
                                </div>
                            </div>
                            <div class="news_rate news_icon_items">
                                <div class="news_rate_icon news_icon">
                                    <i class="far fa-star"></i>                                   
                                </div>
                                <div class="news_rate_descr news_descr">
                                    <span>
                                        <?php echo $rate_read;?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="news_content_main_3">
                        <?php echo $content_read; ?>
                    </div>
                    <div id="news_content_main_4">
                        <div id="news_content_main4_icon" class="news_content_icon"><img src="img/0.png" alt=""></div>
                        <div id="news_content_ration">
                            <div id="news_content_rate_descr">
                            <?php echo     
                            "<span>此則新聞由<a href='frm_news_view.php?action=pers&id=".$id_read."'>".$nickname_read."</a> 發佈<br></span>";
                            ?>

                                <span>覺得新聞不錯嗎?請給我鼓勵!</span>
                            </div>
                            <div id="news_content_rate">
                                <form action="">
                                    <fieldset class="rating">
                                        <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                        <input type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                        <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                        <input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                        <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                        <input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                        <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                        <input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                        <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                        <input type="radio" id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <?php
                        if($struser_id==""){

                        }
                        else if($struser_id==$id_read){
                            echo 
                        "<div id='news_trim'>".
                            "<a href='frm_news_edit.php?action=edit&newsid=".$newsid."'> ".
                                "<span>修改新聞</span> ".
                            "</a>".
                        "</div>";
                        }
                        
                        ?>
                    </div>
                        
                </div>
                <div id="review">
                    <!-- <form action="">
                        <div id="review_caption">
                            <span>留言討論</span>
                        </div>
                        <div id="review_content">
                            <div class='form-group pl-3 font-weight-bold'>
                                <label for='exampleFormControlTextarea1'>新聞內容</label>
                                <textarea class='form-control' placeholder="新增公開留言" name='' id='exampleFormControlTextarea1' rows='8'></textarea>
                            </div>
                        </div>
                        <div id="review_submit">
                            <input type="submit" value="送出留言">
                        </div>
                    </form> -->
                </div>
                <div id="comment_section">
                        <!-- <div class="comment">
                            <div class="news_content_icon">
                                <img src="img/0.png" alt="">
                            </div>
                            <div class="comment_main">
                                <div class="comment_pers_name"><span>Say:</span></div>
                                <div class="comment_descr">
                                I love You Very much more than any others!
                                </div>
                            </div>
                        </div> -->
                    
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
                        $sql_recommand = "SELECT  tuserinfo.cuserinfo_id AS id, 
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
                                $rows = mysqli_query($db,$sql_recommand);
                                // while($row = mysql_fetch_row($result)){
                                while ($row_recommand = $rows->fetch_assoc()) 
                                echo
                        "<div class='recommand_top5_news'>".
                            "<div class='recommand_top5_news_class'><a href='frm_news_view.php?action=class&tags=".$row_recommand["tagid"]."'><span>".$row_recommand["tag"]."</span></a></div>".
                            "<div class='recommand_top5_news_title'><a href='frm_news_detail.php?action=view&newsid=".$row_recommand["newsid"]."'><span>".$row_recommand["title"]."</span></a></div>".
                        "</div>".
                        "<hr class='recommand_top5_news_hr'>";

                        ?>
                        <hr class="recommand_top5_news_hr">
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
    <script src="js/newscontent.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>


