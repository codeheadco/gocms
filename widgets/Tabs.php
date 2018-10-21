<?php

namespace codeheadco\gocms\widgets;

use Yii;
use yii\bootstrap\Tabs as BaseTabs;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;

/**
 * Description of Tabs
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class Tabs extends BaseTabs
{
    
    /**
     *
     * @var type 
     */
    public $activeTab;
    
    /**
     *
     * @var type
     */
    public $disabled = false;

    /**
     * 
     * @param type $label
     * @param type $config
     */
    protected function addTab($label, $config = [])
    {
        $config = array_merge($config, [
            'label' => $label,
        ]);
        
        if (is_numeric($this->activeTab)) {
            if (count($this->items) == $this->activeTab) {
                $config['active'] = true;
            }
        } else if (isset($config['options']['id']) && $config['options']['id'] == $this->activeTab) {
            $config['active'] = true;
        }
        
        $this->items[] = $config;
    }

    /**
     * 
     * @param type $label
     * @param type $config
     */
    public function tab($label, $config = [])
    {
        $this->addTab($label, $config);
    }
    
    /**
     * 
     * @param type $label
     * @param type $view
     * @param type $config
     */
    public function tabFromView($label, $view, $config = [])
    {
        if (!is_array($view)) {
            $view = [$view];
        }
        
        $this->addTab($label, array_merge($config, [
            'content' => Yii::$app->view->render($view[0], (isset($view[1]) ? $view[1] : []))
        ]));
    }

    public function beginTab($label, $config = [])
    {
        $this->addTab($label, $config);
        
        ob_start();
    }

    /**
     * 
     */
    public function endTab()
    {
        $this->items[(count($this->items) - 1)]['content'] = ob_get_clean();
    }
    
    protected static function link($text, $url, $options, $disabled)
    {
        if ($disabled) {
            return Html::tag('span', $text, $options);
        }
        
        return Html::a($text, $url, $options);
    }

    /**
     * Renders tab items as specified on [[items]].
     * @return string the rendering result.
     * @throws InvalidConfigException.
     */
    protected function renderItems()
    {
        $headers = [];
        $panes = [];

        if (!$this->hasActiveTab()) {
            $this->activateFirstVisibleTab();
        }

        foreach ($this->items as $n => $item) {
            if (!ArrayHelper::remove($item, 'visible', true)) {
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $headerOptions = array_merge($this->headerOptions, ArrayHelper::getValue($item, 'headerOptions', []));
            $linkOptions = array_merge($this->linkOptions, ArrayHelper::getValue($item, 'linkOptions', []));
            
            $itemDisabled = ArrayHelper::getValue($item, 'disabled', $this->disabled);

            if (isset($item['items'])) {
                $label .= ' <b class="caret"></b>';
                Html::addCssClass($headerOptions, ['widget' => 'dropdown']);

                if ($this->renderDropdown($n, $item['items'], $panes)) {
                    Html::addCssClass($headerOptions, 'active');
                }

                Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle']);
                if (!isset($linkOptions['data-toggle'])) {
                    $linkOptions['data-toggle'] = 'dropdown';
                }
                /** @var Widget $dropdownClass */
                $dropdownClass = $this->dropdownClass;
                $header = static::link($label, "#", $linkOptions, $itemDisabled) . "\n"
                    . $dropdownClass::widget(['items' => $item['items'], 'clientOptions' => false, 'view' => $this->getView()]);
            } else {
                $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
                $options['id'] = ArrayHelper::getValue($options, 'id', $this->options['id'] . '-tab' . $n);

                Html::addCssClass($options, ['widget' => 'tab-pane']);
                if (ArrayHelper::remove($item, 'active')) {
                    Html::addCssClass($options, 'active');
                    Html::addCssClass($headerOptions, 'active');
                    Html::addCssClass($linkOptions, 'active');
                }

                if (isset($item['url'])) {
                    $header = static::link($label, $item['url'], $linkOptions, $itemDisabled);
                } else {
                    if (!isset($linkOptions['data-toggle'])) {
                        $linkOptions['data-toggle'] = 'tab';
                    }
                    $header = static::link($label, '#' . $options['id'], $linkOptions, $itemDisabled);
                }

                if ($this->renderTabContent) {
                    $tag = ArrayHelper::remove($options, 'tag', 'div');
                    $panes[] = Html::tag($tag, isset($item['content']) ? $item['content'] : '', $options);
                }
            }

            $headers[] = Html::tag('li', $header, $headerOptions);
        }

        return Html::tag('ul', implode("\n", $headers), $this->options) . $this->renderPanes($panes);
    }
    
    public function run()
    {
        return parent::run() 
                . Html::beginTag('script')
                . "jQuery('#{$this->options['id']} a.nav-link.active').trigger('click');"
                . Html::endTag('script');
    }

}
