<?php
if(!defined('IN_DISCUZ')) {
        exit('Access Denied');
}

require_once './source/function/function_cache.php';
class plugin_daxiong_roll_announcement {
    var $conf = array();
	var $isopen = FALSE;
	function plugin_daxiong_roll_announcement() {
		global $_G;		
		if(!isset($_G['cache']['plugin'])){
			loadcache('plugin');
		}
		$this->isopen = $_G['cache']['plugin']['daxiong_roll_announcement']['isopen'] ? TRUE : FALSE;
		if($this->isopen) {
			$this->conf = $_G['cache']['plugin']['daxiong_roll_announcement'];
			if(!$this->conf['speed'])$this->conf['speed']=20;
			if(!$this->conf['width'])$this->conf['width']=650;
		}
	}
	function common(){

	         global $_G;
			 if($this->isopen) {
			 $_G['cache']['plugin_announcements']=$_G['cache']['announcements'];
			 $_G['cache']['announcements']=array();
			 }
			
	}
	
	
    function _get_index_announcements($dir,$speed,$width){
		global $_G;
		$out = '';
    if(file_exists($daxiong_roll_announcement_insertfile = DISCUZ_ROOT.'./data/cache/cache_daxiong_roll_announcement.php')) {
				@include $daxiong_roll_announcement_insertfile;
	$out=$announcement; 			
    }else{
		    $announcements="";
			$announcement_h="";
			$announcement_f="";
			if($_G['cache']['plugin_announcements']) {
			
			$announcement_h='</div><div style="height: 29px;overflow: hidden;width:'.$width.'px;float:right">';
						
			$announcement_h.=<<<EOF
			<table align="center" border="0" width="100%" cellspacing="0" cellpadding="0"> 
			<tr>
			<td>
			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
			<TBODY>
			<TR>
			<TD vAlign=top background="">
			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
			<TBODY>
			<TR>
			<TD vAlign=center align=middle >
EOF;
			$announcement_h.='<DIV id="d1emo" style="OVERFLOW: hidden; width:'.$width.'px; COLOR: #ffffff; "><TABLE cellPadding=0 width='.$width*2;
			$announcement_h.=<<<EOF
			px align=left border=0 cellspace="0">
			<TBODY>
			<TR>
			<TD id="d1emo1" vAlign=top>
			<TABLE cellSpacing=1 cellPadding=1>
			<TBODY>
			<TR vAlign=top>
			<TD vAlign=top noWrap>
			<DIV align=right>
			<TABLE cellSpacing=0 cellPadding=0 align=center border=0  style="overflow:hidden; display:block;">
			<TBODY>
			<TR>
EOF;
		
			
			
			$announcement_f=<<<EOF
			</TR></TBODY></TABLE></DIV></TD></TR></TBODY></TABLE></TD>
			<TD id=d1emo2 width="0"></TD>
			</TR></TBODY></TABLE></DIV>
			<SCRIPT>
			var dir=$dir;//每步移动像素，数大为快
			var speed=$speed;//循环周期（毫秒）数大为慢
			d1emo2.innerHTML=d1emo1.innerHTML
			function Marquee(){//正常移动
			
			if (dir>0 && (d1emo2.offsetWidth-d1emo.scrollLeft)<=0) d1emo.scrollLeft=0
			if (dir<0 &&(d1emo.scrollLeft<=0)) d1emo.scrollLeft=d1emo2.offsetWidth
			d1emo.scrollLeft+=dir
			d1emo.onmouseover=function() {clearInterval(MyMar)}//暂停移动
			d1emo.onmouseout=function() {MyMar=setInterval(Marquee,speed)}//继续移动
			}
			function r_left(){if (dir=-1)dir=1}//换向左移
			function r_right(){if (dir=1)dir=-1}//换向右移
			var MyMar=setInterval(Marquee,speed)
			</SCRIPT>
			</TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
			</td>
			</tr>
			</table>
EOF;
			
			foreach($_G['cache']['plugin_announcements'] as $announcement) {
				if(!$announcement['endtime'] || $announcement['endtime'] > TIMESTAMP && (empty($announcement['groups']) || in_array($_G['member']['groupid'], $announcement['groups']))) {
					if(empty($announcement['type'])) {
				
						$announcements .=	'<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><img alt="公告" src="static/image/common/ann_icon.gif"><a href="forum.php?mod=announcement&id='.$announcement['id'].'"   target="_blank" >'.$announcement['subject'].'('.dgmdate($announcement['starttime'], 'd').')</a></td>';
					} elseif($announcement['type'] == 1) {
						
						$announcements .=	'<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><img alt="公告" src="static/image/common/ann_icon.gif"><a href="'.$announcement['message'].'"  target="_blank" >'.$announcement['subject'].'（'.dgmdate($announcement['starttime'], 'd').'）</a></td>';	
							
					}
				}
			}
		}
		
    $out=$announcement_h.$announcements.$announcement_f;
    $this->_writetocache('daxiong_roll_announcement',getcachevars(array('announcement' =>$out)));
     
    }
   
	return $out;

}

function _writetocache($script, $cachedata, $prefix = 'cache_') {
	global $_G;

	$dir = DISCUZ_ROOT.'./data/cache/';
	if(!is_dir($dir)) {
		dmkdir($dir, 0777);
	}
	if($fp = @fopen("$dir$prefix$script.php", 'wb')) {
		fwrite($fp, "<?php\n//Discuz! cache file, DO NOT modify me!\n//Identify: ".md5($prefix.$script.'.php'.$cachedata.$_G['config']['security']['authkey'])."\n\n$cachedata?>");
		fclose($fp);
	} else {
		exit('Can not write to cache files, please check directory ./data/ and ./data/cache/ .');
	}
}


}
class plugin_daxiong_roll_announcement_forum extends plugin_daxiong_roll_announcement {

	function index_status_extra_output(){
			$announcements=$this->_get_index_announcements($this->conf['dir'],$this->conf['speed'],$this->conf['width']);
			
	return  $announcements;
	}


}

?>