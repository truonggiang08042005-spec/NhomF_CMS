<?php
/**
 * Custom threaded comments for Twenty Twenty.
 *
 * @package Twenty_Twenty
 */


/**
 * ==========================================================
 * HIỂN THỊ KHU VỰC BÌNH LUẬN
 * ==========================================================
 */
function twentytwenty_custom_comments()
{

	$comments = get_comments(
		array(
			'post_id' => get_the_ID(),
			'status' => 'approve',
			'order' => 'ASC',
		)
	);

	/*
	 * Không có bình luận.
	 */
	if (empty($comments)) {
		return;
	}


	/*
	 * ======================================================
	 * GOM COMMENT THEO COMMENT CHA
	 * ======================================================
	 *
	 * 0   = comment gốc
	 * 123 = reply của comment ID 123
	 */
	$comments_by_parent = array();

	foreach ($comments as $comment) {

		$parent_id = (int) $comment->comment_parent;

		if (!isset($comments_by_parent[$parent_id])) {
			$comments_by_parent[$parent_id] = array();
		}

		$comments_by_parent[$parent_id][] = $comment;
	}


	/*
	 * ======================================================
	 * ĐẾM COMMENT GỐC
	 * ======================================================
	 */
	$root_comments = isset($comments_by_parent[0])
		? $comments_by_parent[0]
		: array();

	$root_count = count($root_comments);


	/*
	 * ======================================================
	 * CONTAINER CHÍNH
	 * ======================================================
	 */
	echo '<div class="custom-comments-wrapper">';


	/*
	 * ======================================================
	 * HIỂN THỊ 4 COMMENT GỐC
	 * ======================================================
	 */
	twentytwenty_render_custom_comments(
		$comments_by_parent,
		0,
		1,
		4,
		3
	);


	/*
	 * ======================================================
	 * NÚT XEM THÊM COMMENT GỐC
	 * ======================================================
	 */
	if ($root_count > 4) {
		?>

		<button type="button" class="custom-comments-load-more" aria-expanded="false">
			Xem thêm bình luận
		</button>

		<?php
	}


	echo '</div>';
}


/**
 * ==========================================================
 * RENDER COMMENT THEO DẠNG CÂY
 * ==========================================================
 *
 * $comments_by_parent
 * $parent_id
 * $depth
 * $initial_visible
 * $max_depth
 */
function twentytwenty_render_custom_comments(
	$comments_by_parent,
	$parent_id,
	$depth = 1,
	$initial_visible = 4,
	$max_depth = 3
) {

	/*
	 * Không có comment.
	 */
	if (empty($comments_by_parent[$parent_id])) {
		return;
	}


	$index = 0;


	foreach ($comments_by_parent[$parent_id] as $comment) {

		$comment_id = (int) $comment->comment_ID;


		/*
		 * ==================================================
		 * KIỂM TRA CÓ PHẢI COMMENT GỐC KHÔNG
		 * ==================================================
		 */
		$is_root_comment = (1 === $depth);


		/*
		 * ==================================================
		 * ẨN COMMENT GỐC THỨ 5 TRỞ ĐI
		 * ==================================================
		 */
		$is_hidden = (
			$is_root_comment &&
			$index >= $initial_visible
		);


		/*
		 * ==================================================
		 * THREAD COMMENT GỐC
		 *
		 * Toàn bộ reply nằm trong thread này.
		 * ==================================================
		 */
		if ($is_root_comment) {
			?>

			<div class="custom-comment-thread <?php echo $is_hidden ? 'custom-comment-thread-hidden' : ''; ?>"
				data-root-comment="<?php echo esc_attr($comment_id); ?>">

				<?php
		}
		?>


			<!-- ==================================================
			 COMMENT
		=================================================== -->

			<div id="comment-<?php echo esc_attr($comment_id); ?>"
				class="custom-comment custom-comment-depth-<?php echo esc_attr($depth); ?>">


				<!-- AVATAR -->
				<div class="custom-comment-avatar">

					<?php

					echo get_avatar(
						$comment,
						1 === $depth ? 50 : 40
					);

					?>

				</div>


				<!-- NỘI DUNG -->
				<div class="custom-comment-main">


					<!-- TÊN -->
					<div class="custom-comment-author">

						<?php
						echo esc_html(
							get_comment_author($comment)
						);
						?>

					</div>


					<!-- NỘI DUNG COMMENT -->
					<div class="custom-comment-content">

						<?php

						echo wp_kses_post(
							get_comment_text($comment)
						);

						?>

					</div>


					<!-- NÚT TRẢ LỜI -->
					<div class="custom-comment-actions">

						<?php

						if (comments_open()) {

							echo get_comment_reply_link(
								array(
									'add_below' => 'comment',
									'depth' => $depth,
									'max_depth' => $max_depth,
									'before' => '',
									'after' => '',
									'reply_text' => 'Trả lời',
								),
								$comment
							);

						}

						?>

					</div>


				</div>

			</div>


			<?php


			/*
			 * ==================================================
			 * KIỂM TRA REPLY
			 * ==================================================
			 */
			$has_replies = !empty(
				$comments_by_parent[$comment_id]
			);


			/*
			 * Chỉ cho phép tối đa 3 cấp.
			 *
			 * depth 1 = comment gốc
			 * depth 2 = reply cấp 1
			 * depth 3 = reply cấp 2
			 *
			 * Không render tiếp sau depth 3.
			 */
			if (
				$has_replies &&
				$depth < $max_depth
			) {

				$reply_count = count(
					$comments_by_parent[$comment_id]
				);
				?>

				<!-- ==================================================
				 KHU VỰC REPLY
			=================================================== -->

				<div class="custom-comment-replies">


					<!-- NÚT XỔ REPLY -->
					<button type="button" class="custom-comment-replies-toggle" aria-expanded="false">
						Xem <?php echo esc_html($reply_count); ?> trả lời
					</button>


					<!-- DANH SÁCH REPLY -->
					<div class="custom-comment-replies-list">

						<?php

						twentytwenty_render_custom_comments(
							$comments_by_parent,
							$comment_id,
							$depth + 1,
							$initial_visible,
							$max_depth
						);

						?>

					</div>

				</div>

				<?php
			}


			/*
			 * ==================================================
			 * ĐÓNG THREAD COMMENT GỐC
			 * ==================================================
			 */
			if ($is_root_comment) {
				?>

			</div>

			<?php
			}


			/*
			 * Chỉ tăng index ở comment gốc.
			 */
			if ($is_root_comment) {
				$index++;
			}
	}
}


/**
 * ==========================================================
 * JAVASCRIPT
 * ==========================================================
 *
 * Chạy một lần ở footer.
 */
function twentytwenty_custom_comments_script()
{

	?>

	<script>
		document.addEventListener('DOMContentLoaded', function () {


			/*
			 * ======================================================
			 * XỔ / THU GỌN REPLY
			 * ======================================================
			 */

			document.addEventListener('click', function (event) {

				const button = event.target.closest(
					'.custom-comment-replies-toggle'
				);

				if (!button) {
					return;
				}


				const replies = button.closest(
					'.custom-comment-replies'
				);

				if (!replies) {
					return;
				}


				const replyList = replies.querySelector(
					':scope > .custom-comment-replies-list'
				);

				if (!replyList) {
					return;
				}


				const isOpen =
					button.getAttribute('aria-expanded') === 'true';


				/*
				 * MỞ REPLY
				 */
				if (!isOpen) {

					replyList.classList.add(
						'is-open'
					);

					button.setAttribute(
						'aria-expanded',
						'true'
					);

					button.textContent =
						'Thu gọn trả lời';

				}


				/*
				 * THU GỌN REPLY
				 */
				else {

					replyList.classList.remove(
						'is-open'
					);

					button.setAttribute(
						'aria-expanded',
						'false'
					);


					/*
					 * Lấy lại số reply trực tiếp.
					 */
					const count =
						replyList.querySelectorAll(
							':scope > .custom-comment-depth-' +
							(
								parseInt(
									button.closest('.custom-comment-replies')
										.parentElement
										.querySelector('.custom-comment')
										.className
										.match(/custom-comment-depth-(\d+)/)[1]
								) + 1
							)
						).length;


					button.textContent =
						'Xem ' + count + ' trả lời';

				}

			});


			/*
			 * ======================================================
			 * XEM THÊM / THU GỌN COMMENT GỐC
			 * ======================================================
			 */

			const commentsWrapper = document.querySelector(
				'.custom-comments-wrapper'
			);

			if (!commentsWrapper) {
				return;
			}


			const mainButton = commentsWrapper.querySelector(
				'.custom-comments-load-more'
			);

			if (!mainButton) {
				return;
			}


			mainButton.addEventListener('click', function () {

				const isExpanded =
					mainButton.getAttribute('aria-expanded') === 'true';


				/*
				 * MỞ TOÀN BỘ COMMENT GỐC
				 */
				if (!isExpanded) {

					const hiddenThreads =
						commentsWrapper.querySelectorAll(
							'.custom-comment-thread-hidden'
						);


					hiddenThreads.forEach(function (thread) {

						thread.classList.remove(
							'custom-comment-thread-hidden'
						);

					});


					mainButton.textContent =
						'Thu gọn bình luận';

					mainButton.setAttribute(
						'aria-expanded',
						'true'
					);

				}


				/*
				 * THU GỌN VỀ 4 COMMENT GỐC
				 */
				else {

					const allThreads =
						commentsWrapper.querySelectorAll(
							'.custom-comment-thread'
						);


					allThreads.forEach(function (thread, index) {

						if (index >= 4) {

							thread.classList.add(
								'custom-comment-thread-hidden'
							);

						}

					});


					mainButton.textContent =
						'Xem thêm bình luận';

					mainButton.setAttribute(
						'aria-expanded',
						'false'
					);


					/*
					 * Khi thu gọn comment gốc,
					 * đồng thời thu gọn tất cả reply.
					 */
					const openedReplies =
						commentsWrapper.querySelectorAll(
							'.custom-comment-replies-list.is-open'
						);


					openedReplies.forEach(function (replyList) {

						replyList.classList.remove(
							'is-open'
						);

					});


					const replyButtons =
						commentsWrapper.querySelectorAll(
							'.custom-comment-replies-toggle'
						);


					replyButtons.forEach(function (button) {

						button.setAttribute(
							'aria-expanded',
							'false'
						);

						/*
						 * Tính lại text.
						 */
						const replies =
							button.closest(
								'.custom-comment-replies'
							);

						if (!replies) {
							return;
						}

						const list =
							replies.querySelector(
								':scope > .custom-comment-replies-list'
							);

						if (!list) {
							return;
						}

						const count =
							list.querySelectorAll(
								':scope > .custom-comment'
							).length;

						button.textContent =
							'Xem ' + count + ' trả lời';

					});

				}

			});

		});
	</script>

	<?php
}


/**
 * Đưa JavaScript xuống footer.
 */
add_action(
	'wp_footer',
	'twentytwenty_custom_comments_script'
);
