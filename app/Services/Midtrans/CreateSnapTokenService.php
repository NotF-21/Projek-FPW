<?php
namespace App\Services\Midtrans;

use App\Models\CustomerModel;
use App\Models\Product;
use App\Models\Promo;
use App\Models\PromoGlobal;
use App\Models\Voucher;
use App\Models\VoucherBelonging;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $trans;

    public function __construct($trans)
    {
        parent::__construct();

        $this->trans = $trans;
    }

    public function getSnapToken() {
        $name = $this->trans->customer->customer_name;
        $pieces = explode(' ', $name);
        $last_word = array_pop($pieces);

        array_unshift($pieces, $last_word);

        $new_string = implode(' ', $pieces);

        $params = array(
            'transaction_details' => array(
                'order_id' => $this->trans->invoice_number,
                'gross_amount' => $this->trans->trans_total,
            ),
            'customer_details' => array(
                'first_name' => $new_string,
                'last_name' => $last_word,
                'phone' => $this->trans->customer->customer_phonenumber,
                'shipping_address' => array(
                    'address' => $this->trans->shipping_address,
                ),
            ),
        );

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
