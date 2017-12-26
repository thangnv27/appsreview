<div class="sidebar">
    <div class="rbox">
        <!--<div class="rbox-head">Quảng cáo</div>-->
        <div class="rbox-body">
            <a href="<?php echo get_option('ad_right_link'); ?>"><img alt="" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php echo get_option('ad_right'); ?>&w=220&h=300" /></a>
        </div>
    </div>
    
    <div class="rbox">
        <div class="rbox-head">Tin đọc nhiều</div>
        <div class="rbox-body">
            <ul id="topviewNews_content"><!-- data inside --></ul>
            
            <!--Begin Pagination-->
            <div class="paging-sidebar" id="pagingnews">
                <span class="fl"><span class="current-page">0</span>/<span class="total-page">0</span></span>
                <span class="fr">
                    <a href="#" rel="1" class="prev-page"></a>
                    <a href="#" rel="2" class="next-page"></a>
                </span>
                <div class="clearfix"></div>
            </div>
            <!--End Pagination-->
        </div>
    </div>
    
    <div class="rbox">
        <div class="rbox-head">Ứng dụng xem nhiều</div>
        <div class="rbox-body">
            <div id="topviewApps_content" class="pdt0 pdb0"><!-- data inside --></div>

            <!--Begin Pagination-->
            <div class="paging-sidebar" id="pagingapps">
                <span class="fl"><span class="current-page">0</span>/<span class="total-page">0</span></span>
                <span class="fr">
                    <a href="#" rel="1" class="prev-page"></a>
                    <a href="#" rel="2" class="next-page"></a>
                </span>
                <div class="clearfix"></div>
            </div>
            <!--End Pagination-->
        </div>
    </div>
    
    <?php if (function_exists('dynamic_sidebar') and dynamic_sidebar('Sidebar')): ?>
    <?php else: ?><?php endif; ?>
</div>
<!--/.sidebar-->