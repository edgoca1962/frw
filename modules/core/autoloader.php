<?php

namespace WPFRW\Modules\Core;

/**
 * 
 * Función autoloader
 * 
 * @package WPFRW
 * 
 */

function autoloader($resource)
{

   $resource_path  = false;
   $namespace_root = 'WPFRW\\';
   $resource       = trim($resource, '\\');
   if (empty($resource) || strpos($resource, '\\') === false || strpos($resource, $namespace_root) !== 0) {
      return;
   }
   $resource = str_replace($namespace_root, '', $resource);
   $path = explode(
      '\\',
      str_replace('_', '-', strtolower($resource))
   );
   if (empty($path[0]) || empty($path[1])) {
      return;
   }
   $directory = '';
   $file_name = '';
   if ('modules' === $path[0]) {
      if (in_array($path[1], WPFRW_MODULOS)) {
         $directory = $path[1] . '/' . $path[2];
         $file_name = trim(strtolower($path[3]));
      } else {
         $directory = $path[1];
         $file_name = trim(strtolower($path[2]));
      }
   }
   $resource_path = sprintf('%s/%s/%s/%s.php', untrailingslashit(get_template_directory()), $path[0], $directory, $file_name);
   $is_valid_file = validate_file($resource_path);
   if (!empty($resource_path) && file_exists($resource_path) && (0 === $is_valid_file || 2 === $is_valid_file)) {
      require_once($resource_path);
   }
}

spl_autoload_register('\WPFRW\Modules\Core\autoloader');
