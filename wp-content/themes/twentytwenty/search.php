<?php get_header(); ?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&display=swap');

  /* Khung bọc toàn bộ trang tìm kiếm */
  .search-page-container {
      max-width: 960px;
      margin: 40px auto;
      padding: 0 15px;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Header kết quả tìm kiếm */
  .search-page-header {
      margin-bottom: 30px;
      text-align: center;
  }

  .search-page-title {
      font-size: 24px;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 8px;
  }

  .search-page-title span {
      color: #dc2626; /* Tô đỏ từ khóa tìm kiếm */
  }

  .search-page-count {
      font-size: 14px;
      color: #64748b;
      margin: 0;
  }

  /* Danh sách thẻ kết quả */
  .search-results-list {
      display: flex;
      flex-direction: column;
      gap: 20px;
  }

  /* Mỗi thẻ kết quả tìm kiếm (Card) */
  .post-card-item {
      display: flex;
      flex-direction: row;
      align-items: stretch;
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 4px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      overflow: hidden;
      min-height: 165px;
      transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  }

  .post-card-item:hover {
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
      border-color: #cbd5e1;
  }

  /* 1. Cột Ảnh Đại Diện (Bên trái) */
  .post-card-thumb {
      width: 320px;
      min-width: 320px;
      max-width: 340px;
      flex-shrink: 0;
      position: relative;
      background-color: #f1f5f9;
      overflow: hidden;
  }

  .post-card-thumb a {
      display: block;
      width: 100%;
      height: 100%;
      text-decoration: none;
  }

  .post-card-thumb img,
  .post-card-thumb .post-card-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: transform 0.35s ease;
  }

  .post-card-item:hover .post-card-thumb img {
      transform: scale(1.04);
  }

  /* Placeholder khi không có ảnh hoặc ảnh lỗi */
  .post-card-no-img {
      width: 100%;
      height: 100%;
      min-height: 165px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
      color: #64748b;
  }

  /* 2. Cột Ngày / Tháng (Ở giữa) */
  .post-card-date {
      width: 110px;
      min-width: 110px;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 15px 10px;
  }

  .post-card-date .day-num {
      font-size: 42px;
      font-weight: 500;
      line-height: 1;
      color: #111827;
      font-family: "Playfair Display", Georgia, "Times New Roman", serif;
      letter-spacing: -0.5px;
      text-align: center;
  }

  .post-card-date .month-text {
      font-size: 11px;
      font-weight: 600;
      color: #64748b;
      text-transform: uppercase;
      margin-top: 6px;
      letter-spacing: 0.5px;
      text-align: center;
      font-family: Arial, sans-serif;
  }

  /* Vạch kẻ phân cách dọc giữa Ngày và Tiêu đề */
  .post-card-divider {
      width: 1px;
      height: 70px;
      background-color: #e2e8f0;
      align-self: center;
      flex-shrink: 0;
  }

  /* 3. Cột Tiêu đề & Tóm tắt nội dung (Bên phải) */
  .post-card-info {
      flex: 1;
      min-width: 0;
      padding: 20px 24px 20px 22px;
      display: flex;
      flex-direction: column;
      justify-content: center;
  }

  .post-card-title {
      font-size: 17px;
      font-weight: 700;
      line-height: 1.4;
      margin: 0 0 10px 0;
      text-transform: uppercase;
      font-family: Arial, "Helvetica Neue", sans-serif;
  }

  .post-card-title a {
      color: #0066cc;
      text-decoration: none;
      transition: color 0.2s ease;
  }

  .post-card-title a:hover {
      color: #004b99;
      text-decoration: underline;
  }

  .post-card-excerpt {
      font-size: 13.5px;
      color: #555555;
      line-height: 1.6;
      margin: 0;
  }

  /* Giao diện khi không tìm thấy kết quả */
  .search-no-results-box {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      padding: 40px 20px;
      text-align: center;
      margin-top: 20px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.05);
  }

  .search-no-results-text {
      color: #64748b;
      font-size: 15px;
      max-width: 500px;
      margin: 0 auto 25px auto;
      line-height: 1.6;
  }

  .search-box-wrapper {
      background-color: #f8fafc;
      padding: 20px;
      border-radius: 6px;
      display: flex;
      justify-content: center;
      max-width: 540px;
      margin: 0 auto;
  }

  .custom-search-form {
      display: flex;
      align-items: center;
      background: #ffffff;
      border: 1px solid #cbd5e1;
      border-radius: 4px;
      padding: 6px 12px;
      width: 100%;
      box-shadow: 0 1px 3px rgba(0,0,0,0.04);
  }

  .custom-search-form input[type="search"] {
      border: none !important;
      outline: none !important;
      width: 100%;
      font-size: 15px;
      background: transparent !important;
      color: #1e293b;
      padding: 4px 8px;
  }

  .custom-search-form button {
      background-color: #22c55e !important;
      color: #ffffff !important;
      border: none !important;
      padding: 8px 18px !important;
      border-radius: 4px !important;
      font-weight: 600 !important;
      cursor: pointer !important;
      transition: background-color 0.2s;
      flex-shrink: 0;
  }

  .custom-search-form button:hover {
      background-color: #16a34a !important;
  }

  /* Phân trang */
  .search-pagination {
      margin-top: 35px;
      display: flex;
      justify-content: center;
  }

  .search-pagination .nav-links {
      display: flex;
      gap: 6px;
      align-items: center;
  }

  .search-pagination .page-numbers {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 36px;
      height: 36px;
      padding: 0 10px;
      border: 1px solid #e2e8f0;
      border-radius: 4px;
      background: #ffffff;
      color: #475569;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.2s;
  }

  .search-pagination .page-numbers:hover {
      border-color: #0066cc;
      color: #0066cc;
      background: #f0f7ff;
  }

  .search-pagination .page-numbers.current {
      background: #0066cc;
      border-color: #0066cc;
      color: #ffffff;
  }

  /* Responsive Mobile / Tablet */
  @media (max-width: 768px) {
      .post-card-item {
          flex-direction: column;
          min-height: auto;
      }

      .post-card-thumb {
          width: 100%;
          min-width: 100%;
          max-width: 100%;
          height: 200px;
      }

      .post-card-date {
          flex-direction: row;
          width: 100%;
          min-width: 100%;
          padding: 12px 15px 0 15px;
          justify-content: flex-start;
          gap: 10px;
      }

      .post-card-date .day-num {
          font-size: 28px;
      }

      .post-card-date .month-text {
          margin-top: 0;
          font-size: 12px;
      }

      .post-card-divider {
          display: none;
      }

      .post-card-info {
          padding: 10px 15px 15px 15px;
      }

      .post-card-title {
          font-size: 16px;
      }
  }
</style>

<div class="search-page-container">
    <div class="search-page-header">
        <h1 class="search-page-title">
            Kết quả tìm kiếm cho: "<span><?php echo esc_html( get_search_query() ); ?></span>"
        </h1>
        <?php if ( have_posts() ) : ?>
            <p class="search-page-count">
                Tìm thấy <strong><?php global $wp_query; echo $wp_query->found_posts; ?></strong> kết quả phù hợp
            </p>
        <?php endif; ?>
    </div>

    <?php if ( have_posts() ) : ?>
        
        <!-- Danh sách kết quả tìm thấy -->
        <div class="search-results-list">
            <?php while ( have_posts() ) : the_post(); 
                $day = get_the_date('d');
                $month = get_the_date('m');
            ?>
                <article class="post-card-item">
                    <!-- 1. Ảnh Đại Diện (Bên trái) -->
                    <div class="post-card-thumb">
                        <a href="<?php the_permalink(); ?>">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php 
                                    $thumb_src = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ); 
                                ?>
                                <img src="<?php echo esc_url( $thumb_src ); ?>" 
                                     alt="<?php the_title_attribute(); ?>" 
                                     class="post-card-img" 
                                     loading="lazy"
                                     onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                <div class="post-card-no-img" style="display:none;">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                            <?php else : ?>
                                <div class="post-card-no-img">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </a>
                    </div>

                    <!-- 2. Ngày / Tháng (Ở giữa) -->
                    <div class="post-card-date">
                        <div class="day-num"><?php echo $day; ?></div>
                        <div class="month-text">THÁNG <?php echo $month; ?></div>
                    </div>

                    <!-- Vạch phân cách đứng -->
                    <div class="post-card-divider"></div>

                    <!-- 3. Tiêu đề & Tóm tắt (Bên phải) -->
                    <div class="post-card-info">
                        <h2 class="post-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="post-card-excerpt">
                            <?php echo wp_trim_words( get_the_excerpt(), 24, ' [...]' ); ?>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <!-- Phân trang -->
        <div class="search-pagination">
            <?php
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => '&laquo; Trước',
                'next_text' => 'Sau &raquo;',
            ) );
            ?>
        </div>

    <?php else : ?>

        <!-- Không tìm thấy kết quả phù hợp -->
        <div class="search-no-results-box">
            <p class="search-no-results-text">
                Không tìm thấy bài viết hoặc sản phẩm nào phù hợp với từ khóa của bạn. Vui lòng thử lại với từ khóa khác.
            </p>

            <div class="search-box-wrapper">
                <form role="search" method="get" class="custom-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <span style="margin-right: 8px;">🔍</span>
                    <input type="search" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo get_search_query(); ?>" name="s" required />
                    <button type="submit">Tìm kiếm</button>
                </form>
            </div>
        </div>

    <?php endif; ?>
</div>

<!-- ĐOẠN SCRIPT HIỂN THỊ THÔNG BÁO KHI TÌM KIẾM QUÁ NHIỀU KÝ TỰ -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    var searchForms = document.querySelectorAll('form[role="search"], .custom-search-form');
    
    searchForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            var searchInput = form.querySelector('input[name="s"]');
            var maxLength = 50;
            
            if (searchInput && searchInput.value.length > maxLength) {
                e.preventDefault();
                alert('Từ khóa tìm kiếm của bạn quá dài (' + searchInput.value.length + ' ký tự). Vui lòng nhập tối đa ' + maxLength + ' ký tự!');
            }
        });
    });
});
</script>

<?php get_footer(); ?>