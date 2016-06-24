<?php

/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var ms2GalleryBabelCopying $ms2GalleryBabelCopying */
$ms2GalleryBabelCopying = $modx->getService('ms2gallerybabelcopying', 'ms2GalleryBabelCopying', $modx->getOption('ms2gallerybabelcopying_core_path', null, $modx->getOption('core_path') . 'components/ms2gallerybabelcopying/') . 'model/ms2gallerybabelcopying/');
$modx->lexicon->load('ms2gallerybabelcopying:default');

// handle request
$corePath = $modx->getOption('ms2gallerybabelcopying_core_path', null, $modx->getOption('core_path') . 'components/ms2gallerybabelcopying/');
$path = $modx->getOption('processorsPath', $ms2GalleryBabelCopying->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));