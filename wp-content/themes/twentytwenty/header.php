<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background-color: #f5f5f5;
        }

        /* Khung Header chính */
        .exact-header-navbar {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            margin: 20px auto;
            max-width: 1200px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
            padding-right: 15px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        /* 1. Bên Trái: Logo & Home */
        .header-left-group {
            display: flex;
            align-items: center;
            height: 100%;
        }

        .brand-logo-box {
            background-color: #f1f1f1;
            padding: 0 25px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #555555;
            font-weight: 500;
            border-right: 1px solid #e5e5e5;
        }

        .brand-logo-box a {
            text-decoration: none;
            color: #555555;
        }

        .home-tab-box {
            background-color: #e2e2e2;
            padding: 0 25px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #444444;
        }

        .home-tab-box a {
            text-decoration: none;
            color: #444444;
        }

        /* 2. Ô Tìm Kiếm */
        .header-search-form {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-left: 20px;
        }

        .header-search-form input[type="search"] {
            border: 1px solid #cccccc !important;
            border-radius: 4px !important;
            padding: 7px 12px !important;
            font-size: 14px !important;
            outline: none !important;
            width: 200px;
            background: #ffffff !important;
            color: #333333 !important;
            height: 38px !important;
        }

        .header-search-form input::placeholder {
            color: #888888;
        }

        .header-search-form button {
            background-color: #ffffff !important;
            border: 1px solid #cccccc !important;
            border-radius: 4px !important;
            padding: 0 14px !important;
            height: 38px !important;
            font-size: 14px !important;
            color: #444444 !important;
            cursor: pointer !important;
            transition: background 0.2s;
        }

        .header-search-form button:hover {
            background-color: #f0f0f0 !important;
        }

        /* 3. Menu & Icon Bên Phải */
        .header-right-group {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .header-nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
            list-style: none;
        }

        .header-nav-links a {
            text-decoration: none;
            color: #555555;
            font-size: 15px;
            transition: color 0.2s;
        }

        .header-nav-links a:hover {
            color: #000000;
        }

        .header-action-icons {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-left: 10px;
        }

        .action-icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #666666;
            font-size: 11px;
            cursor: pointer;
        }

        .action-icon-item:hover {
            color: #111111;
        }

        .action-icon-item .icon-svg {
            width: 22px;
            height: 22px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .account-dropdown-text {
            display: flex;
            align-items: center;
            gap: 2px;
            font-size: 14px;
        }

        /* Bọc nội dung trang */
        .site-main-content {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 15px;
        }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="exact-header-navbar">
    
    <!-- Cụm trái: Logo tên trang + Tab Home lấy động từ DB -->
    <div class="header-left-group">
        <div class="brand-logo-box">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php bloginfo( 'name' ); ?>
            </a>
        </div>
        <div class="home-tab-box">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
        </div>
        
        <!-- Form Tìm Kiếm -->
        <form role="search" method="get" class="header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="search" placeholder="Search" value="<?php echo get_search_query(); ?>" name="s" required />
            <button type="submit">Submit</button>
        </form>
    </div>

    <!-- Cụm phải: Lấy danh mục tự động từ Database + Các Icon -->
    <div class="header-right-group">
        
        <ul class="header-nav-links">
            <li>
                <?php
                $latest_post_item = get_posts( array( 'numberposts' => 1 ) );
                if ( ! empty( $latest_post_item ) ) {
                    $post_time = strtotime( $latest_post_item[0]->post_date );
                    $archive_nav_url = get_month_link( date( 'Y', $post_time ), date( 'm', $post_time ) );
                } else {
                    $archive_nav_url = home_url( '/2026/09/' );
                }
                ?>
                <a href="<?php echo esc_url( $archive_nav_url ); ?>" style="font-weight: 600; color: #b91c1c;">
                    Xem nhiều
                </a>
            </li>
            <?php
            // Lấy 3 Chuyên mục (Categories) mới nhất từ Database
            $db_categories = get_categories( array(
                'number'     => 3,
                'orderby'    => 'count',
                'order'      => 'DESC',
                'hide_empty' => false,
            ) );

            if ( ! empty( $db_categories ) ) :
                foreach ( $db_categories as $category ) : ?>
                    <li>
                        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
                            <?php echo esc_html( $category->name ); ?>
                        </a>
                    </li>
                <?php endforeach;
            else : ?>
                <li><a href="#">Chưa có chuyên mục</a></li>
            <?php endif; ?>
        </ul>

        <div class="header-action-icons">
            <!-- Icon Menu -->
            <a href="#" class="action-icon-item">
                <svg class="icon-svg" viewBox="0 0 24 24">
                    <circle cx="5" cy="12" r="1.5" fill="currentColor"></circle>
                    <circle cx="12" cy="12" r="1.5" fill="currentColor"></circle>
                    <circle cx="19" cy="12" r="1.5" fill="currentColor"></circle>
                </svg>
                <span>Menu</span>
            </a>

            <!-- Icon Search -->
            <a href="#" class="action-icon-item">
                <svg class="icon-svg" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7"></circle>
                    <line x1="16.5" y1="16.5" x2="21" y2="21"></line>
                </svg>
                <span>Search</span>
            </a>

            <!-- Icon Account -->
            <a href="#" class="action-icon-item">
                <svg class="icon-svg" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span class="account-dropdown-text">Account ▾</span>
            </a>
        </div>

    </div>

</header>

<div class="site-main-content">