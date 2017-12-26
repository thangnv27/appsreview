=== BBCode ===
Contributors: bOingball
Donate link: http://www.x-3dfx.com/donate/
Tags: bbcode, color, extended
Requires at least: 2.5
Stable tag: trunk
version: 1.1.2

Implements Extended BBCode in posts.

== Description ==

I've created a mod of the excellent BBCode pluging by Viper007Bond.

Since Vipers Plugin didn't support some BBCode commands I thought I would add them since I need them in my buddypress installation.

This plug-in now supports all of the standard BBcode options.

`
Bold: [b]bold[/b]
Italics: [i]italics[/i]
Underline: [u]underline[/u]
URL: [url]http://wordpress.org/[/url] [url="http://wordpress.org/"]WordPress[/url]
Image: [img]http://s.wordpress.org/style/images/codeispoetry.png[/img]
Quote: [quote]Lorem ipsum dolor sit amet, consectetuer adipiscing elit,[/quote]
Named Quote: [quote="NAME"]Lorem ipsum dolor sit amet[/quote]
Color: [color="red"]something red[/color]
Strikeout:[s]striked this out[/s]
Center Text:[center]center me[/center]
Computer code:[code]10 GOTO 10[/code]
Font size: [size=10]10px font size[/size]
Ordered lists: [ol][li][/li][/ol]
Unordered lists: [ul][li][/li][/ul]
List Item: [li]item[/li]
Youtube Links: [youtube]Youtube ID[/youtube]
Google Video Links: [gvideo]Google Video ID[/gvideo]
Named Spoiler: [spoiler=two plus two]four[/spoiler]
Unnamed Spoiler: [spoiler]Boo![/spoiler]
`

== Installation ==

###Updgrading From A Previous Version###

To upgrade from a previous version of this plugin, delete the entire folder and files from the previous version of the plugin and then follow the installation instructions below.

###Installing The Plugin###

Extract all files from the ZIP file, making sure to keep the file structure intact, and then upload it to `/wp-content/plugins/`.

This should result in the following file structure:

`- wp-content
    - plugins
        - boingball-bbcode
            | readme.txt
            | boingball-bbcode.php
`

Then just visit your admin area and activate the plugin.

**See Also:** ["Installing Plugins" article on the WP Codex](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins)

== Frequently Asked Questions ==

= I love your plugin! Can I donate to you? =

Sure you can if you like the extended features over the orignal please go to http://www.x-3dfx.com/donate/, I've created this to help some users out in my spare time so anything is apprecated.

 Also if you haven't already - Viper007bond deserves the main credit for this plugin so please help him out as well. http://www.viper007bond.com/donate/

== ChangeLog ==
**Version 1.1.2**

* Added support for upper and lower case BBCodes

**Version 1.1.1**

* Added support for [Spoiler] tag, corrected implode error if no video ids are used.

**Version 1.1.0**

* Added support for all standard bbcode options

**Version 1.0.1**

* Fixed coding of URL's so that it works with [URL=http][/URL] as well as [URL=""][/URL]

**Version 1.0.0**

* Initial release based of the core 1.0.1 of Viper007bonds plug-in,
Adding support for :
Color: [color="red"]something red[/color]
Strikeout:[s]striked this out[/s]
Center Test:[center]center me[/center]
Computer code:[code]10 GOTO 10[/code]