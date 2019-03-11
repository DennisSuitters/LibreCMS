<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Sidebar Menu Layout
 *
 * sidebar.php version 2.0.1
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
 * @version    2.0.1
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Add "All" to Orders section of menu
 * @change     v2.0.1 Remove # in menu href's that forced slow loading to view
 *                    front end.
 */?>
<div class="app-body">
  <div id="sidebar" class="sidebar mt-5">
    <nav class="sidebar-nav">
      <ul class="nav">
        <li class="nav-item<?php echo$view=='dashboard'?' active':'';?>"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/dashboard';?>"><?php svg('libre-gui-dashboard','nav-icon');?> Dashboard</a></li>
        <li class="nav-item nav-dropdown<?php echo($view=='media'||$view=='pages'||$view=='content'||$view=='rewards'||$view=='newsletters'?' open':'');?>">
          <a class="nav-link nav-dropdown-toggle" href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php svg('libre-gui-content','nav-icon');?> Content</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link<?php echo$view=='media'?' active':'';?>" href="<?php echo URL.$settings['system']['admin'].'/media';?>">&nbsp;&nbsp;<?php svg('libre-gui-picture','nav-icon');?> Media</a></li>
            <li class="nav-item"><a class="nav-link<?php echo$view=='pages'?' active':'';?>" href="<?php echo URL.$settings['system']['admin'].'/pages';?>">&nbsp;&nbsp;<?php svg('libre-gui-content','nav-icon');?> Pages</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/scheduler';?>">&nbsp;&nbsp;<?php svg('libre-gui-calendar-time','nav-icon');?> Scheduler</a></li>
            <li class="nav-item"><a id="menu-article" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/article';?>">&nbsp;&nbsp;<?php svg('libre-gui-content','nav-icon');?> Articles</a></li>
            <li class="nav-item"><a id="menu-portfolio" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/portfolio';?>">&nbsp;&nbsp;<?php svg('libre-gui-portfolio','nav-icon');?> Portfolio</a></li>
            <li class="nav-item"><a id="menu-events" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/events';?>">&nbsp;&nbsp;<?php svg('libre-gui-calendar','nav-icon');?> Events</a></li>
            <li class="nav-item"><a id="menu-news" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/news';?>">&nbsp;&nbsp;<?php svg('libre-gui-email-read','nav-icon');?> News</a></li>
            <li class="nav-item"><a id="menu-testimonials" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/testimonials';?>">&nbsp;&nbsp;<?php svg('libre-gui-testimonial','nav-icon');?> Testimonials</a></li>
            <li class="nav-item"><a id="menu-inventory" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/inventory';?>">&nbsp;&nbsp;<?php svg('libre-gui-shipping','nav-icon');?> Inventory</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/rewards';?>">&nbsp;&nbsp;<?php svg('libre-credit-card','nav-icon');?> Rewards</a></li>
            <li class="nav-item"><a id="menu-service" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/service';?>">&nbsp;&nbsp;<?php svg('libre-gui-service','nav-icon');?> Services</a></li>
            <li class="nav-item"><a id="menu-gallery" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/gallery';?>">&nbsp;&nbsp;<?php svg('libre-gui-gallery','nav-icon');?> Gallery</a></li>
            <li class="nav-item"><a id="menu-proofs" class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/content/type/proofs';?>">&nbsp;&nbsp;<?php svg('libre-gui-proof','nav-icon');?> Proofs</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>">&nbsp;&nbsp;<?php svg('libre-gui-newspaper','nav-icon');?> Newsletters</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php svg('libre-gui-inbox','nav-icon');?> Messages</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/bookings';?>"><?php svg('libre-gui-calendar','nav-icon');?> Bookings</a></li>
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="<?php echo URL.$settings['system']['admin'].'/orders';?>"><?php svg('libre-gui-order','nav-icon');?> Orders</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/orders';?>">&nbsp;&nbsp;<?php svg('libre-gui-order-quote','nav-icon');?> All</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/orders/quotes';?>">&nbsp;&nbsp;<?php svg('libre-gui-order-quote','nav-icon');?> Quotes</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/orders/invoices';?>">&nbsp;&nbsp;<?php svg('libre-gui-order-invoice','nav-icon');?> Invoices</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/orders/pending';?>">&nbsp;&nbsp;<?php svg('libre-gui-order-pending','nav-icon');?> Pending</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/orders/recurring';?>">&nbsp;&nbsp;<?php svg('libre-gui-order-recurring','nav-icon');?> Recurring</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/orders/archived';?>">&nbsp;&nbsp;<?php svg('libre-gui-order-archived','nav-icon');?> Archived</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/accounts';?>"><?php svg('libre-gui-users','nav-icon');?> Accounts</a></li>
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><?php svg('libre-gui-settings','nav-icon');?> Preferences</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/theme';?>">&nbsp;&nbsp;<?php svg('libre-gui-theme','nav-icon');?> Theme</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/contact';?>">&nbsp;&nbsp;<?php svg('libre-gui-address-card','nav-icon');?> Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/social';?>">&nbsp;&nbsp;<?php svg('libre-gui-user-group','nav-icon');?> Social</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/interface';?>">&nbsp;&nbsp;<?php svg('libre-gui-sliders','nav-icon');?> Interface</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/seo';?>">&nbsp;&nbsp;<?php svg('libre-gui-plugin-seo','nav-icon');?> SEO</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/activity';?>">&nbsp;&nbsp;<?php svg('libre-gui-activity','nav-icon');?> Activity</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker';?>">&nbsp;&nbsp;<?php svg('libre-gui-tracker','nav-icon');?> Tracker</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/security';?>">&nbsp;&nbsp;<?php svg('libre-gui-security','nav-icon');?> Security</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/preferences/database';?>">&nbsp;&nbsp;<?php svg('libre-gui-database','nav-icon');?> Database</a></li>
          </ul>
        </li>
      </ul>
    </nav>
    <div class="sidebar-minimizer"></div>
  </div>
