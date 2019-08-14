@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Taxes Rates') }}
                </div>

                <div class="card-body">

                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">
                                    {{ __('State') }}
                                </th>
                                <th scope="col">
                                    {{ __('County') }}
                                </th>
                                @foreach ($rates_data['taxes'] as $name)
                                <th scope="col">
                                    {{ $name }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rates_data['rates'] as $state_id => $counties_data)
                            @foreach ($counties_data as $county_id => $taxes_data)
                            <tr>
                                <th scope="row">
                                    {{ $rates_data['states'][$state_id] }}
                                </th>
                                <td>
                                    {{ $rates_data['counties'][$county_id] }}
                                </td>
                                @foreach (array_keys($rates_data['taxes']) as $tax_id)
                                <td>
                                    @if (isset($taxes_data[$tax_id]))
                                    {{ number_format($taxes_data[$tax_id] * 100, 2) }} %
                                    @else
                                    -
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
