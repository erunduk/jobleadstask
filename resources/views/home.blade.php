@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Public Available States Statistics</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">
                                    State
                                </th>
                                <th scope="col">
                                    Total Paid
                                </th>
                                <th scope="col">
                                    Average Payment
                                </th>
                                <th scope="col">
                                    Average Rate
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($states_stats as $row)
                            <tr>
                                <th scope="row">
                                    {{ $row->name }}
                                </th>
                                <td>
                                    {{ money(number_format($row->payment_total, 2, '', '')) }}
                                </td>
                                <td>
                                    {{ money(number_format($row->payment_avg, 2, '', '')) }}
                                </td>
                                <td>
                                    {{ number_format($row->rate_avg * 100, 2) }} %
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">Public Available Counties Statistics</div>

                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">
                                    State
                                </th>
                                <th scope="col">
                                    County
                                </th>
                                <th scope="col">
                                    Total Paid
                                </th>
                                <th scope="col">
                                    Average Rate
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($counties_stats as $row)
                            <tr>
                                <td>
                                    @if (empty($rendered_states) || !in_array($row->state, $rendered_states))
                                    @php $rendered_states[]= $row->state; @endphp
                                    {{ $row->state }}
                                    @endif
                                </td>
                                <th scope="row">
                                    {{ $row->county }}
                                </th>
                                <td>
                                    {{ money(number_format($row->payment_total, 2, '', '')) }}
                                </td>
                                <td>
                                    {{ number_format($row->rate_avg * 100, 2) }} %
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
