<?php
/**
 * Import pack data package demo
 *
 * @package Import Pack
 * @author Bearsthemes
 */
$plugin_includes = array(
  array(
    'name'     => __('Elementor Website Builder', 'alone'),
    'slug'     => 'elementor',
  ),
  array(
    'name'     => __('Bearsthemes Addons', 'alone'),
    'slug'     => 'bearsthemes-addons',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'bearsthemes-addons.zip',
  ),
  array(
    'name'     => __('UberMenu 3 - The Ultimate WordPress Mega Menu', 'alone'),
    'slug'     => 'ubermenu',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'ubermenu.zip',
  ),
  array(
    'name'     => __('Kirki Customizer Framework', 'alone'),
    'slug'     => 'kirki',
  ),
  array(
    'name'     => __('Advanced Custom Fields PRO', 'alone'),
    'slug'     => 'advanced-custom-fields-pro',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'advanced-custom-fields-pro.zip',
  ),
  array(
    'name'     => __('GiveWP - Donation Plugin and Fundraising Platform', 'alone'),
    'slug'     => 'give',
  ),
  array(
    'name'     => __('The Events Calendar', 'alone'),
    'slug'     => 'the-events-calendar',
  ),
  array(
    'name'     => __('Sermon\'e - Sermons Management', 'alone'),
    'slug'     => 'sermone',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'sermone.zip',
  ),
  array(
    'name'     => __('Yoast SEO', 'alone'),
    'slug'     => 'wordpress-seo',
  ),
  array(
    'name'     => __('WooCommerce', 'alone'),
    'slug'     => 'woocommerce',
  ),

);


$plugin_includes_multiplelanguages = array(
  array(
    'name'     => __('Elementor Website Builder', 'alone'),
    'slug'     => 'elementor',
  ),
  array(
    'name'     => __('Elementor Pro', 'alone'),
    'slug'     => 'elementor-pro',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'elementor-pro.zip',
  ),
  array(
    'name'     => __('Bearsthemes Addons', 'alone'),
    'slug'     => 'bearsthemes-addons',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'bearsthemes-addons.zip',
  ),
  array(
    'name'     => __('Kirki Customizer Framework', 'alone'),
    'slug'     => 'kirki',
  ),
  array(
    'name'     => __('Advanced Custom Fields PRO', 'alone'),
    'slug'     => 'advanced-custom-fields-pro',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'advanced-custom-fields-pro.zip',
  ),
  array(
    'name'     => __('GiveWP - Donation Plugin and Fundraising Platform', 'alone'),
    'slug'     => 'give',
  ),
  array(
    'name'     => __('The Events Calendar', 'alone'),
    'slug'     => 'the-events-calendar',
  ),
  array(
    'name'     => __('Yoast SEO', 'alone'),
    'slug'     => 'wordpress-seo',
  ),
  array(
    'name'     => __('WooCommerce', 'alone'),
    'slug'     => 'woocommerce',
  ),
  array(
    'name'     => __('WPML Multilingual CMS', 'alone'),
    'slug'     => 'sitepress-multilingual-cms',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'sitepress-multilingual-cms.zip',
  ),
  array(
    'name'     => __('WPML String Translation', 'alone'),
    'slug'     => 'wpml-string-translation',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'wpml-string-translation.zip',
  ),
  array(
    'name'     => __('WPML SEO', 'alone'),
    'slug'     => 'wp-seo-multilingual',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'wp-seo-multilingual.zip',
  ),
  array(
    'name'     => __('Advanced Custom Fields Multilingual', 'alone'),
    'slug'     => 'acfml',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'acfml.zip',
  ),
  array(
    'name'     => __('WooCommerce Multilingual & Multicurrency', 'alone'),
    'slug'     => 'woocommerce-multilingual',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'woocommerce-multilingual.zip',
  ),

);

return apply_filters( 'beplus/import_pack/package_demo', [
    [
        'package_name' => 'alone-main',
        'preview' => get_template_directory_uri() . '/install/import-pack/images/alone-main-preview.png', // image size 680x475
        'url_demo' => 'https://alonethemes.com/',
        'title' => __( 'Alone Main', 'alone' ),
        'description' => __( 'Alone main demo, include 39+ home demos & full inner page (Contact, About, Company, blog, etc.).', 'alone' ),
        'plugins' => $plugin_includes,
    ],
    [
      'package_name' => 'alone-rtl',
      'preview' => get_template_directory_uri() . '/install/import-pack/images/alone-rtl-preview.png', // image size 680x475
      'url_demo' => 'https://rtl.alonethemes.com/',
      'title' => __( 'Alone RTL', 'alone' ),
      'description' => __( 'Alone RTL demo, include home demos & full inner page (Contact, About, Company, blog, etc.).', 'alone' ),
      'plugins' => $plugin_includes_multiplelanguages,
  ],
] );
