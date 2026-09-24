<?php
/**
 * The template for displaying archive pages (Xem nhiều / Most Viewed list)
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 */

get_header();

// Thu thập danh sách bài viết từ truy vấn chính
$posts_list = array();
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        $posts_list[] = array(
            'id'            => get_the_ID(),
            'title'         => get_the_title(),
            'permalink'     => get_permalink(),
            'comment_count' => get_comments_number(),
        );
    }
}

// Nếu truy vấn ít hơn 8 bài (ví dụ category trống), query bổ sung để hiển thị đủ 8 bài theo chuẩn widget
if ( count( $posts_list ) < 8 ) {
    $needed = 8 - count( $posts_list );
    $exclude_ids = wp_list_pluck( $posts_list, 'id' );
    $extra_query = new WP_Query( array(
        'post_type'      => 'post',
        'posts_per_page' => $needed,
        'post__not_in'   => $exclude_ids,
        'orderby'        => 'comment_count',
        'order'          => 'DESC',
    ) );
    if ( $extra_query->have_posts() ) {
        while ( $extra_query->have_posts() ) {
            $extra_query->the_post();
            $posts_list[] = array(
                'id'            => get_the_ID(),
                'title'         => get_the_title(),
                'permalink'     => get_permalink(),
                'comment_count' => get_comments_number(),
            );
        }
        wp_reset_postdata();
    }
}

// Giới hạn 8 bài viết cho giao diện 2 cột x 4 hàng chuẩn theo ảnh
$display_posts = array_slice( $posts_list, 0, 8 );
$half = 4;
$col1 = array_slice( $display_posts, 0, $half );
$col2 = array_slice( $display_posts, $half );
?>

<style>
  /* Khung bọc khu vực Archive */
  .archive-page-container {
      max-width: 960px;
      margin: 40px auto 60px auto;
      padding: 30px 35px;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 4px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Tiêu đề mục: "Xem nhiều" với gạch đỏ ở chân */
  .archive-header {
      border-bottom: 1px solid #e5e7eb;
      margin-bottom: 10px;
      display: flex;
      align-items: baseline;
      gap: 12px;
  }

  .archive-header-title {
      font-size: 20px;
      font-weight: 700;
      color: #1f2937;
      display: inline-block;
      margin: 0;
      padding-bottom: 8px;
      border-bottom: 2.5px solid #b91c1c; /* Gạch chân màu đỏ đậm chuẩn VnExpress */
      margin-bottom: -1px; /* Căn thẳng với vạch ngang xám */
      font-family: Arial, "Helvetica Neue", sans-serif;
  }

  .archive-header-subtitle {
      font-size: 14px;
      color: #6b7280;
      font-weight: normal;
  }

  /* Lưới 2 cột chia đôi */
  .archive-rank-grid {
      display: flex;
      flex-direction: row;
      align-items: stretch;
  }

  /* Cột bên trái (Số 1 -> 4) */
  .archive-rank-col.col-left {
      flex: 1;
      border-right: 1px solid #e5e7eb;
      padding-right: 28px;
  }

  /* Cột bên phải (Số 5 -> 8) */
  .archive-rank-col.col-right {
      flex: 1;
      padding-left: 28px;
  }

  /* Mỗi hàng tin tức */
  .archive-rank-item {
      display: flex;
      flex-direction: row;
      align-items: flex-start;
      padding: 18px 0;
      border-bottom: 1px solid #f1f5f9;
      min-height: 82px;
  }

  .archive-rank-col .archive-rank-item:last-child {
      border-bottom: none;
  }

  /* Số thứ tự 1..8 phong cách Serif lớn */
  .rank-number {
      font-family: "Georgia", "Times New Roman", Times, serif;
      font-size: 38px;
      font-weight: 700;
      color: #111827;
      line-height: 1;
      width: 32px;
      min-width: 32px;
      margin-right: 16px;
      flex-shrink: 0;
      text-align: center;
      padding-top: 2px;
      user-select: none;
  }

  /* Khối nội dung tiêu đề */
  .rank-content {
      flex: 1;
      min-width: 0;
  }

  .rank-title {
      font-size: 15px;
      font-weight: 500;
      line-height: 1.45;
      margin: 0;
      font-family: Arial, "Helvetica Neue", sans-serif;
  }

  .rank-title a {
      color: #1f2937;
      text-decoration: none;
      transition: color 0.15s ease;
  }

  .rank-title a:hover {
      color: #0066cc;
  }

  /* Icon bình luận kèm số lượng */
  .rank-comment-badge {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      margin-left: 6px;
      color: #94a3b8;
      font-size: 13px;
      font-weight: normal;
      vertical-align: middle;
      white-space: nowrap;
  }

  .comment-bubble-icon {
      width: 14px;
      height: 14px;
      fill: #94a3b8;
      display: inline-block;
      vertical-align: middle;
  }

  /* Responsive Mobile */
  @media (max-width: 768px) {
      .archive-page-container {
          margin: 20px 10px;
          padding: 20px 18px;
      }

      .archive-rank-grid {
          flex-direction: column;
      }

      .archive-rank-col.col-left {
          border-right: none;
          padding-right: 0;
          border-bottom: 1px solid #e5e7eb;
          padding-bottom: 10px;
      }

      .archive-rank-col.col-right {
          padding-left: 0;
          padding-top: 10px;
      }

      .rank-number {
          font-size: 32px;
          margin-right: 12px;
      }

      .rank-title {
          font-size: 14.5px;
      }
  }
</style>

<main id="site-content">
    <div class="archive-page-container">
        <!-- Header tiêu đề "Xem nhiều" -->
        <div class="archive-header">
            <h2 class="archive-header-title">Xem nhiều</h2>
            <?php if ( is_category() || is_tag() || is_date() || is_author() ) : ?>
                <span class="archive-header-subtitle">&bull; <?php the_archive_title(); ?></span>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $display_posts ) ) : ?>
            <!-- Lưới 2 cột: Cột 1 (1->4) và Cột 2 (5->8) -->
            <div class="archive-rank-grid">
                <!-- Cột trái: 1..4 -->
                <div class="archive-rank-col col-left">
                    <?php foreach ( $col1 as $index => $item ) : 
                        $rank = $index + 1;
                    ?>
                        <article class="archive-rank-item">
                            <div class="rank-number"><?php echo $rank; ?></div>
                            <div class="rank-content">
                                <h3 class="rank-title">
                                    <a href="<?php echo esc_url( $item['permalink'] ); ?>">
                                        <?php echo esc_html( $item['title'] ); ?>
                                    </a>
                                    <?php if ( $item['comment_count'] > 0 ) : ?>
                                        <span class="rank-comment-badge" title="<?php echo esc_attr( $item['comment_count'] . ' bình luận' ); ?>">
                                            <svg class="comment-bubble-icon" viewBox="0 0 20 20">
                                                <path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z"/>
                                            </svg>
                                            <span><?php echo $item['comment_count']; ?></span>
                                        </span>
                                    <?php endif; ?>
                                </h3>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <!-- Cột phải: 5..8 -->
                <div class="archive-rank-col col-right">
                    <?php foreach ( $col2 as $index => $item ) : 
                        $rank = $half + $index + 1;
                    ?>
                        <article class="archive-rank-item">
                            <div class="rank-number"><?php echo $rank; ?></div>
                            <div class="rank-content">
                                <h3 class="rank-title">
                                    <a href="<?php echo esc_url( $item['permalink'] ); ?>">
                                        <?php echo esc_html( $item['title'] ); ?>
                                    </a>
                                    <?php if ( $item['comment_count'] > 0 ) : ?>
                                        <span class="rank-comment-badge" title="<?php echo esc_attr( $item['comment_count'] . ' bình luận' ); ?>">
                                            <svg class="comment-bubble-icon" viewBox="0 0 20 20">
                                                <path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z"/>
                                            </svg>
                                            <span><?php echo $item['comment_count']; ?></span>
                                        </span>
                                    <?php endif; ?>
                                </h3>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else : ?>
            <p style="color: #64748b; padding: 20px 0;">Chưa có bài viết nào trong mục này.</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
