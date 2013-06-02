=== Plugin Name ===
Contributors: Frag1 John
Donate link: http://kiva.com
Tags: comments, comments analysis, comments review, popular, remarks, meta, metrics, information, analysis, geolocation, geomapping, comment locations, comment geolocations, community, targetting, discussion, feedback, map, demographics
Requires at least: WP 3.1.1, GD Package
Tested up to: 3.4.2
Stable tag: 2.0

Analysis of your site's comments, showing which posts, authors, and categories generate the most discussion with tables, charts and geolocation.

== Description ==

Remarks gives useful charts, tables, and geolocations of your blog's comments, and may help you to decide how to focus your blog for even greater comment harvesting.  You will be able to see which of your posts, categories, and authors generate the most discussion. The breakdowns that Remarks produces are accessible via the WordPress Admin menu.

Remarks uses a slightly modified library called LibChart (http://naku.dohcrew.com/libchart/pages/introduction/) to draw bar and pie charts.

All feedback is really appreciated - please mail to john HAT frag1.co DOT uk.

== Installation ==

1. In the "Plugins" section of the WordPress Admin menu, click on "Add New"
2. Enter the phrase "Remarks" into the search bar (we are the first result!)
3. Press "download" and hit yes when the prompt asks you to.
4. After the download, hit "Activate"

== Frequently Asked Questions ==

= What should I do if the installation fails? =

contact the Frag1 team at frag1.co.uk

= Do I need to have anything installed for the graphs etc to work? =

The PHP drawing package GD is required. Please contact your web administrator for assistance here.

The interface uses jQuery

== Screenshots ==

1. This first screenshot shows the Overview Screen.

2. This screen shows the posts ordered by the number of comments.

3. This screen shows the Categories section, specifically the Table of information. 

4. This screen shows which Authors have the most comments.

5. This screen shows the Geolocation of the comments.

== Changelog ==

= 1.3 =
* Moved away from hostIP to FreeGeoIP. This resulted in a greater number of non UK posts being geolocated correctly (100% of our sample was placed right).
* Minor changes based on feedback.
* Reworked the buttons system to reduce code duplication and ease maintainability.

= 1.2 =
* Added a geolocation section. You can now find out which countries and cities host your biggest contributors.
* Other changes based on feedback.

= 1.1 =
* Laid out data in table format 
* Added dashboard buttons to show data in sections


== Upgrade Notice ==
= 1.3 =
* Moved away from HostIP to FreeGeoIP. This resulted in a greater number of non UK posts being geolocated correctly (100% of our sample was placed right).
* Fixed a minor bug with the geolocation button.

= 1.2 =
Added a geolocation section. You can now find out which countries and cities host your biggest contributors.

= 1.1 =
This upgrade gives Remarks buttons to show and hide the data in sections. The data is also laid out in an ultra-clear table format.
