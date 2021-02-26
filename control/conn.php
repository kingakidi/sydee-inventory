<?php
      $conn = mysqli_connect('localhost', 'root', '', 'esphem');
      if (!$conn) {
         die("ERROR ON CONNECTION");
      }
      if(!isset($_SESSION)) 
      { 
         session_start(); 
      } 
      ob_start();

      // TESTING KEYS 
         $tPublic = 'FLWPUBK_TEST-dcf6418b844bc45ae0a7fc1382d927ff-X';
         $tSecret =  'FLWSECK_TEST-742b86bc586fb380baea0253ade116b8-X';

      //LIVE 
         $lPublic = 'pk_live_3bb0a9ce880cedc2dd3ef77f2904622aaa19c6a3';
         $lSecret = 'sk_live_7d7d1bfdf1fe365541168c8239fb75325136a7c6';

      // ROOT URL 
      $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

      $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );