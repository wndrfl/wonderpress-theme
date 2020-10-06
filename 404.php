<?php
/**
 * The 404 page template.
 *
 * @package Brass Tacks
 */

get_header();
?>

	<main role="main">

		<section>

			<article id="post-404">

				<h1>
					<?php echo esc_html_e( 'Page not found', 'bt' ); ?>
				</h1>
				<h2>
					<a href="<?php echo esc_url( home_url() ); ?>">
						<?php echo esc_html_e( 'Return home?', 'bt' ); ?>
					</a>
				</h2>

			</article>

		</section>

	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
