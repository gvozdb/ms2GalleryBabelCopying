<?php
if( $modx->event->name != 'OnDocFormPrerender' || $modx->context->key != 'mgr' || !is_object($resource) ) {return;}

$core_path = $modx->getOption('ms2gallerybabelcopying_core_path', null, $modx->getOption('core_path') .'components/ms2gallerybabelcopying/');
$assets_url = $modx->getOption('ms2gallerybabelcopying_assets_url', null, $modx->getOption('assets_url') .'components/ms2gallerybabelcopying/');
$connector_url = $assets_url .'connector.php';
$model_path = $core_path .'model/';

$modx->addPackage('ms2gallerybabelcopying', $model_path);
$modx->lexicon->load('ms2gallerybabelcopying:default');

$modx->controller->addHtml('<script type="text/javascript">
	ms2GalleryBabelCopyingConfig = {
		resource_id: "'. $resource->get('id') .'",
		assets: "'. $assets_url .'",
		connector: "'. $connector_url .'",
		lexicon:
		{
			duplicate_btn_text: "'. $modx->lexicon('ms2gallerybabelcopying_duplicate_btn_text') .'",
			confirm_duplicate_title: "'. $modx->lexicon('ms2gallerybabelcopying_confirm_duplicate_title') .'",
			confirm_duplicate_text: "'. $modx->lexicon('ms2gallerybabelcopying_confirm_duplicate_text') .'",
			error_babel_resource_not_exists: "'. $modx->lexicon('ms2gallerybabelcopying_error_babel_resource_not_exists') .'",
		},
	};
</script>');
$modx->controller->addLastJavascript($assets_url .'js/mgr/ms2gallerybabelcopying.js');