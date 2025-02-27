<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://shehab24.github.io/portfolio/
 * @since      1.0.0
 *
 * @package    Post_Words_Counter
 * @subpackage Post_Words_Counter/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Post_Words_Counter
 * @subpackage Post_Words_Counter/public
 * @author     Shehab Mahamud <mdshehab204@gmail.com>
 */
class PSTWC_Post_Words_Counter_Public
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/post-words-counter-public.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/post-words-counter-public.js', array('jquery'), $this->version, false);

	}

	public function pstwc_post_words_count_showing_into_post($content)
	{
		$currentDisplayLocation = get_option("pstwc_displayLocation", 2);
		$currentHeadlineText = sanitize_text_field(get_option("pstwc_headlineText", "Post Statistics"));
		$currentWordCount = get_option("pstwc_wordCount", 1);
		$currentCharacterCount = get_option("pstwc_characterCount", 1);
		$currentReadTime = get_option("pstwc_readTime", 1);

		$modifiedContent = ''; // Initialize the modified content variable

		if ($currentDisplayLocation == 1)
		{
			if (is_main_query() && is_single())
			{
				if ($currentWordCount == 1 || $currentCharacterCount == 1 || $currentReadTime == 1)
				{
					$modifiedContent .= '<h2>' . esc_html($currentHeadlineText) . '</h2>';
				}
				if ($currentWordCount == 1)
				{
					$wordCount = str_word_count(strip_tags($content));
					$modifiedContent .= '<h5>This Post has ' . esc_html($wordCount) . ' Words.</h5>';
				}
				if ($currentCharacterCount == 1)
				{
					$modifiedContent .= '<h5>This Post has ' . esc_html(strlen(strip_tags($content))) . ' Characters.</h5>';
				}
				if ($currentReadTime == 1)
				{
					$wordCount = str_word_count(strip_tags($content)); // Make sure to calculate word count before using it
					$modifiedContent .= '<h5>This Post will take about ' . esc_html(round($wordCount / 225)) . ' minute(s) to read.</h5>';
				}
			}
			$modifiedContent .= $content; // Append the original content
		} else
		{
			$modifiedContent .= $content; // Append the original content
			if (is_main_query() && is_single())
			{
				if ($currentWordCount == 1 || $currentCharacterCount == 1 || $currentReadTime == 1)
				{
					$modifiedContent .= '<h2>' . esc_html($currentHeadlineText) . '</h2>';
				}
				if ($currentWordCount == 1)
				{
					$wordCount = str_word_count(strip_tags($content));
					$modifiedContent .= '<h5>This Post has ' . esc_html($wordCount) . ' Words.</h5>';
				}
				if ($currentCharacterCount == 1)
				{
					$modifiedContent .= '<h5>This Post has ' . esc_html(strlen(strip_tags($content))) . ' Characters.</h5>';
				}
				if ($currentReadTime == 1)
				{
					$wordCount = str_word_count(strip_tags($content)); // Make sure to calculate word count before using it
					$modifiedContent .= '<h5>This Post will take about ' . esc_html(round($wordCount / 225)) . ' minute(s) to read.</h5>';
				}
			}
		}

		return $modifiedContent; // Return the modified content
	}


}