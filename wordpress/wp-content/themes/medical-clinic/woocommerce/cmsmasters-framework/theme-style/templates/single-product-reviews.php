<?php
/**
 * @cmsmasters_package 	Medical Clinic
 * @cmsmasters_version 	1.1.4
 */


global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews">
	<div id="comments" class="post_comments cmsmasters_woo_comments">
		<h3 class="post_comments_title"><?php
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) )
				printf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'medical-clinic' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
			else
				esc_html_e( 'Reviews', 'medical-clinic' );
		?></h3>

		<?php if ( have_comments() ) : ?>

			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="cmsmasters_wrap_pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text'    => '<span class="cmsmasters_theme_icon_slide_' . (!is_rtl() ? 'prev' : 'next') . '"></span>', 
					'next_text'    => '<span class="cmsmasters_theme_icon_slide_' . (!is_rtl() ? 'next' : 'prev') . '"></span>', 
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'medical-clinic' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'medical-clinic' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'medical-clinic' ), get_the_title() ),
						'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'medical-clinic' ),
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'id_form'              => 'commentform', 
						'id_submit'            => 'submit', 
						'fields'               => array(
							'author' => '<p class="comment-form-author">' . "\n" . 
								'<label for="author">' . esc_html__('Your name', 'medical-clinic') . '<span class="cmsmasters_req">*</span>' . '</label>' . "\n" . 
								'<input type="text" id="author" name="author" value="' . esc_attr($commenter['comment_author']) . '" size="35" aria-required="true" />' . "\n" . 
							'</p>' . "\n", 
							'email' => '<p class="comment-form-email">' . "\n" . 
								'<label for="email">' . esc_html__('Email', 'medical-clinic') . '<span class="cmsmasters_req">*</span>' . '</label>' . "\n" . 
								'<input type="text" id="email" name="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="35" aria-required="true" />' . "\n" . 
							'</p>' . "\n",
						),
						'label_submit'  => esc_html__( 'Submit', 'medical-clinic' ),
						'logged_in_as'  => '',
						'comment_field' => ''
					);

					if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
						$comment_form['must_log_in'] = '<p class="must-log-in">' .  sprintf( esc_html__( 'You must be <a href="%s">logged in</a> to post a review.', 'medical-clinic' ), esc_url( $account_page_url ) ) . '</p>';
					}

					$comment_form['comment_field'] = '<p class="comment-form-comment">' . 
							'<label for="comment">' . esc_html__('Your Review', 'medical-clinic') . '</label>' . 
							'<textarea name="comment" id="comment" cols="67" rows="2"></textarea>' . 
						'</p>';
					
					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] .= '<p class="comment-form-rating"><label for="rating">' . esc_html__( 'Your Rating', 'medical-clinic' ) .'</label><select name="rating" id="rating">
							<option value="">' . esc_html__( 'Rate&hellip;', 'medical-clinic' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'medical-clinic' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'medical-clinic' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'medical-clinic' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'medical-clinic' ) . '</option>
							<option value="1">' . esc_html__( 'Very Poor', 'medical-clinic' ) . '</option>
						</select></p>';
					}

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'medical-clinic' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
