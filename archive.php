<?php
/**
 * The archive page template.
 *
 * @package Brass Tacks
 */

get_header();
?>

	<main role="main">

		<section>

			<h1>
				<?php echo esc_html_e( 'Archives', 'bt' ); ?>
			</h1>

			<?php get_template_part( 'loop' ); ?>

			<?php get_template_part( 'pagination' ); ?>

		</section>

	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
