<?php
/**
 * Ubit template functions.
 *
 * @package ubit
 */

if ( ! function_exists( 'ubit_post_related' ) ) {
	/**
	 * Display related post.
	 */
	function ubit_post_related() {
		$options = ubit_options( false );

		if ( false == $options['blog_single_related_post'] ) {
			return;
		}

		$id = get_queried_object_id();

		$args = array(
			'post_type'           => 'post',
			'post__not_in'        => array( $id ),
			'posts_per_page'      => 3,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) :
			?>
			<div class="related-box">
				<div class="row">
					<h3 class="related-title"><?php esc_html_e( 'Related Posts', 'ubit' ); ?></h3>
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();

						$post_id = get_the_ID();
						?>
						<div class="related-post col-md-4">

							<a href="<?php echo esc_url( get_permalink() ); ?>" class="entry-header">

								<?php if ( has_post_thumbnail() ) { ?>
									<?php the_post_thumbnail( 'medium' ); ?>
								<?php } else { ?>
									<div class="img-placeholder"></div>
								<?php } ?>

							</a>

							<div class="posted-on"><?php echo get_the_date(); ?></div>
							<h2 class="entry-title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_title(); ?></a></h2>
							<a class="post-read-more" href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Read more', 'ubit' ); ?></a>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
			<?php
			wp_reset_postdata();
		endif;
	}
}

if ( ! function_exists( 'ubit_display_comments' ) ) {
	/**
	 * Ubit display comments
	 */
	function ubit_display_comments() {
		// If comments are open or we have at least one comment, load up the comment template.
		if ( is_single() || is_page() ) {
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		}
	}
}

if ( ! function_exists( 'ubit_relative_time' ) ) {

	/**
	 * Display relative time for comment
	 *
	 * @param      string $type `comment` or `post`.
	 * @return     string real_time relative time
	 */
	function ubit_relative_time( $type = 'comment' ) {
		$time      = 'comment' == $type ? 'get_comment_time' : 'get_post_time';
		$real_time = human_time_diff( $time( 'U' ), current_time( 'timestamp' ) ) . ' ' . esc_html__( 'ago', 'ubit' );

		return apply_filters( 'ubit_real_time_comment', $real_time );
	}
}

if ( ! function_exists( 'ubit_comment' ) ) {
	/**
	 * Ubit comment template
	 *
	 * @param array $comment the comment array.
	 * @param array $args the comment args.
	 * @param int   $depth the comment depth.
	 */
	function ubit_comment( $comment, $args, $depth ) {
		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		?>

		<<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
			<div class="comment-body">
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 70 ); ?>
				</div>

				<?php if ( 'div' != $args['style'] ) : ?>
				<div id="div-comment-<?php comment_ID(); ?>" class="comment-content">
				<?php endif; ?>

					<div class="comment-meta commentmetadata">
						<?php printf( wp_kses_post( '<cite class="fn">%s</cite>', 'ubit' ), get_comment_author_link() ); ?>

						<?php if ( '0' == $comment->comment_approved ) : ?>
							<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'ubit' ); ?></em>
						<?php endif; ?>

						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="comment-date">
							<?php echo esc_html( ubit_relative_time() ); ?>
							<?php echo '<time datetime="' . esc_attr( get_comment_date( 'c' ) ) . '" class="sr-only">' . esc_html( get_comment_date() ) . '</time>'; ?>
						</a>
					</div>

					<div class="comment-text">
					  <?php comment_text(); ?>
					</div>

					<div class="reply">
						<?php
							comment_reply_link(
								array_merge(
									$args, array(
										'add_below' => $add_below,
										'depth' => $depth,
										'max_depth' => $args['max_depth'],
									)
								)
							);
						?>
						<?php edit_comment_link( esc_html__( 'Edit', 'ubit' ), '  ', '' ); ?>
					</div>

				<?php if ( 'div' != $args['style'] ) : ?>
				</div>
				<?php endif; ?>
			</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_footer_widgets' ) ) {
	/**
	 * Display the footer widget regions.
	 */
	function ubit_footer_widgets() {

		// Default values.
		$option        = ubit_options( false );
		$footer_column = (int) $option['footer_column'];

		if ( 0 == $footer_column ) {
			return;
		}

		if ( is_active_sidebar( 'footer' ) ) {
			?>
			<div class="site-footer-widget footer-widget-col-<?php echo esc_attr( $footer_column ); ?>">
				<?php dynamic_sidebar( 'footer' ); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'ubit_footer_custom_text' ) ) {
	/**
	 * Footer custom text
	 *
	 * @return string $content Footer custom text
	 */
	function ubit_footer_custom_text() {
		$content = '&copy; ' . date( 'Y' ) . ' ' . esc_html( get_bloginfo( 'name' ) );

		if ( apply_filters( 'ubit_credit_info', true ) ) {

			if ( apply_filters( 'ubit_privacy_policy_link', true ) && function_exists( 'get_the_privacy_policy_link' ) ) {
				$content .= get_the_privacy_policy_link( '. ' );
			}

			$content .= '. ' . sprintf(
				wp_kses(
					/* translators: external theme info link */
					__( 'All rights reserved. Designed &amp; developed by <a href="%s" target="_blank" rel="noopener noreferrer">Ubit</a>', 'ubit' ),
					array(
						'a' => array(
							'href' => array(),
							'target' => array(),
							'rel' => array(),
						),
					)
				),
				esc_url( UBIT_WEB_URI_MAIN )
			);
		}

		return $content;
	}
}

if ( ! function_exists( 'ubit_credit' ) ) {
	/**
	 * Display the theme credit
	 *
	 * @return void
	 */
	function ubit_credit() {
		$options = ubit_options( false );
		if ( '' == $options['footer_custom_text'] && ! has_nav_menu( 'footer' ) ) {
			return;
		}
		?>
		<div class="site-info">
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				echo '<div class="site-infor-col">';
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'menu_class'     => 'ubit-footer-menu',
						'container'      => '',
						'depth'          => 1,
					));
				echo '</div>';
			}
			?>

			<?php if ( '' != $options['footer_custom_text'] ) { ?>
				<div class="site-infor-col">
					<?php echo wp_kses_post( $options['footer_custom_text'] ); ?>
				</div>
			<?php } ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_site_branding' ) ) {
	/**
	 * Site branding wrapper and display
	 *
	 * @return void
	 */
	function ubit_site_branding() {
		// Default values.
		$class           = '';
		$mobile_logo_src = '';
		$options         = ubit_options( false );

		if ( '' != $options['logo_mobile'] ) {
			$mobile_logo_src = $options['logo_mobile'];
			$class           = 'has-custom-mobile-logo';
		}

		?>
		<div class="site-branding <?php echo esc_attr( $class ); ?>">
			<?php
			echo ubit_site_title_or_logo(); // WPCS: XSS ok.

			// Custom mobile logo.
			if ( '' != $mobile_logo_src ) {
				$mobile_logo_id  = attachment_url_to_postid( $mobile_logo_src );
				$mobile_logo_alt = ubit_image_alt( $mobile_logo_id, esc_html__( 'Ubit mobile logo', 'ubit' ) );
				?>
					<a class="custom-mobile-logo-url" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url">
						<img class="custom-mobile-logo" src="<?php echo esc_url( $mobile_logo_src ); ?>" alt="<?php echo esc_attr( $mobile_logo_alt ); ?>" itemprop="logo">
					</a>
				<?php
			}
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_replace_logo_attr' ) ) {
	/**
	 * Replace header logo.
	 *
	 * @param array  $attr Image.
	 * @param object $attachment Image obj.
	 * @param string  $size Size name.
	 *
	 * @return array Image attr.
	 */
	function ubit_replace_logo_attr( $attr, $attachment, $size ) {

		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$options        = ubit_options( false );

		if ( $custom_logo_id == $attachment->ID ) {

			$attr['alt'] = ubit_image_alt( $custom_logo_id, esc_html__( 'Ubit logo', 'ubit' ) );

			$attach_data = array();
			if ( ! is_customize_preview() ) {
				$attach_data = wp_get_attachment_image_src( $attachment->ID, 'full' );

				if ( isset( $attach_data[0] ) ) {
					$attr['src'] = $attach_data[0];
				}
			}

			$file_type      = wp_check_filetype( $attr['src'] );
			$file_extension = $file_type['ext'];

			if ( 'svg' == $file_extension ) {
				$attr['width']  = '100%';
				$attr['height'] = '100%';
				$attr['class']  = 'ubit-logo-svg';
			}

			// Retina logo.
			$retina_logo = $options['retina_logo'];

			$attr['srcset'] = '';

			if ( $retina_logo ) {
				$cutom_logo     = wp_get_attachment_image_src( $custom_logo_id, 'full' );
				$cutom_logo_url = $cutom_logo[0];
				$attr['alt']    = ubit_image_alt( $custom_logo_id, esc_html__( 'Ubit retina logo', 'ubit' ) );

				// Replace logo src on IE.
				if ( 'ie' == ubit_browser_detection() ) {
					$attr['src'] = $retina_logo;
				}

				$attr['srcset'] = $cutom_logo_url . ' 1x, ' . $retina_logo . ' 2x';

			}
		}

		return apply_filters( 'ubit_replace_logo_attr', $attr );
	}
	add_filter( 'wp_get_attachment_image_attributes', 'ubit_replace_logo_attr', 10, 3 );
}

if ( ! function_exists( 'ubit_get_logo_image_url' ) ) {
	/**
	 * Get logo image url
	 *
	 * @param string $size The image size.
	 */
	function ubit_get_logo_image_url( $size = 'full' ) {
		$options   = ubit_options( false );
		$image_src = '';

		if ( $options['retina_logo'] ) {
			$image_src = $options['retina_logo'];
		} elseif ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$image_id  = get_theme_mod( 'custom_logo' );
			$image     = wp_get_attachment_image_src( $image_id, $size );
			$image_src = $image[0];
		}

		return $image_src;
	}
}

if ( ! function_exists( 'ubit_site_title_or_logo' ) ) {
	/**
	 * Display the site title or logo
	 *
	 * @return string
	 */
	function ubit_site_title_or_logo() {
		if ( function_exists( 'has_custom_logo' ) && function_exists( 'get_custom_logo' ) && has_custom_logo() ) {
			// Image logo.
			$logo = get_custom_logo();
			$html = is_front_page() ? '<h1 class="logo">' . $logo . '</h1>' : $logo;
		} else {
			$tag = is_front_page() ? 'h1' : 'div';

			$html = '<span class="site-description">' . esc_html( get_bloginfo( 'description' ) ) . '</span>';
			$html .= '<' . esc_attr( $tag ) . ' class="beta site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) . '>';
		}

		return $html;
	}
}

if ( ! function_exists( 'ubit_primary_navigation' ) ) {
	/**
	 * Display Primary Navigation
	 */
	function ubit_primary_navigation() {
		// Customize disable primary menu.
		$options             = ubit_options( false );
		$header_primary_menu = $options['header_primary_menu'];

		if ( ! $header_primary_menu ) {
			return;
		}
		?>

		<div class="site-navigation">
			<?php do_action( 'ubit_before_main_nav' ); ?>

			<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'ubit' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_class'     => 'primary-navigation',
							'container'      => '',
						)
					);
				} elseif ( is_user_logged_in() ) {
					?>
					<a class="add-menu" href="<?php echo esc_url( get_admin_url() . 'nav-menus.php' ); ?>"><?php esc_html_e( 'Add a Primary Menu', 'ubit' ); ?></a>
				<?php } ?>
			</nav>

			<?php do_action( 'ubit_after_main_nav' ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_skip_links' ) ) {
	/**
	 * Skip links
	 */
	function ubit_skip_links() {
		?>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_html_e( 'Skip to navigation', 'ubit' ); ?></a>
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ubit' ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'ubit_breadcrumb' ) ) {
	/**
	 * Ubit breadcrumb
	 */
	function ubit_breadcrumb() {
		$page_id     = ubit_get_page_id();
		$options     = ubit_options( false );
		$breadcrumb  = $options['page_header_breadcrumb'];
		$container[] = 'ubit-breadcrumb';

		if ( class_exists( 'woocommerce' ) ) {
			if ( is_singular( 'product' ) ) {
				$breadcrumb  = $options['shop_single_breadcrumb'];
				$container[] = ubit_site_container();
			} elseif ( function_exists( 'ubit_is_woocommerce_page' ) && ubit_is_woocommerce_page() ) {
				$breadcrumb = $options['shop_page_breadcrumb'];
			}
		}

		$container = implode( ' ', $container );

		if ( is_front_page() || false == $breadcrumb ) {
			return;
		}
		?>

		<nav class="<?php echo esc_attr( $container ); ?>" itemscope itemtype="http://schema.org/BreadcrumbList">
			<span class="item-bread" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a itemprop="item" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span itemprop="name"><?php echo esc_html( apply_filters( 'ubit_breadcrumb_home', get_bloginfo( 'name' ) ) ); ?></span>
				</a>
				<meta itemprop="position" content="1">
			</span>

			<?php
			if ( class_exists( 'woocommerce' ) && is_singular( 'product' ) ) {
				$terms = get_the_terms( $page_id, 'product_cat' );

				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					?>
					<span class="item-bread" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ); ?>">
							<span itemprop="name"><?php esc_html_e( 'Shop', 'ubit' ); ?></span>
						</a>
						<meta itemprop="position" content="2">
					</span>

					<span class="item-bread" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="<?php echo esc_url( get_term_link( $terms[0]->term_id, 'product_cat' ) ); ?>">
							<span itemprop="name"><?php echo esc_html( $terms[0]->name ); ?></span>
						</a>
						<meta itemprop="position" content="3">
					</span>

					<span class="item-bread" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="<?php echo esc_url( home_url( '/' ) ); ?>"></a>
						<span itemprop="name"><?php echo get_the_title( $page_id ); ?></span>
						<meta itemprop="position" content="4">
					</span>
					<?php
				}
			} elseif ( is_single() ) {
				$cat = get_the_category();
				if ( ! empty( $cat ) && ! is_wp_error( $cat ) ) {
					$blog_permalink = home_url( '/' );

					if ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) ) {
						$blog_permalink = get_permalink( get_option( 'page_for_posts' ) );
					}
					?>
					<span class="item-bread" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="<?php echo esc_url( $blog_permalink ); ?>">
							<span itemprop="name"><?php esc_html_e( 'Blog', 'ubit' ); ?></span>
						</a>
						<meta itemprop="position" content="2">
					</span>

					<span class="item-bread" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="<?php echo esc_url( get_term_link( $cat[0]->term_id ) ); ?>">
							<span itemprop="name"><?php echo esc_html( $cat[0]->name ); ?></span>
						</a>
						<meta itemprop="position" content="3">
					</span>

					<span class="item-bread" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="<?php echo esc_url( home_url( '/' ) ); ?>"></a>
						<span itemprop="name"><?php echo get_the_title(); ?></span>
						<meta itemprop="position" content="4">
					</span>
					<?php
				}
			} else {
				?>
					<span class="item-bread" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="<?php echo esc_url( home_url( '/' ) ); ?>"></a>
						<span itemprop="name">
							<?php
							if ( is_day() ) {
								/* translators: post date */
								printf( esc_html__( 'Daily Archives: %s', 'ubit' ), get_the_date() );
							} elseif ( is_month() ) {
								/* translators: post date */
								printf( esc_html__( 'Monthly Archives: %s', 'ubit' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'ubit' ) ) );
							} elseif ( is_home() ) {
								echo esc_html( get_the_title( $page_id ) );
							} elseif ( is_author() ) {
								$author = get_query_var( 'author_name' ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
								echo esc_html( $author->display_name );
							} elseif ( is_category() || is_tax() ) {
								single_term_title();
							} elseif ( is_year() ) {
								/* translators: post date */
								printf( esc_html__( 'Yearly Archives: %s', 'ubit' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'ubit' ) ) );
							} elseif ( is_search() ) {
								esc_html_e( 'Search', 'ubit' );
							} elseif ( class_exists( 'woocommerce' ) && is_shop() ) {
								esc_html_e( 'Shop', 'ubit' );
							} elseif ( class_exists( 'woocommerce' ) && ( is_product_tag() || is_tag() ) ) {
								esc_html_e( 'Tags: ', 'ubit' );
								single_tag_title();
							} elseif ( is_page() ) {
								echo get_the_title();
							} else {
								esc_html_e( 'Archives', 'ubit' );
							}
							?>
						</span>
						<meta itemprop="position" content="2">
					</span>
				<?php
			}
			?>
		</nav>
		<?php
	}
}

if ( ! function_exists( 'ubit_page_header' ) ) {
	/**
	 * Display the page header
	 */
	function ubit_page_header() {
		$page_id       = ubit_get_page_id();
		$options       = ubit_options( false );
		$page_header   = $options['page_header_display'];
		$metabox       = ubit_get_metabox( false, 'site-page-header' );
		$title         = get_the_title( $page_id );
		$show_title    = $options['blog_single_title'];

		$classes[]     = ubit_site_container();
		$classes[]     = 'content-align-' . $options['page_header_text_align'];
		$classes       = implode( ' ', $classes );

		if ( class_exists( 'woocommerce' ) && ( is_shop() || is_singular( 'product' ) ) ) {
			// Not showing page header on Product page if breadcrumbs are hidden.
			if ( is_singular( 'product') && true != $options['shop_single_breadcrumb'] ) {
				$page_header = false;
			}

			// Not showing page title on Shop pages if it's disabled or on Product page.
			if ( true != $options['shop_page_title'] || is_singular( 'product' ) ) {
				$show_title = false;
			}

			// Change page title to search title when searching for products.
			if ( is_search() && is_post_type_archive( 'product' ) ) {
				$title = sprintf( esc_html__( 'Search: %s', 'ubit' ), get_search_query() );
			}
		} elseif ( is_archive() ) {
			$title = get_the_archive_title( $page_id );
		} elseif ( is_home() ) {
			$title = esc_html__( 'Blog', 'ubit' );
		} elseif ( is_search() ) {
			$title = sprintf( esc_html__( 'Search: %s', 'ubit' ), get_search_query() );
		} elseif ( is_404() ) {
			$page_header = false;
		}

		// Metabox option.
		if ( 'default' != $metabox ) {
			if ( 'enabled' == $metabox ) {
				$page_header = true;
			} else {
				$page_header = false;
			}
		}

		if ( false == $page_header ) {
			return;
		}

		?>

		<div class="page-header">
			<div class="<?php echo esc_attr( $classes ); ?>">
				<?php do_action( 'ubit_page_header_start' ); ?>

				<?php if ( $show_title ) { ?>
					<h1 class="entry-title"><?php echo wp_kses_post( $title ); ?></h1>
				<?php } ?>

				<?php
					/**
					 * Functions hooked in to ubit_page_header_end
					 *
					 * @hooked ubit_breadcrumb   - 10
					 */
					do_action( 'ubit_page_header_end' );
				?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_page_content' ) ) {
	/**
	 * Display the post content
	 */
	function ubit_page_content() {
		the_content();

		wp_link_pages(
			array(
				'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'ubit' ),
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			)
		);
	}
}

if ( ! function_exists( 'ubit_post_header_wrapper' ) ) {
	/**
	 * Post header wrapper
	 *
	 * @return void
	 */
	function ubit_post_header_wrapper() {
		?>
			<header class="entry-header">
		<?php
	}
}

if ( ! function_exists( 'ubit_post_thumbnail' ) ) {
	/**
	 * Display post thumbnail
	 *
	 * @var $size thumbnail size. thumbnail|medium|large|full|$custom
	 * @uses has_post_thumbnail()
	 * @uses the_post_thumbnail
	 * @param string $size the post thumbnail size.
	 */
	function ubit_post_thumbnail( $size = 'full' ) {
		if ( has_post_thumbnail() ) {
			$options = ubit_options( false );

			if ( ! is_single() ) {
				if ( true == $options['blog_list_feature_image'] ) {
					?>
					<div class="post-cover-image">
						<a href="<?php echo esc_url( get_permalink() ); ?>">
							<?php the_post_thumbnail( $size ); ?>
						</a>
					</div>
					<?php
				}
			} else {
				if ( true == $options['blog_single_feature_image'] ) {
					?>
					<div class="post-cover-image">
						<?php the_post_thumbnail( $size ); ?>
					</div>
					<?php
				}
			}
		}
	}
}

if ( ! function_exists( 'ubit_post_title' ) ) {
	/**
	 * Display the post header with a link to the single post
	 */
	function ubit_post_title() {
		$options = ubit_options( false );

		if ( ! is_single() && true == $options['blog_list_title'] ) {
			the_title( sprintf( '<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		}
	}
}

if ( ! function_exists( 'ubit_post_header_wrapper_close' ) ) {
	/**
	 * Post header wrapper close
	 *
	 * @return void
	 */
	function ubit_post_header_wrapper_close() {
		?>
			</header>
		<?php
	}
}

if ( ! function_exists( 'ubit_post_info_start' ) ) {
	/**
	 * Blog info start
	 */
	function ubit_post_info_start() {
		?>
		<div class="post-info">
		<?php
	}
}

if ( ! function_exists( 'ubit_post_info_end' ) ) {
	/**
	 * Blog info end
	 */
	function ubit_post_info_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_post_meta' ) ) {
	/**
	 * Display the post meta
	 */
	function ubit_post_meta() {
		$options = ubit_options( false );
		?>
		<aside class="entry-meta">
			<?php
			if ( 'post' == get_post_type() ) {
				// Publish date meta.
				if (
					! is_single() && true == $options['blog_list_publish_date'] ||
					is_single() && true == $options['blog_single_publish_date']
				) {
					ubit_posted_on();
				}

				// Author meta.
				if (
					! is_single() && true == $options['blog_list_author'] ||
					is_single() && true == $options['blog_single_author']
				) {
					?>
					<span class="post-meta-item vcard author">
						<?php
						if ( '' === get_the_author() ) {
							esc_html_e( 'by Unknown author', 'ubit' );
						} else {
							echo '<span class="label">' . esc_html__( 'by', 'ubit' ) . '</span>';
							echo sprintf(
								' <a href="%1$s" class="url fn" rel="author">%2$s</a>',
								esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
								get_the_author()
							);
						}
						?>
					</span>
					<?php
				}

				// Category meta.
				if (
					! is_single() && true == $options['blog_list_category'] ||
					is_single() && true == $options['blog_single_category']
				) {
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( esc_html__( ', ', 'ubit' ) );

					if ( $categories_list ) :
						?>
							<span class="post-meta-item cat-links">
								<?php
									echo '<span class="label sr-only">' . esc_html__( 'Posted in', 'ubit' ) . '</span>';
									echo wp_kses_post( $categories_list );
								?>
							</span>
						<?php
					endif; // End if categories.
				}

				// Comment meta.
				if ( ! is_single() && true == $options['blog_list_comment'] || is_single() && true == $options['blog_single_comment'] ) {
					if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
						?>
						<span class="post-meta-item comments-link">
							<?php
								comments_popup_link(
									esc_html__( 'No comments yet', 'ubit' ),
									esc_html__( '1 Comment', 'ubit' ),
									esc_html__( '% Comments', 'ubit' )
								);
							?>
						</span>
						<?php
					}
				}
			} // End if 'post' == get_post_type().
			?>
		</aside>
		<?php
	}
}

if ( ! function_exists( 'ubit_show_excerpt' ) ) {
	/**
	 * Show the blog excerpts or full posts
	 *
	 * @return bool $show_excerpt
	 */
	function ubit_show_excerpt() {
		global $post;

		// Check to see if the more tag is being used.
		$more_tag = apply_filters( 'ubit_more_tag', strpos( $post->post_content, '<!--more-->' ) );

		// Check the post format.
		$format = false != get_post_format() ? get_post_format() : 'standard';

		// If our post format isn't standard, show the full content.
		$show_excerpt = 'standard' != $format ? false : true;

		// If the more tag is found, show the full content.
		$show_excerpt = $more_tag ? false : $show_excerpt;

		// If we're on a search results page, show the excerpt.
		$show_excerpt = is_search() ? true : $show_excerpt;

		// Return our value.
		return apply_filters( 'ubit_show_excerpt', $show_excerpt );
	}
}

if ( ! function_exists( 'ubit_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 */
	function ubit_post_content() {

		do_action( 'ubit_post_content_before' );

		if ( ubit_show_excerpt() && ! is_single() ) {
			?>
				<div class="entry-summary summary-text">
					<?php
					the_excerpt();

					// Add 'Read More' button.
					$read_more_text = apply_filters( 'ubit_read_more_text', esc_html__( 'Read More', 'ubit' ) );
					?>
					<div class="post-read-more">
						<a href="<?php the_permalink(); ?>" class="button">
							<?php echo esc_html( $read_more_text ); ?>
						</a>
					</div>
				</div>
			<?php
		} else {
			?>
			<div class="entry-content summary-text">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'ubit' ),
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					)
				);

				/**
				 * Functions hooked in to ubit_post_content_after action
				 *
				 * @hooked ubit_post_read_more_button - 5
				 */
				do_action( 'ubit_post_content_after' );
				?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'ubit_post_read_more_button' ) ) {
	/**
	 * Display read more button
	 */
	function ubit_post_read_more_button() {
		if ( ! is_single() ) {
			$read_more_text = apply_filters( 'ubit_read_more_text', esc_html__( 'Read More', 'ubit' ) );
			?>

			<p class="post-read-more">
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php echo esc_html( $read_more_text ); ?>
				</a>
			</p>
			<?php
		}
	}
}

if ( ! function_exists( 'ubit_post_divider_bottom' ) ) {
	/**
	 * Display post divider below a post content
	 */
	function ubit_post_divider_bottom() {
		?>
		<div class="ubit-post-divider ubit-post-divider-bottom"></div>
		<?php
	}
}

if ( ! function_exists( 'ubit_post_tags' ) ) {
	/**
	 * Display post tags
	 */
	function ubit_post_tags() {
		$tags_list = get_the_tag_list( '<span class="label">' . esc_html__( 'Tags', 'ubit' ) . '</span>: ', esc_html__( ', ', 'ubit' ) );
		if ( $tags_list ) :
			?>
			<footer class="entry-footer">
				<div class="tags-links">
					<?php echo wp_kses_post( $tags_list ); ?>
				</div>
			</footer>
			<?php
		endif;
	}
}

if ( ! function_exists( 'ubit_paging_nav' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function ubit_paging_nav() {
		global $wp_query;

		$args = array(
			'type'      => 'list',
			'next_text' => esc_html_x( 'Next', 'Next post', 'ubit' ),
			'prev_text' => esc_html_x( 'Prev', 'Previous post', 'ubit' ),
		);

		the_posts_pagination( $args );
	}
}

if ( ! function_exists( 'ubit_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function ubit_post_nav() {
		$args = array(
			'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'ubit' ) . ' </span><i class="fas fa-chevron-left"></i> %title',
			'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'ubit' ) . ' </span>%title <i class="fas fa-chevron-right"></i>',
		);
		the_post_navigation( $args );
	}
}

if ( ! function_exists( 'ubit_gravatar_validate' ) ) {
	function ubit_gravatar_validate( $email ) {
		$hashkey = md5( strtolower( trim( $email ) ) );
		$response = wp_remote_head( 'https://www.gravatar.com/avatar/' . $hashkey . '?d=404' );

		if( ! is_wp_error( $response ) && '200' == $response['response']['code'] ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'ubit_post_author_box' ) ) {
	/**
	 * Display author box
	 */
	function ubit_post_author_box() {
		$options = ubit_options( false );
		if ( true != $options['blog_single_author_box'] ) {
			return;
		}

		$author_id   = get_the_author_meta( 'ID' );
		$author_data = get_userdata( $author_id );
		$author_avatar_validate = ubit_gravatar_validate( $author_data->user_email );

		$author_avatar = $author_avatar_validate ? get_avatar_url( $author_id ) : apply_filters( 'ubit_avatar_default_url', UBIT_THEME_URI . 'assets/images/avatar.png' );
		$author_url  = get_author_posts_url( $author_id );
		$author_name = get_the_author_meta( 'nickname', $author_id );
		$author_bio  = get_the_author_meta( 'description', $author_id );
		$author_box_class = empty( $author_bio ) ? 'post-author-box-without-bio' : '';
		$author_avatar_validate_class = $author_avatar_validate ? '' : 'author-avatar-default';
		?>

		<div class="post-author-box <?php echo esc_attr( $author_box_class ); ?>">
			<?php if ( $author_avatar ) { ?>
				<a class="author-ava <?php echo esc_attr( $author_avatar_validate_class ); ?>" href="<?php echo esc_url( $author_url ); ?>">
					<img src="<?php echo esc_url( $author_avatar ); ?>" alt="<?php esc_attr_e( 'Author Avatar', 'ubit' ); ?>">
				</a>
			<?php } ?>

			<div class="author-content">
				<span class="author-name-before"><?php esc_html_e( 'Written by', 'ubit' ); ?></span>
				<a class="author-name" href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $author_name ); ?></a>

				<?php if ( ! empty( $author_bio ) ) { ?>
					<div class="author-bio"><?php echo wp_kses_post( $author_bio ); ?></div>
				<?php } ?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function ubit_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = '<span class="sr-only">' . esc_html__( 'Posted on', 'ubit' ) . '</span>';
		$posted_on .= '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

		echo wp_kses(
			apply_filters( 'ubit_single_post_posted_on_html', '<span class="post-meta-item posted-on">' . $posted_on . '</span>', $posted_on ), array(
				'span' => array(
					'class'  => array(),
				),
				'a'    => array(
					'href'  => array(),
					'title' => array(),
					'rel'   => array(),
				),
				'time' => array(
					'datetime' => array(),
					'class'    => array(),
				),
			)
		);
	}
}

if ( ! function_exists( 'ubit_get_header_class' ) ) {
	/**
	 * Header class
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function ubit_get_header_class( $class = '' ) {
		$classes = array();

		$classes[] = 'site-header';

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );
		} else {
			// Ensure that we always coerce class to being an array.
			$class = array();
		}

		$classes = array_map( 'esc_attr', $classes );

		$classes = apply_filters( 'ubit_header_class', $classes, $class );

		return array_unique( $classes );
	}
}

if ( ! function_exists( 'ubit_header_class' ) ) {

	/**
	 * Display the classes for the header element.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function ubit_header_class( $class = '' ) {
		// Separates classes with a single space, collates classes for body element.
		echo 'class="' . join( ' ', ubit_get_header_class( $class ) ) . '"'; // WPCS: XSS ok.
	}
}

if ( ! function_exists( 'ubit_default_container_open' ) ) {
	/**
	 * Ubit default container open
	 */
	function ubit_default_container_open() {
		$container = ubit_site_container();
		echo '<div class="' . esc_attr( $container ) . '">';
	}
}

if ( ! function_exists( 'ubit_default_container_close' ) ) {
	/**
	 * Ubit default container close
	 */
	function ubit_default_container_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'ubit_container_open' ) ) {
	/**
	 * Ubit container open
	 */
	function ubit_container_open() {
		$container = ubit_site_container();
		echo '<div class="' . esc_attr( $container ) . '">';
	}
}

if ( ! function_exists( 'ubit_container_close' ) ) {
	/**
	 * Ubit container close
	 */
	function ubit_container_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'ubit_content_top' ) ) {
	/**
	 * Content top, after Header
	 */
	function ubit_content_top() {
		do_action( 'ubit_content_top' );
	}
}

if ( ! function_exists( 'ubit_content_top_open' ) ) {
	/**
	 * Ubit .content-top open
	 */
	function ubit_content_top_open() {
		echo '<div class="content-top">';
	}
}

if ( ! function_exists( 'ubit_content_top_close' ) ) {
	/**
	 * Ubit .content-top close
	 */
	function ubit_content_top_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'ubit_is_product_archive' ) ) {
	/**
	 * Checks if the current page is a product archive
	 *
	 * @return boolean
	 */
	function ubit_is_product_archive() {
		if ( ! class_exists( 'woocommerce' ) || ! ubit_is_woocommerce_activated() ) {
			return false;
		}

		if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() || is_tax() ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'ubit_topbar' ) ) {
	/**
	 * Display topbar
	 */
	function ubit_topbar() {
		$options = ubit_options( false );
		$topbar  = ubit_get_metabox( false, 'site-topbar' );
		if ( 'disabled' == $topbar ) {
			return;
		}

		$container = ubit_site_container();
		?>

		<div class="topbar">
			<div class="<?php echo esc_attr( $container ); ?>">
				<div class="topbar-item topbar-left"><?php echo wp_kses_post( $options['topbar_left'] ); ?></div>
				<div class="topbar-item topbar-center"><?php echo wp_kses_post( $options['topbar_center'] ); ?></div>
				<div class="topbar-item topbar-right"><?php echo wp_kses_post( $options['topbar_right'] ); ?></div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_topbar_sidebar' ) ) {
	/**
	 * Display topbar in sidebar menu
	 */
	function ubit_topbar_sidebar() {
		$options = ubit_options( false );
		$topbar  = ubit_get_metabox( 'site-topbar' );
		if ( 'disabled' == $topbar ) {
			return;
		}
		?>

		<div class="topbar-sidebar">
			<div class="topbar-item"><?php echo wp_kses_post( $options['topbar_left'] ); ?></div>
			<div class="topbar-item"><?php echo wp_kses_post( $options['topbar_center'] ); ?></div>
			<div class="topbar-item"><?php echo wp_kses_post( $options['topbar_right'] ); ?></div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_search' ) ) {
	/**
	 * Display Product Search
	 *
	 * @uses  ubit_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function ubit_search() {
		$options = ubit_options( false );
		if ( ! $options['header_search_icon'] ) {
			return;
		}
		?>

		<div class="site-search">
			<?php
			if ( false == $options['header_search_only_product'] ) {
				get_search_form();
			} elseif ( ubit_is_woocommerce_activated() ) {
				the_widget( 'WC_Widget_Product_Search', 'title=' );
			}
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_dialog_search' ) ) {
	/**
	 * Display Dialog Search
	 *
	 * @uses  ubit_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function ubit_dialog_search() {
		$options = ubit_options( false );

		if ( false == $options['header_search_icon'] ) {
			return;
		}

		$close_icon = apply_filters( 'ubit_dialog_search_close_icon', 'fas fa-times' );
		?>

		<div class="site-dialog-search">
			<div class="dialog-search-content">
				<?php do_action( 'ubit_dialog_search_content_start' ); ?>

				<div class="dialog-search-header">
					<span class="dialog-search-title"><?php
					echo implode(' ', array(
						esc_html( get_bloginfo( 'name' ) ),
						esc_html__( 'Search', 'ubit' ),
					) );
					?></span>
					<span class="dialog-search-close-icon <?php echo esc_attr( $close_icon ); ?>"></span>
				</div>

				<div class="dialog-search-main">
					<?php
					if ( ubit_is_woocommerce_activated() && $options['header_search_only_product'] ) {
						the_widget( 'WC_Widget_Product_Search', 'title=' );
					} else {
						get_search_form();
					}
					?>
				</div>

				<?php do_action( 'ubit_dialog_search_content_end' ); ?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_product_check_in' ) ) {
	/**
	 * Check product already in cart || product quantity in cart
	 *
	 * @param      int     $pid          Product id.
	 * @param      boolean $in_cart      Check in cart.
	 * @param      boolean $qty_in_cart  Get product quantity.
	 */
	function ubit_product_check_in( $pid = null, $in_cart = true, $qty_in_cart = false ) {
		$_cart    = WC()->cart->get_cart();
		$_product = wc_get_product( $pid );
		$variable = $_product->is_type( 'variable' );

		// Check product already in cart. Return boolean.
		if ( true == $in_cart ) {
			foreach ( $_cart as $key ) {
				$product_id = $key['product_id'];

				if ( $product_id == $pid ) {
					return true;
				}
			}

			return false;
		}

		// Get product quantity in cart. Return INT.
		if ( true == $qty_in_cart ) {
			if ( $variable ) {
				$arr = array();
				foreach ( $_cart as $key ) {
					if ( $key['product_id'] == $pid ) {
						$qty   = $key['quantity'];
						$arr[] = $qty;
					}
				}

				return array_sum( $arr );
			} else {
				foreach ( $_cart as $key ) {
					if ( $key['product_id'] == $pid ) {
						$qty = $key['quantity'];

						return $qty;
					}
				}
			}

			return 0;
		}
	}
}

if ( ! function_exists( 'ubit_get_sidebar_id' ) ) {
	/**
	 * Get sidebar by id
	 *
	 * @param      string $sidebar_id      The sidebar id.
	 * @param      string $sidebar_layout  The sidebar layout: left, right, full.
	 * @param      string $sidebar_default The sidebar layout default.
	 * @param      string $wc_sidebar      The woocommerce sidebar.
	 */
	function ubit_get_sidebar_id( $sidebar_id, $sidebar_layout, $sidebar_default, $wc_sidebar = false ) {
		$wc_sidebar_class      = true == $wc_sidebar ? ' woocommerce-sidebar' : '';
		$sidebar_layout_class  = 'full' == $sidebar_layout || ( ! is_active_sidebar( 'sidebar' ) && function_exists( 'ubit_is_woocommerce_page' ) && ! ubit_is_woocommerce_page() ) || ( ! is_active_sidebar( 'sidebar-shop' ) && function_exists( 'ubit_is_woocommerce_page' ) && ubit_is_woocommerce_page() ) ? 'no-sidebar' : $sidebar_layout . '-sidebar has-sidebar' . $wc_sidebar_class;
		$sidebar_default_class = 'full' == $sidebar_default || ( ! is_active_sidebar( 'sidebar' ) && function_exists( 'ubit_is_woocommerce_page' ) && ! ubit_is_woocommerce_page() ) || ( ! is_active_sidebar( 'sidebar-shop' ) && function_exists( 'ubit_is_woocommerce_page' ) && ubit_is_woocommerce_page() ) ? 'no-sidebar' : $sidebar_default . '-sidebar has-sidebar default-sidebar' . $wc_sidebar_class;

		if ( 'default' != $sidebar_layout ) {
			$sidebar = $sidebar_layout_class;
		} else {
			$sidebar = $sidebar_default_class;
		}

		return $sidebar;
	}
}

if ( ! function_exists( 'ubit_sidebar_class' ) ) {
	/**
	 * Get sidebar class
	 *
	 * @return string $sidebar Class name
	 */
	function ubit_sidebar_class() {
		// All theme options.
		$options         = ubit_options( false );

		// Metabox options.
		$metabox_sidebar = ubit_get_metabox( false, 'site-sidebar' );

		// Customize options.
		$sidebar             = '';
		$sidebar_default     = $options['sidebar_default'];
		$sidebar_page        = 'default' != $metabox_sidebar ? $metabox_sidebar : $options['sidebar_page'];
		$sidebar_blog        = 'default' != $metabox_sidebar ? $metabox_sidebar : $options['sidebar_blog'];
		$sidebar_blog_single = 'default' != $metabox_sidebar ? $metabox_sidebar : $options['sidebar_blog_single'];
		$sidebar_shop        = 'default' != $metabox_sidebar ? $metabox_sidebar : $options['sidebar_shop'];
		$sidebar_shop_single = 'default' != $metabox_sidebar ? $metabox_sidebar : $options['sidebar_shop_single'];

		if ( true == ubit_is_elementor_page() || is_404() ) {
			return $sidebar;
		}

		if ( true == ubit_is_product_archive() ) {
			// Product archive.
			$sidebar = ubit_get_sidebar_id( 'sidebar-shop', $sidebar_shop, $sidebar_default );
		} elseif ( is_singular( 'product' ) ) {
			// Product single.
			$sidebar = ubit_get_sidebar_id( 'sidebar-shop', $sidebar_shop_single, $sidebar_default );
		} elseif ( class_exists( 'woocommerce' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
			// Cart, checkout and account page.
			$sidebar = '';
		} elseif ( is_page() ) {
			// Page.
			$sidebar = ubit_get_sidebar_id( 'sidebar', $sidebar_page, $sidebar_default );
		} elseif ( is_singular( 'post' ) ) {
			// Blog page.
			$sidebar = ubit_get_sidebar_id( 'sidebar', $sidebar_blog_single, $sidebar_default );
		} else {
			// Other page.
			$sidebar = ubit_get_sidebar_id( 'sidebar', $sidebar_blog, $sidebar_default );
		}

		return $sidebar;
	}
}

if ( ! function_exists( 'ubit_get_sidebar' ) ) {
	/**
	 * Display ubit sidebar
	 *
	 * @uses get_sidebar()
	 */
	function ubit_get_sidebar() {
		$sidebar = ubit_sidebar_class();

		if ( false !== strpos( $sidebar, 'no-sidebar' ) || '' == $sidebar || true == ubit_is_elementor_page() ) {
			return;
		}

		if ( false !== strpos( $sidebar, 'woocommerce-sidebar' ) || true == ubit_is_product_archive() || is_singular( 'product' ) ) {
			get_sidebar( 'shop' );
		} else {
			get_sidebar();
		}
	}
}

if ( ! function_exists( 'ubit_menu_toggle_btn' ) ) {
	/**
	 * Menu toggle button
	 */
	function ubit_menu_toggle_btn() {
		$menu_toggle_icon  = apply_filters( 'ubit_header_menu_toggle_icon', 'ubit-icon-bar' );
		$ubit_icon_bar = apply_filters( 'ubit_header_icon_bar', '<span></span>' );
		?>
		<div class="wrap-toggle-sidebar-menu">
			<span class="toggle-sidebar-menu-btn <?php echo esc_attr( $menu_toggle_icon ); ?>">
				<?php echo wp_kses_post( $ubit_icon_bar ); ?>
			</span>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_overlay' ) ) {
	/**
	 * Ubit overlay
	 */
	function ubit_overlay() {
		echo '<div id="ubit-overlay"></div>';
	}
}

if ( ! function_exists( 'ubit_toggle_sidebar' ) ) {
	/**
	 * Toogle sidebar
	 */
	function ubit_toggle_sidebar() {
		do_action( 'ubit_toggle_sidebar' );
	}
}

if ( ! function_exists( 'ubit_sidebar_menu_open' ) ) {
	/**
	 * Sidebar menu open
	 */
	function ubit_sidebar_menu_open() {
		echo '<div class="sidebar-menu">';
	}
}

if ( ! function_exists( 'ubit_sidebar_menu_action' ) ) {
	/**
	 * Sidebar menu action
	 */
	function ubit_sidebar_menu_action() {
		if ( ubit_is_woocommerce_activated() ) {
			$page_account_id = get_option( 'woocommerce_myaccount_page_id' );
			$logout_url      = wp_logout_url( get_permalink( $page_account_id ) );
			if ( 'yes' == get_option( 'woocommerce_force_ssl_checkout' ) ) {
				$logout_url = str_replace( 'http:', 'https:', $logout_url );
			}
			?>
			<div class="sidebar-menu-bottom">
				<?php do_action( 'ubit_sidebar_account_before' ); ?>

				<ul class="sidebar-account">
					<?php do_action( 'ubit_sidebar_account_top' ); ?>

					<?php if ( ! is_user_logged_in() ) : ?>
						<li><a href="<?php echo esc_url( get_permalink( $page_account_id ) ); ?>"><?php esc_html_e( 'Login / Register', 'ubit' ); ?></a></li>
					<?php else : ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $page_account_id ) ); ?>"><?php esc_html_e( 'Dashboard', 'ubit' ); ?></a>
						</li>
						<li><a href="<?php echo esc_url( $logout_url ); ?>"><?php esc_html_e( 'Logout', 'ubit' ); ?></a>
						</li>
					<?php endif; ?>

					<?php do_action( 'ubit_sidebar_account_bottom' ); ?>
				</ul>

				<?php do_action( 'ubit_sidebar_account_after' ); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'ubit_sidebar_menu_close' ) ) {
	/**
	 * Sidebar menu close
	 */
	function ubit_sidebar_menu_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'ubit_wishlist_page_url' ) ) {
	/**
	 * Get YTH wishlist page url
	 */
	function ubit_wishlist_page_url() {
		if ( ! defined( 'YITH_WCWL' ) ) {
			return '#';
		}

		global $wpdb;
		$id = $wpdb->get_results( 'SELECT ID FROM ' . $wpdb->prefix . 'posts WHERE post_content LIKE "%[yith_wcwl_wishlist]%" AND post_parent = 0' );

		if ( $id ) {
			$id  = intval( $id[0]->ID );
			$url = get_the_permalink( $id );

			return $url;
		}

		return '#';
	}
}

if ( ! function_exists( 'ubit_header_action' ) ) {
	/**
	 * Display header action
	 *
	 * @uses  ubit_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function ubit_header_action() {
		$options = ubit_options( false );

		if ( ubit_is_woocommerce_activated() ) {
			$page_account_id = get_option( 'woocommerce_myaccount_page_id' );
			$logout_url      = wp_logout_url( get_permalink( $page_account_id ) );

			if ( 'yes' == get_option( 'woocommerce_force_ssl_checkout' ) ) {
				$logout_url = str_replace( 'http:', 'https:', $logout_url );
			}

			$count = WC()->cart->cart_contents_count;
		}

		$search_icon     = apply_filters( 'ubit_header_search_icon', 'fas fa-search' );
		$wishlist_icon   = apply_filters( 'ubit_header_wishlist_icon', 'far fa-heart' );
		$my_account_icon = apply_filters( 'ubit_header_my_account_icon', 'far fa-user' );
		$shop_bag_icon   = apply_filters( 'ubit_header_shop_bag_icon', 'fas fa-shopping-cart cart-icon-rotate' );
		?>

		<div class="site-tools">

			<?php do_action( 'ubit_site_tool_before_first_item' ); ?>

			<?php // Search icon. ?>
			<?php if ( true == $options['header_search_icon'] ) { ?>
				<span class="tools-icon header-search-icon <?php echo esc_attr( $search_icon ); ?>"></span>
			<?php } ?>

			<?php do_action( 'ubit_site_tool_before_second_item' ); ?>

			<?php // Wishlist icon. ?>
			<?php if ( defined( 'YITH_WCWL' ) && true == $options['header_wishlist_icon'] ) { ?>
				<a href="<?php echo esc_url( ubit_wishlist_page_url() ); ?>" class="tools-icon header-wishlist-icon <?php echo esc_attr( $wishlist_icon ); ?>"></a>
			<?php } ?>

			<?php do_action( 'ubit_site_tool_before_third_item' ); ?>

			<?php if ( ubit_is_woocommerce_activated() ) { ?>
				<?php // My account icon. ?>
				<?php if ( true == $options['header_account_icon'] ) { ?>
					<div class="tools-icon my-account">
						<a href="<?php echo esc_url( get_permalink( $page_account_id ) ); ?>" class="tools-icon my-account-icon <?php echo esc_attr( $my_account_icon ); ?>"></a>
						<div class="subbox">
							<ul>
								<?php if ( ! is_user_logged_in() ) : ?>
									<li><a href="<?php echo esc_url( get_permalink( $page_account_id ) ); ?>" class="text-center"><?php esc_html_e( 'Login / Register', 'ubit' ); ?></a></li>
								<?php else : ?>
									<li>
										<a href="<?php echo esc_url( get_permalink( $page_account_id ) ); ?>"><?php esc_html_e( 'Dashboard', 'ubit' ); ?></a>
									</li>
									<li><a href="<?php echo esc_url( $logout_url ); ?>"><?php esc_html_e( 'Logout', 'ubit' ); ?></a>
									</li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				<?php } ?>

				<?php do_action( 'ubit_site_tool_before_fourth_item' ); ?>

				<?php // Shopping cart icon. ?>
				<?php if ( true == $options['header_shop_cart_icon'] ) { ?>
					<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="tools-icon shopping-bag-button <?php echo esc_attr( $shop_bag_icon ); ?>">
						<span class="shop-cart-count"><?php echo esc_html( $count ); ?></span>
					</a>
				<?php } ?>

				<?php do_action( 'ubit_site_tool_after_last_item' ); ?>
			<?php } ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_get_page_id' ) ) {
	/**
	 * Get page id
	 *
	 * @return int $page_id Page id
	 */
	function ubit_get_page_id() {
		$page_id = get_queried_object_id();

		if ( class_exists( 'woocommerce' ) && is_shop() ) {
			$page_id = get_option( 'woocommerce_shop_page_id' );
		}

		return $page_id;
	}
}

if ( ! function_exists( 'ubit_view_open' ) ) {
	/**
	 * Open #view
	 */
	function ubit_view_open() {
		?>
		<div id="view">
		<?php
	}
}

if ( ! function_exists( 'ubit_view_close' ) ) {
	/**
	 * Close #view
	 */
	function ubit_view_close() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_content_open' ) ) {
	/**
	 * Open #content
	 */
	function ubit_content_open() {
		?>
		<div id="content" class="site-content" tabindex="-1">
		<?php
	}
}

if ( ! function_exists( 'ubit_content_close' ) ) {
	/**
	 * Close #content
	 */
	function ubit_content_close() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_site_container' ) ) {

	/**
	 * Ubit site container
	 *
	 * @return $container The site container
	 */
	function ubit_site_container() {
		$options   = ubit_options( false );
		$container = 'ubit-container';

		// Metabox.
		$page_id           = ubit_get_page_id();
		$metabox_container = ubit_get_metabox( false, 'site-container' );

		if ( 'default' != $metabox_container && 'full-width' == $metabox_container ) {
			$container = 'ubit-container container-fluid';
		} elseif ( 'default' == $metabox_container && 'full-width' == $options['default_container'] ) {
			$container = 'ubit-container container-fluid';
		}

		return $container;
	}
}

if ( ! function_exists( 'ubit_site_header' ) ) {
	/**
	 * Display header
	 */
	function ubit_site_header() {
		$header = ubit_get_metabox( false, 'site-header' );
		if ( 'disabled' == $header ) {
			return;
		}
		?>
			<header id="masthead" <?php ubit_header_class(); ?>>
				<div class="site-header-inner">
					<?php
						/**
						 * Functions hooked into ubit_site_header action
						 *
						 * @hooked ubit_container_open     - 0
						 * @hooked ubit_skip_links         - 5
						 * @hooked ubit_site_branding      - 20
						 * @hooked ubit_primary_navigation - 30
						 * @hooked ubit_header_action      - 50
						 * @hooked ubit_container_close    - 200
						 */
						do_action( 'ubit_site_header' );
					?>
				</div>
			</header>
		<?php
	}
}

if ( ! function_exists( 'ubit_after_header' ) ) {
	/**
	 * After header
	 */
	function ubit_after_header() {
		do_action( 'ubit_after_header' );
	}
}
if ( ! function_exists( 'ubit_before_footer' ) ) {
	/**
	 * After header
	 */
	function ubit_before_footer() {
		do_action( 'ubit_before_footer' );
	}
}

if ( ! function_exists( 'ubit_site_footer' ) ) {

	/**
	 * Ubit footer
	 */
	function ubit_site_footer() {
		// Customize disable footer.
		$options        = ubit_options( false );
		$footer_display = $options['footer_display'];

		// Metabox disable footer.
		$metabox_footer = ubit_get_metabox( false, 'site-footer' );
		if ( 'disabled' == $metabox_footer ) {
			$footer_display = false;
		}

		// Return.
		if ( false == $footer_display ) {
			return;
		}

		$container = ubit_site_container();
		?>
			<footer id="colophon" class="site-footer">
				<div class="<?php echo esc_attr( $container ); ?>">

					<?php
					/**
					 * Functions hooked in to ubit_footer action
					 *
					 * @hooked ubit_footer_widgets - 10
					 * @hooked ubit_credit         - 20
					 */
					do_action( 'ubit_footer_content' );
					?>

				</div>
			</footer>
		<?php
	}
}

if ( ! function_exists( 'ubit_footer_action' ) ) {
	/**
	 * Footer action
	 */
	function ubit_footer_action() {
		?>
		<div class="footer-action"><?php do_action( 'ubit_footer_action' ); ?></div>
		<?php
	}
}

if ( ! function_exists( 'ubit_after_footer' ) ) {
	/**
	 * After footer
	 */
	function ubit_after_footer() {
		do_action( 'ubit_after_footer' );
	}
}

if ( ! function_exists( 'ubit_scroll_to_top' ) ) {
	/**
	 * Scroll to top
	 */
	function ubit_scroll_to_top() {
		$options = ubit_options( false );
		if ( true != $options['scroll_to_top'] ) {
			return;
		}

		$icon = apply_filters( 'ubit_scroll_to_top_icon', 'fas fa-chevron-up' );
		?>
		<span id="scroll-to-top" class="ft-action-item <?php echo esc_attr( $icon ); ?>" title="<?php esc_attr_e( 'Scroll To Top', 'ubit' ); ?>"></span>
		<?php
	}
}
