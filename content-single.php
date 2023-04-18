<div id="post__related">
        <?php
  $related_posts = get_related_posts();

  if ( $related_posts->have_posts() ) :
    echo '<div class="related__post__cat">
            <div class="related__header__cat">
              <h3 class="related__heading__cat">Bài viết liên quan</h3>
            </div>
            <div class="related__list__cat">
              <div class="row related_grid">';
              ?>
              <?php
              while ( $related_posts->have_posts() ) : $related_posts->the_post();
              ?>
                <div class="col-md-12 content__related">
                    <article class="news_post_item">
                        <div class="row post_item_content">
                            <div class="col-md-4 newpost_left">
                                <div class="newpost__thumb block__thumb--style transition--thumbnail hidden-xs">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
                            if ( $thumbnail_src ) :
                            ?>
                                        <img width="83" height="43" src="<?php echo esc_url( $thumbnail_src[0] ); ?>"
                                            class="img-responsive center-block wp-post-image" alt="<?php the_title(); ?>"
                                            decoding="async" loading="lazy" sizes="(max-width: 83px) 100vw, 83px" />
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="newpost__thumb block__thumb--style transition--thumbnail hidden-sm">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
                            if ( $thumbnail_src ) :
                            ?>
                                        <img width="273" height="143" src="<?php echo esc_url( $thumbnail_src[0] ); ?>"
                                            class="img-responsive center-block wp-post-image" alt="<?php the_title(); ?>"
                                            decoding="async" loading="lazy" sizes="(max-width: 273px) 100vw, 273px" />
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-8 newpost_right">
                                <div class="newpost__meta">
                                    <h4 class="newpost__title">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark">
                                            <?php the_title(); ?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
        <?php
    endwhile;
    echo '</div></div></div>';
    wp_reset_query();
  endif;
  ?>
        <?php
    function get_related_posts() {
        global $post;
    
        $tags = wp_get_post_tags( $post->ID );
        $tag_ids = array();
        foreach( $tags as $tag ) {
            $tag_ids[] = $tag->term_id;
        }
    
        $current_category = get_the_category($post->ID)[0];
        $child_categories = get_categories(array(
            'child_of' => $current_category->cat_ID
        ));
    
        $category_ids = array();
        if (!empty($child_categories)) {
            foreach ($child_categories as $child_category) {
                $category_ids[] = $child_category->cat_ID;
            }
        } else {
            $category_ids[] = $current_category->cat_ID;
        }
    
        $related_posts_query = new WP_Query( array(
            'category__in' => $category_ids,
            'tag__in' => $tag_ids,
            'post__not_in' => array( $post->ID ),
            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC',
            'ignore_sticky_posts' => true
        ) );
    
        return $related_posts_query;
    }
    
?>