<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Sidebar Menu Layout
 *
 * sidebar.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Sidebar Menu
 * @package    core/layout/set_sidebar.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Add "All" to Orders section of menu
 * @changes    v2.0.1 Remove # in menu href's that forced slow loading to view
 *                    front end.
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Add Server Stats for Developers.
 */
echo'<div class="app-body">'.
      '<div id="sidebar" class="sidebar mt-5">'.
        '<nav class="sidebar-nav">'.
          '<ul class="nav">'.
            '<li class="nav-item'.($view=='dashboard'?' active':'').'"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/dashboard">'.svg2('libre-gui-dashboard','nav-icon').' '.localize('Dashboard').'</a></li>'.
            '<li class="nav-item nav-dropdown'.($view=='media'||$view=='pages'||$view=='content'||$view=='rewards'||$view=='newsletters'?' open':'').'">'.
              '<a class="nav-link nav-dropdown-toggle" href="'.URL.$settings['system']['admin'].'/content">'.svg2('libre-gui-content','nav-icon').' '.localize('Content').'</a>'.
              '<ul class="nav-dropdown-items">'.
                '<li class="nav-item"><a class="nav-link'.($view=='media'?' active':'').'" href="'.URL.$settings['system']['admin'].'/media">'.svg2('libre-gui-picture','nav-icon ml-2').' '.localize('Media').'</a></li>'.
                '<li class="nav-item"><a class="nav-link'.($view=='pages'?' active':'').'" href="'.URL.$settings['system']['admin'].'/pages">'.svg2('libre-gui-content','nav-icon ml-2').' '.localize('Pages').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/content/scheduler">'.svg2('libre-gui-calendar-time','nav-icon ml-2').' '.localize('Scheduler').'</a></li>'.
                '<li class="nav-item"><a id="menu-article" class="nav-link" href="'.URL.$settings['system']['admin'].'/content/type/article">'.svg2('libre-gui-content','nav-icon ml-2').' '.localize('Articles').'</a></li>'.
                '<li class="nav-item"><a id="menu-portfolio" class="nav-link" href="'.URL.$settings['system']['admin'].'/content/type/portfolio">'.svg2('libre-gui-portfolio','nav-icon ml-2').' '.localize('Portfolio').'</a></li>'.
                '<li class="nav-item"><a id="menu-events" class="nav-link" href="'.URL.$settings['system']['admin'].'/content/type/events">'.svg2('libre-gui-calendar','nav-icon ml-2').' '.localize('Events').'</a></li>'.
                '<li class="nav-item"><a id="menu-news" class="nav-link" href="'.URL.$settings['system']['admin'].'/content/type/news">'.svg2('libre-gui-email-read','nav-icon ml-2').' '.localize('News').'</a></li>'.
                '<li class="nav-item"><a id="menu-testimonials" class="nav-link" href="'.URL.$settings['system']['admin'].'/content/type/testimonials">'.svg2('libre-gui-testimonial','nav-icon ml-2').' '.localize('Testimonials').'</a></li>'.
                '<li class="nav-item"><a id="menu-inventory" class="nav-link" href="'.URL.$settings['system']['admin'].'/content/type/inventory">'.svg2('libre-gui-shipping','nav-icon ml-2').' '.localize('Inventory').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/rewards">'.svg2('libre-credit-card','nav-icon ml-2').' '.localize('Rewards').'</a></li>'.
                '<li class="nav-item"><a id="menu-service" class="nav-link" href="'.URL.$settings['system']['admin'].'/content/type/service">'.svg2('libre-gui-service','nav-icon ml-2').' '.localize('Services').'</a></li>'.
/*                '<li class="nav-item"><a id="menu-gallery" class="nav-link" href="'.URL.$settings['system']['admin'].'/content/type/gallery">'.svg2('libre-gui-gallery','nav-icon ml-2').' '.localize('Gallery').'</a></li>'. */
                '<li class="nav-item"><a id="menu-proofs" class="nav-link" href="'.URL.$settings['system']['admin'].'/content/type/proofs">'.svg2('libre-gui-proof','nav-icon ml-2').' '.localize('Proofs').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/newsletters">'.svg2('libre-gui-newspaper','nav-icon ml-2').' '.localize('Newsletters').'</a></li>'.
              '</ul>'.
            '</li>'.
            '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/messages">'.svg2('libre-gui-inbox','nav-icon').' '.localize('Messages').'</a></li>'.
            '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/bookings">'.svg2('libre-gui-calendar','nav-icon').' '.localize('Bookings').'</a></li>'.
            '<li class="nav-item nav-dropdown">'.
              '<a class="nav-link nav-dropdown-toggle" href="'.URL.$settings['system']['admin'].'/orders">'.svg2('libre-gui-order','nav-icon').' '.localize('Orders').'</a>'.
              '<ul class="nav-dropdown-items">'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/orders">'.svg2('libre-gui-order-quote','nav-icon ml-2').' '.localize('All').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/orders/quotes">'.svg2('libre-gui-order-quote','nav-icon ml-2').' '.localize('Quotes').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/orders/invoices">'.svg2('libre-gui-order-invoice','nav-icon ml-2').' '.localize('Invoices').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/orders/pending">'.svg2('libre-gui-order-pending','nav-icon ml-2').' '.localize('Pending').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/orders/recurring">'.svg2('libre-gui-order-recurring','nav-icon ml-2').' '.localize('Recurring').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/orders/archived">'.svg2('libre-gui-order-archived','nav-icon ml-2').' '.localize('Archived').'</a></li>'.
              '</ul>'.
            '</li>'.
            '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/accounts">'.svg2('libre-gui-users','nav-icon').' '.localize('Accounts').'</a></li>';
if($user['options'][7]==1){
echo        '<li class="nav-item nav-dropdown">'.
              '<a class="nav-link nav-dropdown-toggle" href="'.URL.$settings['system']['admin'].'/preferences">'.svg2('libre-gui-settings','nav-icon').' '.localize('Preferences').'</a>'.
              '<ul class="nav-dropdown-items">'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/preferences/theme">'.svg2('libre-gui-theme','nav-icon ml-2').' '.localize('Theme').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/preferences/contact">'.svg2('libre-gui-address-card','nav-icon ml-2').' '.localize('Contact').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/preferences/social">'.svg2('libre-gui-user-group','nav-icon ml-2').' '.localize('Social').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/preferences/interface">'.svg2('libre-gui-sliders','nav-icon ml-2').' '.localize('Interface').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/preferences/seo">'.svg2('libre-gui-plugin-seo','nav-icon ml-2').' '.localize('SEO').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/preferences/activity">'.svg2('libre-gui-activity','nav-icon ml-2').' '.localize('Activity').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/preferences/tracker">'.svg2('libre-gui-tracker','nav-icon ml-2').' '.localize('Tracker').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/preferences/security">'.svg2('libre-gui-security','nav-icon ml-2').' '.localize('Security').'</a></li>'.
                '<li class="nav-item"><a class="nav-link" href="'.URL.$settings['system']['admin'].'/preferences/database">'.svg2('libre-gui-database','nav-icon ml-2').' '.localize('Database').'</a></li>'.
              '</ul>'.
            '</li>';
}
if($user['options']{8}==1){?>
            <li class="nav-divider"></li>
            <li class="nav-title">System Utilization</li>
            <li class="nav-item px-3 d-compact-none d-minimized-none">
              <div class="text-uppercase mb-1">
                <small>
                  <b>CPU Usage</b>
                </small>
              </div>
              <div class="progress progress-xs">
                <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo getload();?>%" aria-valuenow="<?php echo getload();?>" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <small><?php echo gpc();?> Processes. <?php echo num_cpu();?> Cores.</small>
            </li>
<?php $mem=getmemstats();?>
            <li class="nav-item px-3 d-compact-none d-minimized-none">
              <div class="text-uppercase mb-1">
                <small>
                  <b>Memory Usage</b>
                </small>
              </div>
              <div class="progress progress-xs">
                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo$mem['percent'];?>%" aria-valuenow="<?php echo$mem['percent'];?>" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <small><?php echo size_format($mem['used']).'/'.size_format($mem['total']);?></small>
            </li>
            <li class="nav-item px-3 d-compact-none d-minimized-none">
              <div class="text-uppercase">
                <small>
                  <b>Server Uptime</b>
                </small>
              </div>
              <small><?php echo shell_exec('uptime -p');?></small>
            </li>
<?php }?>
          </ul>
        </nav>
      <div class="sidebar-minimizer"></div>
    </div>
