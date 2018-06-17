[![LibreCMS Introduction](http://img.youtube.com/vi/ssYaSJWPgMQ/0.jpg)](https://youtu.be/ssYaSJWPgMQ "LibreCMS Introduction")

![LibreCMS](core/images/librecms.png)  
a **Free** Open Source [MIT](https://www.gnu.org/licenses/gpl-3.0.html) Content Management System, that is built utilising [PHP](http://php.net/), PDO, [jQuery](http://jquery.com/), [Bootstrap](http://getbootstrap.com/), and [LibreICONS](https://github.com/DiemenDesign/LibreICONS). Built to take advantage of HTML5 and CSS3, with necessary SEO attributes that fit in with Google's recommendations, and Micro-formats to help with Search Engine ranking.
(AMP has been removed as testing proved that there was nothing to be gained from using it).

### FAQ
- Why no Version Numbers?
  - Some people have asked why we don't use a Versioning System of some sorts. Well, as this is an ever changing and growing project, rather than having version numbers, we're going to be doing releases instead. The other reason, is due to my laziness. I originally was updating version numbers to files, but laziness got the better of me, so I just stopped doing that completely.
- Why is English the only Language available?
  - LibreCMS was, and is targetted towards English Speaking Australian Business's. We may in the future decide, or if someone wants to add Language support, then we may do that, or merge their changes.
- Why no Plugins?
  - Anybody who's worked on or developed any kind of Content Mangement System in any Programming Language knows that Plugins are a potential security problem. Plugins are something that because third parties can build them, end up being out of the control of the developer, especially if the Plugin Maker disregards the conventions set by the project.

### Features
- Blog, Portfolio's, Bookings, Events, News, Testimonials, Inventory, Services, Gallery, Proofs, Messages, and Newsletters.
- Add and Remove Custom Pages. Submenu custom and existing pages.
- Messaging - Whenever a message is created via the Contact Us page, it is stored in the Messages system as well as emailed.
- Orders - Create Quotes, Invoices. Client viewing of Orders.
- Media - Upload and manage various types of files for addition into content using elFinder.
- Featured Content - Can use Content Items as Featured Content, or Images and HTML Templates uploaded into the `media/carousel/` folder. Which then will get sorted, and number of items displayed depending on the settings attributes in the `featured.html` template file.
- Accounts - Create Accounts for co-workers with Account Types for Administrators, Editors (especially good for SEO and Copywriters), Client's, and Visitors.
- Client Proofs and Commenting
- Easy Theme Selector
- Front End Theme Engine using HTML Style Markup, the use of any CSS or Javascript Framework.
- Front End integration uses Vanilla Javascript for back end processing for Form Submission and Event Notification.
- Administration uses jQuery, Modified Bootstrap, LibreICONS, and other jQuery Addons.
- Activity Fingerprint Analysis Logs of Previous Content Changes with Undo, and who made the changes. Examine Content Inputs with Draggable Popover with Undoing.
- Suggestions Editor to allow Administrators and Content Editor to make Editing Suggestions with Reasons, and Click Adding of Suggestions.
- WYSIWYG Editor Content is encoded to get around some server filters blocking data such as iFrames.
- Page and Visitor Tracking.
- SEO Stats within Content, Google (currently broken), Alexa, and Moz.
- Button links to Wiki Help pages, and popup Video Help.
- Multiple Custom Summernote (WYSIWYG Editor) Addons, created by Studio Junkyard:
  - summernote-accessibility (In Progress)
  - [summernote-cleaner](https://github.com/DiemenDesign/summernote-cleaner)
  - [summernote-findnreplace](https://github.com/DiemenDesign/summernote-text-findnreplace)
  - [summernote-image-attributes](https://github.com/DiemenDesign/summernote-image-attributes)
  - [summernote-image-captionit](https://github.com/DiemenDesign/summernote-image-captionit)
  - [summernote-image-shapes](https://github.com/DiemenDesign/summernote-image-shapes)
  - [summernote-save-button](https://github.com/DiemenDesign/summernote-save-button)
  - [summernote-seo](https://github.com/DiemenDesign/summernote-seo)
  - [summernote-video-attributes](https://github.com/DiemenDesign/summernote-video-attributes)

You can now get themes from our Themes GitHub Repository @ [LibreCMS-Themes](https://github.com/DiemenDesign/LibreCMS-themes)

### Dependencies
- PHP > 5.6 - Must have PDO, and Password Compat support. If you have tried LibreCMS with a higher version, please report your experiences.
- Now works with PHP 7+. Please make sure PHP Libraries are installed before reporting Issues.
- mod_rewrite
- GD-Image & Imagemagick- LibreCMS will work without them, but things like Thumbnails, and image resizing won't work.
- mail services - Are needed for mail notification sending, and for the Newsletters.

#### Integrated Projects:
- [LibreICONS](https://github.com/DiemenDesign/LibreICONS)
- [Summernote](https://github.com/summernote/summernote)
  - summernote-accessibility (In Progress)
  - [summernote-cleaner](https://github.com/DiemenDesign/summernote-cleaner)
  - [summernote-findnreplace](https://github.com/DiemenDesign/summernote-text-findnreplace)
  - [summernote-image-attributes](https://github.com/DiemenDesign/summernote-image-attributes)
  - [summernote-image-captionit](https://github.com/DiemenDesign/summernote-image-captionit)
  - [summernote-image-shapes](https://github.com/DiemenDesign/summernote-image-shapes)
  - [summernote-save-button](https://github.com/DiemenDesign/summernote-save-button)
  - [summernote-seo](https://github.com/DiemenDesign/summernote-seo)
  - [summernote-video-attributes](https://github.com/DiemenDesign/summernote-video-attributes)
  - [summernote-ext-elfinder](https://github.com/semplon/summernote-ext-elfinder)
  - [summernote-libreICONS-svg](https://github.com/DiemenDesign/LibreICONS/tree/master/themes/summernote)
- [CodeMirror](https://github.com/codemirror/CodeMirror)
- [FullCalendar](https://github.com/fullcalendar/fullcalendar)
  - fullcalendar-bootstrap-theme (Unreleased, but within LibreCMS, WIP)
- [PHPMailer](https://github.com/PHPMailer/PHPMailer)
- [TCPDF](http://www.tcpdf.org/)
- [Zebra_Image](https://github.com/stefangabos/Zebra_Image)
- [kses](https://github.com/RichardVasquez/kses)
  - We've modified kses to include HTML5, and minified the source.
- [elFinder](https://github.com/Studio-42/elFinder)
  - [elFinder-bootstrap-theme](https://github.com/DiemenDesign/LibreICONS/tree/master/themes/elFinder)
- [bootstrap-tokenfield](https://github.com/sliptree/bootstrap-tokenfield)

### Tested on:
- CentOS Linux 7.2.1511 with Webmin 1.791
- Ubuntu Linux 14.04 + Apache v2.4.7 + PHP v5.6 + MySQL v5.5.37
- Linux Mint Ubuntu Edition Apache 2.4.7 + PHP v5.6-7+ & MySQL v5.5.37
- Linux Mint Debian Edition Apache 2.4.7 + PHP v5.6-7+ & MySQL v5.5.37
- Debian 7 + nGinx + PHP 5.5 + MySQL
- Windows 7 + WAMP + PHP 5.5 + MySQL

### TODO:
- Add Content to the Wiki Pages on how to use LibreCMS and how to create Templates.
- Add Instructional [Videos to the LibreCMS YouTube Channel](https://www.youtube.com/channel/UC9vFbrBKmnSgf8TNUBvDX2Q).
- Once at a Stable Platform, create a release candidate, and create a proper gh-page site.
- Create Free Templates.
- Testing, and Bug Squashing, as per the usual with ongoing projects.

### LEGAL:
By downloading LibreCMS you hereby agree not to hold Diemen Design liable for any damages that your usage of LibreCMS may cause to your system, or persons. Damages may infer such things as Data Loss, Aural or Visual Impairment, Server Crashes, Alien Abduction, Coding nightmare's, Alien Implants, or Visiting Alternate Realities. LibreCMS is Licensed under GPLv3. We request that if you modify, and hopefully enhance LibreCMS, that you take part in maintaining, and contributing to it's code base here at GitHub.

### Contributors:
- [Raycraft Computer Services](https://www.raycraft.com.au/)
  - Live Testing, Suggestions, and witty Banter.

### LibreCMS Live Sites by Diemen Design:
- [Anime Excess](https://www.animeexcess.com.au/)
- [Fast Track Business Club](https://www.fasttrackbusinessclub.com.au/)
- [Live Lightly Centre](https://www.livelightlycentre.com.au/)
- [Powerline Automotive Services](https://www.powerlineauto.com.au/)
- [Raycraft Computer Services](https://www.raycraft.com.au/)
- [Raycraft Entertainment](https://www.entertainme.net.au/)
- [StudioJunkyard](https://www.studiojunkyard.com/)
