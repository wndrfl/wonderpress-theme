<?php
/**
 * The theme search page template.
 *
 * @package Brass Tacks
 */

// Set the <body> id
bt_body_id( 'search' );

get_header();
?>

	<main role="main">
		<section>

			<h1>
			<?php echo get_search_query(); ?>
			</h1>

			<?php get_template_part( 'loop' ); ?>

			<?php get_template_part( 'pagination' ); ?>

		</section>
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
