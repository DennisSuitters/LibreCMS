![LibreCMS](core/images/librecms.png)  
a **Free** Open Source Content Management System, that is built utilising [PHP](http://php.net/), PDO, [jQuery](http://jquery.com/), [Bootstrap](http://getbootstrap.com/), and [LibreICONS](https://github.com/StudioJunkyard/LibreICONS). Built to take advantage of HTML5 and CSS3, and injects necessary SEO attributes that fit in with Google's recommendations, and Micro-formats to help with Search Engine ranking.

(https://youtu.be/ssYaSJWPgMQ)[https://youtu.be/ssYaSJWPgMQ]

[![LibreCMS Introduction](http://img.youtube.com/vi/ssYaSJWPgMQ/0.jpg)](https://youtu.be/ssYaSJWPgMQ "LibreCMS Introduction")

### FAQ
- Why no Version Numbers?
  - Some people have asked why we don't use a Versioning System of some sorts. Well, as this is an ever changing and growing project, rather than having version numbers, we're going to be doing releases instead. (We're actually pretty close to release 1). The other reason, is due to my laziness. I originally was updating version numbers to files, but laziness, and neglectfulness got the better of me, so I just stopped doing that completely.
- Why are some files Minified (or Uglified as some call it)?
  - Files that are minified, are considered to be done with, or complete. Others, are still in the process of being fixed, edited, added to, or modified, but will eventually also be minified. The reason we do this, isn't to make it harder for contributors, but as we're the main users of LibreCMS, minifying the source helps to minimise the footprint. And despite what others think, and claim to have tested, which we have tested. Minifying the source can help improve the speed, and also the download time for outputted data.
- Why is English the only Language available?
  - LibreCMS was, and is targetted towards English Speaking Australian Business's. We may in the future decide, or if someone wants to add Language support, then we may do that.

### Features
- Installer when first Opened.
- Blog, Portfolio's, Bookings, Events, News, Testimonials, Inventory, Services, Gallery, Proofs.
- Messaging - Whenever a message is created via the Contact Us page, it is stored in the Messages system as well as emailed.
- Orders - Create Quotes, Invoices. Client viewing of Orders.
- Media - Upload and manage various types of files for addition into content using elFinder.
- Featured Content - Can use Content Items as Featured Content, or Images uploaded into the `media/carousel/` folder. Which then will get sorted, and number of items depending on the settings attributes in the `featured.html` template file.
- Accounts - Create Accounts for co-workers with Account Types for Administrators, Editors (especially good for SEO and Copywriters), Client's, and Visitors.
- Client Proofs and Commenting
- Easy Theme Selector
- Front End Theme Engine using HTML Style Markup, the use of any CSS or Javascript Framework.
- Front End integration uses Vanilla Javascript for back end processing for Form Submission and Event Notification.
- Administration uses jQuery, Modified Bootstrap, LibreICONS, and other jQuery Addons.

You can now get themes from our Themes GitHub Repository @ [LibreCMS-Themes](https://github.com/StudioJunkyard/LibreCMS-themes)

### Dependencies
- PHP > 5.5.9 - Must have PDO, and Password Compat support.
- mod_rewrite
- PHP5-gd2 (GD-Image) - LibreCMS will work without GD Support, but things like Thumbnails, and image resizing won't work.

#### Integrated Projects:
- [LibreICONS](https://github.com/StudioJunkyard/LibreICONS)
- [Summernote](https://github.com/summernote/summernote)
  - [summernote-cleaner](https://github.com/StudioJunkyard/summernote-cleaner)
  - [summernote-save-button](https://github.com/StudioJunkyard/summernote-save-button)
  - [summernote-image-attributes](https://github.com/StudioJunkyard/summernote-image-attributes)
  - [summernote-ext-elfinder](https://github.com/semplon/summernote-ext-elfinder)
  - [summernote-libreICONS-svg](https://github.com/StudioJunkyard/LibreICONS/tree/master/themes/summernote)
- [CodeMirror](https://github.com/codemirror/CodeMirror)
- [FullCalendar](https://github.com/fullcalendar/fullcalendar)
  - fullcalendar-bootstrap-theme (Unreleased, but within LibreCMS, WIP)
- [PHPMailer](https://github.com/PHPMailer/PHPMailer)
- [TCPDF](http://www.tcpdf.org/)
- [Zebra_Image](https://github.com/stefangabos/Zebra_Image)
- [kses](https://github.com/RichardVasquez/kses)
  - We've modified kses to include HTML5, and minified the source.
- [elFinder](https://github.com/Studio-42/elFinder)
  - [elFinder-bootstrap-theme](https://github.com/StudioJunkyard/LibreICONS/tree/master/themes/elFinder)
- [bootstrap-tokenfield](https://github.com/sliptree/bootstrap-tokenfield)

### Tested on:
- CentOS Linux 7.2.1511 with Webmin 1.791
- Ubuntu Linux 14.04 + Apache v2.4.7 + PHP v5.5.9-1 + MySQL v5.5.37
- Linux Mint Ubuntu Edition
- Linux Mint Debian Edition
- Debian 7 + nGinx + PHP 5.4 + MySQL
- Windows 7 + WAMP + PHP 5.5 + MySQL

### TODO:
- Fix Avatar Image Uploads for Testimonials.
- Fix the Installer.
- Add Content to the Wiki Pages on how to use LibreCMS and how to create Templates.
- Once at a Stable Platform, create a release candidate, and create a proper gh-page site.
- Create Free Templates.
- Testing, and Bug Squashing, as per the usual with ongoing projects.

### LEGAL:
By downloading LibreCMS you hereby agree not to hold Studio Junkyard liable for any damages that your usage of LibreCMS may cause to your system, or persons. Damages may infer such things as (which we are NOT responsible for) Data Loss, Hearing Impairment, Server Crashes, Alien Abduction, Coding nightmare's, Alien Implants, or Visiting Alternate Realities. LibreCMS is Licensed under GPLv3. We request that if you modify, and hopefully enhance LibreCMS, that you take part in maintaining, and contributing to it's code base here at GitHub.

### Contributors:
- [Raycraft Computer Services](https://www.raycraft.com.au/)
  - Live Testing, Suggestions, and witty Banter.
