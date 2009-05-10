=== Plugin Name ===
Contributors: GeekLad
Donate link: http://geeklad.com
Tags: ebay, store, earn, money
Requires at least: 2.0
Tested up to: 2.7.1
Stable tag: 1.1

Display an eBay store on your website, and sell products with your own campaign ID. Display them within posts, or as a widget.

== Description ==

The Free eBay Store plugin allows you to automatically display eBay listings on your blog. You just add a simple tag to a post or page, along with your eBay Campaign ID, and the relevant keywords for the products to be displayed. You can also optionally specify the number of rows and columns to specify the layout of your eBay store. Why pay to build an eBay store when you can build one for free?

== Installation ==

= Installation of the Plugin =
1. Upload `free-ebay-store.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

= Displaying a Store in Pages or Posts =
If you want to display the store on a page or post, use the following code:

	[ebay campaignid="YourCampaignID" keywords="Product Keywords" rows="RowCount" columns="ColumnCount"]

Be sure to replace _YourCampaignID_ with your own eBay campaign ID, _Product Keywords_ with the keywords for products you want in your store, _RowCount_ with the number of rows and _ColumnCount_ with the number of columns.

Make sure that you *always use double-quotes for each of the parameters* and *use spaces between the keywords*.  You can display more than one store in a single post/page, and use a totally different configuration if you want (different keywords, rows, columns, even campaign ID). If you don't have an eBay campaign ID, sign up to [become an eBay affiliate](https://www.ebaypartnernetwork.com/) and [get one](https://publisher.ebaypartnernetwork.com/PublisherCampaignCreate).

= Displaying a Store as a Widget =
1. Go to *Appearance* > *Widgets* in WordPress.
2. Select the section where you want the widget to appear and click *Show*.
3. Click the *Add* button next to the *Free eBay Store* widget.
4. Be sure to enter your *Campaign ID* and *Keywords*.  For multiple keywords, separate them with a pipe character (*|*), e.g. _dollhouse|inflatable pool|swingset_.
5. Select the number of items to display.
6. Select the HTML code to display before the widget.
7. Select the HTML code to display after the widget.
8. Click *Save Changes*.

== Frequently Asked Questions ==

= What's the catch? Other people usually charge for this kind of stuff? =

* I shamelessly place a link back to the plugin homepage to promote my plugin.
* 40% of the time, your campaign ID is displayed.  The other 60% of the time, my campaign ID is displayed.

= 40%? What's up with that?  Why won't you display my campaign ID more often? =

As usage of the plugin increases, I will likely increase the display of user campaign IDs.

= What's the maximum number of products that can be displayed? = 

25.

= Why is only one column displayed in the widget? =

I got anxious to release the plugin to the public and got lazy toward the end.  If there is demand to display more than one column, I will add it in.  Most sidebars in WordPress templates will only reasonably fit a single column anyway.

== Screenshots ==

1. This is a 1-column, 3-row in-line (in a blog post) store.
2. This is a 3-item sidebar widget.