<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://shehab24.github.io/portfolio/
 * @since      1.0.0
 *
 * @package    Post_Words_Counter
 * @subpackage Post_Words_Counter/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Post_Words_Counter
 * @subpackage Post_Words_Counter/admin
 * @author     Shehab Mahamud <mdshehab204@gmail.com>
 */
class Post_Words_Counter_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Post_Words_Counter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Words_Counter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/post-words-counter-admin.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Post_Words_Counter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Words_Counter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/post-words-counter-admin.js', array('jquery'), $this->version, false);

	}

	public function pstwc_add_setting_page_admin()
	{
		add_options_page(
			__('Post Words Counter', 'post-words-counter'),
			__('Words Counter', 'post-words-counter'),
			'manage_options',
			'post-words-counter',
			array(
				$this,
				'post_words_counter_page'
			)
		);
	}

	public function post_words_counter_page()
	{
		if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['post_count_nonce']))
		{

			if (!current_user_can('manage_options') || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['post_count_nonce'])), 'post_count_nonce'))
			{
				wp_die('Access denied.', 'Error', array('response' => 403));
			}
			$displayLocation = isset($_POST['displayLocation']) ? intval($_POST['displayLocation']) : 0;
			$wordCount = isset($_POST['wordCount']) ? 1 : 0;
			$characterCount = isset($_POST['characterCount']) ? 1 : 0;
			$readTime = isset($_POST['readTime']) ? 1 : 0;
			$headlineText = isset($_POST['headlineText']) ? sanitize_text_field($_POST['headlineText']) : "Post Statistics";

			update_option("pstwc_displayLocation", $displayLocation);
			update_option("pstwc_wordCount", $wordCount);
			update_option("pstwc_characterCount", $characterCount);
			update_option("pstwc_readTime", $readTime);
			update_option("pstwc_headlineText", $headlineText);
		}

		// Fetch the current values from options for pre-filling the form
		$currentDisplayLocation = get_option("pstwc_displayLocation", 2);
		$currentWordCount = get_option("pstwc_wordCount", 1);
		$currentCharacterCount = get_option("pstwc_characterCount", 1);
		$currentReadTime = get_option("pstwc_readTime", 1);
		$currentHeadlineText = get_option("pstwc_headlineText", "Post Statistics");
		?>

		<div class="wrap">
			<h2>Word Counter Settings Page</h2>
			<form method="post">
				<div class="form_control">
					<label for="displayLocation">Display Location</label>
					<select name="displayLocation" id="displayLocation">
						<option value="1" <?php selected($currentDisplayLocation, 1); ?>>Beginning of Post</option>
						<option value="2" <?php selected($currentDisplayLocation, 2); ?>>Ending of Post</option>
					</select>
				</div>
				<div class="form_control">
					<label for="headlineText">Headline Text</label>
					<input type="text" name="headlineText" id="headlineText"
						value="<?php echo esc_attr($currentHeadlineText); ?>">
				</div>
				<div class="form_control">
					<label for="wordCount">Word Count</label>
					<input type="checkbox" name="wordCount" id="wordCount" <?php checked($currentWordCount, 1); ?>>
				</div>
				<div class="form_control">
					<label for="characterCount">Character Count</label>
					<input type="checkbox" name="characterCount" id="characterCount" <?php checked($currentCharacterCount, 1); ?>>
				</div>
				<div class="form_control">
					<label for="readTime">Read Time</label>
					<input type="checkbox" name="readTime" id="readTime" <?php checked($currentReadTime, 1); ?>>
				</div>
				<?php wp_nonce_field('post_count_nonce', 'post_count_nonce'); ?>
				<?php submit_button('Save Settings'); ?>
			</form>
			<div>
				<a href="<?php echo esc_url('https://www.buymeacoffee.com/shehab24'); ?>"><img
						src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'images/buy-coffee.gif'); ?>"></a>
			</div>
		</div>
		<?php
	}

	public function pstwc_remove_author_column($columns)
	{
		global $post_type;

		if ($post_type === 'post')
		{
			unset($columns['author']);
		}
		return $columns;
	}

	public function pstwc_add_word_count_column($columns)
	{
		global $post_type;

		if ($post_type === 'post')
		{
			$new_columns = array();

			foreach ($columns as $key => $value)
			{
				$new_columns[$key] = $value;

				if ($key === 'title')
				{
					$new_columns['word_count'] = 'Total Words';
				}
			}

			return $new_columns;
		}

		return $columns;
	}


	function pstwc_add_word_counter_into_column($column_name, $post_id)
	{
		global $post_type;
		if ($post_type === 'post')
		{
			if ($column_name === 'word_count')
			{

				$post_content = get_post_field('post_content', $post_id);
				$wordCounter = str_word_count(strip_tags($post_content));
				echo '<p>' . esc_html($wordCounter) . ' words</p>';
			}
		}
	}




}