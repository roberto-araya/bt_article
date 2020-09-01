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
    'node.add',
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
    $breadcrumb->addLink(Link::createFromRoute($this->siteName, 'bt_core.app'));
    $breadcrumb->addLink(Link::createFromRoute('Website', 'bt_cms.website'));
    $breadcrumb->addLink(Link::createFromRoute('Content', 'bt_cms.website_content'));
    $breadcrumb->addLink(Link::createFromRoute('Create Content', 'node.add_page'));

    return $breadcrumb;
  }

}
