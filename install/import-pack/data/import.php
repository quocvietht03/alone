<?php
/**
 * Import pack data package demo
 *
 * @package Import Pack
 * @author BePlus
 */
$plugin_includes = array(
  array(
    'name'     => 'Elementor Website Builder',
    'slug'     => 'elementor',
  ),
  array(
    'name'     => 'Elementor Pro',
    'slug'     => 'elementor-pro',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'elementor-pro.zip',
  ),
  array(
    'name'     => 'Bearsthemes Addons',
    'slug'     => 'bearsthemes-addons',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'bearsthemes-addons.zip',
  ),
  array(
    'name'     => 'UberMenu 3 - The Ultimate WordPress Mega Menu',
    'slug'     => 'ubermenu',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'ubermenu.zip',
  ),
  array(
    'name'     => 'Kirki Customizer Framework',
    'slug'     => 'kirki',
  ),
  array(
    'name'     => 'Advanced Custom Fields PRO',
    'slug'     => 'advanced-custom-fields-pro',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'advanced-custom-fields-pro.zip',
  ),
  array(
    'name'     => 'GiveWP – Donation Plugin and Fundraising Platform',
    'slug'     => 'give',
  ),
  array(
    'name'     => 'The Events Calendar',
    'slug'     => 'the-events-calendar',
  ),
  array(
    'name'     => 'Sermon\'e - Sermons Management',
    'slug'     => 'sermone',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'sermone.zip',
  ),
  array(
    'name'     => 'Yoast SEO',
    'slug'     => 'wordpress-seo',
  ),
  array(
    'name'     => 'WooCommerce',
    'slug'     => 'woocommerce',
  ),

);


$plugin_includes_multiplelanguages = array(
  array(
    'name'     => 'Elementor Website Builder',
    'slug'     => 'elementor',
  ),
  array(
    'name'     => 'Elementor Pro',
    'slug'     => 'elementor-pro',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'elementor-pro.zip',
  ),
  array(
    'name'     => 'Bearsthemes Addons',
    'slug'     => 'bearsthemes-addons',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'bearsthemes-addons.zip',
  ),
  array(
    'name'     => 'Kirki Customizer Framework',
    'slug'     => 'kirki',
  ),
  array(
    'name'     => 'Advanced Custom Fields PRO',
    'slug'     => 'advanced-custom-fields-pro',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'advanced-custom-fields-pro.zip',
  ),
  array(
    'name'     => 'GiveWP – Donation Plugin and Fundraising Platform',
    'slug'     => 'give',
  ),
  array(
    'name'     => 'The Events Calendar',
    'slug'     => 'the-events-calendar',
  ),
  array(
    'name'     => 'Yoast SEO',
    'slug'     => 'wordpress-seo',
  ),
  array(
    'name'     => 'WooCommerce',
    'slug'     => 'woocommerce',
  ),
  array(
    'name'     => 'WPML Multilingual CMS',
    'slug'     => 'sitepress-multilingual-cms',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'sitepress-multilingual-cms.zip',
  ),
  array(
    'name'     => 'WPML String Translation',
    'slug'     => 'wpml-string-translation',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'wpml-string-translation.zip',
  ),
  array(
    'name'     => 'WPML SEO',
    'slug'     => 'wp-seo-multilingual',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'wp-seo-multilingual.zip',
  ),
  array(
    'name'     => 'Advanced Custom Fields Multilingual',
    'slug'     => 'acfml',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'acfml.zip',
  ),
  array(
    'name'     => 'WooCommerce Multilingual & Multicurrency',
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
        'description' => __( 'Alone main demo, include 39+ home demos & full inner page (Contact, About, Company, blog, etc.).' ),
        'plugins' => $plugin_includes,
    ],
    [
      'package_name' => 'alone-multiplelanguages',
      'preview' => get_template_directory_uri() . '/install/import-pack/images/alone-multiplelanguages-preview.png', // image size 680x475
      'url_demo' => 'https://alonethemes.com/',
      'title' => __( 'Alone Multiple Languages', 'alone' ),
      'description' => __( 'Alone multiple languages demo, include home demos & full inner page (Contact, About, Company, blog, etc.).' ),
      'plugins' => $plugin_includes_multiplelanguages,
  ],
] );
