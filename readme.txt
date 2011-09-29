=== Catagories by Tag Table ===
Contributors: haroldstreet
Donate link: http://www.haroldstreet.org.uk/thanks/
Tags: html, table, categories, category, tags, tag, embed, list, navigation, menu, post, page, plugin, free
Requires at least: 2.7
Tested up to: 3.2.1
Stable tag: trunk

'Catagories by Tag Table' displays all your Catagories as rows and Tags as columns in a html table.

== Description ==

'Catagories by Tag Table' allows you to display all your Catagories as rows and Tags as columns in a html table.
Once activated it will replace the text '[CATS_BY_TAGS_TABLE]' in any post or page with a table.
Each cell displays the number of posts that are in both the category and have the tag, and a URL link to those posts.
It might be a useful way to list your content for navigation or embed as a menu.

The options menu allows you to; 
*   specify the text displayed in the first cell
*   specify the basic CSS style of the table's <td> elements
*   specify whether Categories are rows with tags as columns or vice versa

== Installation ==

1. Upload `cat-by-tags-table.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure through 'Options' menu.
1. Include the text '[CATS_BY_TAGS_TABLE]' in a post or page content 
*   alternatively you may place the following php code in your page.php file...
`<?php if(function_exists("display_cats_by_tag")){echo display_cats_by_tag();} ?>`

== Screenshots ==

1. This is a screen shot of the table generated in a post and corresponds to `/cat-by-tags-table/screenshot1.png`


== Frequently Asked Questions ==

= Can I change the style of the table =
You can specify the style of the cells by the <td> style element through options
if you want to do more than this you might edit the Stylesheet of your theme 

== Changelog ==

= 1.01 =
First stable release

== Upgrade Notice ==

= 1.01 =
First stable release

== License ==

Copyright 2011  Phil Newby  (email: phil@haroldstreet.org.uk )

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.