jQuery(document).ready(function($) {
    if (wpmlData.currentLanguage === 'ar') {
        $('li.tribe-events-c-view-selector__list-item--day span.tribe-events-c-view-selector__list-item-text').text('يوم');
        $('li.tribe-events-c-view-selector__list-item--month span.tribe-events-c-view-selector__list-item-text').text('شهر');
        $('li.tribe-events-c-view-selector__list-item--list span.tribe-events-c-view-selector__list-item-text').text('قائمة');
        $('.tribe-events-header__top-bar .tribe-events-c-top-bar__today-button').text('اليوم');
        $('.elementor-posts--skin-grid-toluca .elementor-post__content .elementor-post__meta li a span').text('بواسطة');
        $('.elementor-filter-wrap.elementor-members--skin-pumori .elementor-filter__link[data-filter="all"]').text('فريقنا');
        $('.woocommerce .ribbons .ribbon.featured').text('حار');
    }
});