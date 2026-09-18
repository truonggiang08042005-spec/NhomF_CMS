<?php get_header(); ?>

<style>
  /* Khung chứa danh sách bài viết */
  .content-list-container {
      max-width: 800px;
      margin: 30px auto;
      padding: 0 15px;
      font-family: Arial, sans-serif;
  }

  /* Mỗi thẻ bài viết (Card) */
  .post-card-item {
      display: flex !important;
      align-items: center !important;
      background: #ffffff !important;
      border: 1px solid #e2e8f0 !important;
      border-radius: 4px !important;
      padding: 20px 25px !important;
      margin-bottom: 20px !important;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03) !important;
  }

  /* 1. Cột Ngày & Tháng bên trái */
  .post-card-date {
      width: 90px !important;
      min-width: 90px !important;
      text-align: center !important;
      padding-right: 20px !important;
      margin-right: 20px !important;
      border-right: 1px solid #e2e8f0 !important;
  }

  .post-card-date .day-num {
      font-size: 38px !important;
      font-weight: bold !important;
      line-height: 1 !important;
      color: #1e293b !important;
      font-family: Georgia, serif !important;
  }

  .post-card-date .month-text {
      font-size: 11px !important;
      color: #64748b !important;
      text-transform: uppercase !important;
      margin-top: 6px !important;
      letter-spacing: 0.5px !important;
  }

  /* 2. Cột Tiêu đề & Nội dung tóm tắt bên phải */
  .post-card-info {
      flex: 1 !important;
  }

  .post-card-title {
      font-size: 16px !important;
      font-weight: 700 !important;
      margin: 0 0 10px 0 !important;
      line-height: 1.4 !important;
      text-transform: uppercase !important;
  }

  .post-card-title a {
      color: #0284c7 !important; /* Màu xanh dương chủ đạo */
      text-decoration: none !important;
  }

  .post-card-title a:hover {
      text-decoration: underline !important;
  }

  .post-card-excerpt {
      font-size: 13px !important;
      color: #64748b !important;
      margin: 0 !important;
      line-height: 1.5 !important;
  }
</style>

<div class="content-list-container">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); 
            $day = get_the_date('d');
            $month = get_the_date('m');
        ?>
            
            <article class="post-card-item">
                <!-- Cột 1: Ngày / Tháng -->
                <div class="post-card-date">
                    <div class="day-num"><?php echo $day; ?></div>
                    <div class="month-text">THÁNG <?php echo $month; ?></div>
                </div>

                <!-- Cột 2: Tiêu đề & Tóm tắt bài viết -->
                <div class="post-card-info">
                    <h2 class="post-card-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <p class="post-card-excerpt">
                        <?php echo wp_trim_words( get_the_excerpt(), 25, ' [...]' ); ?>
                    </p>
                </div>
            </article>

        <?php endwhile; ?>
    <?php else : ?>
        <p>Chưa có bài viết nào trong Database.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>