<?php
/**
 * Template Name: Example Page Template
 * Description: A page template for showing off parts of Wonderpress.
 *
 * @package Wonderpress Theme
 */

// Set the <body> id
wonder_body_id( 'example' );

get_header();
?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
<main role="main">

	<section>

		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<?php
						wonder_include_template_file(
							'partials/image.php',
							array(
								'alt' => 'This is an example image',
								'src' => 'https://via.placeholder.com/150',
							)
						);
					?>
				</div>
				<div class="col-md-6">
					<script src="https://gist.github.com/johnnietheblack/167c186443ba2839eadf1a9ccedc4630.js"></script>
				</div>
			</div>
		</div>

	</section>

</main>

		<?php
	endwhile;
endif;
?>

<?php get_footer(); ?>
