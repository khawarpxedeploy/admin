<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function countriesList(Request $request)
    {

        $countries = Country::where('status', 1)->orderBy('id', 'desc')
            ->get();
        if (!$countries) {
            return $this->sendError('Not Found.', ['error' => 'No Countries found. Add from BackOffice!']);
        }
        $success['countries'] = $countries;
        return $this->sendResponse($success ?? [], 'Countries found!.');

    }
}
