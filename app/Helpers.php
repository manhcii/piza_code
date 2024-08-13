<?php

namespace App;

use Illuminate\Support\Str;

class Helpers
{
  public static function generateRoute($route, $title, $id, $is_type = null, $taxonomy_title = null)
  {
    if ($is_type) {
      if (isset(Consts::ROUTE_POST[$route])) {
        $alias = Str::slug($title);
        $taxonomy_title = Str::slug($taxonomy_title);
        $route = route(Consts::ROUTE_POST[$route], ['alias' => $alias, 'alias_category' => $taxonomy_title]);
      }
    }
    else {
      if (isset(Consts::ROUTE_TAXONOMY[$route])) {
        $alias = Str::slug($title);
        $route = route(Consts::ROUTE_TAXONOMY[$route], ['alias_category' => $alias]);
      }
    }
    return $route;
  }

  public static function getIdFromAlias($slug)
  {
    $id = null;

    if (Str::contains($slug, '.html')) {
      $slug = Str::afterLast(Str::before($slug, '.html'), '-');

      $id = Str::afterLast($slug, '-');
    } else {
      $id = Str::afterLast($slug, '-');
    }

    return $id;
  }
}
