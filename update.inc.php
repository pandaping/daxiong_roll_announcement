<?php 
if(!defined('IN_DISCUZ')) {
exit('Access Denied');
}

@unlink(DISCUZ_ROOT.'./data/cache/cache_daxiong_roll_announcement.php');
echo  lang('plugin/daxiong_roll_announcement','update_ok');
?>