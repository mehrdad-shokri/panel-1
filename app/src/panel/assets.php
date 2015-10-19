<?php

namespace Kirby\Panel;

use Collection;
use F;
use Media;
use JShrink\Minifier;

class Assets {

  static public function css() {
    return css(panel()->urls()->css() . '/panel.css?v=' . panel()->version());
  }

  static public function js() {

    $files = array(
      // no-dependency vendors
      'vendors/moment.js',
      'vendors/nprogress.js',
      'vendors/pikaday.js',

      // jquery stuff
      'vendors/jquery.js',
      'vendors/jquery.ui.js',
      'vendors/jquery.ui.touch.js',
      'vendors/jquery.autosize.js',
      'vendors/jquery.center.js',
      'vendors/jquery.drop.js',
      'vendors/jquery.filereader.js',
      'vendors/jquery.upload.js',
      'vendors/jquery.filedrop.js',
      'vendors/jquery.hotkeys.js',
      'vendors/jquery.serializeobject.js',
      'vendors/jquery.autocomplete.js',
      'vendors/jquery.editorhelpers.js',
      'vendors/jquery.fakefocus.js',
      'vendors/jquery.token.js',
      'vendors/jquery.passwordsuggestion.js',
      'vendors/jquery.context.js',
      'vendors/jquery.tags.js',

      // custom components
      'components/shortcuts.js',
      'components/search.js',
      'components/focus.js',
      'components/uploader.js',
      'components/message.js',
      'components/delay.js',
      'components/breadcrumb.js',
      'components/dropdown.js',
      'components/form.js',
      'components/sidebar.js',
      'components/content.js',
      'components/modal.js',

    );

    return static::combine('js', $files, false);

  }

  static public function combine($type, $files, $compress = false) {

    $root  = panel()->roots()->assets() . DS . $type;
    $cache = new Media($root . DS . 'panel.' . $type);
    $media = new Collection(array_map(function($file) use($root) {
      return new Media($root . DS . str_replace('/', DS, $file));
    }, $files));

    // get the max modification date
    $modified = max($media->pluck('modified'));

    if(is_writable($root) and (!$cache->exists() or $cache->modified() < $modified)) {
      $cache->remove();
      $content = '';
      foreach($media as $asset) $content .= $asset->read() . PHP_EOL;
      if($compress) $content = static::compress($type, $content);
      f::write($root . DS . 'panel.' . $type, $content);
    }

    if($cache->exists()) {
      return $type(panel()->urls()->$type() . '/panel.' . $type . '?v=' . panel()->version());
    }

    return $type(array_map(function($item) use($type) {
      return 'panel/assets/' . $type . '/' . $item . '?v=' . panel()->version();
    }, $files));

  }

  static public function compress($type, $output) {

    if($type == 'css') {
      $output = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $output);
      $output = trim(str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $output));
    } else {
      $output = Minifier::minify($output, array('flaggedComments' => false));
    }

    return $output;      

  }

}