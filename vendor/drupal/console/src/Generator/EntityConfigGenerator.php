<?php

/**
 * @file
 * Contains \Drupal\Console\Generator\EntityGenerator.
 */

namespace Drupal\Console\Generator;

class EntityConfigGenerator extends Generator
{
    /**
     * Generator Entity.
     *
     * @param string $module       Module name
     * @param string $entity_name  Entity machine name
     * @param string $entity_class Entity class name
     * @param string $label        Entity label
     * @param string $base_path    Base path
     * @param string $bundle_of    Entity machine name of the content entity this config entity acts as a bundle for.
     */
    public function generate($module, $entity_name, $entity_class, $label, $base_path, $bundle_of = null)
    {
        $parameters = [
          'module' => $module,
          'entity_name' => $entity_name,
          'entity_class' => $entity_class,
          'label' => $label,
          'bundle_of' => $bundle_of,
          'base_path' => $base_path,
        ];

        $this->renderFile(
            'module/config/schema/entity.schema.yml.twig',
            $this->getSite()->getModulePath($module).'/config/schema/'.$entity_name.'.schema.yml',
            $parameters
        );

        $this->renderFile(
            'module/links.menu-entity-config.yml.twig',
            $this->getSite()->getModulePath($module).'/'.$module.'.links.menu.yml',
            $parameters,
            FILE_APPEND
        );

        $this->renderFile(
            'module/links.action-entity.yml.twig',
            $this->getSite()->getModulePath($module).'/'.$module.'.links.action.yml',
            $parameters,
            FILE_APPEND
        );

        $this->renderFile(
            'module/src/interface-entity.php.twig',
            $this->getSite()->getSourcePath($module).'/'.$entity_class.'Interface.php',
            $parameters
        );

        $this->renderFile(
            'module/src/Entity/entity.php.twig',
            $this->getSite()->getEntityPath($module).'/'.$entity_class.'.php',
            $parameters
        );

        $this->renderFile(
            'module/src/entity-route-provider.php.twig',
            $this->getSite()->getSourcePath($module).'/'.$entity_class.'HtmlRouteProvider.php',
            $parameters
        );

        $this->renderFile(
            'module/src/Form/entity.php.twig',
            $this->getSite()->getFormPath($module).'/'.$entity_class.'Form.php',
            $parameters
        );

        $this->renderFile(
            'module/src/Form/entity-delete.php.twig',
            $this->getSite()->getFormPath($module).'/'.$entity_class.'DeleteForm.php',
            $parameters
        );

        $this->renderFile(
            'module/src/entity-listbuilder.php.twig',
            $this->getSite()->getSourcePath($module).'/'.$entity_class.'ListBuilder.php',
            $parameters
        );
    }
}
