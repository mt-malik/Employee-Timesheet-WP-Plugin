<?php
// $custom_content = 'YOUR CONTENT GOES HERE';
   // $custom_content .= $content;
   // return $custom_content;
   // $meta = get_post_meta(get_the_ID(), '', true);
   // print_r($meta);
//    echo get_post_type();
//    if ( is_user_logged_in() ) {
if(  get_post_type() == "timesheets"){
      $post_metas = get_post_meta(get_the_ID());
      $post_key = array_keys($post_metas);
      $post_metas = array_combine($post_key, array_column($post_metas, '0'));
if($post_metas['Employee'] == get_current_user_id() or current_user_can('administrator')){ 
   ?>
<style>
.accept {
  color: #FFF;
  background: #44CC44;
  padding: 15px 20px;
  box-shadow: 0 4px 0 0 #2EA62E;
}
.accept:hover {
  background: #6FE76F;
  box-shadow: 0 4px 0 0 #7ED37E;
  color: #fff;
}
.deny {
  color: #FFF;
  background: tomato;
  padding: 15px 20px;
  box-shadow: 0 4px 0 0 #CB4949;
}
.deny:hover {
  background: rgb(255, 147, 128);
  box-shadow: 0 4px 0 0 #EF8282;
  color: #fff;
}
ul.likes {
    padding-top: 15px;
}
ul.likes li {
    list-style: none;
    display: inline-block;
}
</style>
   <table>
      <tr>
         <th>Name</th>
         <th>Value</th>
      </tr>
      <tr>
         <th>Employee</th>
         <td><?php 
            $user_info = get_userdata($post_metas['Employee']);
            echo $user_info->user_login; ?></td>
      </tr>
      <tr>
         <th>Monday</th>
         <td><?php echo $post_metas['Monday']; ?></td>
         <!-- <td><?php echo $post_metas[$post_key['0']]; ?></td> -->
      </tr>
      <tr>
         <th>Tuesday</th>
         <td><?php echo $post_metas['Tuesday']; ?></td>
      </tr>
      <tr>
         <th>Wednesday</th>
         <td><?php echo $post_metas['Wednesday']; ?></td>
      </tr>
      <tr>
         <th>Thursday</th>
         <td><?php echo $post_metas['Thursday']; ?></td>
      </tr>
      <tr>
         <th>Friday</th>
         <td><?php echo $post_metas['Friday']; ?></td>
      </tr>
      <tr>
         <th>Saturday</th>
         <td><?php echo $post_metas['Saturday']; ?></td>
      </tr>
      <tr>
         <th>Sunday</th>
         <td><?php echo $post_metas['Sunday']; ?></td>
      </tr>
      <tr>
      <?php
      //   $votes = $post_metas['votes'];
      //   $votes = ($votes == "") ? 0 : $votes;
         $accept = $post_metas['accept'];
         $accept = ($accept == "") ? 0 : $accept;
         $reject = $post_metas['reject'];
         $reject = ($reject == "") ? 0 : $reject;
         ?>
            <!-- This post has <span id='vote_counter'><?php echo $votes ?></span> votes<br> -->
        <?php
        $nonce = wp_create_nonce("my_user_vote_nonce");
            $link = admin_url('admin-ajax.php?action=my_user_vote&post_id='.get_the_ID().'&nonce='.$nonce);
            // echo '<a class="user_vote" data-nonce="' . $nonce . '" data-post_id="' . $post_ID . '" href="' . $link . '">vote for this article</a>';
        ?>
         <th>Reaction</th>
         <td>
            <!-- <span id='vote_counter'><?php echo '<a class="user_vote" data-nonce="' . $nonce . '" data-post_id="' . $post_ID . '" href="' . $link . '">Vote</a>'; echo '('.$votes.')'; ?></span> -->
         <ul class="likes">
                <li class="accept_item">
                    <?php echo '<a class="user_vote accept" data-nonce="' . $nonce . '" data-post_id="' . $post_ID . '" href="' . $link . '&accept=1">Accept('.$accept.')</a>'; ?>
                </li>
                <li class="reject_item">
                    <?php echo '<a class="user_vote deny" data-nonce="' . $nonce . '" data-post_id="' . $post_ID . '" href="' . $link . '&reject=1">Reject('.$reject.')</a> '; ?>
                </li>
            </ul>
        </td>
      </tr>
   </table>
   <?php
   // echo "<pre>";
   // print_r($post_metas);
   // echo "</pre>";
}else{
    if ( is_user_logged_in() ) {
        echo "This post is not linked to you.";
    }
}
   }
// }else{
//    echo "Login to view this.";
// }
?>