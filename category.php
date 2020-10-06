<?php
/**
 * The category page template.
 *
 * @package Brass Tacks
 */

// Set the <body> id
bt_body_id( 'category' );

get_header();
?>

	<main role="main">

		<section>

			<h1>
			<?php
			esc_html_e( 'Categories for ', 'bt' );
			single_cat_title();
			?>
			</h1>

			<?php get_template_part( 'loop' ); ?>

			<?php get_template_part( 'pagination' ); ?>

		</section>

	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
