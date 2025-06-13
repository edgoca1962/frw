<?php

namespace WPFRW\Modules\Core;

/**
 * Implemtnación del esquema Singleton
 * 
 * @package WPFRW
 */


trait Singleton
{

   final public static function get_instance()
   {
      static $instance = [];

      $called_class = get_called_class();
      if (!isset($instance[$called_class])) {
         $instance[$called_class] = new $called_class();
         do_action(sprintf('WPFRW_singleton_init_%s', $called_class));
      }
      return $instance[$called_class];
   }
}
