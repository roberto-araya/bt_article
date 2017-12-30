<?php
/**
 *
 */

namespace Drupal\bt_article\Config;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Config\ConfigFactory;

/**
 * Example configuration override.
 */
class ConfigArticleOverride implements ConfigFactoryOverrideInterface {

    private $create_content;
    private $delete_content;
    private $delete_own_content;
    private $edit_content;
    private $views_admin_content;
    private $views_full_admin_content;

    public function __construct(ConfigFactory $ConfigFactory)
    {
        $this->create_content = $ConfigFactory->get('user.role.bt_create_content');
        $this->delete_content = $ConfigFactory->get('user.role.bt_delete_content');
        $this->delete_own_content = $ConfigFactory->get('user.role.bt_delete_own_content');
        $this->edit_content = $ConfigFactory->get('user.role.bt_edit_publish_content');
        $this->views_admin_content = $ConfigFactory->get('views.view.bt_admin_content');
        $this->views_full_admin_content = $ConfigFactory->get('views.view.bt_full_admin_content');
    }

    public function loadOverrides($names) {
        $overrides = array();

        // Add article permissions to bt_create_content role.
        if (in_array('user.role.bt_create_content', $names)) {
            $article_permissions = [
                'create bt_article content',
                'edit own bt_article content',
                'revert bt_article revisions',
                'view bt_article revisions'
            ];
            $content_role = $this->create_content;
            $permissions = array_merge($content_role->get('permissions'),$article_permissions);
            $overrides['user.role.bt_create_content']['permissions'] = $permissions;
        }
        // Add article permissions to bt_delete_content role.
        if (in_array('user.role.bt_delete_content', $names)) {
            $article_permissions = [
                'delete any bt_article content',
                'delete bt_article revisions'
            ];
            $content_role = $this->delete_content;
            $permissions = array_merge($content_role->get('permissions'),$article_permissions);
            $overrides['user.role.bt_delete_content']['permissions'] = $permissions;
        }
        // Add article permissions to bt_delete_own_content role.
        if (in_array('user.role.bt_delete_own_content', $names)) {
            $article_permissions = [
                'delete own bt_article content'
            ];
            $content_role = $this->delete_own_content;
            $permissions = array_merge($content_role->get('permissions'),$article_permissions);
            $overrides['user.role.bt_delete_own_content']['permissions'] = $permissions;
        }
        // Add article permissions to bt_edit_publish_content role.
        if (in_array('user.role.bt_edit_publish_content', $names)) {
            $article_permissions = [
                'edit any bt_article content'
            ];
            $content_role = $this->edit_content;
            $permissions = array_merge($content_role->get('permissions'),$article_permissions);
            $overrides['user.role.bt_edit_publish_content']['permissions'] = $permissions;
        }
        $article_values = [
            'bt_article' => 'bt_article'
        ];
        // Add article filter values to views.view.bt_admin_content view.
        if (in_array('views.view.bt_admin_content', $names)) {
            $views = $this->views_admin_content;
            $filter_values = $views->get('display.default.display_options.filters.type.value');
            $values = array_merge($filter_values,$article_values);
            $overrides['views.view.bt_admin_content']['display']['default']['display_options']['filters']['type']['value'] = $values;
            $overrides['views.view.bt_admin_content']['display']['default']['display_options']['filters']['type_expose']['value'] = $values;
        }
        // Add article filter values to views.view.bt_full_admin_content view.
        if (in_array('views.view.bt_full_admin_content', $names)) {
            $views = $this->views_full_admin_content;
            $filter_values = $views->get('display.default.display_options.filters.type.value');
            $values = array_merge($filter_values,$article_values);
            $overrides['views.view.bt_full_admin_content']['display']['default']['display_options']['filters']['type']['value'] = $values;
            $overrides['views.view.bt_full_admin_content']['display']['default']['display_options']['filters']['type_expose']['value'] = $values;
        }
        return $overrides;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheSuffix() {
        return 'ConfigArticleOverride';
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheableMetadata($name) {
        return new CacheableMetadata();
    }

    /**
     * {@inheritdoc}
     */
    public function createConfigObject($name, $collection = StorageInterface::DEFAULT_COLLECTION) {
        return NULL;
    }

}