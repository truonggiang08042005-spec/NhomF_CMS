</div> <!-- Đóng thẻ site-main-content từ header.php -->

    <style>
        /* CSS cho Footer chuẩn mẫu */
        .custom-site-footer {
            background-color: #006849; /* Tông màu xanh lá đậm theo ảnh */
            color: #ffffff;
            padding: 40px 20px 20px 20px;
            font-family: Arial, sans-serif;
            margin-top: 50px;
        }

        .footer-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* Chia 3 cột Quick links */
        .footer-grid {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            padding-bottom: 30px;
        }

        .footer-col {
            flex: 1;
        }

        .footer-col-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            border-left: 3px solid #ffffff;
            padding-left: 10px;
            text-transform: capitalize;
        }

        .footer-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-col ul li {
            margin-bottom: 8px;
            font-size: 14px;
        }

        .footer-col ul li a {
            color: #e0e0e0;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-col ul li a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        /* Cột mạng xã hội và bản quyền */
        .footer-bottom {
            text-align: center;
            padding-top: 25px;
            font-size: 12px;
            color: #d0d0d0;
        }

        .footer-socials {
            margin-bottom: 15px;
        }

        .footer-socials a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 10px;
            font-size: 16px;
            font-weight: bold;
        }

        .footer-copyright-text {
            line-height: 1.6;
        }
    </style>

    <footer class="custom-site-footer">
        <div class="footer-container">
            
            <div class="footer-grid">
                
                <!-- Cột 1: Thay Quick links giả bằng Bài viết mới (Recent Posts) trong DB -->
                <div class="footer-col">
                    <div class="footer-col-title">Bài viết mới</div>
                    <ul>
                        <?php
                        $recent_posts = wp_get_recent_posts( array( 'numberposts' => 5, 'post_status' => 'publish' ) );
                        foreach( $recent_posts as $post_item ) : ?>
                            <li>» <a href="<?php echo get_permalink($post_item['ID']); ?>"><?php echo $post_item['post_title']; ?></a></li>
                        <?php endforeach; wp_reset_query(); ?>
                    </ul>
                </div>
<!-- Cột 2: Thay Quick links giả bằng Chuyên mục (Categories) trong DB -->
                <div class="footer-col">
                    <div class="footer-col-title">Chuyên mục</div>
                    <ul>
                        <?php
                        $categories = get_categories( array('number' => 5) );
                        foreach( $categories as $category ) : ?>
                            <li>» <a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Cột 3: Thay Quick links giả bằng Bình luận mới (Comments) trong DB -->
                <div class="footer-col">
                    <div class="footer-col-title">Bình luận mới</div>
                    <ul>
                        <?php
                        $comments = get_comments( array('number' => 5, 'status' => 'approve') );
                        if ( $comments ) :
                            foreach( $comments as $comment ) : ?>
                                <li>» <a href="<?php echo get_permalink($comment->comment_post_ID); ?>"><?php echo wp_trim_words($comment->comment_content, 5); ?></a></li>
                            <?php endforeach;
                        else : ?>
                            <li>» Chưa có bình luận</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Cột 4: Trang mới nhất (Pages) -->
                <div class="footer-col">
                    <div class="footer-col-title">Trang mới nhất</div>
                    <ul>
                        <?php
                        $footer_pages = get_posts( array( 'post_type' => 'page', 'posts_per_page' => 4, 'orderby' => 'date', 'order' => 'ASC' ) );
                        if ( ! empty( $footer_pages ) ) :
                            foreach( $footer_pages as $fp ) : ?>
                                <li>» <a href="<?php echo esc_url( get_permalink($fp->ID) ); ?>"><?php echo esc_html( $fp->post_title ); ?></a></li>
                            <?php endforeach;
                        else : ?>
                            <li>» <a href="<?php echo esc_url( home_url('/?page_id=2') ); ?>">Trang mẫu</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div>

            <!-- Phần Icon Mạng Xã Hội và Copyright phía dưới -->
            <div class="footer-bottom">
                <div class="footer-socials">
                    <a href="#">f</a>
                    <a href="#">t</a>
                    <a href="#">i</a>
                    <a href="#">g+</a>
                    <a href="#">✉</a>
                </div>
                <div class="footer-copyright-text">
                    <p><?php bloginfo( 'name' ); ?> is a Registered Website. All rights reserved.</p>
                    <p>© All right Reversed. Sunlimetech</p>
                </div>
            </div>

        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>