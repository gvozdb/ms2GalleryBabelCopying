<?php
/** @var modX $modx */
/** @var Office $office */
if ($Office = $modx->getService('office', 'Office', MODX_CORE_PATH . 'components/office/model/office/')) {

	if (!($Office instanceof Office)) {
		$modx->log(xPDO::LOG_LEVEL_ERROR, '[ms2GalleryBabelCopying] Could not register paths for Office component!');

		return true;
	}
	elseif (!method_exists($Office, 'addExtension')) {
		$modx->log(xPDO::LOG_LEVEL_ERROR, '[ms2GalleryBabelCopying] You need to update Office for support of 3rd party packages!');

		return true;
	}

	/**@var array $options */
	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:
			$Office->addExtension('ms2GalleryBabelCopying', '[[++core_path]]components/ms2gallerybabelcopying/controllers/office/');
			$modx->log(xPDO::LOG_LEVEL_INFO, '[ms2GalleryBabelCopying] Successfully registered ms2GalleryBabelCopying as Office extension!');
			break;

		case xPDOTransport::ACTION_UNINSTALL:
			$Office->removeExtension('ms2GalleryBabelCopying');
			$modx->log(xPDO::LOG_LEVEL_INFO, '[ms2GalleryBabelCopying] Successfully unregistered ms2GalleryBabelCopying as Office extension.');
			break;
	}
}
else {
	$modx->log(xPDO::LOG_LEVEL_ERROR, '[ms2GalleryBabelCopying] Could not register paths for Office component!');
}

return true;