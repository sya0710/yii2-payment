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

class Payment extends InputWidget
{

    /**
     * @var string Name input when haven't model
     */
    public $name = '';

    /**
     * @var string value selected in input
     */
    public $selected = '';

    /**
     * @var array item in input
     */
    protected $items = [];

    /**
     * @var array Html attribute of input
     */
    public $options = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->options['class'] = 'form-control';
        $this->buildItems();

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
            $input = Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);

        return $input;
    }

    protected function buildItems()
    {
        $this->items = [
            '' => Yii::t('payment', '-- Select a payment method --'),
            'pay_at_home' => Yii::t('payment', 'Pay at home'),
            'transfer' => Yii::t('payment', 'Transfer')
        ];
    }
}