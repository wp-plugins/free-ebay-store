<?php
/*
Plugin Name: Free eBay Store
Plugin URI: http://geeklad.com/free-ebay-store
Description: Display your own ebay store on your blog.  To display a store, use the following code in a page or post:  <code>[ebay campaignid="YOUR-CAMPAIGN-ID" keywords="YOUR-STORE-KEYWORDS" rows="NUMBER-OF-ROWS-YOU-WANT-TO-DISPLAY" columns="NUMBER-OF-COLUMNS-YOU-WANT-TO-DISPLAY" pagination="yes" vertical="yes"]</code>  Use spaces between the keywords.  You can also <a href="widgets.php">display the store as a widget</a>.
Author: GeekLad
Version: 1.2
Author URI: http://geeklad.com/
License: GPL*/

/*  Copyright 2009 GeekLad (email : geeklad@geeklad.com)    This program is free software; you can redistribute it and/or modify    it under the terms of the GNU General Public License as published by    the Free Software Foundation; either version 2 of the License, or    (at your option) any later version.    This program is distributed in the hope that it will be useful,    but WITHOUT ANY WARRANTY; without even the implied warranty of    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the    GNU General Public License for more details.    You should have received a copy of the GNU General Public License    along with this program; if not, write to the Free Software    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA*/

add_shortcode('ebay', 'ebay_store_display');
function ebay_store_display($atts) {
	extract(shortcode_atts(array(
			'campaignid' => false,
			'keywords' => false,
			'rows' => '5',
			'columns' => '2',
			'pagination' => false,
			'vertical' => false,
		), $atts));
		
		if (!$keywords || !$campaignid)
			return "";
		
		if ($pagination && $pagination != "none") {
			$pagination = "&pagination=yes";
			if ($_GET['pagenumber'])
				$pagination .= "&pagenumber=" . $_GET['pagenumber'];
			else
				$pagination .= "&pagenumber=1";
		}
		
		if ($vertical && $vertical != "no") {
			$vertical = "&display=vertical";
		}
		
		$keywords = urlencode($keywords);
		$storeurl = "http://geeklad.com/tools/ebay.php?campaignid=$campaignid&rows=$rows&columns=$columns$pagination$vertical&keyword=$keywords";
		return file_get_contents($storeurl);
}
add_action("plugins_loaded", "ebay_store_widget_init");
function ebay_store_widget_init() {
	register_widget_control(__('Free eBay Store'), 'ebay_store_widget_control');
	register_sidebar_widget(__('Free eBay Store'), 'ebay_store_widget');
}

function ebay_store_widget_control() {
	$options = $newoptions = get_option('ebay_store_widget');
	if ( $_POST["ebay_store_widget_submit"] ) {
		$newoptions['title'] = $_POST["ebay_store_widget_title"];
		$newoptions['campaignid'] = $_POST["ebay_store_widget_campaignid"];
		$newoptions['keywords'] = $_POST["ebay_store_widget_keywords"];
		$newoptions['itemcount'] = $_POST["ebay_store_widget_itemcount"];
		$newoptions['before'] = str_replace("\"", "'", str_replace("\\", "", $_POST["ebay_store_widget_before"]));
		$newoptions['after'] = $_POST["ebay_store_widget_after"];
	}
	
	if ( empty($options['keywords']) && empty($options['campaignid']) ) {
		$title = "Buy on eBay";
		$keywords = "";
		$itemcount = 3;
		$before = "<div style='font-size: 10px; line-height: 12px;'>";
		$after = "</div>";
	}
	else {
		$title = $newoptions['title'];
		$campaignid = $newoptions['campaignid'];
		$keywords = $newoptions['keywords'];
		$itemcount = $newoptions['itemcount'];
		$before = $newoptions['before'];
		$after = $newoptions['after'];
	}
	
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('ebay_store_widget', $options);
	}
?>
			<p><label for="ebay-store-widget-title"><?php _e('Title:'); ?> <input class="widefat" name="ebay_store_widget_title" type="text" value="<?php echo $title; ?>" title="This will be the title of the widget on your webpage."/></label></p>
			<p>
				<label for="ebay-store-widget-campaignid"><?php _e('Campaign ID<br>'); ?><input type="text" name="ebay_store_widget_campaignid" value="<?php echo $campaignid; ?>" title="Don't forget your eBay campaign ID!" />
				<br />
			</p>
			<p>
				<label for="ebay-store-widget-keywords"><?php _e('Keywords<br>'); ?><input type="text" name="ebay_store_widget_keywords" value="<?php echo $keywords; ?>" title="You can specify multiple sets of keywords by separating them with a pipe character (|).  For example, to display teddy bears or inflatable pools at random, you would enter they keywords as: teddy bear|inflatable pool"/>
				<br />
			</p>
			<p>
				<label for="ebay-store-widget-itemcount"><?php _e('# Items to Display<br>'); ?><input type="text" name="ebay_store_widget_itemcount" value="<?php echo $itemcount; ?>" title="The number of items to display in the widget."/>
				<br />
			</p>
			<p>
				<label for="ebay-store-widget-before"><?php _e('Before Store<br>'); ?><input type="text" name="ebay_store_widget_before" value="<?php echo $before; ?>" title="The html code to use before the widget.  The default choice reduces the font so that it might fit a bit better in a sidebar."/>
				<br />
			</p>
			<p>
				<label for="ebay-store-widget-after"><?php _e('After Store<br>'); ?><input type="text" name="ebay_store_widget_after" value="<?php echo str_replace("\\", "", $after); ?>" title="Be sure to close the tag you use before the widget." />
				<br />
			</p>
			<input type="hidden" id="ebay_store_widget_submit" name="ebay_store_widget_submit" value="1" />
<?php
}

function ebay_store_widget($args) {
	$options = get_option('ebay_store_widget');
	if ($options['keywords'] && $options['campaignid']) {
		if ( '%BEG_OF_TITLE%' != $args['before_title'] ) {
			if ( $output = wp_cache_get('ebay_store_widget', 'widget') )
				return print($output);
			ob_start();
		}

		extract($args);
		$keywords = @preg_split("/\|/", $options['keywords']);
		if (!$keywords)
			$keywords = $options['keywords'];
		else
			$keywords = $keywords[rand(0, count($keywords)-1)];
		$options['keywords'] = $keywords;
		$options['vertical'] = "yes";
		$options['columns'] = 1;
		$options['rows'] = $options['itemcount'];

		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo str_replace("\\", "", $before);
		echo ebay_store_display($options);
		echo str_replace("\\", "", $after);
		echo $after_widget;
		
		if ( '%BEG_OF_TITLE%' != $args['before_title'] )
			wp_cache_add('ebay_store_widget', ob_get_flush(), 'widget');
	}
}
?>