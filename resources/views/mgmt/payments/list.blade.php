@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        {{ __('Payments') }}
                    </span>
                    <span class="float-right">
                        <a class="btn-link" href="{{ route('payments.new') }}">
                            {{ __('Add Payment') }}
                        </a>
                    </span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form>
                        <div class="form-row mb-4">
                            <div class="col-4">
                                <select id="tax" class="form-control" name="tax_id">
                                    <option value=""> - Select Tax - </option>
                                    @foreach($rates_data['taxes'] as $tax_id => $tax_lbl)
                                    <option value="{{ $tax_id }}" @if($tax_id == $current_tax_id) selected @endif>
                                        {{ $tax_lbl }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select id="state" class="form-control" name="state_id" data-old="{{ $current_state_id }}">
                                    <option value=""> - Select State - </option>
                                </select>
                            </div>
                            <div class="col">
                                <select id="county" class="form-control" name="county_id" data-old="{{ $current_county_id }}">
                                    <option value=""> - Select County - </option>
                                </select>
                            </div>
                            <div class="col-1">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>

                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">
                                    {{ __('Date') }}
                                </th>
                                <th scope="col">
                                    {{ __('Amount') }}
                                </th>
                                <th scope="col">
                                    {{ __('TAX') }}
                                </th>
                                <th scope="col">
                                    {{ __('State') }}
                                </th>
                                <th scope="col">
                                    {{ __('County') }}
                                </th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $model)
                            <tr>
                                <td>
                                    {{ $model->date }}
                                </td>
                                <th scope="row">
                                    {{ money(number_format($model->amount, 2, '', '')) }}
                                </th>
                                <td>
                                    {{ $model->tax->name }}
                                </td>
                                <td>
                                    {{ $model->county->state->name }}
                                </td>
                                <td>
                                    {{ $model->county->name }}
                                </td>
                                <td>
                                    <a href="{{ route('payments.edit', ['id' => $model->id]) }}">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            {!! $payments->appends(['state_id' => $current_state_id, 'tax_id' => $current_tax_id, 'county_id' => $current_county_id])->links() !!}
        </div>
    </div>
</div>
@endsection
@push('head')
<script src="{{ asset('js/pages/payments.list.js') }}" defer></script>
<script>
var rates_data = {!! json_encode($rates_data) !!};
</script>

@endpush
