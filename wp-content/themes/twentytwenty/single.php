<?php
/**
 * Template Name: Single Product Details
 * Description: Template for displaying full product information when clicking on a product.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 */

get_header();
?>

<style>
  /* Container hiển thị chi tiết sản phẩm */
  .product-detail-container {
      max-width: 800px;
      margin: 40px auto;
      padding: 30px;
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
  }

  /* Nút quay lại danh sách sản phẩm */
  .back-to-list-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 25px;
      padding: 10px 18px;
      background-color: #f1f5f9;
      color: #2a6fbe;
      text-decoration: none !important;
      font-weight: 600;
      font-size: 14px;
      border-radius: 6px;
      transition: all 0.2s ease-in-out;
  }

  .back-to-list-btn:hover {
      background-color: #2a6fbe;
      color: #ffffff !important;
      transform: translateX(-3px);
  }

  /* Phần đầu bài viết / sản phẩm */
  .product-detail-header {
      border-bottom: 2px solid #f1f5f9;
      padding-bottom: 20px;
      margin-bottom: 25px;
  }

  .product-detail-title {
      font-size: 28px;
      font-weight: 700;
      color: #1e293b;
      margin: 0 0 12px 0;
      line-height: 1.3;
  }

  .product-detail-meta {
      font-size: 13px;
      color: #64748b;
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      align-items: center;
  }

  .product-detail-meta .meta-item {
      display: inline-flex;
      align-items: center;
      gap: 5px;
  }

  /* Hình ảnh sản phẩm (nếu có) */
  .product-detail-image {
      margin-bottom: 30px;
      text-align: center;
  }

  .product-detail-image img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  }

  /* Nội dung thông tin chi tiết sản phẩm */
  .product-detail-content {
      font-size: 16px;
      line-height: 1.8;
      color: #334155;
  }

  .product-detail-content p {
      margin-bottom: 1.5em;
  }

  .product-detail-content img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      margin: 20px 0;
  }

  .product-detail-content ul, 
  .product-detail-content ol {
      padding-left: 24px;
      margin: 20px 0;
  }

  .product-detail-content li {
      margin-bottom: 10px;
  }

  .product-detail-content figure {
      margin: 20px 0;
  }

  .product-detail-footer {
      margin-top: 40px;
      padding-top: 25px;
      border-top: 1px solid #f1f5f9;
  }
</style>

<div class="product-detail-container">
    <a href="<?php echo esc_url( home_url('/') ); ?>" class="back-to-list-btn">
        &larr; Quay lại danh sách sản phẩm
    </a>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('product-detail-article'); ?>>
            <header class="product-detail-header">
                <h1 class="product-detail-title"><?php the_title(); ?></h1>
                <div class="product-detail-meta">
                    <span class="meta-item">
                        <strong>Ngày đăng:</strong> <?php echo get_the_date('d/m/Y'); ?>
                    </span>
                    <?php if ( has_category() ) : ?>
                        <span class="meta-item">
                            <strong>Chuyên mục:</strong> <?php the_category(', '); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </header>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="product-detail-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="product-detail-content">
                <?php the_content(); ?>
            </div>

            <footer class="product-detail-footer">
                <a href="<?php echo esc_url( home_url('/') ); ?>" class="back-to-list-btn">
                    &larr; Quay lại danh sách sản phẩm
                </a>
            </footer>
        </article>

    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
