<?php
/**
 * Plugin Name: TweetView-Widget
 * Plugin URI: http://ppfeufer.de/tweetview-widget-anzeige-der-letzten-tweets-in-der-wordpress-sidebar/
 * Description: Adds a widget to your blogs sidebar to show your latest tweets. (XHTML-valid - based on Tweetbox from Rob Carr)
 * Version: 1.6
 * Author: <a href="http://sharjes.de">Simon Harjes</a> & <a href="http://ppfeufer.de">H.-Peter Pfeufer</a>
 */
if(!class_exists('Tweetview_Widget')) {
	class Tweetview_Widget extends WP_Widget {
		private $var_sUserAgent;
		private $var_sPluginVersion = '1.6';
		private $var_sTextdomain = 'tweetview-sidebar-widget';

		function Tweetview_Widget() {
			$this->var_sUserAgent = 'Mozilla/5.0 (X11; Linux x86_64; rv:5.0) Gecko/20100101 Firefox/5.0 Tweetview Widget (Version ' . $this->var_sPluginVersion . ') for WordPress';
			add_action('wp_footer', array(
				$this,
				'tweetview_javascript'
			));

			if(function_exists('load_plugin_textdomain')) {
				load_plugin_textdomain('tweetview-sidebar-widget', PLUGINDIR . '/' . dirname(plugin_basename(__FILE__)) . '/l10n', dirname(plugin_basename(__FILE__)) . '/l10n');
			}

			$widget_ops = array(
				'classname' => 'tweetview_widget',
				'description' => __('Tweetview Widget', $this->var_sTextdomain)
			);

			$control_ops = array();

			$this->WP_Widget('tweetview_widget', 'Tweetview Widget', $widget_ops, $control_ops);

			if(!is_admin()) {
				wp_enqueue_script('jquery');

				add_action('wp_head', array(
					$this,
					'tweetview_head'
				));
			} // END if(!is_admin())

			if(ini_get('allow_url_fopen') || function_exists('curl_init')) {
				add_action('in_plugin_update_message-' . plugin_basename(__FILE__), array(
					$this,
					'_update_notice'
				));
			}
		}

		function form($instance) {
			$instance = wp_parse_args((array) $instance, array(
				'tweetview_title' => '',
				'tweetview_username' => '',
				'tweetview_no_tweets' => '5'
			));

			// Titel
			echo '<p style="border-bottom: 1px solid #DFDFDF;"><strong>' . __('Title', $this->var_sTextdomain) . '</strong></p>';
			echo '<p><input id="' . $this->get_field_id('tweetview_title') . '" name="' . $this->get_field_name('tweetview_title') . '" type="text" value="' . $instance['tweetview_title'] . '" /></p>';
			echo '<p style="clear:both;"></p>';

			// Settings
			echo '<p style="border-bottom: 1px solid #DFDFDF;"><strong>' . __('Preferences', $this->var_sTextdomain) . '</strong></p>';
			echo '<p><label>' . __('Username', $this->var_sTextdomain) . '<br /><input id="' . $this->get_field_id('tweetview_username') . '" name="' . $this->get_field_name('tweetview_username') . '" type="text" value="' . $instance['tweetview_username'] . '" /></p>';
			echo '<p><label>' . __('Number of tweets to show', $this->var_sTextdomain) . '<br /></label><input id="' . $this->get_field_id('tweetview_no_tweets') . '" name="' . $this->get_field_name('tweetview_no_tweets') . '" type="text" value="' . $instance['tweetview_no_tweets'] . '" /></p>';
			echo '<p style="clear:both;"></p>';

			// Own CSS
			echo '<p style="border-bottom: 1px solid #DFDFDF;"><strong>' . __('Custom CSS', $this->var_sTextdomain) . '</strong></p>';
			echo '<p><span style="display:inline-block;">' . __('Write your CSS here ...', $this->var_sTextdomain) . ': </span><textarea id="' . $this->get_field_id('own-css') . '" rows="10" name="' . $this->get_field_name('own-css') . '">' . $instance['own-css'] . '</textarea></p>';
			echo '<p style="clear:both;"></p>';

			// Flattr
			echo '<p style="border-bottom: 1px solid #DFDFDF;"><strong>' . __('Like this Plugin? Buy me a coffee.', $this->var_sTextdomain) . '</strong></p>';
			echo '<p><a href="https://flattr.com/thing/93549/TweetView-Widget" target="_blank"><img src="http://api.flattr.com/button/flattr-badge-large.png" alt="Flattr this" title="Flattr this" border="0" /></a></p>';
			echo '<p style="clear:both;"></p>';
		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;

			$new_instance = wp_parse_args((array) $new_instance, array(
				'tweetview_title' => '',
				'tweetview_username' => '',
				'tweetview_no_tweets' => '5'
			));

			$instance['plugin-version'] = strip_tags($new_instance['plugin-version']);
			$instance['tweetview_title'] = strip_tags($new_instance['tweetview_title']);
			$instance['tweetview_username'] = strip_tags($new_instance['tweetview_username']);
			$instance['tweetview_no_tweets'] = strip_tags($new_instance['tweetview_no_tweets']);
			$instance['own-css'] = $new_instance['own-css'];

			print_r($instance);

			return $instance;
		}

		function widget($args, $instance) {
			extract($args);

			echo $before_widget;

			$title = (empty($instance['tweetview_title'])) ? '' : apply_filters('widget_title', $instance['tweetview_title']);

			if(!empty($title)) {
				echo $before_title . $title . $after_title;
			}

			echo $this->tweetview_output($instance, 'widget');
			echo $after_widget;
		}

		function tweetview_output($args = array(), $position) {
			echo '<script type="text/javascript">var tweetview_username = "' . $args['tweetview_username'] . '"; var tweetview_number_of_tweets = "' . $args['tweetview_no_tweets'] . '";</script>';
// 			echo '<script type="text/javascript">jQuery(document).ready(function() {twitter.load("' . $args['tweetview_username'] . '", ' . $args['tweetview_no_tweets'] . ')});</script>';
			echo '<ul id="tweetview_tweetlist"><li>' . __('Loading tweets', $this->var_sTextdomain) . ' ...</li></ul>';
			echo '<ul><li>' . __('Follow', $this->var_sTextdomain) . ' <a href="http://twitter.com/' . $args['tweetview_username'] . '">@' . $args['tweetview_username'] . '</a> ' . __('on twitter.', $this->var_sTextdomain) . '</li></ul>';
		}

		/**
		 * Injecting the header with the css
		 *
		 * @since 1.4
		 * @author ppfeufer
		 */
		function tweetview_head() {
			/**
			 * Adding the custom CSS to the header
			 */
			$array_widgetOptions = get_option('widget_tweetview-widget');

			/**
			 * Looking for custom CSS
			 */
			if(is_array($array_widgetOptions)) {
				foreach((array) $array_widgetOptions as $key => $value) {
					if($value['own-css']) {
						$var_sOwnCSS = $value['own-css'];
						break;
					} // END if($value['own-css'])
				} // END foreach($array_widgetOptions as $key => $value)

				if(isset($var_sOwnCSS) && $var_sOwnCSS != '') {
					/**
					 * Adding the CSS to the header
					 */
					echo "\n" . '<!-- CSS for Tweetview Widget by H.-Peter Pfeufer [http://ppfeufer.de | http://blog.ppfeufer.de] -->' . "\n" . '<style type="text/css">' . "\n" . $var_sOwnCSS . "\n" . '</style>' . "\n" . '<!-- END of CSS for Talos Tweetview Widget -->' . "\n\n";
				} // END if(isset($var_sOwnCSS) && $var_sOwnCSS != '')
			} // END if(is_array($array_widgetOptions))
		} // END function tweetview_head()

		/**
		 * Injecting the footer with the javascript
		 *
		 * @since 1.4
		 * @author ppfeufer
		 */
		function tweetview_javascript() {
			if(!is_page() || !is_attachment()) {
				wp_register_script('tweetview-js', plugin_dir_url(__FILE__) . 'js/tweetview-min.js', array(
// 				wp_register_script('tweetview-js', plugin_dir_url(__FILE__) . 'js/tweetview.js', array(
					'jquery'
				), $this->var_sPluginVersion, true);
				wp_enqueue_script('tweetview-js');
				wp_localize_script('tweetview-js', 'localizing_tweetview_js', array(
					'second' => __('second', $this->var_sTextdomain),
					'seconds' => __('seconds', $this->var_sTextdomain),
					'minute' => __('minute', $this->var_sTextdomain),
					'minutes' => __('minutes', $this->var_sTextdomain),
					'hour' => __('hour', $this->var_sTextdomain),
					'hours' => __('hours', $this->var_sTextdomain),
					'day' => __('day', $this->var_sTextdomain),
					'days' => __('days', $this->var_sTextdomain),
					'ago' => __('time ago:', $this->var_sTextdomain)
				));

				echo '<script type="text/javascript">jQuery(document).ready(function() {if((typeof tweetview_username != \'undefined\') && ( typeof tweetview_number_of_tweets != \'undefined\')) {twitter.load(tweetview_username, tweetview_number_of_tweets)}});</script>';
			} // END if(!is_page() || !is_attachment())
		} // END function tweetview_javascript()

		function _update_notice() {
			$url = 'http://plugins.trac.wordpress.org/browser/tweetview-widget/trunk/readme.txt?format=txt';
			$data = $this->_helper_curl($url);

			if($data) {
				$matches = null;
				$regexp = '~==\s*Changelog\s*==\s*=\s*[0-9.]+\s*=(.*)(=\s*' . preg_quote($this->var_sPluginVersion) . '\s*=|$)~Uis';

				if(preg_match($regexp, $data, $matches)) {
					$changelog = (array) preg_split('~[\r\n]+~', trim($matches[1]));

					echo '</div><div class="update-message" style="font-weight: normal;"><strong>' . __('What\'s new:', $this->var_sTextdomain) . '</strong>';
					$ul = false;
					$version = 99;

					foreach($changelog as $index => $line) {
						if(version_compare($version, $this->var_sPluginVersion, ">")) {
							if(preg_match('~^\s*\*\s*~', $line)) {
								if(!$ul) {
									echo '<ul style="list-style: disc; margin-left: 20px;">';
									$ul = true;
								} // END if(!$ul)

								$line = preg_replace('~^\s*\*\s*~', '', $line);
								echo '<li>' . $line . '</li>';
							} else {
								if($ul) {
									echo '</ul>';
									$ul = false;
								} // END if($ul)

								$version = trim($line, " =");
								echo '<p style="margin: 5px 0;">' . htmlspecialchars($line) . '</p>';
							} // END if(preg_match('~^\s*\*\s*~', $line))
						} // END if(version_compare($version, TWOCLICK_SOCIALMEDIA_BUTTONS_VERSION,">"))
					} // END foreach($changelog as $index => $line)

					if($ul) {
						echo '</ul><div style="clear: left;"></div>';
					} // END if($ul)

					echo '</div>';
				} // END if(preg_match($regexp, $data, $matches))
			} // END if($data)
		} // END function _update_notice()

		/**
		 * Helper for cURL
		 *
		 * <[[ NOTE ]]>
		 * We are not using wp_remote_get(); it will not work propper on every system.
		 * So we are using a simple cURL-call here. Make sure your PHP is compiled with cURL.
		 *
		 * @since 1.4
		 * @author ppfeufer
		 *
		 * @param string $var_sUrl
		 * @return mixed
		 */
		private function _helper_curl($var_sUrl = '') {
			if(ini_get('allow_url_fopen')) {
				$cUrl_Data = file_get_contents($var_sUrl);
			} else {
				if(function_exists('curl_init')) {
					$cUrl_Channel = curl_init($var_sUrl);
					curl_setopt($cUrl_Channel, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($cUrl_Channel, CURLOPT_HEADER, 0);

					// EDIT your domain to the next line:
					curl_setopt($cUrl_Channel, CURLOPT_USERAGENT, $this->var_sUserAgent);
					curl_setopt($cUrl_Channel, CURLOPT_TIMEOUT, 10);

					$cUrl_Data = curl_exec($cUrl_Channel);

					if(curl_errno($cUrl_Channel) !== 0 || curl_getinfo($cUrl_Channel, CURLINFO_HTTP_CODE) !== 200) {
						$cUrl_Data === false;
					} // END if(curl_errno($ch) !== 0 || curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200)

					curl_close($cUrl_Channel);
				}
			}

			return $cUrl_Data;
		} // END private function helper_curl($var_sUrl = '')
	}
} // END if(!class_exists('Tweetview_Widget'))

add_action('widgets_init', create_function('', 'return register_widget("Tweetview_Widget");'));
?>