<?php
/*
Plugin Name: Free eBay Store
Plugin URI: http://geeklad.com/free-ebay-store
Description: Display your own ebay store on your blog.  To display a store, use the following code in a page or post:  <code>[ebay campaignid="YOUR-CAMPAIGN-ID" keywords="YOUR-STORE-KEYWORDS" rows="NUMBER-OF-ROWS-YOU-WANT-TO-DISPLAY" columns="NUMBER-OF-COLUMNS-YOU-WANT-TO-DISPLAY"]</code>  Be sure to use double quotes for the parameters, and use spaces between the keywords.  You can also <a href="widgets.php">display the store as a widget</a>.
Author: GeekLad
Version: 1.1
Author URI: http://geeklad.com/
License: GPL*/

/*  Copyright 2009 GeekLad (email : geeklad@geeklad.com)    This program is free software; you can redistribute it and/or modify    it under the terms of the GNU General Public License as published by    the Free Software Foundation; either version 2 of the License, or    (at your option) any later version.    This program is distributed in the hope that it will be useful,    but WITHOUT ANY WARRANTY; without even the implied warranty of    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the    GNU General Public License for more details.    You should have received a copy of the GNU General Public License    along with this program; if not, write to the Free Software    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA*/add_filter('the_content', 'ebay_store_display');
function ebay_store_display($content) {
	preg_match_all("/\[ebay[^\]]*\]/", $content, $storematches);
	if ($storematches) {
		$stores = array();
		foreach ($storematches[0] as $parameters) {
			$campaignid = ebay_store_get_parameters("campaignid", $parameters);
			$keywords = ebay_store_get_parameters("keywords", $parameters);
			$rows = ebay_store_get_parameters("rows", $parameters);
			$columns = ebay_store_get_parameters("columns", $parameters);
			if ($rows)
				$rows = "&rows=$rows";
			if ($columns)
				$columns = "&columns=$columns";
			$storeurl = "http://geeklad.com/tools/ebay.php?campaignid=$campaignid$rows$columns&keyword=$keywords";
			$stores[count($stores)] = file_get_contents($storeurl);
			$content = preg_replace("/" . preg_quote($parameters) . "/", "[store]", $content, 1);
		}
		preg_match_all("/\[store\]/", $content, $storeplacements);
		while (preg_match("/\[store\]/", $content)) {	
			$content = preg_replace("/\[store\]/", str_replace("$", "\\$", array_shift($stores)), $content, 1);
		}
	}
	return $content;
}

function ebay_store_get_parameters($parametername, $parameters) {
	$parameter = false;
	if (preg_match("/.*" . preg_quote($parametername) . "\s*=\s*\"([^\"]*)\".*/", $parameters))
		$parameter =  preg_replace("/.*" . preg_quote($parametername) . "\s*=\s*\"([^\"]*)\".*/", "$1", $parameters);
	return $parameter;
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
		$newoptions['before'] = $_POST["ebay_store_widget_before"];
		$newoptions['after'] = $_POST["ebay_store_widget_after"];
	}
	
	if ( empty($options['keywords']) ) {
		$title = "Buy on eBay";
		$keywords = "teddy bear|inflatable pool";
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
				<label for="ebay-store-widget-before"><?php _e('Before Store<br>'); ?><input type="text" name="ebay_store_widget_before" value="<?php echo str_replace("\\", "", $before); ?>" title="The html code to use before the widget.  The default choice reduces the font so that it might fit a bit better in a sidebar."/>
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
	if ($options['keywords']) {
		if ( '%BEG_OF_TITLE%' != $args['before_title'] ) {
			if ( $output = wp_cache_get('ebay_store_widget', 'widget') )
				return print($output);
			ob_start();
		}

		extract($args);
		$title = $options['title'];
		$campaignid = $options['campaignid'];
		$keywords = $options['keywords'];
		$keywords = @preg_split("/\|/", $keywords);
		if (!$keywords)
			$keywords = $options['keywords'];
		else
			$keywords = $keywords[rand(0, count($keywords)-1)];
		$itemcount = $options['itemcount'];
		$before = $options['before'];
		$after = $options['after'];
		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo str_replace("\\", "", $before);
		echo file_get_contents("http://geeklad.com/tools/ebay.php?campaignid=$campaignid&rows=$itemcount&columns=1&keyword=$keywords");
		echo str_replace("\\", "", $after);
		echo $after_widget;
		
		if ( '%BEG_OF_TITLE%' != $args['before_title'] )
			wp_cache_add('ebay_store_widget', ob_get_flush(), 'widget');
	}
}
