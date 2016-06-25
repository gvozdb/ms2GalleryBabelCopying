<?php

class ms2GalleryBabelDuplicateProcessor extends modProcessor
{
    public $languageTopics = array('ms2gallerybabelcopying');
    private $slashes = array('////', '///', '//');

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $from = $this->getProperty('from', 0);
        $to = $this->getProperty('to', 0);

        if (!empty($from) || !empty($to)) {
            // $this->modx->log(modX::LOG_LEVEL_ERROR, 'lala');

            if ($this->modx->getCount('modResource', $from) > 0) {
                $this->modx->addPackage('ms2gallery', MODX_CORE_PATH . 'components/ms2gallery/model/'); // подключаем модель компонента ms2Gallery
                $this->modx->loadClass('sources.modMediaSource'); // подключаем класс modMediaSource

                $response_getlist = $this->modx->runProcessor('gallery/getlist', array(
                    'resource_id' => $from,
                    'parent' => 0,
                    //'type'		=> 'image',
                    'limit' => 99999,
                ), array('processors_path' => MODX_CORE_PATH . 'components/ms2gallery/processors/mgr/'));

                // $this->modx->log(modX::LOG_LEVEL_ERROR, print_r($this->modx->fromJSON($response_getlist->response),1));

                $getlist = $this->modx->fromJSON($response_getlist->response);
                $list = $getlist['results'];

                foreach ($list as $row) {
                    // >> Получаем данные Источника Медиа
                    if (!is_object($mSource)) {
                        $mSource = modMediaSource::getDefaultSource($this->modx, $row['source']);
                        $mSource->initialize();
                    }
                    $source_base_url = $mSource->getBaseUrl();
                    $source_base_path = $mSource->getBasePath();
                    unset($mSource);
                    // << Получаем данные Источника Медиа

                    // $filepath = substr(str_replace($this->slashes, '/', '/'. $row['url']), 1);
                    // $filepath = str_replace($this->slashes, '/', '/'. $row['url']);
                    $filepath = str_replace($this->slashes, '/', '/' . $source_base_path . '/' . $row['path'] . $row['file']);
                    // $this->modx->log(modX::LOG_LEVEL_ERROR, print_r($filepath,1));

                    if (file_exists($filepath)) {
                        $response_upload = $this->modx->runProcessor('gallery/upload', array(
                            'file' => $filepath,
                            'id' => $to,
                        ), array('processors_path' => MODX_CORE_PATH . 'components/ms2gallery/processors/mgr/'));

                        // $upload = $this->modx->fromJSON($response_upload->response);
                        $upload = $response_upload->response;
                        // $this->modx->log(modX::LOG_LEVEL_ERROR, print_r($upload,1));

                        if ($upload['success']) {
                            $img = $upload['object'];

                            $response_update = $this->modx->runProcessor('gallery/update', array(
                                'id' => $img['id'],
                                'name' => $row['name'],
                                'alt' => $row['alt'],
                                'description' => $row['description'],
                                'add' => $row['add'],
                                'active' => $row['active'],
                            ), array('processors_path' => MODX_CORE_PATH . 'components/ms2gallery/processors/mgr/'));

                            $update = $response_upload->response;
                            //                            $this->modx->log(modX::LOG_LEVEL_ERROR, 'update');
                            //                            $this->modx->log(modX::LOG_LEVEL_ERROR, print_r($update, 1));
                        }
                    }
                }
            } else {
                return $this->failure($this->modx->lexicon('ms2gallerybabelcopying_error_id_empty'));
            }
        } else {
            return $this->failure($this->modx->lexicon('ms2gallerybabelcopying_error_id_empty'));
        }

        return $this->success('ok');
    }
}

return 'ms2GalleryBabelDuplicateProcessor';