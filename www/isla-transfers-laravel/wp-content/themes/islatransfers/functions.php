<?php
/**
 * IslaTransfers functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since IslaTransfers 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'islatransfers_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since IslaTransfers 1.0
	 *
	 * @return void
	 */
	function islatransfers_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'islatransfers_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'islatransfers_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since IslaTransfers 1.0
	 *
	 * @return void
	 */
	function islatransfers_editor_style() {
		add_editor_style( get_parent_theme_file_uri( 'assets/css/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 'islatransfers_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'islatransfers_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since IslaTransfers 1.0
	 *
	 * @return void
	 */
	function islatransfers_enqueue_styles() {
		wp_enqueue_style(
			'islatransfers-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'islatransfers_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'islatransfers_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since IslaTransfers 1.0
	 *
	 * @return void
	 */
	function islatransfers_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'islatransfers' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'islatransfers_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'islatransfers_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since IslaTransfers 1.0
	 *
	 * @return void
	 */
	function islatransfers_pattern_categories() {

		register_block_pattern_category(
			'islatransfers_page',
			array(
				'label'       => __( 'Pages', 'islatransfers' ),
				'description' => __( 'A collection of full page layouts.', 'islatransfers' ),
			)
		);

		register_block_pattern_category(
			'islatransfers_post-format',
			array(
				'label'       => __( 'Post formats', 'islatransfers' ),
				'description' => __( 'A collection of post format patterns.', 'islatransfers' ),
			)
		);
	}
endif;
add_action( 'init', 'islatransfers_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'islatransfers_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since IslaTransfers 1.0
	 *
	 * @return void
	 */
	function islatransfers_register_block_bindings() {
		register_block_bindings_source(
			'islatransfers/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'islatransfers' ),
				'get_value_callback' => 'islatransfers_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'islatransfers_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'islatransfers_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since IslaTransfers 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function islatransfers_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

add_filter('genesis_custom_blocks_render_callback_listado-json', 'mostrar_listado_json');

function mostrar_listado_json() {
    $url = 'http://localhost/admin/estadisticas-zonas';
    $json = @file_get_contents($url);

    if ($json === false) {
        return '<p>Error al obtener los datos.</p>';
    }

    $data = json_decode($json, true);
    if ($data === null) {
        return '<p>Error al procesar JSON.</p>';
    }

    if (empty($data)) {
        return '<p>No hay zonas registradas.</p>';
    }

    $output = '<ul>';
    foreach ($data as $zona) {
        // Solo mostramos la descripción de la zona
        $output .= '<li>' . esc_html($zona['descripcion']) . '</li>';
    }
    $output .= '</ul>';

    return $output;
}




