<?php
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>长胖小电视</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <script src="index.browser.min.js"></script>
    <script src="hlsjs-p2p-engine.min.js"></script>
    <script src="p2p-chimee-kernel-hls@latest"></script>
    <style>
      body,html{width:100%;height:100%;background:#000;padding:0;margin:0;overflow-x:hidden;overflow-y:hidden}
      .videotop {width:100%;padding-bottom: 15px;background:#1D1D1D;position:relative;z-index:1000;}
      #player{width:100%;text-align:center;}
      @media screen and (max-width:1020px){
        .videotop{height:150px;}
        #player{height:calc(100% - 165px);}
      }
      @media screen and (min-width:1020px){
        .videotop{height:50px;}
        #player{height:calc(100% - 65px);}
      }
      #tip {
          position: fixed;
          color: gray;
          font-size: 30px;
          top: 350px;
          left: 0px;
          right: 0px;
      }
      .top-item{
		float: left;
		margin-left: 30px;
		margin-top: 15px;
      }
      #logo {
          width: 125px;
          color: white;
          font-size: 23px;
          font-weight: bold;
          display: inline-block;
          height: 33px;
          line-height: 33px;
      }
      .op-input {
        width: 250px;
        float: left;
    	border:0;
    	outline: none;
        height: 33px;
        padding: 0 10px;
      }
      .op-button {
        cursor: pointer;
        padding: 0 15px;
        float: left;
    	border:0;
    	outline: none;
        height: 33px;
        font-weight: bold;
      }
    </style>  
  </head>  
  <body> 
    <div class="videotop">
        <div class="top-item"><span id="logo">长胖小电视</span></div>
        <div class="top-item"><input class="op-input" id="bf" placeholder="请输入视频资源链接(mp4/m3u8/avi...)" value='<?php echo $_GET['bf'];?>' /><button class="op-button" onclick="bf()">播放</button></div>
        <div style="clear:both;"></div>
	</div>
    <div id="player">
        <span id="tip">
        <?php if(isset($_GET['bf'])){ 
            echo "视频加载中....";
        } else{ 
            echo "欢迎使用长胖小电视！";
        } ?>
        </span>
    </div>
	<script>
	    
	    function tip(display,content){
	        var tip = document.getElementById("tip");
	        if(display){
	            tip.style.cssText = "z-index: 999;"
	        }else{
	            tip.style.cssText = "z-index: -1;"
	        }
	        tip.innerHTML = content;
	    }
	    function play(src){
	        if((src.indexOf(".mp4?") > -1 || src.lastIndexOf(".mp4") == src.length - 4) || (src.indexOf(".m3u8?") > -1 || src.lastIndexOf(".m3u8") == src.length - 5) || (src.indexOf(".avi?") > -1 || src.lastIndexOf(".avi") == src.length - 4)){
    	        var player = new Chimee({
        			wrapper: '#player',
        			src: src,
        			controls: true,
                    autoplay: true,
                    preload: true,
        			kernels: {
        				hls: {
        					handler: window.ChimeeKernelHls,
        					maxBufferSize: 0,
        					maxBufferLength: 5,
        					liveSyncDuration: 30, 
        					p2pConfig: {
        						logLevel: 'debug',
        						live: false,
        					}
        				}
        			},
        		});
        		focusVideo();
	        }else{
	            var iframe = document.createElement('iframe'); 
                iframe.src=src;
                iframe.style.cssText="height:100%;width:100%;border:none;float:left;"
                document.getElementById("player").appendChild(iframe);
	        }
	    }
	    function focusVideo(){
	        var video = document.getElementsByTagName("video")[0];
	        if(video){
	            video.focus();
	        }else{
	            setTimeout("focusVideo();",500);
	        }
	    }
	    
	    function bf(){
	        document.getElementById("tip").innerText = "视频加载中....";
	        window.location = "/?bf=" + document.getElementById("bf").value;
	    }

	    <?php 
	    //如果是点击的播放按钮，则直接播放对应资源
	    if(isset($_GET['bf'])){ ?>
	        play("<?php echo $_GET['bf'];?>");
	    <?php }?>
	</script>
  </body>
</html>