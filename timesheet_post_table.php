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
         <th><?php echo $post_key['0']; ?></th>
         <td><?php echo $post_metas[$post_key['0']]; ?></td>
      </tr>
      <tr>
         <th><?php echo $post_key['1']; ?></th>
         <td><?php echo $post_metas[$post_key['1']]; ?></td>
      </tr>
      <tr>
         <th><?php echo $post_key['2']; ?></th>
         <td><?php echo $post_metas[$post_key['2']]; ?></td>
      </tr>
      <tr>
         <th><?php echo $post_key['3']; ?></th>
         <td><?php echo $post_metas[$post_key['3']]; ?></td>
      </tr>
      <tr>
         <th><?php echo $post_key['4']; ?></th>
         <td><?php echo $post_metas[$post_key['4']]; ?></td>
      </tr>
      <tr>
         <th><?php echo $post_key['5']; ?></th>
         <td><?php echo $post_metas[$post_key['5']]; ?></td>
      </tr>
      <tr>
         <th><?php echo $post_key['6']; ?></th>
         <td><?php echo $post_metas[$post_key['6']]; ?></td>
      </tr>
      <tr>
      <?php
        $votes = $post_metas['votes'];
        $votes = ($votes == "") ? 0 : $votes;
            ?>
            <!-- This post has <span id='vote_counter'><?php echo $votes ?></span> votes<br> -->
        <?php
        $nonce = wp_create_nonce("my_user_vote_nonce");
            $link = admin_url('admin-ajax.php?action=my_user_vote&post_id='.get_the_ID().'&nonce='.$nonce);
            // echo '<a class="user_vote" data-nonce="' . $nonce . '" data-post_id="' . $post_ID . '" href="' . $link . '">vote for this article</a>';
        ?>
         <th>Reaction</th>
         <td>
            <span id='vote_counter'><?php echo '<a class="user_vote" data-nonce="' . $nonce . '" data-post_id="' . $post_ID . '" href="' . $link . '">Vote</a>'; echo '('.$votes.')'; ?></span>
         <!-- <ul class="likes">
                <li class="likes__item likes__item--like">
                    <a href="#">
                        Like (0)
                    </a>
                </li>
                <li class="likes__item likes__item--dislike">
                    <a href="#">
                        Dislike (0)
                    </a>
                </li>
            </ul> -->
        </td>
      </tr>
   </table>
   <?php
   
//    echo "<pre>";
//    print_r($post_metas);
//    echo "</pre>";
}else{
    if ( is_user_logged_in() ) {
        echo "This post is not linked to you.";
    }else{

    }
}
   }
// }else{
//    echo "Login to view this.";
// }
?>