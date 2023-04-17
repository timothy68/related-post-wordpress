<div class="related-entries">
  <?php
    $post_tags = wp_get_post_tags( $post->ID );
    if ( $post_tags ) {
      $tag_ids = array();
      foreach( $post_tags as $tag ) {
        $tag_ids[] = $tag->term_id;
      }
      $args = array(
        'tag__in' => $tag_ids,
        'post__not_in' => array( $post->ID ),
        'posts_per_page' => 5,
        'ignore_sticky_posts' => true
      );
      $related_posts_query = new WP_Query( $args );
      if ( $related_posts_query->have_posts() ) {
  ?>
  <div class="block">
    <h3>Related Posts</h3>
    <ul>
      <?php while ( $related_posts_query->have_posts() ) {
        $related_posts_query->the_post();
      ?>
      <li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
      <?php } ?>
    </ul>
  </div>
  <?php
      }
      wp_reset_postdata();
    }
  ?>
</div>
