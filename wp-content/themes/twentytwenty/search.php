<?php get_header(); ?>

<style>
  /* Khung bọc trang tìm kiếm */
  .search-page-container {
      max-width: 900px;
      margin: 50px auto;
      padding: 0 15px;
      font-family: Arial, sans-serif;
  }

  .search-page-title {
      font-size: 22px;
      font-weight: bold;
      color: #333333;
      margin-bottom: 20px;
      text-align: center;
  }

  .search-page-title span {
      color: #dc2626; /* Tô đỏ từ khóa */
  }

  /* Giao diện khi không tìm thấy */
  .search-no-results-text {
      color: #666666;
      font-size: 14px;
      text-align: center;
      max-width: 500px;
      margin: 0 auto 30px auto;
      line-height: 1.5;
  }

  .search-box-wrapper {
      background-color: #f7f3e9;
      padding: 30px 20px;
      border-radius: 4px;
      display: flex;
      justify-content: center;
  }

  .custom-search-form {
      display: flex;
      align-items: center;
      background: #ffffff;
      border-radius: 4px;
      padding: 15px 15px;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  }

  .custom-search-form input[type="search"] {
      border: none !important;
      outline: none !important;
      width: 100%;
      font-size: 15px;
      background: transparent !important;
  }

  .custom-search-form button {
      background-color: #22c55e !important;
      color: #ffffff !important;
      border: none !important;
      padding: 5px 5px !important;
      border-radius: 4px !important;
      font-weight: bold !important;
      cursor: pointer !important;
  }
</style>

<div class="search-page-container">
    <h1 class="search-page-title">
        Kết quả tìm kiếm cho: "<span><?php echo esc_html( get_search_query() ); ?></span>"
    </h1>

    <?php if ( have_posts() ) : ?>
        
        <!-- Danh sách kết quả gần giống tìm thấy -->
        <div class="search-results-list">
            <?php while ( have_posts() ) : the_post(); 
                $day = get_the_date('d');
                $month = get_the_date('m');
            ?>
                <article class="post-card-item">
                    <!-- 1. Ngày / Tháng -->
                    <div class="post-card-date">
                        <div class="day-num"><?php echo $day; ?></div>
                        <div class="month-text">THÁNG <?php echo $month; ?></div>
                    </div>

                    <!-- 2. Ảnh Đại Diện -->
                    <div class="post-card-thumb">
                        <a href="<?php the_permalink(); ?>">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php else : ?>
                                <img src="https://via.placeholder.com/140x100?text=No+Image" alt="<?php the_title(); ?>" />
                            <?php endif; ?>
                        </a>
                    </div>
<!-- 3. Tiêu đề & Tóm tắt -->
                    <div class="post-card-info">
                        <h2 class="post-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <p class="post-card-excerpt">
                            <?php echo wp_trim_words( get_the_excerpt(), 20, ' [...]' ); ?>
                        </p>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

    <?php else : ?>

        <!-- Không tìm thấy kết quả phù hợp -->
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

    <?php endif; ?>
</div>

<!-- ĐOẠN SCRIPT HIỂN THỊ THÔNG BÁO KHI TÌM KIẾM QUÁ NHIỀU KÝ TỰ -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Tìm tất cả các form tìm kiếm trên trang (bao gồm form trong header nếu có và form custom này)
    var searchForms = document.querySelectorAll('form[role="search"], .custom-search-form');
    
    searchForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            var searchInput = form.querySelector('input[name="s"]');
            var maxLength = 50; // Thay đổi con số này nếu bạn muốn giới hạn dài/ngắn hơn
            
            if (searchInput && searchInput.value.length > maxLength) {
                e.preventDefault(); // Chặn hành động chuyển trang tìm kiếm
                alert('Từ khóa tìm kiếm của bạn quá dài (' + searchInput.value.length + ' ký tự). Vui lòng nhập tối đa ' + maxLength + ' ký tự!');
            }
        });
    });
});
</script>

<?php get_footer(); ?>