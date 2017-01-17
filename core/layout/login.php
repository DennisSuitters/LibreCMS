<!DOCTYPE HTML>
<html lang="en-AU" id="libreCMS">
  <head>
    <base href="<?php echo URL;?>">
    <title>Administration - LibreCMS</title>
    <meta name="generator" content="LibreCMS">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="alternate" media="handheld" href="<?php echo URL;?>">
    <link rel="alternate" hreflang="x-default" href="<?php echo URL;?>">
    <link rel="alternate" hreflang="en-AU" href="<?php echo URL;?>">
    <link rel="icon" href="<?php echo URL.'/'.$favicon;?>">
    <link rel="apple-touch-icon" href="<?php echo URL.$favicon;?>">
    <meta name="viewport" content="width=400,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="core/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="core/css/style.css">
    <link rel="stylesheet" type="text/css" href="core/css/libreicons-svg.css">
    <script src="core/js/jquery-2.1.3.min.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="panel panel-default login center-block">
        <div class="panel-body">
          <form role="form" method="post" action="<?php if(strpos(URL,'logout')!=='false')echo rtrim(URL,'logout').$settings['system']['admin'];?>" accept-charset="UTF-8">
            <input type="hidden" name="act" value="login">
            <div class="panel-heading clearfix">
              <span class="loginimg col-xs-8 pull-right">
                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 500 90" id="librecms"><path id="libre" d="m 0,47.406885 0,-42.59302 7.79538,0.36704 7.79538,0.36705 0.33094,35.44523 0.33094,35.4452 18.06615,0 18.06615,0 0,6.7808 0,6.7808 -26.19247,0 -26.19246,0 z m 61.11576,11.7712 0,-30.82192 8.10719,0 8.10719,0 0,30.82192 0,30.8219 -8.10719,0 -8.10719,0 z m 29.93425,-14.1781 0,-44.99997 8.10719,0 8.1072,0 0,20.00034 c 0,18.47533 0.14842,19.79093 1.9466,17.25322 4.0697,-5.74329 14.44495,-8.70835 22.7433,-6.4996 11.82728,3.14802 18.23391,13.39351 18.15939,29.04051 -0.0516,10.8498 -1.7537,16.0869 -7.36694,22.6677 -4.74378,5.5614 -9.99938,7.5378 -20.04466,7.5378 -8.12241,0 -8.46571,-0.1302 -13.13629,-4.9834 l -4.79592,-4.9834 0,4.9834 0,4.9834 -6.85994,0 -6.85993,0 z m 37.24286,30.7783 c 4.63341,-3.8538 6.99733,-13.3406 5.2117,-20.9153 -3.05002,-12.9382 -19.02237,-15.9623 -24.84693,-4.7043 -0.76628,1.4811 -1.39324,6.6684 -1.39324,11.5274 0,8.4032 0.20701,9.0391 4.24068,13.0262 5.37055,5.3086 11.23884,5.6812 16.78779,1.066 z m 33.85099,-16.6002 0,-30.82192 6.85993,0 6.85994,0 0,5.15343 0,5.15339 4.38063,-5.05874 c 4.4859,-5.18033 9.6927,-7.31883 14.30025,-5.87331 2.00684,0.6296 2.51864,1.84563 2.50346,5.94804 -0.025,6.74831 -0.91885,7.80701 -6.56304,7.77361 -3.48685,-0.021 -5.59381,0.8436 -8.10719,3.3256 -3.39335,3.351 -3.39625,3.3697 -3.7899,24.2877 l -0.39394,20.9341 -8.02507,0 -8.02507,0 z m 61.54013,29.6413 c -2.16755,-0.5105 -5.8139,-2.0094 -8.10295,-3.3309 -11.51508,-6.6476 -15.33878,-25.3714 -8.38508,-41.0599 3.2772,-7.3938 5.57954,-9.73303 12.94552,-13.15292 18.75709,-8.70858 35.51564,3.72186 35.53997,26.36132 l 0.007,6.4726 -18.08528,0 -18.08527,0 0,2.9726 c 0,3.7713 6.13142,8.9937 11.7914,10.0433 3.92157,0.7272 12.26693,-0.4765 17.05457,-2.4598 1.64784,-0.6827 2.19361,0.2384 2.8999,4.8939 0.47851,3.1542 0.66414,5.9384 0.41249,6.1871 -0.25164,0.2488 -3.77927,1.3075 -7.83918,2.3528 -7.84318,2.0193 -13.74127,2.23 -20.15304,0.7199 z m 17.52098,-39.1961 c -2.19303,-9.1671 -11.40761,-11.8917 -18.04128,-5.3346 -2.00522,1.9821 -3.64584,4.7561 -3.64584,6.1644 0,2.403 0.69262,2.5606 11.2491,2.5606 l 11.24911,0 z M 63.27878,19.732905 c -2.29273,-1.78266 -3.41028,-3.80497 -3.41028,-6.17125 0,-4.9004 5.47505,-9.08885 10.56533,-8.08253 5.04697,0.99775 7.31208,3.50154 7.31208,8.08253 0,7.3411 -8.37037,10.91165 -14.46712,6.17125 z" />
                <path id="cms" d="m 295.74172,88.17648 c -12.07434,-3.0125 -21.63603,-10.8346 -26.9591,-22.0546 -2.93194,-6.18 -3.2676,-8.3439 -3.2676,-21.0656 0,-13.00958 0.28582,-14.75326 3.46824,-21.1578 4.17481,-8.4017 11.24319,-14.99379 20.70366,-19.30861 9.27036,-4.22811 27.39964,-5.0988 36.94386,-1.7743 5.89765,2.05431 6.25787,2.43226 6.63333,6.95978 0.34944,4.21402 0.12533,4.67743 -1.8709,3.86863 -29.77589,-12.06425 -55.27648,2.42716 -55.27648,31.4123 0,14.7828 6.7668,26.6388 18.37408,32.193 7.26829,3.478 22.76854,3.7914 31.36134,0.6342 3.00173,-1.1029 5.70162,-2.0052 5.99978,-2.0052 0.29816,0 0.36792,2.0804 0.15501,4.6232 -0.3496,4.1752 -0.87067,4.7846 -5.37616,6.2877 -6.30385,2.1031 -24.70728,2.9296 -30.88906,1.3873 z m 50.66222,-8.1692 c 0.44365,-5.1879 0.80664,-25.1859 0.80664,-44.43988 l 0,-35.00728 8.3065,0.36455 8.3065,0.36454 9.7562,25.8904 c 5.36591,14.23977 11.21365,30.32877 12.99495,35.75347 1.78131,5.4246 3.51079,10.6934 3.84331,11.7083 0.33252,1.0149 2.73963,-4.533 5.34913,-12.3288 3.96157,-11.835 16.44333,-45.68156 21.48093,-58.24939 1.2842,-3.20388 1.7967,-3.39041 9.3149,-3.39041 l 7.9558,0 0,23.11643 c 0,12.71403 0.3711,32.68667 0.82,44.38357 l 0.8161,21.2671 -5.0294,0 c -4.6352,0 -5.0906,-0.302 -5.809,-3.8527 -0.4288,-2.1191 -0.8094,-20.0112 -0.846,-39.7603 l -0.066,-35.90753 -2.9715,9.86301 c -1.6343,5.42467 -7.9284,22.62332 -13.9869,38.21922 l -11.01531,28.3561 -5.54784,0 -5.54784,0 -8.5066,-21.5753 C 372.1498,52.91588 365.83408,35.99469 362.79353,27.17961 l -5.52828,-16.02738 -0.0538,34.52055 c -0.0295,18.9863 -0.40165,36.601 -0.82684,39.1438 -0.74381,4.4481 -0.96289,4.6233 -5.78197,4.6233 l -5.00886,0 0.80663,-9.4326 z m 113.92106,8.1526 c -7.226,-1.7912 -9.5918,-3.4379 -9.5918,-6.6762 0,-6.2243 0.9259,-6.8359 6.6392,-4.386 16.2479,6.9671 32.0259,1.7342 32.0259,-10.6218 0,-7.4535 -2.9318,-11.0753 -12.7948,-15.8059 -12.5317,-6.0106 -15.9314,-8.4608 -19.2435,-13.86898 -3.3391,-5.45227 -3.8862,-15.34581 -1.1999,-21.70079 2.2274,-5.26936 9.5683,-11.51121 15.4306,-13.12042 6.2293,-1.70993 17.3592,-1.49993 22.7966,0.43012 3.3488,1.18867 4.4597,2.33958 4.7703,4.94186 0.7077,5.93039 -0.3501,7.02818 -4.7035,4.88146 -6.1823,-3.04858 -16.1941,-3.44873 -21.2278,-0.84841 -8.6601,4.47363 -10.9452,14.24779 -5.0599,21.6434 1.3203,1.65909 7.734,5.61576 14.2527,8.79256 15.2518,7.4328 17.5809,10.405 17.5809,22.4352 0,10.9761 -3.6651,17.2708 -12.5243,21.51 -6.5855,3.1512 -19.5015,4.2901 -27.1507,2.3939 z"/></svg>
              </span>
            </div>
            <div class="form-group input-group">
              <div class="input-group-addon"><?php svg('user');?></div>
              <input type="text" id="username" class="form-control" name="username" value="" placeholder="Username..." autofocus required>
            </div>
            <div class="form-group input-group">
              <div class="input-group-addon"><?php svg('lock');?></div>
              <input type="password" id="password" class="form-control" name="password" placeholder="Password..." autocomplete="off" required>
            </div>
            <div class="form-group clearfix">
              <button class="btn lgn btn-danger pull-left" type="reset"><?php svg('eraser');?>&nbsp;&nbsp;Reset</button>
              <button class="btn lgn btn-primary pull-right" type="submit"><?php svg('sign-in');?>&nbsp;&nbsp;Sign in</button>
            </div>
          </form>
          <div class="form-group text-center">
            <a href="javascript:return false;" onclick="$('#panel-rst').toggleClass('hidden');">Reset Password</a>
          </div>
          <form target="rstfeedback" id="panel-rst" class="hidden" role="form" method="post" action="core/rst.php" accept-charset="UTF-8">
            <input type="hidden" name="emailtrap" value="">
            <div class="form-group">
              <div class="input-group col-xs-12">
                <input type="text" id="rst" class="form-control" name="rst" value="" autocomplete="off" placeholder="Enter Account Email..." required>
                <div class="input-group-btn">
                  <button id="rstbusy" type="submit" class="btn btn-primary pull-right"><?php svg('envelope');?></button>
                </div>
              </div>
            </div>
            <div id="rstfeedback" class="form-group"></div>
          </form>
        </div>
      </div>
    </div>
    <script>/*<![CDATA[*/
      $('#panel-rst').submit(function(){
        $('#rstbusy').html('<i class="libre libre-spinner-1"></i>');
        $.ajax({
          data:$(this).serialize(),
          type:$(this).attr('method'),
          url:$(this).attr('action'),
          success:function(response){
            $('#rstfeedback').html(response);
            $('#rstbusy').html('<i class="libre libre-envelope"></i>');
          }
        });
        return false;
      });
    /*]]>*/</script>
  </body>
</html>
