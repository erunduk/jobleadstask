<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Payment;
use App\Models\Tax;
use App\Models\County;

class PaymentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the tax payments list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $tax_id = $request->get('tax_id');
        $state_id = $request->get('state_id');
        $county_id = $request->get('county_id');

        $query = Payment::with(['tax', 'county', 'county.state']);
        if ($tax_id) {
            $query->where('tax_id', $tax_id);
            if ($state_id) {
                if ($county_id) {
                    $query->where('county_id', $county_id);
                } else {
                    // First load all counties
                    $counties = County::where('state_id', $state_id)->get();
                    $counties_plucked = $counties->pluck('id');
//                    var_dump($counties_plucked);die();
                    $query->whereIn('county_id', $counties_plucked->toArray());
                }
            }
        }
//        \Illuminate\Support\Facades\DB::enableQueryLog(); // Enable query log

        $payments = $query->paginate(10);

// Your Eloquent query

//dd(\Illuminate\Support\Facades\DB::getQueryLog()); // Show results of log
        $rates_data = State::getTaxesRatesOverview();
        $taxes = Tax::all();
        $taxes_plucked = $taxes->pluck('name', 'id');

        return view(
            'mgmt.payments.list',
            [
                'payments' => $payments,
                'rates_data' => $rates_data,
                'taxes_list' => $taxes_plucked,
                'current_tax_id' => $tax_id,
                'current_state_id' => $state_id,
                'current_county_id' => $county_id,
            ]
        );
    }


    /**
     * Show the tax payment create form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $taxes = Tax::all();
        $taxes_plucked = $taxes->pluck('name', 'id');
        $rates_data = State::getTaxesRatesOverview();

        return view(
            'mgmt.payments.create',
            [
                'taxes_list' => $taxes_plucked,
                'rates_data' => $rates_data,
            ]
        );
    }


    /**
     * Show the tax payment edit form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Request $request)
    {
        if (!$request->get('id')) {
            return abort(404);
        }

        $model = Payment::with(['county', 'tax', 'county.state'])->find($request->get('id'));

        if (empty($model)) {
            return abort(404);
        }

        $rate = Tax::getRate($model->county_id, $model->tax_id);

        return view(
            'mgmt.payments.edit',
            [
                'model' => $model,
                'rate' => $rate,
            ]
        );
    }

    /**
     * Process submitted existing payment updated data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function processEdit(Request $request)
    {
        // Perform basic simple validation
        $validationRules = [
            'id' => 'required|exists:payments,id',
            'amount_taxable' => 'required|numeric|max:9999999999|min:1',
        ];
        $validatedData = $request->validate($validationRules);

        // Fetch the model & actual rate
        $model = Payment::find($validatedData['id']);
        $rate = Tax::getRate($model->county_id, $model->tax_id);

        // Perform modification
        $model->amount = number_format($validatedData['amount_taxable'] * $rate, 2, '.', '');
        $model->save();

        return redirect()->route('payments.list')->with('status', __('Payment has been updated!'));
    }

    /**
     * Process submitted new payment data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function processCreate(Request $request)
    {
        // Perform basic simple validation
        $validationRules = [
            'tax' => 'required|exists:taxes,id',
            'state' => 'required|exists:states,id',
            'county' => 'required|exists:counties,id',
            'amount_taxable' => 'required|numeric|max:9999999999|min:1',
            'date' => 'required|date_format:Y-m-d|before:today'
        ];
        $validatedData = $request->validate($validationRules);

        // Prevent duplicates and attempts to add record for non-supported county
        $rate = 0;
        $finalValidator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'date' => [
                function ($attribute, $value, $fail) use ($validatedData, &$rate) {
                    $duplicate = Payment::where('date', $validatedData['date'])
                        ->where('county_id', $validatedData['county'])
                        ->where('tax_id', $validatedData['tax'])->count();
                    if ($duplicate) {
                        $fail(__('Duplicate record. Choose another date.'));
                    }

                    $rate = Tax::getRate($validatedData['county'], $validatedData['tax']);
                    if (is_null($rate)) {
                        $fail(__('Tax not supported by selected county.'));
                    }
                },
            ],
        ]);

        if ($finalValidator->fails()) {
            return redirect()
                ->back()
                ->withErrors($finalValidator)
                ->withInput();
        }

        // All data valie, write data
        $payment = new Payment();
        $payment->date = $validatedData['date'];
        $payment->amount = number_format($validatedData['amount_taxable'] * $rate, 2, '.', '');
        $payment->county_id = $validatedData['county'];
        $payment->tax_id = $validatedData['tax'];
        $payment->save();

        return redirect()->route('payments.list')->with('status', __('Payment has been added!'));
    }
}
