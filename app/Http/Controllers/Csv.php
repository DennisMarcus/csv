<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Redirector;

class Csv extends BaseController {
    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function uploadCsvIntoDatabase(Request $request) {
        if (($file = fopen('csv/' . $request->input('fileName') . '.csv', 'r')) !== false) {
            $header = [];
            $csvData = [];
            $pointer = 0;

            while (($row = fgetcsv($file)) !== false) {
                if ($pointer === 0){
                    $header = $row;
                    $pointer++;
                    continue;
                }

                array_push($csvData, array_combine($header, $row));

                $pointer++;
            }

            fclose($file);

            Payment::insert($csvData);

            return redirect('/upload-completed');
        }

        return redirect('/upload-failed');
    }
}
