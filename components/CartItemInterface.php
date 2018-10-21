<?php

namespace codeheadco\gocms\components;

/**
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
interface CartItemInterface
{
    
    public function getPrice();

    public function getCurrentPrice();
    
    public function getDiscountPrice();
    
    public function getDiscountPercent();
    
    public function getVat();
    
    public function getPricesForCart();

    public function getCartName($options);

    public function getCartId($options);

    public function getId();

    public static function findByCartId($cartId, $options);
    
}
