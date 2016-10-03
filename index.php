<html>
<head>
    <meta charset="utf-8">
    <title>CPU OPcache Testing...</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet"  href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        blink, .blink {
          -webkit-animation: blink 1s step-end infinite;
          -moz-animation: blink 1s step-end infinite;
          -o-animation: blink 1s step-end infinite;
          animation: blink 1s step-end infinite;
      }

      @-webkit-keyframes blink {
          67% { opacity: 0 }
      }

      @-moz-keyframes blink {
          67% { opacity: 0 }
      }

      @-o-keyframes blink {
          67% { opacity: 0 }
      }

      @keyframes blink {
          67% { opacity: 0 }
      }
  </style>
</head>
<body>

    <?php
    @session_start();
    $time = 10;
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


    // แบบไม่กระจายงาน
    `sudo rm -f /tmp/t1_d.txt`; 
    `sudo rm -f /tmp/t4_*.txt`; 
    `rm -f /tmp/t1_d.txt`; 
    `rm -f /tmp/t4_*.txt`; 
    ob_flush(); flush();
    $check_opc = `php -v | grep OPcache`;
    if($check_opc == null || $check_opc == ""){
        echo "<div class=\"alert alert-danger\">\n";
        echo "<center>"; 
        echo "<blink>สถานะ OPcache <strong>ปิดใช้งานอยู่ในขณะนี้!</strong></blink> \n"; 
        echo "</center>"; 
        echo "</div>\n";
    }else {
        echo "<div class=\"alert alert-success\">\n";
        echo "<center>";  
        echo "<blink>สถานะ OPcache <strong>เปิดใช้งานอยู่ในขณะนี้!</strong></blink> \n"; 
        echo "</center>"; 
        echo "</div>\n";
    }
    if (!isset($_POST['submit_1']) || !isset($_POST['submit_4'])){

        echo "<form method='POST' action=\"\">";
    //echo "<center><input type=\"number\" name=\"time\" id=\"time\" min=\"1\">\n</center><br>";
        echo "<center><input class=\"cpu_1\" type=\"submit\" name=\"submit_1\" value=\"เริ่มประมวณผลแบบ 1 cpu\">\n";
        echo "<input class=\"cpu_4\" type=\"submit\" name=\"submit_4\" value=\"เริ่มประมวณผลแบบ 4 cpu\">\n";
        echo "<input class=\"clear\" type=\"submit\" name=\"clear\" value=\"ล้าง\">\n</center>";
        echo "</form>";
    }

    function getdata_t1_d(){
        if(file_exists("logs/t1_d.txt")){
            $file_t1_d = fopen("logs/t1_d.txt", "r") or die("Unable to open file!");
            $_t1 = fread($file_t1_d,filesize("logs/t1_d.txt"));
            fclose($file_t1_d);

            $ex = explode("\n",$_t1);
            $size = sizeof($ex);
            $size -= 1;
            $count_t1_d = 0;

            for($i=0; $i<$size; $i++){
                $count_t1_d += $ex[$i];
            }

            $res_t1_d = $count_t1_d/$size;
            $data = array("res" => $res_t1_d,"count" => $size);
            return $data;
        }else 
        $data = array("res" => 0,"count" => 0);
        return $data;
            //echo "<br> total op dis = $res_t1_d";
    }
    function getdata_t1_e(){
        if(file_exists("logs/t1_e.txt")){
            $file_t1_e = fopen("logs/t1_e.txt", "r") or die("Unable to open file!");
            $_t1 = fread($file_t1_e,filesize("logs/t1_e.txt"));
            fclose($file_t1_e);

            $ex = explode("\n",$_t1);
            $size = sizeof($ex);
            $size -= 1;
            $count_t1_e = 0;

            for($i=0; $i<$size; $i++){
                $count_t1_e += $ex[$i];
            }

            $res_t1_e = $count_t1_e/$size;
            $data = array("res" => $res_t1_e,"count" => $size);
            return $data;
        }else
        $data = array("res" => 0,"count" => 0);
        return $data;
            //echo "<br> total op dis = $res_t1_d";
    }
    function getdata_t4_d(){
        if(file_exists("logs/t4_d.txt")){
            $file_t4_d = fopen("logs/t4_d.txt", "r") or die("Unable to open file!");
            $_t4 = fread($file_t4_d,filesize("logs/t4_d.txt"));
            fclose($file_t4_d);

            $ex = explode("\n",$_t4);
            $size = sizeof($ex);
            $size -= 1;
            $count_t4_d = 0;

            for($i=0; $i<$size; $i++){
                $count_t4_d += $ex[$i];
            }
            $count_res = $size/4;

            $res_t4_d = $count_t4_d/$count_res;

                /// นำผลลัพธ์การบวกของ t4 op dis ไปเก็บไว้ที่ logs/t4_d_res

            $data = array("res" => $res_t4_d,"count" => $count_res);
            return $data;
        }else
        $data = array("res" => 0,"count" => 0);
        return $data;
            //echo "<br> total op dis = $res_t1_d";
    }
    function getdata_t4_e(){
        if(file_exists("logs/t4_e.txt")){
            $file_t4_e = fopen("logs/t4_e.txt", "r") or die("Unable to open file!");
            $_t4 = fread($file_t4_e,filesize("logs/t4_e.txt"));
            fclose($file_t4_e);

            $ex = explode("\n",$_t4);
            $size = sizeof($ex);
            $size -= 1;
            $count_t4_e = 0;

            for($i=0; $i<$size; $i++){
                $count_t4_e += $ex[$i];
            }
            $count_res = $size/4;

            $res_t4_e = $count_t4_e/$count_res;

                /// นำผลลัพธ์การบวกของ t4 op dis ไปเก็บไว้ที่ logs/t4_d_res

            $data = array("res" => $res_t4_e,"count" => $count_res);
            return $data;
        }else
        $data = array("res" => 0,"count" => 0);
        return $data;
            //echo "<br> total op dis = $res_t1_d";
    }

    // กรณี T1 ไม่เปิด OPcache
    ////-----------------------------------------------------------------------------------------------------////
    if(isset($_POST['submit_1'])){
        //$time = $_POST['time'];
        if($time != 0){
            if($check_opc == null || $check_opc == ""){
                $zstart_time=time(); 
                $diff=0;

                for($n=1;$diff<$time;$n++){
                    $x=rand(500, 15000)^5;
                    $fact1 = $x*floor(log($x,10)) ; // 5 * 4 * 3 * 2 * 1
                    `echo "$n. $fact1" >> /tmp/t1_d.txt`;  
                    $zend_time=time(); 
                    $diff=$zend_time-$zstart_time;
                }

                $n = $n - 1 ;
                // อ่านไฟล์ t1 ไม่เปิด opcache
                $myfile = file_put_contents('logs/t1_d.txt', "{$n}\n",FILE_APPEND);

                
        ////-----------------------------------------------------------------------------------------------------////
            }else {
        // กรณี T1 เปิด OPcache
        ////-----------------------------------------------------------------------------------------------------////
                $zstart_time=time(); 
                $diff=0;

                for($n=1;$diff<$time;$n++){
                    $x=rand(500, 15000)^5;
                    $fact1 = $x*floor(log($x,10)) ; // 5 * 4 * 3 * 2 * 1
                    `echo "$n. $fact1" >> /tmp/t1_e.txt`;  
                    $zend_time=time(); 
                    $diff=$zend_time-$zstart_time;
                }
                $n = $n - 1 ;
                // อ่านไฟล์ t1 ไม่เปิด opcache
                $myfile = file_put_contents('logs/t1_e.txt', "{$n}\n",FILE_APPEND);

        ////-----------------------------------------------------------------------------------------------------////

            }
        }
    }else if(isset($_POST['submit_4'])){
        //$time = $_POST['time'];
        if($check_opc == null || $check_opc == ""){
            $mh = curl_multi_init();
            $fnum=4;
            for($k=1;$k<=$fnum;$k++){
                // create both cURL resources
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_VERBOSE, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // ต้องเพิ่มเข้าไป
                curl_setopt($ch, CURLOPT_TIMEOUT, 1800); // 1800 sec=30 minutes for execution timeout
                curl_setopt($ch, CURLOPT_COOKIESESSION, false);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); // 60 sec=1 minute for connection timeout
                curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
                curl_setopt($ch, CURLOPT_POST, true);
                // set URL and other appropriate options
                curl_setopt($ch, CURLOPT_URL, "{$actual_link}t4_part.php?part=$k&cmd=op-dis&time={$time}");
                //add the two handles
                curl_multi_add_handle($mh,$ch);
            }
            $running=null;
            //execute the handles
            do {
                usleep(1000);
                curl_multi_exec($mh,$running);
            } while ($running > 0);

            // นำผลที่อยู่ในไฟล์  /tmp/t4_1.txt, /tmp/t4_2.txt, /tmp/t4_3.txt, /tmp/t4_4.txt มารวมกัน

            //echo "finish...<br>";

        }else {
            $mh = curl_multi_init();
            $fnum=4;
            for($k=1;$k<=$fnum;$k++){
                // create both cURL resources
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_VERBOSE, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // ต้องเพิ่มเข้าไป
                curl_setopt($ch, CURLOPT_TIMEOUT, 1800); // 1800 sec=30 minutes for execution timeout
                curl_setopt($ch, CURLOPT_COOKIESESSION, false);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); // 60 sec=1 minute for connection timeout
                curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
                curl_setopt($ch, CURLOPT_POST, true);
                // set URL and other appropriate options
                curl_setopt($ch, CURLOPT_URL, "{$actual_link}t4_part.php?part=$k&cmd=op-en&time={$time}");
                //add the two handles
                curl_multi_add_handle($mh,$ch);
            }
            $running=null;
            //execute the handles
            do {
                usleep(1000);
                curl_multi_exec($mh,$running);
            } while ($running > 0);

            // นำผลที่อยู่ในไฟล์  /tmp/t4_1.txt, /tmp/t4_2.txt, /tmp/t4_3.txt, /tmp/t4_4.txt มารวมกัน

            //echo "finish...<br>";


        }

    }else if(isset($_POST['clear'])){
        `rm logs/*.txt `;
    }

    
////////////////////////////////////////////////////////////////////////////////////////////
    $res_t1_d = getdata_t1_d();
    $res_t1_e = getdata_t1_e();
    $res_t4_d = getdata_t4_d();
    $res_t4_e = getdata_t4_e();

        //echo "T1 Dis = {$res_t1_d['res']} count = {$res_t1_d['count']}<br>";
        //echo "T1 En = {$res_t1_e['res']} count = {$res_t1_e['count']}<br>";
        //echo "T4 Dis = {$res_t4_d['res']} count = {$res_t4_d['count']}<br>";
        //echo "T4 En = {$res_t4_e['res']} count = {$res_t4_e['count']}<br>";


    

    $font_color_e = "<center><font color='green'>เปิด</font></center>";
    $font_color_d = "<center><font color='blue'>ปิด</font></center>";
    $font_cpu_1 = "<font color='#cc66ff'>CPU 1 core</font>";
    $font_cpu_4 = "<font color='#cc6600'>CPU 4 core</font>";

    echo "<canvas id=\"myChart\" width=\"100%\" height=\"26%\"></canvas>\n";

    echo "<div class=\"container\">\n"; 

    echo "  <table class=\"table table-sm table-hover\">\n"; 
    echo "    <thead>\n"; 
    echo "      <tr>\n";  
    echo "        <th><center>CPU</center></th>\n"; 
    echo "        <th><center>สถานะ OPcache</center></th>\n"; 
    echo "        <th><center>จำนวนการรัน(ครั้ง)</center></th>\n"; 
    echo "        <th><center>ค่าเฉลี่ย (loop)</center></th>\n";
    echo "      </tr>\n"; 
    echo "    </thead>\n"; 
    echo "    <tbody>\n"; 
    echo "      <tr>\n"; 
    echo "        <td>{$font_cpu_1}</td>\n"; 
    echo "        <td><font>{$font_color_d}</font></td>\n"; 
    echo "        <td><center>{$res_t1_d['count']}</center></td>\n"; 
    echo "        <td><center><font color='#cc66ff'>{$res_t1_d['res']}</center></td>\n"; 
    echo "      </tr>\n"; 
    echo "      <tr>\n"; 
    echo "        <td>{$font_cpu_1}</td>\n"; 
    echo "        <td>{$font_color_e}</td>\n"; 
    echo "        <td><center>{$res_t1_e['count']}</center></td>\n"; 
    echo "        <td><center><font color='#cc66ff'>{$res_t1_e['res']}</center></td>\n"; 
    echo "      </tr>\n";
    echo "      <tr>\n"; 
    echo "        <td>{$font_cpu_4}</td>\n"; 
    echo "        <td>{$font_color_d}</td>\n"; 
    echo "        <td><center>{$res_t4_d['count']}</center></td>\n"; 
    echo "        <td><center><font color='#cc6600'>{$res_t4_d['res']}</center></td>\n"; 
    echo "      </tr>\n";
    echo "      <tr>\n"; 
    echo "        <td>{$font_cpu_4}</td>\n"; 
    echo "        <td>{$font_color_e}</td>\n"; 
    echo "        <td><center>{$res_t4_e['count']}</center></td>\n"; 
    echo "        <td><center><font color='#cc6600'>{$res_t4_e['res']}</center></td>\n"; 
    echo "      </tr>\n";
    echo "    </tbody>\n"; 
    echo "  </table>\n"; 
    echo "</div>\n";

    echo "<script>";
    echo "
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [''],
            datasets: [
            {
                label: ['CPU 1 core Opcache [Disabled]'],
                data: [{$res_t1_d['res']}],
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                'rgba(255,99,132,1)',
                ],
                borderWidth: 2
            },
            {
                label: ['CPU 1 core Opcache [Enabled]'],
                data: [{$res_t1_e['res']}],
                backgroundColor: [
                'rgba(255, 179, 102, 0.2)',
                ],
                borderColor: [
                'rgba(255, 102, 0, 1)',
                ],
                borderWidth: 2
            },
            {
                label: ['CPU 4 core Opcache [Disabled]'],
                data: [{$res_t4_d['res']}],
                backgroundColor: [
                'rgba(153, 255, 102, 0.2)',
                ],
                borderColor: [
                'rgba(51, 204, 51, 1)',
                ],
                borderWidth: 2
            },
            {
                label: ['CPU 4 core Opcache [Enabled]'],
                data: [{$res_t4_e['res']}],
                backgroundColor: [
                'rgba(204, 255, 255, 0.2)',
                ],
                borderColor: [
                'rgba(102, 204, 255, 1)',
                ],
                borderWidth: 2
            },

            ]
        },
        options: {
            title: {
                display: true,
                text: 'กราฟแสดงผล',
                fontSize: 18,
            },
            scales: {
                yAxes: [{

                    ticks: {
                        beginAtZero:true,
                        display: true,
                        fontSize: 15,
                    }
                }]
            }
        }
    });
    ";

    

    ?>
</script>
</body>
</html>
