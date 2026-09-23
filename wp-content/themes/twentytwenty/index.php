<?php get_header(); ?>

<style>
  /* Layout 3 cột đồng đều chuẩn hình thiết kế: Left (Categories 280px) | Center (Detail) | Right (Recent post 280px) */
  .page-three-column-layout {
      max-width: 1200px;
      margin: 25px auto;
      padding: 0 15px;
      display: flex;
      gap: 25px;
      align-items: flex-start;
      box-sizing: border-box;
  }

  /* Cột bên trái: Categories (9) - Rộng đồng đều 280px */
  .left-sidebar-column {
      width: 280px;
      min-width: 280px;
  }

  /* Cột ở giữa: Detail (6) (Danh sách sản phẩm / nội dung chính) */
  .center-content-column {
      flex: 1;
      min-width: 0;
  }

  /* Cột bên phải: Recent post (10) - Rộng đồng đều 280px */
  .right-sidebar-column {
      width: 280px;
      min-width: 280px;
  }

  @media (max-width: 1024px) {
      .page-three-column-layout {
          flex-direction: column;
      }
      .left-sidebar-column,
      .right-sidebar-column {
          width: 100%;
          min-width: 100%;
      }
  }

  /* Khung thẻ từng bài viết/sản phẩm ở cột giữa */
  .post-card-item {
      position: relative;
      display: flex;
      align-items: flex-start;
      background: #ffffff;
      padding: 22px 18px;
      border-bottom: 1px solid #e2e8f0;
      cursor: pointer;
      transition: all 0.2s ease-in-out;
      border-radius: 8px;
      margin-bottom: 12px;
  }

  .post-card-item:hover {
      background-color: #f8fafc;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
      transform: translateY(-1px);
  }

  .post-card-item:last-child {
      border-bottom: none;
  }

  /* 1. Cột Ngày & Tháng trong thẻ sản phẩm */
  .post-card-date {
      width: 75px;
      min-width: 75px;
      text-align: center;
      padding-right: 15px;
      margin-right: 18px;
      border-right: 1px solid #e2e8f0;
      align-self: stretch;
      display: flex;
      flex-direction: column;
      justify-content: center;
  }

  .post-card-date .day-num {
      font-size: 40px;
      font-weight: 700;
      line-height: 0.9;
      color: #1e293b;
      font-family: "Playfair Display", "Times New Roman", Times, serif;
  }

  .post-card-date .month-text {
      font-size: 11px;
      color: #64748b;
      text-transform: uppercase;
      margin-top: 6px;
      letter-spacing: 0.5px;
      font-weight: 600;
  }

  /* 2. Cột Tiêu đề & Tóm tắt sản phẩm */
  .post-card-info {
      flex: 1;
  }

  .post-card-title {
      font-size: 16.5px;
      font-weight: 700;
      margin: 0 0 10px 0;
      line-height: 1.35;
      text-transform: uppercase;
  }

  .post-card-title a {
      color: #2a6fbe;
      text-decoration: none;
      transition: color 0.2s ease;
  }

  .post-card-item:hover .post-card-title a {
      color: #1d4ed8;
      text-decoration: underline;
  }

  .post-card-excerpt {
      font-size: 13.5px;
      color: #475569;
      margin: 0 0 14px 0;
      line-height: 1.55;
  }

  /* Nút thao tác mở nhanh / xem chi tiết */
  .post-card-actions {
      display: flex;
      gap: 10px;
      align-items: center;
  }

  .btn-action-view {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      background-color: #2a6fbe;
      color: #ffffff !important;
      font-size: 12px;
      font-weight: 600;
      border-radius: 4px;
      text-decoration: none !important;
      transition: background-color 0.2s ease;
      border: none;
      cursor: pointer;
  }

  .btn-action-view:hover {
      background-color: #1d4ed8;
  }

  .btn-action-page {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      background-color: #f1f5f9;
      color: #334155 !important;
      font-size: 12px;
      font-weight: 600;
      border-radius: 4px;
      text-decoration: none !important;
      transition: all 0.2s ease;
  }

  .btn-action-page:hover {
      background-color: #e2e8f0;
      color: #0f172a !important;
  }

  /* Giao diện Popup Modal xem thông tin sản phẩm */
  .product-modal-backdrop {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(15, 23, 42, 0.65);
      backdrop-filter: blur(4px);
      z-index: 99999;
      justify-content: center;
      align-items: center;
      padding: 20px;
      box-sizing: border-box;
      opacity: 0;
      transition: opacity 0.25s ease-in-out;
  }

  .product-modal-backdrop.active {
      display: flex;
      opacity: 1;
  }

  .product-modal-box {
      background: #ffffff;
      width: 100%;
      max-width: 800px;
      max-height: 85vh;
      border-radius: 12px;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      display: flex;
      flex-direction: column;
      overflow: hidden;
      animation: modalSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  }

  @keyframes modalSlideUp {
      from { transform: translateY(20px) scale(0.97); opacity: 0; }
      to { transform: translateY(0) scale(1); opacity: 1; }
  }

  .product-modal-header {
      padding: 20px 25px;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #f8fafc;
  }

  .product-modal-title {
      font-size: 20px;
      font-weight: 700;
      color: #0f172a;
      margin: 0;
      line-height: 1.35;
  }

  .product-modal-close {
      background: none;
      border: none;
      font-size: 26px;
      color: #64748b;
      cursor: pointer;
      padding: 4px 8px;
      line-height: 1;
      border-radius: 4px;
      transition: all 0.2s;
  }

  .product-modal-close:hover {
      background-color: #e2e8f0;
      color: #0f172a;
  }

  .product-modal-body {
      padding: 25px 30px;
      overflow-y: auto;
      font-size: 15.5px;
      line-height: 1.75;
      color: #334155;
  }

  .product-modal-body img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      margin: 15px 0;
  }

  .product-modal-body ul, .product-modal-body ol {
      padding-left: 24px;
      margin: 15px 0;
  }

  .product-modal-body li {
      margin-bottom: 8px;
  }

  .product-modal-footer {
      padding: 16px 25px;
      border-top: 1px solid #e2e8f0;
      background-color: #f8fafc;
      display: flex;
      justify-content: space-between;
      align-items: center;
  }

  /* ==========================================================================
     Widget Categories (Phía bên trái) - Chuẩn mẫu "Sau chỉnh sửa"
     ========================================================================== */
  .categories-widget-box {
      background-color: #ededed;
      background-image: repeating-linear-gradient(45deg, #f4f4f4, #f4f4f4 10px, #e9e9e9 10px, #e9e9e9 20px);
      padding: 22px 18px;
      border-radius: 4px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
      box-sizing: border-box;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
  }

  .widget-title-styled {
      font-size: 24px !important;
      font-weight: 800 !important;
      color: #1a1a1a !important;
      margin: 0 0 6px 0 !important;
      padding: 0 !important;
      border: none !important;
      text-transform: none !important;
      letter-spacing: -0.4px !important;
      line-height: 1.2 !important;
  }

  /* Thanh sọc chéo chéo bên dưới tiêu đề (Striped separator bar) */
  .widget-striped-bar {
      width: 100%;
      height: 14px;
      margin-top: 8px;
      margin-bottom: 16px;
      background: repeating-linear-gradient(
          -45deg,
          #d5d5d5,
          #d5d5d5 3px,
          #e9e9e9 3px,
          #e9e9e9 6px
      );
      border-radius: 1px;
  }

  /* Khung màu trắng bên trong chứa danh sách Categories */
  .categories-white-box {
      background: #ffffff;
      padding: 8px 16px;
      border-radius: 2px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
  }

  .categories-white-box ul {
      margin: 0;
      padding: 0;
      list-style: none;
  }

  .categories-white-box ul li {
      display: flex;
      align-items: center;
      padding: 12px 0;
      margin: 0;
      border-bottom: 1px solid #f0f0f0;
      list-style: none;
      font-size: 14.5px;
  }

  .categories-white-box ul li:last-child {
      border-bottom: none;
  }

  .categories-white-box ul li::before {
      content: "";
      display: inline-block;
      width: 8px;
      height: 8px;
      min-width: 8px;
      background-color: #f5b025; /* Màu vàng tròn chuẩn mẫu */
      border-radius: 50%;
      margin-right: 12px;
  }

  .categories-white-box ul li a {
      color: #5587b7;
      text-decoration: none;
      font-weight: 500;
      font-size: 14.5px;
      transition: color 0.2s ease-in-out;
  }

  .categories-white-box ul li a:hover {
      color: #1d4ed8;
      text-decoration: underline;
  }

  /* ==========================================================================
     Widget Recent Post (#10 Phía bên phải) - Thiết kế 100% CHUẨN MẪU MỚI
     ========================================================================== */
  .recent-posts-teal-card {
      background-color: #45b5b4; /* Tone màu xanh ngọc / turquoise chuẩn như hình mẫu */
      border-radius: 4px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
  }

  .recent-posts-teal-list {
      padding: 20px 18px 10px 18px;
  }

  .recent-post-teal-item {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 15px 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.22);
  }

  .recent-post-teal-item:last-child {
      border-bottom: none;
  }

  /* Định dạng ngày/tháng phân số bên trái: Day / Month Year */
  .recent-teal-date-badge {
      display: flex;
      align-items: center;
      gap: 3px;
      color: #ffffff;
      min-width: 50px;
      font-family: Arial, "Helvetica Neue", sans-serif;
      user-select: none;
  }

  .recent-teal-date-fraction {
      display: flex;
      flex-direction: column;
      align-items: center;
      line-height: 1;
  }

  .recent-teal-date-day {
      font-size: 13px;
      font-weight: 700;
      line-height: 1;
      padding-bottom: 2px;
  }

  .recent-teal-date-line {
      width: 17px;
      height: 1.5px;
      background-color: #ffffff;
      margin: 1px 0;
  }

  .recent-teal-date-month {
      font-size: 13px;
      font-weight: 700;
      line-height: 1;
      padding-top: 2px;
  }

  .recent-teal-date-year {
      font-size: 13px;
      font-weight: 700;
      line-height: 1;
      align-self: center;
      margin-left: 1px;
  }

  /* Tiêu đề bài viết màu trắng */
  .recent-post-teal-title {
      flex: 1;
      font-size: 13.5px;
      line-height: 1.45;
      margin: 0;
  }

  .recent-post-teal-title a {
      color: #ffffff !important;
      text-decoration: none !important;
      font-weight: 400;
      transition: opacity 0.2s ease;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
  }

  .recent-post-teal-title a:hover {
      opacity: 0.85;
      text-decoration: underline !important;
  }

  /* Nút XEM TẤT CẢ TIN TỨC màu xanh đậm ở dưới đáy */
  .recent-posts-btn-banner {
      display: block;
      background-color: #3ba3a2;
      color: #ffffff !important;
      text-align: center;
      padding: 16px 10px;
      font-weight: 700;
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 0.6px;
      text-decoration: none !important;
      transition: background-color 0.2s ease;
  }

  .recent-posts-btn-banner:hover {
      background-color: #2e8b89;
  }
</style>

<div class="page-three-column-layout">
    
    <!-- CỘT BÊN TRÁI: Categories (9) theo đúng hình thiết kế (Rộng 280px) -->
    <div class="left-sidebar-column">
        <aside class="categories-widget-box">
            <h3 class="widget-title-styled">Categories</h3>
            <div class="widget-striped-bar"></div>
            <div class="categories-white-box">
                <ul>
                    <?php
                    // Lấy tất cả Chuyên mục (Categories) tự động từ Database
                    $all_categories = get_categories( array(
                        'hide_empty' => false,
                        'orderby'    => 'name',
                        'order'      => 'ASC'
                    ) );

                    if ( ! empty( $all_categories ) ) :
                        foreach ( $all_categories as $cat ) : ?>
                            <li>
                                <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
                                    <?php echo esc_html( $cat->name ); ?>
                                </a>
                            </li>
                        <?php endforeach;
                    else : ?>
                        <li><a href="#">Uncategorized</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </aside>
    </div>

    <!-- CỘT Ở GIỮA: Detail (6) (Danh sách sản phẩm / bài viết) -->
    <div class="center-content-column">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); 
                $day = get_the_date('d');
                $month = get_the_date('m');
                $post_id = get_the_ID();
                $fallback_link = add_query_arg( 'p', $post_id, home_url( '/' ) );
            ?>
                
                <article class="post-card-item" onclick="openProductModal(<?php echo $post_id; ?>);">
                    <!-- 1. Cột Ngày / Tháng -->
                    <div class="post-card-date">
                        <div class="day-num"><?php echo $day; ?></div>
                        <div class="month-text">THÁNG <?php echo $month; ?></div>
                    </div>

                    <!-- 2. Cột Tiêu đề & Mô tả ngắn -->
                    <div class="post-card-info">
                        <h2 class="post-card-title">
                            <a href="<?php echo esc_url($fallback_link); ?>" onclick="event.stopPropagation();"><?php the_title(); ?></a>
                        </h2>
                        <p class="post-card-excerpt">
                            <?php echo wp_trim_words( get_the_excerpt(), 25, '' ); ?>
                        </p>
                        
                    </div>

                    <!-- Dữ liệu phục vụ Popup Modal -->
                    <div id="product-data-<?php echo $post_id; ?>" style="display: none;">
                        <template class="modal-title-tpl"><?php the_title(); ?></template>
                        <template class="modal-content-tpl">
                            <div class="product-modal-meta" style="margin-bottom: 18px; color: #64748b; font-size: 13.5px;">
                                <span><strong>Ngày đăng:</strong> <?php echo get_the_date('d/m/Y'); ?></span>
                                <?php if ( has_category() ) : ?>
                                    <span style="margin-left: 15px;"><strong>Chuyên mục:</strong> <?php the_category(', '); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div style="text-align: center; margin-bottom: 20px;">
                                    <?php the_post_thumbnail('medium_large', array('style' => 'max-width: 100%; height: auto; border-radius: 8px;')); ?>
                                </div>
                            <?php endif; ?>
                            <div>
                                <?php the_content(); ?>
                            </div>
                        </template>
                        <template class="modal-link-tpl"><?php echo esc_url($fallback_link); ?></template>
                    </div>
                </article>

            <?php endwhile; ?>
        <?php else : ?>
            <p>Chưa có bài viết nào.</p>
        <?php endif; ?>
    </div>

    <!-- CỘT BÊN PHẢI: Recent post (#10) - Thiết kế 100% CHUẨN MẪU MỚI -->
    <div class="right-sidebar-column">
        <aside class="recent-posts-teal-card">
            <div class="recent-posts-teal-list">
                <?php
                // Lấy 5 bài viết mới nhất từ Database
                $recent_posts = wp_get_recent_posts( array(
                    'numberposts' => 5,
                    'post_status' => 'publish'
                ) );

                if ( ! empty( $recent_posts ) ) :
                    foreach ( $recent_posts as $post_item ) : 
                        $recent_link = add_query_arg( 'p', $post_item['ID'], home_url( '/' ) );
                        $r_day   = date('d', strtotime($post_item['post_date']));
                        $r_month = date('m', strtotime($post_item['post_date']));
                        $r_year  = date('y', strtotime($post_item['post_date']));
                    ?>
                        <div class="recent-post-teal-item">
                            <!-- Badge hiển thị ngày tháng dạng phân số 13/08 ─23 -->
                            <div class="recent-teal-date-badge">
                                <div class="recent-teal-date-fraction">
                                    <span class="recent-teal-date-day"><?php echo $r_day; ?></span>
                                    <span class="recent-teal-date-line"></span>
                                    <span class="recent-teal-date-month"><?php echo $r_month; ?></span>
                                </div>
                                <span class="recent-teal-date-year">─<?php echo $r_year; ?></span>
                            </div>

                            <!-- Tiêu đề bài viết mới -->
                            <div class="recent-post-teal-title">
                                <a href="<?php echo esc_url( $recent_link ); ?>">
                                    <?php echo esc_html( $post_item['post_title'] ); ?>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; wp_reset_query();
                else : ?>
                    <p style="color:#ffffff; font-size:13px;">Chưa có bài viết mới</p>
                <?php endif; ?>
            </div>

            <!-- Nút XEM TẤT CẢ TIN TỨC màu đậm ở đáy -->
            <a href="<?php echo esc_url( home_url('/') ); ?>" class="recent-posts-btn-banner">
                XEM TẤT CẢ TIN TỨC
            </a>
        </aside>
    </div>

</div>

<!-- Modal Dialog Xem nhanh thông tin sản phẩm -->
<div id="productModalBackdrop" class="product-modal-backdrop" onclick="closeProductModal(event);">
    <div class="product-modal-box" onclick="event.stopPropagation();">
        <div class="product-modal-header">
            <h3 id="modalProductTitle" class="product-modal-title">Thông tin sản phẩm</h3>
            <button type="button" class="product-modal-close" onclick="closeProductModal()">&times;</button>
        </div>
        <div id="modalProductBody" class="product-modal-body">
            <!-- Nội dung sản phẩm được nạp động -->
        </div>
        <div class="product-modal-footer">
            <a id="modalProductFullLink" href="#" class="btn-action-view" style="padding: 8px 18px;">
                Xem trang chi tiết đầy đủ &rarr;
            </a>
            <button type="button" class="btn-action-page" onclick="closeProductModal()" style="padding: 8px 18px;">
                Đóng
            </button>
        </div>
    </div>
</div>

<script>
function openProductModal(postId) {
    var dataContainer = document.getElementById('product-data-' + postId);
    if (!dataContainer) return;

    var titleTpl = dataContainer.querySelector('.modal-title-tpl');
    var contentTpl = dataContainer.querySelector('.modal-content-tpl');
    var linkTpl = dataContainer.querySelector('.modal-link-tpl');

    document.getElementById('modalProductTitle').textContent = titleTpl ? titleTpl.innerHTML : 'Thông tin sản phẩm';
    document.getElementById('modalProductBody').innerHTML = contentTpl ? contentTpl.innerHTML : '';
    
    var fullLinkBtn = document.getElementById('modalProductFullLink');
    if (fullLinkBtn && linkTpl) {
        fullLinkBtn.href = linkTpl.innerHTML.trim();
    }

    var backdrop = document.getElementById('productModalBackdrop');
    backdrop.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeProductModal(event) {
    if (event && event.target !== event.currentTarget) return;
    var backdrop = document.getElementById('productModalBackdrop');
    backdrop.classList.remove('active');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeProductModal();
    }
});
</script>

<?php get_footer(); ?>