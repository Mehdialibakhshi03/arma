<?php

use App\Models\AttributeValues;
use App\Models\Cart;
use App\Models\Category;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Measurements;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttrVariation;
use App\Models\Attribute;
use App\Models\ProductOption;
use App\Models\ProductVariation;
use App\Models\Province;
use App\Models\Wallet;
use Carbon\Carbon;

if (!function_exists('generateFileName')) {
    function generateFileName($name)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        $hour = Carbon::now()->hour;
        $minute = Carbon::now()->minute;
        $second = Carbon::now()->second;
        $microsecond = Carbon::now()->microsecond;
        return $year . '_' . $month . '_' . $day . '_' . $hour . '_' . $minute . '_' . $second . '_' . $microsecond . '_' . $name;
    }
}

if (!function_exists('convertShamsiToGregorianDate')) {
    function convertShamsiToGregorianDate($date)
    {
        if ($date == null) {
            return null;
        }
        $pattern = "/[-\s]/";
        $shamsiDateSplit = preg_split($pattern, $date);

        $arrayGergorianDate = verta()->getGregorian($shamsiDateSplit[0], $shamsiDateSplit[1], $shamsiDateSplit[2]);

        return implode("-", $arrayGergorianDate) . " " . $shamsiDateSplit[3];
    }
}

if (!function_exists('cartTotalSaleAmount')) {
    function cartTotalSaleAmount()
    {
        $cartTotalSaleAmount = 0;
        foreach (\Cart::getContent() as $item) {
            if (sizeof($item->attributes) > 0) {
                $variation = ProductVariation::where('id', $item->attributes[0])->first();
                if (($variation->percentSalePrice > 0 && Carbon::now() > $variation->date_on_sale_from && Carbon::now() < $variation->date_on_sale_to) or ($variation->percentSalePrice > 0 && $variation->has_discount == 1)) {
                    $cartTotalSaleAmount += $item->quantity * ($variation->price - $variation->sale_price);
                }

            } else {
                if ($item->associatedModel->percentSalePrice > 0 && Carbon::now() > $item->associatedModel->DateOnSaleFrom && Carbon::now() < $item->associatedModel->DateOnSaleTo) {
                    $cartTotalSaleAmount += $item->quantity * ($item->associatedModel->price - $item->associatedModel->salePrice);
                }
            }
        }

        return $cartTotalSaleAmount;
    }
}

if (!function_exists('cartTotalAmount')) {
    function cartTotalAmount()
    {
        $delivery_price = 0;
        if (auth()->check()) {
            if (session()->has('delivery_price')) {
                $delivery_price = session()->get('delivery_price');
            }
        }
        $delivery_price = intval($delivery_price);
        if (session()->has('coupon')) {
            if (session()->get('coupon.amount') > (\Cart::getTotal() + $delivery_price)) {
                return 0;
            } else {
                return (\Cart::getTotal() + $delivery_price - session()->get('coupon.amount'));
            }
        } else {
            return \Cart::getTotal() + $delivery_price;
        }


    }
}

if (!function_exists('checkCoupon')) {
    function checkCoupon($code)
    {
        $coupon = Coupon::where('code', $code)->first();
        if ($coupon->user_id == null) {
            $coupon = Coupon::where('code', $code)
                ->where('expired_at', '>', Carbon::now())
                ->where('times', '>', 0)
                ->first();
        } else {
            if (!auth()->check()) {
                session()->forget('coupon');
                return ['error' => 'برای استفاده از کد تخفیف لازم است وارد شوید'];
            }
            $userId = auth()->id();
            $coupon = Coupon::where('code', $code)
                ->where('expired_at', '>', Carbon::now())
                ->where('user_id', $userId)
                ->where('times', '>', 0)
                ->first();
        }
        if ($coupon == null) {
            session()->forget('coupon');
            return ['error' => 'کد تخفیف وارد شده وجود ندارد'];
        }

//    if (Order::where('user_id', auth()->id())->where('coupon_id', $coupon->id)->where('payment_status', 1)->exists()) {
//        session()->forget('coupon');
//        return ['error' => 'شما قبلا از این کد تخفیف استفاده کرده اید'];
//    }


        if ($coupon->getRawOriginal('type') == 'amount') {
            session()->put('coupon', ['id' => $coupon->id, 'code' => $coupon->code, 'amount' => $coupon->amount]);
        } else {
            $total = calculateCartPrice()['sale_price'];

            $amount = (($total * $coupon->percentage) / 100) > $coupon->max_percentage_amount ? $coupon->max_percentage_amount : (($total * $coupon->percentage) / 100);

            session()->put('coupon', ['id' => $coupon->id, 'code' => $coupon->code, 'amount' => $amount]);
        }
        return ['success' => 'کد تخفیف برای شما ثبت شد'];
    }
}

if (!function_exists('province_name')) {
    function province_name($provinceId)
    {
        $province_exist = Province::where('id', $provinceId)->exists();
        if ($province_exist) {
            return Province::findOrFail($provinceId)->name;
        } else {
            return $provinceId;
        }
    }
}

if (!function_exists('city_name')) {
    function city_name($cityId)
    {
        $city_exists = City::where('id', $cityId)->exists();
        if ($city_exists) {
            return City::findOrFail($cityId)->name;
        } else {
            return $cityId;
        }

    }
}

if (!function_exists('dayOfWeek')) {
    function dayOfWeek($day)
    {
        switch ($day) {
            case '0';
                $dayName = 'شنبه';
                break;
            case '1';
                $dayName = 'یکشنبه';
                break;
            case '2';
                $dayName = 'دوشنبه';
                break;
            case '3';
                $dayName = 'سه شنبه';
                break;
            case '4';
                $dayName = 'چهارشنبه';
                break;
            case '5';
                $dayName = 'پنجشنبه';
                break;
            case '6';
                $dayName = 'جمعه';
                break;
        }
        return $dayName;

    }
}

if (!function_exists('convert')) {
    function convert($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);

        return $convertedPersianNums;
    }
}

if (!function_exists('imageExist')) {
    function imageExist($env, $image)
    {
        $path = $env . '/' . $image;

        if (file_exists($path) and !is_dir($path)) {
            $src = url($env . '/' . $image);


        } else {
            $src = url('no_image.png');
        }
        return $src;
    }
}

if (!function_exists('unlink_image_helper_function')) {
    function unlink_image_helper_function($path)
    {
        if (file_exists($path) and !is_dir($path)) {
            unlink($path);
        }
    }
}

if (!function_exists('product_price')) {
    function product_price($product_id, $product_attr_variation_id = null)
    {
        $user = auth()->user();
        if ($product_attr_variation_id != null) {
            $product_attr_variation = ProductAttrVariation::where('id', $product_attr_variation_id)->first();
            //محاسبه قیمت برای کاربران عادی
            if ($user == null or $user->getRawOriginal('role') == 4) {
                $price = $product_attr_variation->price_user_normal;
                $percent_sale = $product_attr_variation->percent_sale_user_normal;
                $sale_price = calculateDiscount($price, $percent_sale);
                return [$price, $percent_sale, $sale_price];
            }
            //محاسبه قیمت برای کاربران اینستاگرام
            if ($user->getRawOriginal('role') == 5) {
                $price = $product_attr_variation->price_user_instagram;
                $percent_sale = $product_attr_variation->percent_sale_user_instagram;
                $sale_price = calculateDiscount($price, $percent_sale);
                return [$price, $percent_sale, $sale_price];
            }
            //محاسبه قیمت برای همکاران
            if ($user->getRawOriginal('role') == 6 or $user->getRawOriginal('role') == 1 or $user->getRawOriginal('role') == 2 or $user->getRawOriginal('role') == 3) {
                $price = $product_attr_variation->price_user_coworker;
                $percent_sale = $product_attr_variation->percent_sale_user_coworker;
                $sale_price = calculateDiscount($price, $percent_sale);
                return [$price, $percent_sale, $sale_price];
            }
        }
        $product = Product::where('id', $product_id)->first();
        if (($product->DateOnSaleTo > Carbon::now() && $product->DateOnSaleFrom < Carbon::now()) or ($product->has_discount == 1)) {
            //محاسبه قیمت برای کاربران عادی
            if ($user == null or $user->getRawOriginal('role') == 4) {
                $price = $product->price_user_normal;
                $percent_sale = $product->percent_sale_user_normal;
                $sale_price = calculateDiscount($price, $percent_sale);
                return [$price, $percent_sale, $sale_price];
            }
            //محاسبه قیمت برای کاربران اینستاگرام
            if ($user->getRawOriginal('role') == 5) {
                $price = $product->price_user_instagram;
                $percent_sale = $product->percent_sale_user_instagram;
                $sale_price = calculateDiscount($price, $percent_sale);
                return [$price, $percent_sale, $sale_price];
            }
            //محاسبه قیمت برای همکاران
            if ($user->getRawOriginal('role') == 6 or $user->getRawOriginal('role') == 1 or $user->getRawOriginal('role') == 2 or $user->getRawOriginal('role') == 3) {
                $price = $product->price_user_coworker;
                $percent_sale = $product->percent_sale_user_coworker;
                $sale_price = calculateDiscount($price, $percent_sale);
                return [$price, $percent_sale, $sale_price];
            }
        } else {
            //محاسبه قیمت برای کاربران عادی
            if ($user == null or $user->getRawOriginal('role') == 4) {
                $price = $product->price_user_normal;
                $percent_sale = 0;
                $sale_price = calculateDiscount($price, $percent_sale);
                return [$price, $percent_sale, $sale_price];
            }
            //محاسبه قیمت برای کاربران اینستاگرام
            if ($user->getRawOriginal('role') == 5) {
                $price = $product->price_user_instagram;
                $percent_sale = 0;
                $sale_price = calculateDiscount($price, $percent_sale);
                return [$price, $percent_sale, $sale_price];
            }
            //محاسبه قیمت برای همکاران
            if ($user->getRawOriginal('role') == 6 or $user->getRawOriginal('role') == 1 or $user->getRawOriginal('role') == 2 or $user->getRawOriginal('role') == 3) {
                $price = $product->price_user_coworker;
                $percent_sale = 0;
                $sale_price = calculateDiscount($price, $percent_sale);
                return [$price, $percent_sale, $sale_price];
            }
        }

    }
}

if (!function_exists('product_price_for_user_normal')) {
    function product_price_for_user_normal($product_id, $product_attr_variation_id = null)
    {
        if ($product_attr_variation_id != null) {
            $product_attr_variation = ProductAttrVariation::where('id', $product_attr_variation_id)->first();
            //محاسبه قیمت برای کاربران عادی
            $price = $product_attr_variation->price;
            $percent_sale_price = $product_attr_variation->percent_sale_price;
            $sale_price = calculateDiscount($price, $percent_sale_price);
            return [$price, $percent_sale_price, $sale_price];
        }

        $product = Product::where('id', $product_id)->first();
        if (($product->DateOnSaleTo > Carbon::now() && $product->DateOnSaleFrom < Carbon::now()) or ($product->has_discount == 1)) {
            //محاسبه قیمت برای کاربران عادی
            $price = $product->price;
            $percent_sale = $product->percent_sale_price;
            $sale_price = calculateDiscount($price, $percent_sale);
            return [$price, $percent_sale, $sale_price];
        } else {
            //محاسبه قیمت برای کاربران عادی
            $price = $product->price;
            $percent_sale = 0;
            $sale_price = calculateDiscount($price, $percent_sale);
            return [$price, $percent_sale, $sale_price];
        }

    }
}

if (!function_exists('calculateDiscount')) {
    function calculateDiscount($price, $percent_sale)
    {
        return $price - ($price * $percent_sale / 100);
    }
}

if (!function_exists('calculateCartProductPrice')) {
    function calculateCartProductPrice($product_price, $product_options)
    {
        if ($product_options != null) {
            foreach ($product_options as $product_option) {
                $price_option = ProductOption::where('id', $product_option)->first()->price;
                $product_price += $price_option;
            }
        }

        return $product_price;
    }
}

if (!function_exists('calculateCartPrice')) {
    function calculateCartPrice()
    {
        $user_id = auth()->id();
        $carts = Cart::where('user_id', $user_id)->get();
        $original_price = 0;
        $sale_price = 0;
        $tax = 0;
        foreach ($carts as $cart) {
            $product_attr_variation = ProductAttrVariation::where('product_id', $cart->product_id)
                ->where('attr_value', $cart->variation_id)
                ->where('color_attr_value', $cart->color_id)
                ->first();
            if ($product_attr_variation != null) {
                $product_attr_variation_id = $product_attr_variation->id;
                $cart['product_attr_variation_id'] = $product_attr_variation_id;
            }
            $option_ids = json_decode($cart->option_ids);
            $cart['option_ids'] = $option_ids;
        }
        foreach ($carts as $cart) {
            $original_price += calculateCartProductPrice(product_price_for_user_normal($cart->product_id, $cart->product_attr_variation_id)[0], $cart->option_ids) * $cart->quantity;
            $sale_price += calculateCartProductPrice(product_price_for_user_normal($cart->product_id, $cart->product_attr_variation_id)[2], $cart->option_ids) * $cart->quantity;
        }
        foreach ($carts as $cart) {
            if ($cart->product_has_tax == 1) {
                $tax += calculateCartProductPrice(product_price_for_user_normal($cart->product_id, $cart->product_attr_variation_id)[2], $cart->option_ids) * $cart->quantity * 0.09;
            }
        }
        $total_sale = $original_price - $sale_price;
        $sale_price = $sale_price + $tax;
        return [
            'original_price' => $original_price,
            'sale_price' => $sale_price,
            'tax' => $tax,
            'total_sale' => $total_sale,
        ];
    }
}

if (!function_exists('summery_cart')) {
    function summery_cart()
    {
        //get user wallet
        $wallet_amount = 0;
        $use_wallet = 0;
        //calculate cart-summery options
        $original_price = calculateCartPrice()['original_price'];
        $total_sale = calculateCartPrice()['total_sale'];
        $sale_price = calculateCartPrice()['sale_price'];
        $tax = calculateCartPrice()['tax'];
        $coupon_amount = session()->get('coupon.amount');
        $delivery_price = session()->get('delivery_price');
        $total_amount = intval($sale_price) + intval($delivery_price) - intval($coupon_amount);
        $payment = $total_amount;
        $left_over_wallet = $wallet_amount;
        //if use wallet
        if (session()->exists('use_wallet')) {
            $use_wallet = session()->get('use_wallet');
        }
        if ($use_wallet != 0) {
            $wallet = Wallet::where('user_id', auth()->id())->first();
            if ($wallet != null) {
                $wallet_amount = $wallet->amount;
            }
            if ($total_amount > $wallet_amount or $total_amount == $wallet_amount) {
                $payment = $total_amount - $wallet_amount;
                $left_over_wallet = 0;
            } else {
                $payment = 0;
                $left_over_wallet = $wallet_amount - $total_amount;
            }
            $wallet_amount = $wallet_amount - $left_over_wallet;
        } else {
            $wallet = Wallet::where('user_id', auth()->id())->first();
            $wallet == null ? $left_over_wallet = 0 : $left_over_wallet = $wallet->amount;
        }
        return
            [
                'original_price' => $original_price,
                'total_sale' => $total_sale,
                'sale_price' => $sale_price,
                'coupon_amount' => $coupon_amount,
                'total_amount' => $total_amount,
                'payment' => $payment,
                'left_over_wallet' => $left_over_wallet,
                'delivery_price' => $delivery_price,
                'wallet_amount' => $wallet_amount,
                'tax' => $tax,
            ];
    }
}

if (!function_exists('discount_timer_creator')) {
    function discount_timer_creator($DateOnSaleTo)
    {
        $year = Carbon::createFromFormat('Y-m-d H:i:s', $DateOnSaleTo)->year;
        $month = Carbon::createFromFormat('Y-m-d H:i:s', $DateOnSaleTo)->month;
        $day = Carbon::createFromFormat('Y-m-d H:i:s', $DateOnSaleTo)->day;
        $hour = Carbon::createFromFormat('Y-m-d H:i:s', $DateOnSaleTo)->hour;
        $minute = Carbon::createFromFormat('Y-m-d H:i:s', $DateOnSaleTo)->minute;
        $second = Carbon::createFromFormat('Y-m-d H:i:s', $DateOnSaleTo)->second;
        $data_until = $year . ', ' . $month . ', ' . $day;
        $data_labels_short = $day . ':' . $hour . ':' . $minute . ':' . $second;
        return [
            'data_until' => $data_until,
            'data_labels_short' => $data_labels_short,
        ];
    }
}

if (!function_exists('children_categories')) {
    function children_categories($category)
    {
        $category_ids = [];
        $ids = [];
        array_push($category_ids, $category->id);
        array_push($ids, $category->id);
        do {
            $categories = Category::whereIn('parent_id', $ids)->get();
            $ids = [];
            if (count($categories) > 0) {
                foreach ($categories as $cat) {
                    array_push($category_ids, $cat->id);
                    array_push($ids, $cat->id);
                }
            }
        } while (count($categories) > 0);
        return $category_ids;
    }
}

if (!function_exists('products_in_children_categories')) {
    function product_ids_in_children_categories($category_ids)
    {
        $product_category_ids = [];
        foreach ($category_ids as $category_id) {
            $Category = Category::find($category_id);
            $products_category = $Category->Products()->where('is_active', 1)->get();
            foreach ($products_category as $item) {
                array_push($product_category_ids, $item->id);
            }
        }
        return $product_category_ids;
    }
}

if (!function_exists('product_name')) {
    function product_info($product_id)
    {
        $product = Product::where('id', $product_id)->first();
        return [
            'product_name' => $product->name,
            'product_price' => $product->price
        ];
    }
}

if (!function_exists('fabric_information')) {
    function fabric_information($fabric_price_product_attr_variation_id)
    {
        $product_attr_variation = ProductAttrVariation::where('id', $fabric_price_product_attr_variation_id)->first();
//        $fabric_price = $product_attr_variation->price;
        $fabric_name = $product_attr_variation->AttributeValue->name;
        $color_name = $product_attr_variation->Color->name;
        return [
            'fabric_name' => $fabric_name,
            'color_name' => $color_name,
        ];
    }
}

if (!function_exists('attribute_name')) {
    function attribute_name($attribute_id)
    {
        $attribute = Attribute::where('id', $attribute_id)->first();
        return [
            'name' => $attribute->name,
        ];
    }
}

if (!function_exists('attribute_value')) {
    function attribute_value($value_id)
    {
        $value_id = ProductOption::where('id', $value_id)->first()->value;
        $attribute_value = \App\Models\AttributeValues::where('id', $value_id)->first();
        return [
            'name' => $attribute_value->name,
        ];
    }
}

if (!function_exists('product_option_price')) {
    function product_option_price($product_option_id)
    {
        $product_option = ProductOption::where('id', $product_option_id)->first();
        return [
            'price' => $product_option->price,
        ];
    }
}

if (!function_exists('calculate_price')) {
    function calculate_price($cart)
    {
        $product_id = $cart['product_id'];
        $options = $cart['options'];
        $measurements = $cart['measurement'];
        $fabrics = $cart['fabric'];
        //calculate product price
        $product_price = Product::where('id', $product_id)->first()->price;
        $product_price = 0;
        //calculate option prices
        $option_prices = 0;
        foreach ($options as $option) {
            $option = ProductOption::where('id', $option)->first();
            $option_prices = $option_prices + $option->price;
        }
        //calculate fabric and side control
        $fabric_measurement_price = 0;
        $side_control_price = 0;
        $fabric_prices = 0;
        foreach ($fabrics as $fabric) {
            $product_attr_variation_id = $fabric['fabric_price_product_attr_variation_id'];
            $product_attr_variation = ProductAttrVariation::where('id', $product_attr_variation_id)->first();
            $fabric_price = $fabric['price'];
            $fabric_prices = $fabric_prices + $fabric_price;
//            foreach ($measurements as $measurement) {
//                $width = $measurement['width'];
//                $drop = $measurement['drop'];
//                //convert mm to m
//                $width = $width / 1000;
//                $drop = $drop / 1000;
//                $s = $width * $drop;
//                $fabric_measurement_price = $fabric_measurement_price + ($fabric_price * $s);
//            }
        }
        $total_price = $product_price + $option_prices + $fabric_prices;
        return $total_price;
    }
}

if (!function_exists('cart_total_price')) {
    function cart_total_price()
    {
        $total_price = 0;
        $carts = session('carts');
        foreach ($carts as $cart) {
            $cart_price = calculate_price($cart);
            $total_price = $total_price + $cart_price;
        }
        return $total_price;
    }
}

if (!function_exists('fabricPriceHelper')) {
    function fabricPriceHelper($price_group, $width, $drop): int
    {
        $measurement = Measurements::where('width', '>=', intval($width))->where('drop', '>=', intval($drop))->first();
        if ($measurement) {
            return $measurement['price_' . $price_group];
        }
        return 0;
    }
}
if (!function_exists('imageExist')) {
    function imageExist($env, $image)
    {
        $path = $env . '/' . $image;

        if (file_exists($path) and !is_dir($path)) {
            $src = url($env . '/' . $image);


        } else {
            $src = url('no_image.png');
        }
        return $src;
    }
}

if (!function_exists('filed_name')) {
    function filed_name($value)
    {
        $value=str_replace('/',' ',$value);
        $value=str_replace(' ','_',$value);
        return strtolower($value);
    }
}
