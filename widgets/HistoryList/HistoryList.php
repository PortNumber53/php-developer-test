<?php

namespace app\widgets\HistoryList;

use app\models\search\HistorySearch;
use app\widgets\Export\Export;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;
use yii\web\Request;

class HistoryList extends Widget
{
    private $model;
    private $request;

    public function __construct(HistorySearch $model, Request $request, $config = [])
    {
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('main', [
            'model' => $this->model,
            'linkExport' => $this->getLinkExport(),
            'dataProvider' => $this->model->search(Yii::$app->request->queryParams)
        ]);
    }

    /**
     * @return string
     */
    private function getLinkExport()
    {
        $params = $this->request->getQueryParams();
        $params = ArrayHelper::merge([
            'exportType' => Export::FORMAT_CSV
        ], $params);
        $params[0] = 'site/export';

        return Url::to($params);
    }
}
