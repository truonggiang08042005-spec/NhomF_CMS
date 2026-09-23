<?php get_header(); ?>

<style>
  /* Container chứa danh sách sản phẩm/bài viết */
  .content-list-container {
      max-width: 800px;
      margin: 30px auto;
      padding: 0 15px;
      background: #ffffff;
  }

  /* Khung thẻ từng bài viết/sản phẩm */
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

  /* 1. Cột Ngày & Tháng */
  .post-card-date {
      width: 80px;
      min-width: 80px;
      text-align: center;
      padding-right: 18px;
      margin-right: 22px;
      border-right: 1px solid #e2e8f0;
      align-self: stretch;
      display: flex;
      flex-direction: column;
      justify-content: center;
  }

  .post-card-date .day-num {
      font-size: 44px;
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

  /* 2. Cột Tiêu đề & Tóm tắt */
  .post-card-info {
      flex: 1;
  }

  .post-card-title {
      font-size: 17px;
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
      font-size: 14px;
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
      font-size: 12.5px;
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
      font-size: 12.5px;
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
</style>

<div class="content-list-container">
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