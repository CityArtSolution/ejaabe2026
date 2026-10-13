<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Web\CartManagerController;
use App\Mixins\Financial\MultiCurrency;
use App\Mixins\PurchaseNotifications\PurchaseNotificationsHelper;
use App\Models\Cart;
use App\Models\CartDiscount;
use App\Models\Currency;
use App\Models\FloatingBar;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Share
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
public function handle($request, Closure $next)
{
    $purchaseNotificationsHelper = new PurchaseNotificationsHelper();
    $purchaseNotifications = $purchaseNotificationsHelper->getDisplayableNotifications();
    view()->share('purchaseNotifications', $purchaseNotifications);

    if (auth()->check()) {
        $user = auth()->user();
        view()->share('authUser', $user);

        if (!$user->isAdmin()) {
            $unReadNotifications = $user->getUnReadNotifications();
            view()->share('unReadNotifications', $unReadNotifications);
        }
    } else {
        $user = null;
    }

    // carts
    $cartManagerController = new CartManagerController();
    $carts = $cartManagerController->getCarts();

    view()->share('userCarts', $carts);

    // الإجمالي القديم (كل السلات مع بعض)
    $totalCartsPrice = Cart::getCartsTotalPrice($carts);
    view()->share('totalCartsPrice', $totalCartsPrice);

    // الجديد: اجمالي كل فرع لوحده
    $branchTotals = [];
    if (!empty($carts) and $user) {
        foreach ($carts->groupBy('branch_id') as $branchId => $branchCarts) {
            $branchTotals[$branchId] = $this->calculatePrice($branchCarts, $user);
        }
    }
    view()->share('branchTotals', $branchTotals);

    $cartDiscount = CartDiscount::query()->where('enable', true)->count();
    view()->share('userCartDiscount', $cartDiscount);

    $generalSettings = getGeneralSettings();
    view()->share('generalSettings', $generalSettings);

    $currency = currencySign();
    view()->share('currency', $currency);

    if (getFinancialCurrencySettings('multi_currency')) {
        $multiCurrency = new MultiCurrency();
        $currencies = $multiCurrency->getCurrencies();

        if ($currencies->isNotEmpty()) {
            view()->share('currencies', $currencies);
        }
    }

    // locale config
    if (!Session::has('locale')) {
        Session::put('locale', mb_strtolower(getDefaultLocale()));
    }
    App::setLocale(session('locale'));

    view()->share('categories', \App\Models\MainCategory::getCategories());
    view()->share('navbarPages', getNavbarLinks());
    view()->share('footerPage2', \App\Models\Page::getFooterPages2());
    view()->share('footerPage3', \App\Models\Page::getFooterPages3());

    if (!$request->is("course/learning*")) {
        $floatingBar = FloatingBar::getFloatingBar($request);
        view()->share('floatingBar', $floatingBar);
    }

    $userTimezone = getTimezone();
    config()->set('app.timezone', $userTimezone);

    return $next($request);
}

    
    private function calculatePrice($carts, $user, $discountCoupon = null)
{
    $financialSettings = getFinancialSettings();

    $subTotal = 0;
    $totalDiscount = 0;
    $tax = (!empty($financialSettings['tax']) and $financialSettings['tax'] > 0) ? $financialSettings['tax'] : 0;
    $taxPrice = 0;
    $commissionPrice = 0;
    $commission = 0;

    $cartHasWebinar = array_filter($carts->pluck('webinar_id')->toArray());
    $cartHasBundle = array_filter($carts->pluck('bundle_id')->toArray());
    $cartHasMeeting = array_filter($carts->pluck('reserve_meeting_id')->toArray());

    $taxIsDifferent = (count($cartHasWebinar) or count($cartHasBundle) or count($cartHasMeeting));

    foreach ($carts as $cart) {
        $orderPrices = app(\App\Http\Controllers\Web\CartController::class)->handleOrderPrices($cart, $user, $taxIsDifferent);

        $subTotal += $orderPrices['sub_total'];
        $totalDiscount += $orderPrices['total_discount'];
        $tax = $orderPrices['tax'];
        $taxPrice += $orderPrices['tax_price'];
        $commission += $orderPrices['commission'];
        $commissionPrice += $orderPrices['commission_price'];
        $taxIsDifferent = $orderPrices['tax_is_different'];
    }

    if (!empty($discountCoupon)) {
        $totalDiscount += app(\App\Http\Controllers\Web\CartController::class)->handleDiscountPrice($discountCoupon, $carts, $subTotal);
    }

    if ($totalDiscount > $subTotal) {
        $totalDiscount = $subTotal;
    }

    $subTotalWithoutDiscount = $subTotal - $totalDiscount;
    $productDeliveryFee = app(\App\Http\Controllers\Web\CartController::class)->calculateProductDeliveryFee($carts);

    $total = $subTotalWithoutDiscount + $taxPrice + $productDeliveryFee;

    if ($total < 0) {
        $total = 0;
    }

    $currencyItem = getUserCurrencyItem($user);
    return [
        'sub_total' => round($subTotal, 2),
        'total_discount' => round(convertPriceToUserCurrency($totalDiscount, $currencyItem), 2),
        'tax' => $tax,
        'tax_price' => round(convertPriceToUserCurrency($taxPrice, $currencyItem), 2),
        'commission' => $commission,
        'commission_price' => round(convertPriceToUserCurrency($commissionPrice, $currencyItem), 2),
        'total' => round($total, 2),
        'product_delivery_fee' => round(convertPriceToUserCurrency($productDeliveryFee, $currencyItem), 2),
        'tax_is_different' => $taxIsDifferent
    ];
}

}
