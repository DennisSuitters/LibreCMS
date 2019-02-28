<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - SEO Stats for Content
 *
 * seostats-content.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - SEO Stats for Alexa
 * @package    core/layout/seostats-content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$u=isset($_POST['u'])?filter_input(INPUT_POST,'u',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'u',FILTER_SANITIZE_STRING);
$a=isset($_POST['a'])?filter_input(INPUT_POST,'a',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'a',FILTER_SANITIZE_STRING);
if($a=='social'){?>
<legend class="control-legend clearfix">Social Shares<span id="social-loading" class="pull-right"><div class="loader display margin"></div> Loading Stats...</span></legend>
<div class="col-xs-12">
  <div class="col-xs-6 col-sm-3">
    <div class="panel panel-default">
      <div class="panel-heading">Delicious</div>
      <div class="panel-body">
        <span class="text-black" style="font-size:1.5em">
          <i class="libre libre-social"><svg xmlns="http://www.w3.org/2000/svg" id="libre-social-delicious" viewBox="0 0 14 14"><path d="M 11.543689,1 2.456311,1 C 1.652019,1 1,1.65202 1,2.45631 l 0,9.08738 C 1,12.34798 1.652019,13 2.456311,13 l 9.087378,0 C 12.347981,13 13,12.34798 13,11.54369 L 13,2.45631 C 13,1.65202 12.34801,1 11.543689,1 Z m 0.291262,10.36893 c 0,0.25739 -0.208631,0.46602 -0.466019,0.46602 L 7,11.83495 7,7 2.165049,7 l 0,-4.36893 c 0,-0.25736 0.208631,-0.46602 0.466019,-0.46602 L 7,2.16505 7,7 l 4.834951,0 0,4.36893 z"/></svg></i>
          <span id="social-delicious" class="pull-right">0</span>
        </span>
      </div>
    </div>
  </div>
  <div class="col-xs-6 col-sm-3">
    <div class="panel panel-default">
      <div class="panel-heading">Digg</div>
      <div class="panel-body">
        <span class="text-black" style="font-size:1.5em">
          <i class="libre libre-social"><svg xmlns="http://www.w3.org/2000/svg" id="libre-social-digg" viewBox="0 0 14 14"><path d="M 1,9.11765 1,5.13904 Q 1,5 1.1390374,5 l 1.882353,0 0,-1.37968 q 0,-0.14973 0.1390374,-0.14973 l 1.0481283,0 0,5.49732 q 0,0.14974 -0.1283422,0.14974 L 1,9.11765 Z m 1.1657754,-0.88771 0.7165775,0 q 0.1390375,0 0.1390375,-0.14973 l 0,-2.20321 -0.7165776,0 q -0.1390374,0 -0.1390374,0.14974 l 0,2.2032 z m 2.4064171,0.88771 0,-3.97861 Q 4.5721925,5 4.7112299,5 l 1.0481284,0 0,3.96791 q 0,0.14974 -0.1283423,0.14974 l -1.0588235,0 z m 0,-4.75936 0,-0.73797 q 0,-0.14973 0.1283423,-0.14973 l 1.0588235,0 0,0.73796 q 0,0.14974 -0.1283423,0.14974 l -1.0588235,0 z m 1.5935829,4.75936 0,-3.97861 Q 6.1657754,5 6.3048128,5 l 3.0802139,0 0,5.39037 q 0,0.13904 -0.1390374,0.13904 l -3.0802139,0 0.010695,-0.73797 q 0,-0.14973 0.1283422,-0.14973 l 1.882353,0 0,-0.52406 -2.0213904,0 z m 1.1764706,-0.88771 0.7165775,0 q 0.1283423,0 0.1283423,-0.14973 l 0,-2.20321 -0.7165776,0 q -0.1283422,0 -0.1283422,0.14974 l 0,2.2032 z m 2.4491979,1.5615 q 0,-0.14973 0.1390374,-0.14973 l 1.8823527,0 0,-0.52406 -2.0213901,0 0,-3.97861 Q 9.7914439,5 9.9304813,5 L 13,5 l 0,5.39037 q 0,0.13904 -0.128342,0.13904 l -3.0802141,0 0,-0.73797 z m 1.1657751,-1.5615 0.716578,0 q 0.139037,0 0.139037,-0.14973 l 0,-2.20321 -0.716577,0 q -0.139038,0 -0.139038,0.14974 l 0,2.2032 z"/></svg></i>
          <span id="social-digg" class="pull-right">0</span>
        </span>
      </div>
    </div>
  </div>
  <div class="col-xs-6 col-sm-3">
    <div class="panel panel-default">
      <div class="panel-heading">Facebook</div>
      <div class="panel-body">
        <span class="text-black" style="font-size:1.5em">
          <i class="libre libre-social"><svg xmlns="http://www.w3.org/2000/svg" id="libre-social-facebook" viewBox="0 0 14 14"><path d="m 8.2784001,5.92307 -1.25662,0 0,2.05124 1.25662,0 0,6.02569 2.4164689,0 0,-6.05132 1.685881,0 0.17948,-2.02561 -1.865361,0 c 0,0 0,-0.75641 0,-1.15384 0,-0.47761 0.0962,-0.6667 0.557681,-0.6667 0.37182,0 1.30765,0 1.30765,0 L 12.5602,2 c 0,0 -1.37843,0 -1.67304,0 -1.7980899,0 -2.6087599,0.79162 -2.6087599,2.3077 0,1.32044 0,1.61537 0,1.61537 z"/></svg></i>
          <span id="social-facebook" class="pull-right">0</span>
        </span>
      </div>
    </div>
  </div>
  <div class="col-xs-6 col-sm-3">
    <div class="panel panel-default">
      <div class="panel-heading">Google+</div>
      <div class="panel-body">
        <span class="text-black" style="font-size:1.5em">
          <i class="libre libre-social"><svg xmlns="http://www.w3.org/2000/svg" id="libre-social-google-plus" viewBox="0 0 14 14"><path d="m 13,3.660595 -1.590903,0 0,1.59093 -0.795466,0 0,-1.59093 -1.590932,0 0,-0.79547 1.590932,0 0,-1.59087 0.795466,0 0,1.5909 1.590903,0 0,0.79544 z m -4.497583,6.57999 c 0,1.19251 -1.088854,2.64428 -3.828174,2.64428 C 2.670825,12.884865 1,12.020745 1,10.567325 1,9.445555 1.710184,7.989335 5.028825,7.989335 4.535951,7.587625 4.41499,7.025925 4.716214,6.417705 c -1.943127,0 -2.938224,-1.14238 -2.938224,-2.5929 0,-1.41935 1.055593,-2.70967 3.208253,-2.70967 0.543495,0 3.448485,0 3.448485,0 l -0.770592,0.80884 -0.905214,0 c 0.638593,0.36588 0.978233,1.1194 0.978233,1.94997 0,0.76238 -0.419796,1.37985 -1.018922,1.84308 -1.063194,0.822 -0.79101,1.28097 0.322922,2.09335 1.098292,0.82285 1.461262,1.45803 1.461262,2.43021 z M 6.351592,3.925815 C 6.191223,2.705285 5.396078,1.703955 4.46701,1.676025 c -0.929389,-0.0276 -1.55269,0.90637 -1.392175,2.12723 0.160456,1.22053 1.043709,2.07314 1.973272,2.10113 0.929039,0.0276 1.463796,-0.75789 1.303485,-1.97857 z m 0.958049,6.43719 c 0,-1.00387 -0.915758,-1.96069 -2.452194,-1.96069 -1.384719,-0.0152 -2.558214,0.87501 -2.558214,1.90692 0,1.05303 1.000049,1.92961 2.384825,1.92961 1.770321,-3e-5 2.625583,-0.82281 2.625583,-1.87584 z"/></svg></i>
          <span id="social-google-plus" class="pull-right">0</span>
        </span>
      </div>
    </div>
  </div>
  <div class="col-xs-6 col-sm-3">
    <div class="panel panel-default">
      <div class="panel-heading">Linkedin</div>
      <div class="panel-body">
        <span class="text-black" style="font-size:1.5em">
          <i class="libre libre-social"><svg xmlns="http://www.w3.org/2000/svg" id="libre-social-linkedin" viewBox="0 0 14 14"><path d="m 3.931553,2.47617 c 0,0.81531 -0.655573,1.47621 -1.464262,1.47621 -0.808689,0 -1.464262,-0.6609 -1.464262,-1.47621 C 1.003029,1.6609 1.658602,1 2.467291,1 3.27601,1 3.931553,1.6609 3.931553,2.47617 Z m -0.214252,2.52382 -2.476223,0 0,8.00001 2.476223,0 0,-8.00001 z m 3.958281,0 -2.37498,0 0,8.00001 2.37498,0 c 0,0 0,-2.96729 0,-4.19945 0,-1.12497 0.517835,-1.79461 1.508942,-1.79461 0.910719,0 1.348223,0.64285 1.348223,1.79461 0,1.1518 0,4.19945 0,4.19945 l 2.464224,0 c 0,0 0,-2.92264 0,-5.06549 0,-2.14284 -1.214243,-3.17857 -2.910699,-3.17857 -1.696457,0 -2.410719,1.32143 -2.410719,1.32143 l 0,-1.07738 z"/></svg></i>
          <span id="social-linkedin" class="pull-right">0</span>
        </span>
      </div>
    </div>
  </div>
  <div class="col-xs-6 col-sm-3">
    <div class="panel panel-default">
      <div class="panel-heading">Pinterest</div>
      <div class="panel-body">
        <span class="text-black" style="font-size:1.5em">
          <i class="libre libre-social"><svg xmlns="http://www.w3.org/2000/svg" id="libre-social-pinterest" viewBox="0 0 14 14"><path d="m 7.281145,1.0000276 c -3.274743,0 -4.92602,2.34791 -4.92602,4.3058 0,1.18549 0.448863,2.24021 1.411511,2.6333 0.157805,0.0645 0.299271,0.002 0.345028,-0.17255 0.03184,-0.12096 0.107213,-0.42614 0.140825,-0.55313 0.04614,-0.17289 0.02825,-0.23354 -0.09912,-0.3842 -0.277572,-0.32744 -0.45498,-0.75131 -0.45498,-1.35169 0,-1.74192 1.303278,-3.30124 3.393636,-3.30124 1.85094,0 2.8679,1.13099 2.8679,2.64144 0,1.9874 -0.87955,3.66477 -2.18521,3.66477 -0.72114,0 -1.26087,-0.59636 -1.08789,-1.32771 0.20723,-0.87323 0.60856,-1.81555 0.60856,-2.44587 0,-0.56417 -0.30285,-1.03476 -0.92965,-1.03476 -0.737128,0 -1.329291,0.76258 -1.329291,1.78409 0,0.65059 0.219873,1.09066 0.219873,1.09066 0,0 -0.754309,3.19621 -0.88657,3.7559304 -0.263388,1.11474 -0.03964,2.48134 -0.02062,2.61934 0.01107,0.0818 0.116185,0.10124 0.163718,0.0394 0.06801,-0.0888 0.945988,-1.17262 1.244444,-2.25556 0.08446,-0.30664 0.484896,-1.8946304 0.484896,-1.8946304 0.23944,0.45679 0.93934,0.85914 1.68363,0.85914 2.21577,0 3.71906,-2.02002 3.71906,-4.72388 -3e-5,-2.0446 -1.73175,-3.94868997 -4.36373,-3.94868997 z"/></svg></i>
          <span id="social-pinterest" class="pull-right">0</span>
        </span>
      </div>
    </div>
  </div>
  <div class="col-xs-6 col-sm-3">
    <div class="panel panel-default">
      <div class="panel-heading">Stumbleupon</div>
      <div class="panel-body">
        <span class="text-black" style="font-size:1.5em">
          <i class="libre libre-social"><svg xmlns="http://www.w3.org/2000/svg" id="libre-social-stumbleupon" viewBox="0 0 14 14"><path d="m 7.635023,5.84985 0.790658,0.44027 1.251288,-0.42314 0,-0.84804 c 0,-1.46236 -1.223007,-2.60105 -2.676984,-2.60105 -1.448676,0 -2.677012,1.06462 -2.677012,2.58521 0,1.52061 0,3.87462 0,3.87462 0,0.35071 -0.28433,0.63504 -0.635038,0.63504 -0.350708,0 -0.635037,-0.28433 -0.635037,-0.63504 l 0,-1.64199 -2.052898,0 c 0,0 0,1.64455 0,1.66389 0,1.4815 1.200958,2.68249 2.682489,2.68249 1.468511,0 2.66178,-1.18042 2.682488,-2.64398 l 0,-3.82683 c 0,-0.35071 0.28433,-0.63504 0.635038,-0.63504 0.350707,0 0.635037,0.28433 0.635037,0.63504 l 0,0.73855 z m 3.31205,1.38588 0,1.71865 c 0,0.35071 -0.284359,0.63504 -0.635037,0.63504 -0.350708,0 -0.635067,-0.28433 -0.635067,-0.63504 l 0,-1.68597 -1.251288,0.42315 -0.790658,-0.44025 0,1.67208 c 0.01282,1.4704 1.208997,2.65869 2.682488,2.65869 C 11.799042,11.58208 13,10.38112 13,8.89959 13,8.88029 13,7.2357 13,7.2357 l -2.052927,0 z"/></svg></i>
          <span id="social-stumbleupon" class="pull-right">0</span>
        </span>
      </div>
    </div>
  </div>
  <div class="col-xs-6 col-sm-3">
    <div class="panel panel-default">
      <div class="panel-heading">Twitter</div>
      <div class="panel-body">
        <span class="text-black" style="font-size:1.5em">
          <i class="libre libre-social"><svg xmlns="http://www.w3.org/2000/svg" id="libre-social-twitter" viewBox="0 0 14 14"><path d="m 13,3.278335 c -0.441495,0.19585 -0.91599,0.32823 -1.41399,0.38767 0.508223,-0.30469 0.89866,-0.78713 1.082446,-1.36206 -0.475718,0.28215 -1.002582,0.48702 -1.563378,0.59741 -0.449068,-0.47848 -1.088913,-0.77741 -1.797029,-0.77741 -1.589127,0 -2.757321,1.48299 -2.398166,3.02293 -2.046116,-0.10264 -3.860213,-1.08283 -5.074456,-2.57226 -0.644912,1.10631 -0.334514,2.55411 0.761884,3.2869 -0.403515,-0.0128 -0.783233,-0.12353 -1.115097,-0.30798 -0.02671,1.14064 0.79066,2.20721 1.974611,2.44511 -0.346485,0.0943 -0.726,0.11587 -1.111747,0.0421 0.313223,0.97806 1.222485,1.68984 2.299805,1.70968 -1.035058,0.81113 -2.338689,1.17344 -3.644883,1.0195 1.089495,0.69851 2.383602,1.10613 3.773913,1.10613 4.570835,0 7.153252,-3.86071 6.997602,-7.32335 0.481077,-0.3471 0.898427,-0.7807 1.228485,-1.27442 z"/></svg></i>
          <span id="social-twitter" class="pull-right">0</span>
        </span>
      </div>
    </div>
  </div>
</div>
<script>
  $.get("core/layout/seostats-social.php?u=<?php echo $u;?>", {}, function (results) {
    var social = results.split(",");
    $('#social-loading').fadeOut();
    if (social[0] != 'n.a.') $('#social-google-plus').countTo({ from: 0, to: social[0]});
    if (social[1] != 'n.a.') $('#social-twitter').countTo({     from: 0, to: social[2]});
    if (social[2] != 'n.a.') $('#social-facebook').countTo({    from: 0, to: social[2]});
    if (social[3] != 'n.a.') $('#social-pinterest').countTo({   from: 0, to: social[3]});
    if (social[4] != 'n.a.') $('#social-linkedin').countTo({    from: 0, to: social[4]});
    if (social[5] != 'n.a.') $('#social-delicious').countTo({   from: 0, to: social[5]});
    if (social[6] != 'n.a.') $('#social-digg').countTo({        from: 0, to: social[6]});
    if (social[7] != 'n.a.') $('#social-stumbleupon').countTo({ from: 0, to: social[7]});
  });
</script>
<?php }
if($a=='google'){?>
<legend class="control-legend clearfix">Google <span id="google-loading" class="pull-right"><div class="loader display margin"></div> Loading Stats...</span></legend>
<div class="col-xs-12" id="seostats-google"></div>
<script>
  $.get("core/layout/seostats-google.php?id=<?php echo $id;?>&t=content&u=<?php echo $u;?>", {}, function (results) {
    $('#google-loading').fadeOut('hidden');
    $('#seostats-google').html(results);
  });
</script>
<?php }
if($a=='alexa'){?>
<legend class="control-legend clearfix">Alexa <span id="alexa-loading" class="pull-right"><div class="loader display margin"></div> Loading Stats...</span></legend>
<div class="col-xs-12" id="seostats-alexa"></div>
<script>
  $.get("core/layout/seostats-alexa.php?id=<?php echo $id;?>&t=content&u=<?php echo $u;?>", {}, function (results) {
    $('#alexa-loading').fadeOut('hidden');
    $('#seostats-alexa').html(results);
  });
</script>
<?php }
if($a=='moz'){?>
<legend class="control-legend clearfix">Moz <span id="moz-loading" class="pull-right"><div class="loader display margin"></div> Loading Stats...</span></legend>
<div class="col-xs-12" id="seostats-moz"></div>
<script>
  $.get("core/layout/seostats-moz.php?id=<?php echo $id;?>&t=content&u=<?php echo $u;?>", {}, function (results) {
    $('#moz-loading').fadeOut('hidden');
    $('#seostats-moz').html(results);
  });
</script>
<?php }
