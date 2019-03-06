<?php
    $result = "";
    include_once("conn/_db_Config.php");
    // 登入
    if (isset($_POST["txtaccount"])) {
        // 取得欄位資料
        $strname = $_POST["txtaccount"];
        $strpassword = $_POST["txtloginpsd"];

        $struser_id = "";
        $strpsd = "";

        // 檢查是否有輸入欄位資料
        if ($strname != "") {

            $sql = "SELECT * FROM tuserinfo WHERE caccount='".$strname."'";

            //echo $sql;

            // 執行SQL指令
            $rows = mysqli_query($db,$sql); 
            $total_records = $rows->num_rows;

            //echo $total_records;
            if ($total_records == 0) 
            {
                prc_msg("帳號錯誤，請重新輸入");

            } else {

                while ($row = $rows->fetch_assoc()) {
                    $struser_id = $row["cuserinfo_id"]; 
                    $saaccount=$row["caccount"];
                    $strpsd = $row["cpassword"];                                  
                }

                // 密碼，使用SHA1加密處理。
                $strencpassword = sha1($strpassword);

                if($strencpassword != $strpsd)
                {
                    prc_msg("密碼錯誤，請重新輸入。");

                } else {
                    // 啟動 Session
                    session_start();
                    // 寫入 Session 變數值
                    // $_SESSION['ws_account']=$saaccount;
                    $_SESSION['ws_account_id'] = $struser_id;

                    // prc_msgto("index.php");
                    echo "<script language=\"javascript\">"; 
		            echo "location.href='index.php'"; 
		            echo "</script>";
                }
            }            
        }
    }


    // 是否是表單送回(註冊)
    if (isset($_POST["txtname"])) {

        // 取得欄位資料
        $strname = $_POST["txtname"];
        $strpassword = $_POST["txtpassword"];
		$strnicename = $_POST["txtnicename"];

        // 檢查是否有輸入欄位資料
        if ($strname != "") {
			
            //檢查帳號是否重覆。返回真的話，就執行此IF，否則就執行ELSE
            if (prc_chk($db, $strname))
            {
                //密碼，使用SHA1加密處理。
                $strencpassword = sha1($strpassword);

                // 建立SQL字串
                $sql = "INSERT INTO tuserinfo ( caccount, cpassword, cnicename, ccreatedate) values('";
                $sql.= $strname."', '".$strencpassword."', '".$strnicename."',now())";

                //echo $sql;

                if (!mysqli_query($db,$sql)) { // 執行SQL指令
                    $result = "註冊失敗<br/>" . mysqli_error();
                }
                else {

                    //依mysqli_insert_id函數，取得最新新增的auto_increment的值。
                    $intresult_id = mysqli_insert_id($db);

                    // 啟動 Session
                    session_start();

                    // 寫入 Session 變數值
                    $_SESSION['ws_account_id'] = $intresult_id;

                    prc_msgto("註冊成功！","index.php");

                }

                mysqli_close($db); // 關閉連接         
            } else 
            {
                prc_msg("帳號重覆，請重新輸入");
            }
        }
    }

    function prc_chk($db, $straccount)
    {
        
        $sql = "SELECT * FROM tuserinfo WHERE caccount='".$straccount."'";

        //echo $sql;

        $rows = mysqli_query($db,$sql); // 執行SQL指令
        //把資料記錄在total_records 
        $total_records = $rows->num_rows;
        //先假定$bolcheck是錯的，後面再用
        $bolcheck = false;        
        //如果紀錄total_records是0，也就是沒有資料傳入，也就是SQL找不到東西，也就是沒有上面SQL的WHERE裡限定的帳號，也就是這個帳號目前是沒人註冊，那就讓他為真
        if ($total_records == 0) 
        {
            $bolcheck = true;
        }
        //返回真。真假作用取決於創作者，此支程式的作用在上面的註冊IF ELSE語法可以看出來
        return $bolcheck;
    }

    function prc_msg($msg)
    {
        echo "<SCRIPT Language=javascript>"; 
        echo "window.alert('".$msg."')"; 
        echo "</SCRIPT>"; 
        return; 
    }

    function prc_msgto($msg,$redirect){ 
		echo "<SCRIPT Language=javascript>"; 
		echo "window.alert('".$msg."')"; 
		echo "</SCRIPT>"; 
		echo "<script language=\"javascript\">"; 
		echo "location.href='".$redirect."'"; 
		echo "</script>";
		return; 
	} 

    ?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NewsMap 登入-註冊</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="css/frm_login.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <style>
      #news_pers_inf_area a{
          cursor: context-menu;
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
                        <form class="form-inline">
                            <input class="form-control mr-sm-2 bg-light" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0 bg-light" type="submit">Search</button>
                        </form>
                    </nav>
                </div>
            </div>
            <div id="news_pers_inf_area">
                <div id="pers_descr">
                    <div id="pers_desc-1">
                        <div id="pers_name"><a href=""><span>訪客</span></a></div>
                        <!-- <div id="pers_location"><i class="fas fa-map-marker-alt"></i><a href=""><span>台中市</span></a> </div> -->
                    </div>
                    <!-- <div id="pers_desc-2"><span>發布<a href="">1000</a>則新聞</span></div> -->
                </div>
                <div id="pers_icon"><a href=""><span><img src="img/0.png" alt="頭像"></span></a> </div>
            </div>


        </header>

        
        <main>
            <div id="checkView">
                <div id="loginView" class="login_signup_view">
                    <form action="frm_login.php" method="POST">
                        <div class="inputView">
                            <div class="editTxt">
                                <label >
                                    <span>帳號</span>
                                    <input type="text" name="txtaccount" id="txtaccount" placeholder="輸入您的帳號">
                                </label>
                            </div>
                            <div class="editTxt">
                                <label>
                                    <span>密碼</span>
                                    <input type="password" name="txtloginpsd" id="txtloginpsd" placeholder="輸入您的密碼">
                                </label>
                            </div>
                        </div>
                        <div class="okBtn">
                            <input type="submit" value="登入" name="btnSingup" id="btnSingup">
                        </div>
                    </form>
                </div>
                <div id="signupView" class="login_signup_view">
                    <form action="frm_login.php" method="POST">
                        <div class="inputView">
                            <div class="editTxt">
                                <label>
                                    <span>暱稱</span>
                                    <input type="text" name="txtnicename" id="txtnicename" placeholder="輸入您的暱稱">
                                </label></div>
                            <div class="editTxt">
                                <label>
                                    <span>帳號</span>
                                    <input type="text" name="txtname" id="txtname" placeholder="輸入您的帳號">
                                </label></div>
                            <div class="editTxt">
                                <label>
                                    <span>密碼</span>
                                    <input type="password" name="txtpassword" id="txtpassword" placeholder="輸入您的密碼">
                                </label>
                            </div>
                        </div>
                        <div class="okBtn">
                            <input type="submit" value="註冊" name="btnSave" id="btnSave" >
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script type="text/javascript">
        $(function () {

            $('#btnSingup').click(function (ev) {
                $(this).attr("disable", "disable");
               
                var errMsg = [];

                if ($('#txtaccount').val() == '') { errMsg.push("請輸入帳號"); }
                
                if ($('#txtloginpsd').val() == '') { errMsg.push("請輸入密碼"); }
                                                    
                if (errMsg.length) { alert(errMsg.join('\n')); $(this).removeAttr("disabled"); return false; }
                else { return true; }
            });

            $('#btnSave').click(function (ev) {
                $(this).attr("disable", "disable");
               
                var errMsg = [];

                if ($('#txtname').val() == '') { errMsg.push("請輸入帳號"); }
				
				if ($('#txtpassword').val() == '') { errMsg.push("請輸入密碼"); }
				
				if ($('#txtnicename').val() == '') { errMsg.push("請輸入暱稱"); }
						                
                if (errMsg.length) { alert(errMsg.join('\n')); $(this).removeAttr("disabled"); return false; }
                else { return true; }
            });            
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>


