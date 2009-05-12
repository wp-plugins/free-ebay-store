=== Plugin Name ===
Contributors: GeekLad
Donate link: http://geeklad.com
Tags: ebay, store, earn, money
Requires at least: 2.0
Tested up to: 2.7.1
Stable tag: 1.2

Display an eBay store on your website, and sell products with your own campaign ID. Display them within posts, or as a widget.

== Description ==

The Free eBay Store plugin allows you to automatically display eBay listings on your blog. You just add a simple tag to a post or page, along with your eBay Campaign ID, and the relevant keywords for the products to be displayed. You can also optionally specify the number of rows and columns to specify the layout of your eBay store. Why pay to build an eBay store when you can build one for free?

== Installation ==

= Installation of the Plugin =
1. Upload `free-ebay-store.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

= Displaying a Store in Pages or Posts =

If you want to display the store on a page or post, use the following [shortcode](http://faq.wordpress.com/2008/06/18/what-are-the-wordpress-shortcodes/):

	[ebay campaignid="_YourCampaignID_" keywords="_Product Keywords_" rows="_RowCount_" columns="_ColumnCount_" pagination="_yes_" vertical="_yes_"]

Required Parameters:

* campaignid
* keywords

Be sure to set the _campaignid_ to your own eBay campaign ID.  _keywords_ should contain the keywords for products you want in your store.  Separate the keywords with spaces, and if you want to exclude a particular word, prefix it with a *-* character.  If you want, you can put multiple stores on the same page or post.  Just place multiple shortcodes with the product info you wish to display in each store.

Optional Parameters:

* rows (_Default: 5_)
* columns (_Default = 2_)
* pagination (_Default: none_)
* vertical (_Default: no_)

Set _row_ to the number of product rows you want to display and and _column_ to the number of product columns you want to display.

If you specify the _pagination="yes"_ parameter, it will enable pagination of the store page.  If you have multiple stores on one page, this may cause some odd results if the stores do not have the same row and column count.

If you specify the _vertical="yes"_, it will place the item info below the image rather than to the right of it.

= Displaying a Store as a Widget =

1. Go to *Appearance* > *Widgets* in WordPress.
2. Select the section where you want the widget to appear and click *Show*.
3. Click the *Add* button next to the *Free eBay Store* widget.
4. Be sure to enter your *Campaign ID* and *Keywords*.  For multiple keywords, separate them with a pipe character (*|*), e.g. _star wars lego|inflatable pool|swingset_.  When multiple keywords are used, one of them will be selected at random each time the widget is displayed.
5. Select the number of items to display.
6. Select the HTML code to display before the widget.
7. Select the HTML code to display after the widget.
8. Click *Save Changes*.

== Frequently Asked Questions ==

= What's the maximum number of products that can be displayed? = 

25.

= Is it possible to put more than one store on a single page? =

Yes.  Just enter the appropriate shortcode multiple times.

= Why would I want to put more than one store on a single page? =

You may want to display different types of products within the same page.  For instance, if you wanted to display iPods and headphones on the same page, you could use the following shortcode:

	[ebay id="1" campaignid="0123456789" keywords="ipod" columns="2" rows="3"]
	[ebay id="2" campaignid="0123456789" keywords="headphones" columns="2" rows="3"]

= Why is only one column displayed in the widget? =

I got anxious to release the plugin to the public and got lazy toward the end.  If there is demand to display more than one column, I will add it in.  Most sidebars in WordPress templates will only reasonably fit a single column anyway.

= What's the catch? There are a lot of eBay stores out there that cost money.  Why is yours free? =

* I shamelessly place a link back to the plugin homepage to promote my plugin.
* 40% of the time, your campaign ID is displayed.  The other 60% of the time, my campaign ID is displayed.

= You only display my campaign ID 40% of the time? What's up with that?  Why won't you display my campaign ID more often? =

As usage of the plugin increases, I will likely increase the display of user campaign IDs.

== Screenshots ==

1. This is a 2-column, 5-row in-line (in a blog post) store, with pagination.
2. This is a 3-item sidebar widget.