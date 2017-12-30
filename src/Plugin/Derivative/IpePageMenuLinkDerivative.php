<?php
/**
 * @file
 */

namespace Drupal\bt_article\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\page_manager\Entity\Page;

/**
 * Provides menu links of all Node entities with type "Page".
 */
class IpePageMenuLinkDerivative extends DeriverBase {

    /**
     * {@inheritdoc}
     */
    public function getDerivativeDefinitions($base_plugin_definition) {
        $links = array();
        $pages = [
            'articles' => 'All published articles'
        ];
        foreach ($pages as $page_name => $description) {
            $w = 3;
            $page = Page::load('ipe_' . $page_name);
            $route_name = 'page_manager.page_view_ipe_' . $page_name . '_ipe_' . $page_name . '-panels_variant-0';
            if ($page->status()) {
                $links['main_' . $page->id()] = [
                        'title' => $page->label(),
                        'description' => $description,
                        'menu_name' => 'main',
                        'weight' => $w,
                        'route_name' => $route_name,
                    ] + $base_plugin_definition;
            }
            $w++;
        }
        return $links;
    }
}