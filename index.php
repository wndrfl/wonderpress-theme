<?php
/**
 * The index page template.
 *
 * @package Brass Tacks
 */

// Set the <body> id
bt_body_id( 'index' );

get_header();
?>

	<main role="main">

		<section>

			<h1>
				<?php echo esc_html_e( 'Latest Posts', 'bt' ); ?>
			</h1>

			<?php get_template_part( 'loop' ); ?>

			<?php get_template_part( 'pagination' ); ?>

		</section>
		
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
