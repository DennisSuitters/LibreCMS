We are currently in a broken State, as we make alterations to seperate the Administration Styling, and make adjustments to allow the ability to use other CSS Frameworks on the Front End.

![Libr8](core/images/librecms.png)  
a **Free** Open Source Content Management System, that is built utilising [PHP](http://php.net/), PDO, [jQuery](http://jquery.com/), [Bootstrap](http://getbootstrap.com/), and [Font Awesome](http://fortawesome.github.io/Font-Awesome/). Built to take advantage of HTML5 and CSS3, and injects necessary SEO attributes that fit in with Google's recommendations, and Microformats to help with Search Engine ranking.


### Features
* Blog, Portfolio's, Bookings, Events, News, Testimonials, Inventory, Services, Gallery, Proofs
* Messaging - Whenever a message is created via the Contact Us page, it is stored in the Messages system as well as emailed.
* Orders - Create Quotes, Invoices, and recurring Orders. Client viewing of Orders.
* Media - Upload and manage various types of files for addition into content.
* Accounts - Create Accounts for co-workers with Account Types for Administrators, Editors (especially good for SEO and Copywriters), Client's, and Visitors.
* Client Proofs and Commenting
* Easy Theme Selector
* Live Front End Theme Engine processing that allows the use of any CSS or Javascript Framework.
* Front End integration uses Vanilla Javascript for backend processing for Form Submission and Event Notices.
* Administration uses jQuery, Modified Bootstrap, Font Awesome, and other jQuery Addons.

Please submit issue's here at GitHub, this is so we can track, and update issue's more efficiently.

You can now get themes from our Themes GitHub Repository @ [LibreCMS-Themes](https://github.com/StudioJunkyard/LibreCMS-themes)

### Dependencies
* PHP/PDO (Tested with MySQL)
* mod_rewrite

#### PHP Addons used:
* [PHPMailer](https://github.com/PHPMailer/PHPMailer)
* [TCPDF](http://www.tcpdf.org/)
* [Zebra_Image](https://github.com/stefangabos/Zebra_Image)

### Tested on:
* Ubuntu 14.04 + Apache v2.4.7 + PHP v5.5.9-1 + MySQL v5.5.37
* Linux Mint Debian Edition
* Debian 7 + nGinx + PHP 5.4 + MySQL
* Windows 7 + WAMP + PHP 5.5 + MySQL

### Setup:
LibreCMS uses PHP's PDO for Database integration. So all you need to do, is use a Database Engine that's compatible with PDO. Then import the "libre.sql" file found in the "core/" folder, then edit the "config.ini" file in the "core/" folder.
Remember to set the appropriate file and folder permissions for security purposes, and make sure "media" uses 0755 so files can be uploaded when editing or creating content.

### LEGAL:
By downloading LibreCMS you hereby agree not to hold Studio Junkyard liable for any damages that your usage of LibreCMS may cause to your system, or persons. LibreCMS is Licensed under GPLv3. We request that if you modify, and hopefully enhance LibreCMS, that you take part in maintaining, and contributing to it's code base here at GitHub.

### NOTE:
* We are currently overhauling parts of the Administration Area, and will soon be making changes to the Layout (Front End) area.
