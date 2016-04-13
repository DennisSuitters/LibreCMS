![Libr8](core/images/librecms.png)  
a **Free** Open Source Content Management System, that is built utilising [PHP](http://php.net/), PDO, [jQuery](http://jquery.com/), [Bootstrap](http://getbootstrap.com/), and [LibreICONS](https://github.com/StudioJunkyard/LibreICONS). Built to take advantage of HTML5 and CSS3, and injects necessary SEO attributes that fit in with Google's recommendations, and Microformats to help with Search Engine ranking.

## Current Update may contain a lot of broken features as we upgrade and fix bugs.

### Features
* Auto Installer when first Opened (In Progress)...
* Blog, Portfolio's, Bookings, Events, News, Testimonials, Inventory, Services, Gallery, Proofs
* Messaging - Whenever a message is created via the Contact Us page, it is stored in the Messages system as well as emailed.
* Orders - Create Quotes, Invoices, and recurring Orders. Client viewing of Orders.
* Media - Upload and manage various types of files for addition into content using elFinder.
* Accounts - Create Accounts for co-workers with Account Types for Administrators, Editors (especially good for SEO and Copywriters), Client's, and Visitors.
* Client Proofs and Commenting
* Easy Theme Selector
* Front End Theme Engine processing that allows the use of any CSS or Javascript Framework.
* Front End integration uses Vanilla Javascript for backend processing for Form Submission and Event Notification.
* Administration uses jQuery, Modified Bootstrap, LibreICONS, and other jQuery Addons.

Please submit issue's here at GitHub, this is so we can track, and update issue's more efficiently.

You can now get themes from our Themes GitHub Repository @ [LibreCMS-Themes](https://github.com/StudioJunkyard/LibreCMS-themes)

### Dependencies
* PHP/PDO (Tested with MySQL)
* mod_rewrite

#### Integrated Projects:
* [LibreICONS](https://github.com/StudioJunkyard/LibreICONS)
* [Summernote](https://github.com/summernote/summernote)
* * [summernote-save-button](https://github.com/StudioJunkyard/summernote-save-button)
* * [summernote-image-attributes](https://github.com/StudioJunkyard/summernote-image-attributes)
* * [summernote-ext-elfinder](https://github.com/semplon/summernote-ext-elfinder)
* [PHPMailer](https://github.com/PHPMailer/PHPMailer)
* [TCPDF](http://www.tcpdf.org/)
* [Zebra_Image](https://github.com/stefangabos/Zebra_Image)
* [kses]() We've modified kses to include HTML5, and minified the source.
* [elFinder](https://github.com/Studio-42/elFinder)
* * [elFinder-bootstrap-theme](https://github.com/StudioJunkyard/elfinder-bootstrap-theme)

### Tested on:
* Ubuntu 14.04 + Apache v2.4.7 + PHP v5.5.9-1 + MySQL v5.5.37
* Linux Mint Debian Edition
* Debian 7 + nGinx + PHP 5.4 + MySQL
* Windows 7 + WAMP + PHP 5.5 + MySQL

### Setup:
LibreCMS uses PHP's PDO for Database integration. So all you need to do, is use a Database Engine that's compatible with PDO. Then import the "libre.sql" file found in the "core/" folder, then edit the "config.ini" file in the "core/" folder.
Remember to set the appropriate file and folder permissions for security purposes, and make sure "media" uses 0755 so files can be uploaded when uploading, editing or creating content.
To Login into the Administration area, goto http://yoursite/admin/ or use the "Administration" link at the bottom of the page. The default "Username/Password" is set to "admin/admin", we recommend changing this on a live site.

### TODO:
* Build Installer to make Installation Easier, and Checking PHP Components are Installed to Allow LibreCMS to work.
* Make sure database backup works properly, last time we checked it wasn't.
* Convert from font icons to using svg icons to reduce footprint.
* Reduce the Templating System Markup to make it easier to use.
* Add Content to the Wiki Pages on how to use LibreCMS and how to create Templates.
* Once at a Stable Platform, create a release candidate, and create a proper gh-page site.
* Create Free Templates.
* Testing, and Bug Squashing, as per the usual with ongoing projects.

### LEGAL:
By downloading LibreCMS you hereby agree not to hold Studio Junkyard liable for any damages that your usage of LibreCMS may cause to your system, or persons. Damages may infere such things as (which we are NOT responsible for) Data Loss, Hearing Imparement, Server Crashes, Alien Abduction, Coding Nitemare's, Alien Implants, or Visiting Alternate Realities. LibreCMS is Licensed under GPLv3. We request that if you modify, and hopefully enhance LibreCMS, that you take part in maintaining, and contributing to it's code base here at GitHub.

### NOTE:
* We are currently overhauling parts of the Administration Area, and will soon be making changes to the Layout (Front End) area.
