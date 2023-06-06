<?php
namespace App\Faker;
use Faker\Provider\Base;

class FrameworkProvider extends Base
{
    protected static $nike_shoes = [
        'Nike Air Max Ice Blue',
        'Nike Dunk Low Panda',
        'Nike Blazer Mid \'77'
    ];

    protected static $nike_accessories = [
        'Nike Training Headband',
        'Nike Compression Sleeves',
        'Nike Finger Sleeves'
    ];

    protected static $adidas_shoes = [
        'adidas Continental 80',
        'adidas Ultraboost',
        'adidas Gazelle'
    ];

    protected static $adidas_accessories = [
        'adidas Training Headband',
        'adidas Compression Sleeves',
        'adidas Finger Sleeves'
    ];

    public function product($category_id, $brand_id): string
    {
        if ($category_id == 1) {
            if ($brand_id == 1) {
                return static::randomElement(static::$nike_shoes);
            }
    
            return static::randomElement(static::$adidas_shoes);
        }

        if ($brand_id == 1) {
            return static::randomElement(static::$nike_accessories);
        }

        return static::randomElement(static::$adidas_accessories);
    }

    public function description($category_id, $brand_id): string
    {
        if ($category_id == 1) {
            if ($brand_id == 1) {
                return "Nike shoes";
            }
    
            return "adidas shoes";
        }

        if ($brand_id == 1) {
            return "Nike accessories";
        }

        return "adidas accessories";
    }
}