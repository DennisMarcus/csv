<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Payment as PaymentModel;

class Payment extends BaseController {
    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function showPaymentRecords(Request $request) {
        switch ($request->input('filter')) {
            case 'Currency':
                return view('view-csv', ['data' => $this->showPaymentsPerCurrency()]);
            case 'User':
                return view('view-csv', ['data' => $this->showPaymentsPerUser()]);
            case 'Day':
                return view('view-csv', ['data' => $this->showPaymentsPerDay()]);
            default:
                return view('view-csv', ['data' => $this->showAllPayments()]);
        }
    }

    private function showAllPayments(): Collection {
        return PaymentModel::selectRaw(
            'user_id,
            FROM_UNIXTIME(unix_timestamp, "%d-%m-%Y") AS date,
            country,
            currency,
            amount_in_cents')
            ->get();
    }

    /**
     * @return Collection
     */
    private function showPaymentsPerCurrency(): Collection {
        return PaymentModel::selectRaw('country, currency, SUM(amount_in_cents) as amount_in_cents')
            ->groupBy('currency')
            ->orderBy('currency', 'DESC')
            ->get();
    }

    /**
     * @return Collection
     */
    private function showPaymentsPerUser(): Collection {
        return PaymentModel::selectRaw('user_id, SUM(amount_in_cents) as amount_in_cents')
            ->groupBy('user_id')
            ->orderBy('user_id', 'DESC')
            ->get();
    }

    /**
     * @return Collection
     */
    private function showPaymentsPerDay(): Collection {
        $collection = Collection::make();
        $data = PaymentModel::selectRaw(
            'FROM_UNIXTIME(unix_timestamp, "%d-%m-%Y") AS date,
            currency,
            amount_in_cents')
            ->orderBy('date', 'DESC')
            ->get();

        foreach ($data as $row) {
            $row = $this->setCurrencyToEuro($row);
            $collection->push($row);
        }

        return $collection;
    }

    private function setCurrencyToEuro(PaymentModel $row): PaymentModel {
        if ($row->currency !== 'EUR') {
            $row->amount_in_cents = $row->amount_in_cents * $_ENV[$row->currency];
            $row->currency = 'EUR';
        }

        return $row;
    }
}
