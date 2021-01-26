<?php
global $wpdb;
$votes = $wpdb->prefix."votes";

// echo $_GET['post_id'];
// echo $_GET['nonce'];
// die();
if ( !wp_verify_nonce( $_REQUEST['nonce'], "my_user_vote_nonce")) {
   //  exit("No naughty business please");
 }   
 if(isset($_GET['post_id']) && $_GET['post_id']!=""){
   if(isset($_GET['nonce']) && $_GET['nonce']!=""){
      $get = $wpdb->get_row("select * from $votes where post_id='".$_GET['post_id']."' AND  nonce='".$_GET['nonce']."'",ARRAY_A);
      if($get == true){
         //Cannot vote
         // die("No naughty business please.");
      }else{
         //Can vote
         //  $vote_count = get_post_meta($_REQUEST["post_id"], "votes", true);
         //  $vote_count = ($vote_count == '') ? 0 : $vote_count;
         //  $new_vote_count = $vote_count + 1;
         //  $vote = update_post_meta($_REQUEST["post_id"], "votes", $new_vote_count); 
         if(isset($_GET['accept']) && $_GET['accept'] == '1'){
            $accept_count = get_post_meta($_REQUEST["post_id"], "accept", true);
            $accept_count = ($accept_count == '') ? 0 : $accept_count;
            $new_accept_count = $accept_count + 1;
            $accept = update_post_meta($_REQUEST["post_id"], "accept", $new_accept_count);
            //Insert into DB
            $insert_accept = "insert into $votes (post_id,nonce,accept) values(
               '".$_REQUEST['post_id']."','".$_REQUEST['nonce']."','1')";  
            echo $wpdb->query($insert_accept);
            /////
            if($accept === false && $insert_accept == false) {
               // $result['vote_count'] = $vote_count;
               $result['type'] = "error";
               $result['accept_count'] = $accept_count;
            }else{
               $result['type'] = "success";
               $result['accept_count'] = $new_accept_count;
            }
         }else if(isset($_GET['reject']) && $_GET['reject'] == '1'){
            $reject_count = get_post_meta($_REQUEST["post_id"], "reject", true);
            $reject_count = ($reject_count == '') ? 0 : $reject_count;
            $new_reject_count = $reject_count + 1;
            $reject = update_post_meta($_REQUEST["post_id"], "reject", $new_reject_count);
            //Insert into DB
            $insert_reject = "insert into $votes (post_id,nonce,reject) values(
               '".$_REQUEST['post_id']."','".$_REQUEST['nonce']."','1')";  
            echo $wpdb->query($insert_reject);
            /////
            if($reject === false && $insert_reject == false) {
               $result['type'] = "error";
               $result['accept_count'] = $reject_count;
            }else{
               $result['type'] = "success";
               $result['reject_count'] = $new_reject_count;
            }
         }
         
         // echo "<pre>";
         // print_r($result);
         // echo "</pre>";
         // die();
      }
   }
}


 if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $result = json_encode($result);
    echo $result;
 }
 else {
    header("Location: ".$_SERVER["HTTP_REFERER"]);
 }

 die();


?>