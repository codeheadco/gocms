<?php

namespace codeheadco\gocms\components;

use \Yii;

/**
 * Description of Cart
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class Cart
{
    
    const SESSION_KEY = 'cart';
    
    protected function add($id, $price, $options = [], $amount = 1)
    {
        $cartData = $this->get();
        
        if (isset($cartData[$id])) {
            $cartData[$id]['amount'] += $amount;
        } else {
            $cartData[$id] = [
                'amount' => $amount,
                'price' => $price,
                'options' => $options,
            ];
        }
        
        Yii::$app->session->set(static::SESSION_KEY, $cartData);
    }

    protected function get($id = null)
    {
        $cartData = Yii::$app->session->get(static::SESSION_KEY, []);
        
        if ($id) {
            return $cartData[$id];
        }
        
        return $cartData;
    }
    
    public function modify($itemId, $amount)
    {
        $cartData = $this->get();
        
        if (isset($cartData[$itemId])) {
            $cartData[$itemId]['amount'] = $amount;
        }
        
        Yii::$app->session->set(static::SESSION_KEY, $cartData);
    }
    
    public function modifyAll($amountsByItemId)
    {
        foreach ($amountsByItemId as $itemId => $amount) {
            $this->modify($itemId, $amount);
        }
    }

    public function remove($id)
    {
        $cartData = $this->get();
        unset($cartData[$id]);
        
        Yii::$app->session->set(static::SESSION_KEY, $cartData);
    }
    
    public function removeAll()
    {
        Yii::$app->session->remove(static::SESSION_KEY);
    }

    public function addItem(CartItemInterface $item, $options = [], $amount = 1)
    {
        $this->add($item->getCartId($options), $item->getPricesForCart(), $options, $amount);
    }
    
    public function getAmount()
    {
        $count = 0;
        
        foreach ($this->get() as $item) {
            $count += $item['amount'];
        }
        
        return $count;
    }
    
    public function getItemsTotal()
    {
        $total = 0;
        
        foreach ($this->get() as $item) {
            $total += $item['price']['current_price'];
        }
        
        return $total;
    }
    
    public function getItems($itemClass)
    {
        if (!Utils::implementsInterface($itemClass, CartItemInterface::class)) {
            throw new \yii\base\InvalidArgumentException();
        }
        
        $cartData = $this->get();
        
        $items = [];
        foreach ($cartData as $cartId => $datum) {
            $datum['product'] = $itemClass::findByCartId($cartId, $datum['options']);
            $items[$cartId] = $datum;
        }
        
        return $items;
    }
    
    public function getAmountInput($itemId, $amount)
    {
        return \yii\bootstrap\Html::input('number', "amounts[{$itemId}]", $amount);
    }
    
}
