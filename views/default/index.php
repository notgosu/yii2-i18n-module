<?php
/**
 * @var View $this
 * @var SourceMessageSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;
use Zelenin\yii\modules\I18n\models\search\SourceMessageSearch;
use Zelenin\yii\modules\I18n\Module;

$this->title = 'Переводы';
echo Breadcrumbs::widget(['links' => [
    $this->title
]]);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
    </div>

    <div class="panel-body">
        <?php
        Pjax::begin();
        echo GridView::widget([
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'id',
                        'value' => function ($model, $index, $dataColumn) {
                                return $model->id;
                            },
                        'filter' => false
                    ],
                    [
                        'attribute' => 'message',
                        'format' => 'raw',
                        'value' => function ($model, $index, $widget) {
                                return Html::a($model->message, ['update', 'id' => $model->id], ['data' => ['pjax' => 0]]);
                            }
                    ],
                    [
                        'attribute' => 'translation',
                        'format' => 'raw',
                        'value' => function ($model, $index, $widget) {
                            return $model->getDefaultLangTranslation();
                        }
                    ],
                    [
                        'attribute' => 'category',
                        'value' => function ($model, $index, $dataColumn) {
                                return $model->category;
                            },
                        'filter' => ArrayHelper::map($searchModel::getCategories(), 'category', 'category')
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model, $index, $widget) {
                            return \Zelenin\yii\modules\I18n\models\Message::isModelFullyTranslated($model->id)
                                ? 'Переведено'
                                : 'Не переведено';
                            },
                        'filter' => Html::dropDownList($searchModel->formName() . '[status]', $searchModel->status, $searchModel->getStatus(), [
                                    'class' => 'form-control',
                                    'prompt' => ''
                                ])
                    ]
                ]
            ]);
        Pjax::end();
        ?>
    </div>
</div>
