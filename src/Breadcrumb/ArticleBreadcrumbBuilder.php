<?php

namespace Drupal\bt_article\Breadcrumb;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Link;
use Drupal\Core\Config\ConfigFactory;

/**
 * {@inheritdoc}
 */
class ArticleBreadcrumbBuilder implements BreadcrumbBuilderInterface {

  /**
   * The Site name.
   *
   * @var string
   */
  protected $siteName;

  /**
   * The routes that will change their breadcrumbs.
   *
   * @var array
   */
  private $routes = [
    'page_manager.page_view_bt_add_article',
  ];

  /**
   * Class constructor.
   */
  public function __construct(ConfigFactory $configFactory) {
    $this->siteName = $configFactory->get('system.site')->get('name');
  }

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $routeMatch) {
    $match = $this->routes;
    if (in_array($routeMatch->getRouteName(), $match)) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();
    $breadcrumb->addCacheContexts(["url"]);
    $breadcrumb->addLink(Link::createFromRoute($this->siteName, 'page_manager.page_view_app_app-panels_variant-0'));
    $breadcrumb->addLink(Link::createFromRoute('Website', 'page_manager.page_view_app_website_app_website-panels_variant-0'));
    $breadcrumb->addLink(Link::createFromRoute('Content', 'page_manager.page_view_app_website_content_app_website_content-panels_variant-0'));
    $breadcrumb->addLink(Link::createFromRoute('Create Content', 'node.add_page'));

    return $breadcrumb;
  }

}
