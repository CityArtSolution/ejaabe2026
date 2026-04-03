<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\ReserveMeeting;
use App\Models\Ticket;
use App\Models\Webinar;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartManagerController extends Controller
{
    public $cookieKey = 'carts';

    public function getCarts()
    {
        $carts = collect();

        if (auth()->check()) {
            $user = auth()->user();

            $user->carts()
                ->whereNotNull('product_order_id')
                ->where(function ($query) {
                    $query->whereDoesntHave('productOrder');
                    $query->orWhereDoesntHave('productOrder.product');
                })
                ->delete();

            $carts = $user->carts()
                ->with([
                    'webinar',
                    'bundle',
                    'event',
                    'installmentPayment',
                    'productOrder' => function ($query) {
                        $query->with(['product']);
                    }
                ])
                ->get();
        } else {
            $cookieCarts = Cookie::get($this->cookieKey);

            if (!empty($cookieCarts)) {
                $cookieCarts = json_decode($cookieCarts, true);

                if (!empty($cookieCarts) and count($cookieCarts)) {
                    $carts = collect();

                    foreach ($cookieCarts as $cookieCart) {

                        if (!empty($cookieCart['item_name']) and $cookieCart['item_name'] == 'webinar_id') {
                            $webinar = Webinar::where('id', $cookieCart['item_id'])
                                ->where('private', false)
                                ->where('status', 'active')
                                ->first();

                            if (!empty($webinar)) {
                                $ticket = null;

                                if (!empty($cookieCart['ticket_id'])) {
                                    $ticket = Ticket::where('id', $cookieCart['ticket_id'])->first();
                                }

                                $item = new Cart();
                                $item->webinar_id = $webinar->id;
                                $item->webinar = $webinar;
                                $item->ticket = $ticket;
                                $item->ticket_id = !empty($ticket) ? $ticket->id : null;

                                $carts->add($item);
                            }
                        } elseif (!empty($cookieCart['item_name']) and $cookieCart['item_name'] == 'bundle_id') {
                            $bundle = Bundle::where('id', $cookieCart['item_id'])
                                ->where('status', 'active')
                                ->first();

                            if (!empty($bundle)) {
                                $ticket = null;

                                if (!empty($cookieCart['ticket_id'])) {
                                    $ticket = Ticket::where('id', $cookieCart['ticket_id'])->first();
                                }

                                $item = new Cart();
                                $item->bundle_id = $bundle->id;
                                $item->bundle = $bundle;
                                $item->ticket = $ticket;
                                $item->ticket_id = !empty($ticket) ? $ticket->id : null;

                                $carts->add($item);
                            }
                        } elseif (!empty($cookieCart['item_name']) and $cookieCart['item_name'] == 'product_id') {
                            $product = Product::where('id', $cookieCart['item_id'])->first();

                            if (!empty($product)) {
                                $item = new Cart();

                                $item->product_order_id = $product->id;
                                $item->productOrder = (object)[
                                    'quantity' => $cookieCart['quantity'] ?? 1,
                                    'product' => $product
                                ];

                                $carts->add($item);
                            }
                        }
                    }
                }
            }
        }

        return $carts;
    }

    public function storeCookieCartsToDB()
    {
        try {
            if (auth()->check()) {
                $user = auth()->user();
                $carts = Cookie::get($this->cookieKey);
                if (!empty($carts)) {
                    $carts = json_decode($carts, true);

                    if (!empty($carts)) {
                        foreach ($carts as $cart) {
                            if (!empty($cart['item_name']) and !empty($cart['item_id'])) {
                                if ($cart['item_name'] == 'webinar_id') {
                                    $this->storeUserWebinarCart($user, $cart , $cart['branch_id']);
                                } elseif ($cart['item_name'] == 'product_id') {
                                    $this->storeUserProductCart($user, $cart);
                                } elseif ($cart['item_name'] == 'bundle_id') {
                                    $this->storeUserBundleCart($user, $cart);
                                }
                            }
                        }
                    }

                    Cookie::queue($this->cookieKey, null, 0);
                }
            }
        } catch (\Exception $exception) {

        }
    }

    public function storeUserWebinarCart($user, $data , $branchId)
    {
        $webinar_id = $data['item_id'];
        $ticket_id = $data['ticket_id'] ?? null;

        $webinar = Webinar::where('id', $webinar_id)->where('branch_id' , $branchId)->where('private', false)->where('status', 'active')->first();

        if (!empty($webinar) and !empty($user)) {
            $checkCourseForSale = checkCourseForSale($webinar, $user);

            if ($checkCourseForSale != 'ok') {
                return $checkCourseForSale;
            }

            $activeSpecialOffer = $webinar->activeSpecialOffer();
               $selectedCoursePrice = $data['selectedCoursePrice'] ?? null;

            session()->put('course_price_' . $webinar_id, [
                'price' => $selectedCoursePrice,
                'date' => $data['selectedCourseDate'] ?? null,
                'time' => $data['selectedCourseTime'] ?? null,
                'location' => $data['selectedCourseLocation'] ?? null,
                'language' => $data['selectedCourseLangs'] ?? null,
                'days' => $data['selectedCourseDays'] ?? null
            ]);


            Cart::updateOrCreate([
                'creator_id' => $user->id,
                'webinar_id' => $webinar_id,
            ], [
                'ticket_id' => $ticket_id,
                'branch_id' => $branchId,
                'special_offer_id' => !empty($activeSpecialOffer) ? $activeSpecialOffer->id : null,
                'created_at' => time()
            ]);

            return 'ok';
        }

        $toastData = [
            'title' => trans('public.request_failed'),
            'msg' => trans('cart.course_not_found'),
            'status' => 'error'
        ];
        return back()->with(['toast' => $toastData]);
    }
    
     public function storeUserEventCart($user, $data  , $branchId)
    {
        $event_id = $data['item_id'];
        $ticket_id = $data['event_id'] ?? null;

        $event = Event::where('id', $event_id)->where('status', '1')->where('branch_id' , $branchId)->first();

        if (!empty($event) and !empty($user)) {
          //  $checkCourseForSale = checkCourseForSale($bundle, $user);

           /* if ($checkCourseForSale != 'ok') {
                return $checkCourseForSale;
            }
            $activeSpecialOffer = $bundle->activeSpecialOffer();
*/
            Cart::updateOrCreate([
                'creator_id' => $user->id,
                'event_id' => $event_id,
            ], [
                'ticket_id' => $ticket_id,
                'branch_id' => $branchId,
              //  'special_offer_id' => !empty($activeSpecialOffer) ? $activeSpecialOffer->id : null,
                'created_at' => time()
            ]);

            return 'ok';
        }

        $toastData = [
            'title' => trans('public.request_failed'),
            'msg' => trans('cart.course_not_found'),
            'status' => 'error'
        ];
        return back()->with(['toast' => $toastData]);
    }

    public function storeUserBundleCart($user, $data , $branchId)
    {
        $bundle_id = $data['item_id'];
        $ticket_id = $data['ticket_id'] ?? null;

        $bundle = Bundle::where('id', $bundle_id)->where('status', 'active')->where('branch_id', $branchId)->first();

        if (!empty($bundle) and !empty($user)) {
            $checkCourseForSale = checkCourseForSale($bundle, $user);

            if ($checkCourseForSale != 'ok') {
                return $checkCourseForSale;
            }

            $activeSpecialOffer = $bundle->activeSpecialOffer();

            Cart::updateOrCreate([
                'creator_id' => $user->id,
                'bundle_id' => $bundle_id,
            ], [
                'ticket_id' => $ticket_id,
                'special_offer_id' => !empty($activeSpecialOffer) ? $activeSpecialOffer->id : null,
                'branch_id' => $branchId,
                'created_at' => time()
            ]);

            return 'ok';
        }

        $toastData = [
            'title' => trans('public.request_failed'),
            'msg' => trans('cart.course_not_found'),
            'status' => 'error'
        ];
        return back()->with(['toast' => $toastData]);
    }

    public function storeUserProductCart($user, $data , $branchId)
    {
        $product_id = $data['item_id'];
        $specifications = $data['specifications'] ?? null;
        $quantity = $data['quantity'] ?? 1;

        $product = Product::where('id', $product_id)->where('status', 'active')->where('branch_id', $branchId)->first();

        if (!empty($product) and !empty($user)) {
            $checkProductForSale = checkProductForSale($product, $user);

            if ($checkProductForSale != 'ok') {
                return $checkProductForSale;
            }

            $activeDiscount = $product->getActiveDiscount();

            $productOrder = ProductOrder::updateOrCreate([
                'product_id' => $product->id,
                'seller_id' => $product->creator_id,
                'buyer_id' => $user->id,
                'sale_id' => null,
                'status' => 'pending',
            ], [
                'specifications' => $specifications ? json_encode($specifications) : null,
                'quantity' => $quantity,
                'branch_id' => $branchId,
                'discount_id' => !empty($activeDiscount) ? $activeDiscount->id : null,
                'created_at' => time()
            ]);

            Cart::updateOrCreate([
                'creator_id' => $user->id,
                'product_order_id' => $productOrder->id,
            ], [
                'product_discount_id' => !empty($activeDiscount) ? $activeDiscount->id : null,
                'branch_id' => $branchId ,
                'created_at' => time()
            ]);

            return 'ok';
        }

        $toastData = [
            'title' => trans('public.request_failed'),
            'msg' => trans('cart.course_not_found'),
            'status' => 'error'
        ];
        return back()->with(['toast' => $toastData]);
    }

    public function storeCookieCart($data)
    {
        $carts = Cookie::get($this->cookieKey);

        if (!empty($carts)) {
            $carts = json_decode($carts, true);
        } else {
            $carts = [];
        }
        $item_id = $data['item_id'];
        $item_name = $data['item_name'];

        if (empty($data['quantity'])) {
            $data['quantity'] = 1;
        }

        $carts[$item_name . '_' . $item_id] = $data;

        Cookie::queue($this->cookieKey, json_encode($carts), 30 * 24 * 60);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $branchId = "";
        $url = url()->previous();
        $redirectUrl = "";
        $isCanada = str_contains($url, '/canada');
        $isEgy = str_contains($url, '/egy');
        $isUae = str_contains($url, '/uae');

        if ($isCanada) {
            $redirectUrl = '/cart/canada';
            $branchId = 3;
        }elseif ($isEgy) {
            $redirectUrl = '/cart/egy';
            $branchId = 4;
        }elseif ($isUae) {
            $redirectUrl = '/cart/uae';
            $branchId = 2;
        }else{
            $redirectUrl = '/cart';
            $branchId = 1;  
        }

        $this->validate($request, [
            'item_id' => 'required',
            'item_name' => 'nullable',
        ]);

        $data = $request->except('_token');
        $item_name = $data['item_name'];
        $data['branch_id'] = $branchId;

        if (!empty($user)) { // store in DB
            $result = null;

            if ($item_name == 'webinar_id') {
                $result = $this->storeUserWebinarCart($user, $data , $branchId);
            } elseif ($item_name == 'product_id') {
                $result = $this->storeUserProductCart($user, $data , $branchId);
            } elseif ($item_name == 'bundle_id') {
                $result = $this->storeUserBundleCart($user, $data , $branchId);
            }
            elseif  ($item_name == 'event_id') {
                 $result = $this->storeUserEventCart($user, $data , $branchId);
            }

            if ($result != 'ok') {
                return $result;
            }
        } else { // store in cookie
            $this->storeCookieCart($data);
        }

        $toastData = [
            'title' => trans('cart.cart_add_success_title'),
            'msg' => trans('cart.cart_add_success_msg'),
            'status' => 'success'
        ];
        
        return redirect($redirectUrl)->with(['toast' => $toastData]);
    }


    public function destroy($id)
    {
        if (auth()->check()) {
            $user_id = auth()->id();

            $cart = Cart::where('id', $id)
                ->where('creator_id', $user_id)
                ->first();

            if (!empty($cart)) {
                session()->forget('course_price_' . $cart->webinar_id);

                if (!empty($cart->reserve_meeting_id)) {
                    $reserve = ReserveMeeting::where('id', $cart->reserve_meeting_id)
                        ->where('user_id', $user_id)
                        ->first();

                    if (!empty($reserve)) {
                        $reserve->delete();
                    }
                } elseif (!empty($cart->installment_payment_id)) {
                    $installmentPayment = $cart->installmentPayment;

                    if (!empty($installmentPayment) and $installmentPayment->status == 'paying') {
                        $installmentOrder = $installmentPayment->installmentOrder;

                        $installmentPayment->delete();

                        if (!empty($installmentOrder) and $installmentOrder->status == 'paying') {
                            $installmentOrder->delete();
                        }
                    }
                }

                $cart->delete();
            }
        } else {
            $carts = Cookie::get($this->cookieKey);

            if (!empty($carts)) {
                $carts = json_decode($carts, true);

                if (!empty($carts[$id])) {
                    unset($carts[$id]);
                }

                Cookie::queue($this->cookieKey, json_encode($carts), 30 * 24 * 60);
            }
        }

        return response()->json([
            'code' => 200
        ], 200);
    }
}
