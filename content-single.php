<div class="related-posts">
  <?php
    $related_posts = get_related_posts();

    if ( $related_posts->have_posts() ) :
      echo '<h3>Related Posts</h3>';
      echo '<ul>';
      while ( $related_posts->have_posts() ) : $related_posts->the_post();
  ?>
        <li>
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
  <?php
      endwhile;
      echo '</ul>';
    endif;

    wp_reset_postdata();
  ?>
</div>

<?php
function get_related_posts() {
  global $post;

  $tags = wp_get_post_tags( $post->ID );
  $tag_ids = array();
  foreach( $tags as $tag ) {
    $tag_ids[] = $tag->term_id;
  }

  $related_posts_query = new WP_Query( array(
    'tag__in' => $tag_ids,
    'post__not_in' => array( $post->ID ),
    'posts_per_page' => 5,
    'ignore_sticky_posts' => true
  ) );

  return $related_posts_query;
}
?>
