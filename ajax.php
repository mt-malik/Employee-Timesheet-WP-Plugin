<?php
global $wpdb;
$orders = $wpdb->prefix."orders";

echo $_GET['post_id'];
echo $_GET['nonce'];
// die();
if ( !wp_verify_nonce( $_REQUEST['nonce'], "my_user_vote_nonce")) {
    exit("No naughty business please");
 }   

 $vote_count = get_post_meta($_REQUEST["post_id"], "votes", true);
 $vote_count = ($vote_count == '') ? 0 : $vote_count;
 $new_vote_count = $vote_count + 1;

 $vote = update_post_meta($_REQUEST["post_id"], "votes", $new_vote_count);

 if($vote === false) {
    $result['type'] = "error";
    $result['vote_count'] = $vote_count;
 }
 else {
    $result['type'] = "success";
    $result['vote_count'] = $new_vote_count;
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