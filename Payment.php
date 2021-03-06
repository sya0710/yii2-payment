<?php
/**
 * Created by PhpStorm.
 * User: Phongnv093
 * Date: 9/29/2015
 * Time: 8:45 PM
 */

namespace sya\payment;

use Yii;
use yii\bootstrap\Html;
use yii\widgets\InputWidget;
use yii\helpers\ArrayHelper;
use yii\web\View;

class Payment extends InputWidget
{
    CONST STATUS_TRANSFER = 'transfer';

    CONST STATUS_PAYATHOME = 'pay_at_home';

    CONST STATUS_EMPTY = '';

    private static $_instance = null;

    /**
     * @var string Name input when haven't model
     */
    public $name = '';

    /**
     * @var string value selected in input
     */
    public $selected = '';

    /**
     * @var array columns in input
     */
    public $columns = [];

    /**
     * @var array item in input
     */
    protected $items = [];

    /**
     * @var array Html attribute of input
     */
    public $options = [];

    /**
     * @return \sya\payment\Payment
     */
    public static function getInstance()
    {
        if (null === static::$_instance) {
            static::$_instance = new static();
        }

        return static::$_instance;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->buildItems();

        if (!isset($this->options['class']))
            $this->options['class'] = 'form-control';
        else
            $this->options['class'] = $this->options['class'] . ' form-control';

        if (!isset($this->options['columnClass']))
            $this->options['columnClass'] = 'form-control';
        else
            $this->options['columnClass'] = $this->options['columnClass'] . ' form-control';

        if (!isset($this->options['onchange']))
            $this->options['onchange'] = 'changeValueStatusPayment(this);';

        $this->buildItems();
    }

    public function run() {
        $this->registerAssets();

        echo $this->renderInput();
    }

    /**
     * @return string render input
     */
    protected function renderInput()
    {
        $input = Html::dropDownList($this->name, $this->selected, $this->items, $this->options);

        // If use form model then $input use active input
        if ($this->hasModel())
            $input = Html::activeDropDownList($this->model, $this->attribute . '[status]', $this->items, $this->options);
 
        $input .= Html::beginTag('div', ['id' => 'status_payment', 'style' => 'margin-top: 20px;']);
            foreach ($this->columns as $status => $item) {
                $input .= Html::beginTag('div', ['class' => 'status_payment', 'id' => 'status_payment_' . $status, 'style' => 'display: none']);
                    foreach ($item as $name => $info) {
                        $column_value = Html::getAttributeValue($this->model, $this->attribute . '[infomation][' . $name . ']');
                        $placeholder = isset($info['placeholder']) ? $info['placeholder'] : null;
                        $value = !empty($column_value) ? $column_value : ArrayHelper::getValue($info, 'value');
                        $readonly = isset($info['readonly']) ? $info['readonly'] : null;

                        $input .= Html::activeInput('text', $this->model, $this->attribute . '[infomation][' . $name . ']', ['placeholder' => $placeholder, 'class' => $this->options['columnClass'], 'readonly' => $readonly, 'value' => $value, 'style' => 'margin-top: 20px;']);
                    }
                $input .= Html::endTag('div');
            }
        $input .= Html::endTag('div');

        return $input;
    }

    protected function buildItems()
    {
        $this->items = [
            self::STATUS_EMPTY => Yii::t('payment', '-- Select a payment method --'),
            self::STATUS_PAYATHOME => Yii::t('payment', 'Pay at home'),
            self::STATUS_TRANSFER => Yii::t('payment', 'Transfer')
        ];
    }

    private function registerAssets() {
        $value = $this->hasModel() ? Html::getAttributeValue($this->model, $this->attribute . '[status]') : $this->selected;
        $this->getView()->registerJs('
            function changeValueStatusPayment(element){
                var status = $(element).val();

                $(".status_payment").hide();
                $("#status_payment_" + status).show();
            }
        ', View::POS_END);

        $this->getView()->registerJs('
            var status = "' . $value . '";
            $("#status_payment_" + status).show();
        ', View::POS_READY);
    }

    public function getStatus($status){
        if (empty($status))
            return $this->items;

        return ArrayHelper::getValue($this->items, $status);
    }
}