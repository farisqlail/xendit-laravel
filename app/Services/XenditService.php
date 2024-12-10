<?php

namespace App\Services;

use Xendit\Xendit;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;

class XenditService
{
    public function __construct()
    {
        Configuration::setXenditKey(env('XENDIT_API_KEY'));
    }

    public function createInvoice(array $data)
    {
        $apiInstance = new InvoiceApi();
        return $apiInstance->createInvoice($data);
    }

    public function getInvoice(string $invoiceId)
    {
        $apiInstance = new InvoiceApi();
        return $apiInstance->getInvoiceById($invoiceId);
    }

    public function getAllInvoices()
    {
        $apiInstance = new InvoiceApi();
        return $apiInstance->getInvoices();
    }
}
