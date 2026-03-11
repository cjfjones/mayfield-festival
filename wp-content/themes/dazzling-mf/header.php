<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-344334-16"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-344334-16');
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Elsie:wght@400;900&display=swap" rel="stylesheet">

</head>

<body <?php body_class(); ?>>
<!--
<div class="global-bar-warning">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p class="no-margin-bottom text-center">We are delighted to announce that the next Mayfield Festival will take place from Sunday 24 April to Sunday 8 May 2022.</p>
            </div>
        </div>
    </div>
</div>
-->
<div id="page" class="hfeed site">

	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
			    <span class="sr-only"><?php _e( 'Toggle navigation', 'dazzling' ); ?></span>
			    <span class="icon-bar"></span>
			    <span class="icon-bar"></span>
			    <span class="icon-bar"></span>
			  </button>

				<div id="logo">

					<?php echo is_home() ?  '<h1 class="site-title">' : '<span class="site-title">'; ?>

						<?php if( get_header_image() != '' ) : ?>

							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="/wp-content/themes/dazzling-mf/media/mayfield-festival_logo.svg" alt="<?php bloginfo( 'name' ); ?>"/></a>


						<?php endif; // header image was removed ?>

						<?php if( !get_header_image() ) : ?>

							<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>

						<?php endif; // header image was removed (again) ?>

					<?php echo is_home() ?  '</h1>' : '</span>'; ?><!-- end of .site-name -->

				</div><!-- end of #logo -->

				<?php if( !get_header_image() ) : ?>

					<?php $description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
					<?php
					endif; ?>

				<?php endif; ?>
						
			</div>
				<?php dazzling_header_menu(); ?>
		</div>
	</nav><!-- .site-navigation -->

        <div class="top-section">
		<?php dazzling_featured_slider(); ?>
		<?php // dazzling_call_for_action(); ?>
        </div>
        <div id="content" class="site-content">

            <div class="main-content-area"><?php

                global $post;
                if( get_post_meta($post->ID, 'site_layout', true) ){
                        $layout_class = get_post_meta($post->ID, 'site_layout', true);
                }
				else{
                        $layout_class = of_get_option( 'site_layout' );
                } 
                if( is_home() && is_sticky( $post->ID ) ){
                        $layout_class = of_get_option( 'site_layout' );
                }
                ?>
			
                <div class="<?php echo $layout_class; ?>">
