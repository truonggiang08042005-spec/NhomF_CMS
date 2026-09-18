<?php get_header(); ?>

<style>
  /* Container chứa danh sách bài viết */
  .content-list-container {
      max-width: 700px;
      margin: 30px auto;
      padding: 0 15px;
      background: #ffffff;
  }

  /* Khung thẻ từng bài viết */
  .post-card-item {
      display: flex !important;
      align-items: flex-start !important;
      background: #ffffff !important;
      padding: 20px 0 !important;
      border-bottom: 1px solid #e0e0e0 !important; /* Đường gạch kẻ ngang phân cách các bài viết */
  }

  .post-card-item:last-child {
      border-bottom: none !important;
  }

  /* 1. Cột Ngày & Tháng */
  .post-card-date {
      width: 75px !important;
      min-width: 75px !important;
      text-align: center !important;
      padding-right: 15px !important;
      margin-right: 20px !important;
      border-right: 1px solid #dcdcdc !important; /* Đường kẻ dọc ngăn cách giữa ngày và nội dung */
      align-self: stretch !important; /* Giúp đường kẻ kéo dài trọn chiều cao */
  }

  .post-card-date .day-num {
      font-size: 42px !important;
      font-weight: 700 !important;
      line-height: 0.9 !important;
      color: #2b2b2b !important;
      font-family: "Playfair Display", "Times New Roman", Times, serif !important;
  }

  .post-card-date .month-text {
      font-size: 11px !important;
      color: #888888 !important;
      text-transform: uppercase !important;
      margin-top: 6px !important;
      letter-spacing: 0.5px !important;
  }

  /* 2. Cột Tiêu đề & Tóm tắt */
  .post-card-info {
      flex: 1 !important;
  }

  .post-card-title {
      font-size: 16px !important;
      font-weight: 700 !important;
      margin: 0 0 8px 0 !important;
      line-height: 1.3 !important;
      text-transform: uppercase !important;
  }

  .post-card-title a {
      color: #2a6fbe !important; /* Màu xanh chuẩn mẫu */
      text-decoration: none !important;
  }

  .post-card-title a:hover {
      color: #1d4ed8 !important;
  }

  .post-card-excerpt {
      font-size: 13px !important;
      color: #888888 !important;
      margin: 0 !important;
      line-height: 1.4 !important;
  }

  .post-card-excerpt a.more-link {
      color: #2a6fbe !important;
      text-decoration: none !important;
  }
</style>

<div class="content-list-container">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); 
            $day = get_the_date('d');
            $month = get_the_date('m');
        ?>
            
            <article class="post-card-item">
                <!-- 1. Cột Ngày / Tháng -->
                <div class="post-card-date">
                    <div class="day-num"><?php echo $day; ?></div>
                    <div class="month-text">THÁNG <?php echo $month; ?></div>
                </div>

                <!-- 2. Cột Tiêu đề & Mô tả ngắn (Đã ẩn phần ảnh đại diện) -->
                <div class="post-card-info">
                    <h2 class="post-card-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <p class="post-card-excerpt">
                        <?php echo wp_trim_words( get_the_excerpt(), 25, '' ); ?>
                        <a href="<?php the_permalink(); ?>" class="more-link">[...]</a>
                    </p>
                </div>
            </article>

        <?php endwhile; ?>
    <?php else : ?>
        <p>Chưa có bài viết nào.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>