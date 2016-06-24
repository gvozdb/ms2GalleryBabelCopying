<?php

/**
 * Class ms2GalleryBabelCopyingMainController
 */
abstract class ms2GalleryBabelCopyingMainController extends modExtraManagerController
{
	/** @var ms2GalleryBabelCopying $ms2GalleryBabelCopying */
	public $ms2GalleryBabelCopying;

	/**
	 * @return void
	 */
	public function initialize()
	{
		$corePath = $this->modx->getOption('ms2gallerybabelcopying_core_path', null, $this->modx->getOption('core_path') . 'components/ms2gallerybabelcopying/');
		require_once $corePath . 'model/ms2gallerybabelcopying/ms2gallerybabelcopying.class.php';

		$this->ms2GalleryBabelCopying = new ms2GalleryBabelCopying($this->modx);
		//$this->addCss($this->ms2GalleryBabelCopying->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->ms2GalleryBabelCopying->config['jsUrl'] . 'mgr/ms2gallerybabelcopying.js');
		$this->addHtml('
		<script type="text/javascript">
			ms2GalleryBabelCopying.config = ' . $this->modx->toJSON($this->ms2GalleryBabelCopying->config) . ';
			ms2GalleryBabelCopying.config.connector_url = "' . $this->ms2GalleryBabelCopying->config['connectorUrl'] . '";
		</script>
		');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('ms2gallerybabelcopying:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}