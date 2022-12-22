<?php

namespace App\Services\Midtrans;

use App\Models\Transaction;
use App\Services\Midtrans\Midtrans;
use Midtrans\Notification;

class CallBackService extends Midtrans
{
    protected $notification;
    protected $trans;
    protected $serverKey;

    public function __construct()
    {
        parent::__construct();

        $this->serverKey = env('MIDTRANS_SERVER_KEY');
        $this->_handleNotification();
    }

    public function isSignatureKeyVerified() {
        return ($this->_createLocalSignatureKey() == $this->notification->signature_key);
    }

    public function isSuccess() {
        $statusCode = $this->notification->status_code;
        $transStatus = $this->notification->transaction_status;
        $fraudStatus = !empty($this->notification->fraud_status) ? ($this->notification->fraud_status) : true;

        return ($statusCode == 200 && $fraudStatus && ($transStatus == 'capture' || $transStatus == 'settlement'));
    }

    public function isExpire() {
        return ($this->notification->transaction_status == 'expire');
    }

    public function isCancelled() {
        return ($this->notification->transaction_status == 'cancel');
    }

    public function getNotification() {
        return $this->notification;
    }

    public function getTrans() {
        return $this->trans;
    }

    protected function _createLocalSignatureKey() {
        $id = $this->trans->invoice_number;
        $statusCode = $this->notification->status_code;
        $total = $this->trans->trans_total;
        $serverKey = $this->serverKey;
        $input = $id . $statusCode . $total . $serverKey;
        $signature = openssl_digest($input, 'sha512');

        return $signature;
    }

    protected function _handleNotification() {
        $notification = new Notification();

        $orderNumber = $notification->order_id;
        $order = Transaction::where("invoice_number", $orderNumber)->first();

        $this->notification = $notification;
        $this->trans = $order;
    }
}
