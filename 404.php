<?php
/**
 * The 404 page template.
 *
 * @package Wonderpress Theme
 */

// Set the <body> id
wonder_body_id( '404' );

get_header();
?>

	<main id="main" tabindex="-1">

		<section>

			<article id="post-404">

				<h1>
					<?php esc_html_e( 'Page not found', 'wonder' ); ?>
				</h1>
				<h2>
					<a href="<?php echo esc_url( home_url() ); ?>">
						<?php esc_html_e( 'Return home?', 'wonder' ); ?>
					</a>
				</h2>

			</article>

		</section>

	</main>

<?php get_footer(); ?>
