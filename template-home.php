<?php
/**
 * Template Name: Home Page Template
 * Description: A custom Home Page template.
 *
 * @package Wonderpress Theme
 */

// Set the <body> id
wonder_body_id( 'home' );

get_header();
?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
<main role="main">

	<section>
		<?php the_content(); ?>
	</section>

</main>

		<?php
	endwhile;
endif;
?>

<?php get_footer(); ?>
