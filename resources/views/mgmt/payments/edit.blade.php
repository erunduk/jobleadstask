@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">{{ __('Register New Payment') }}</span>
                    <span class="float-right">
                        <a class="btn-link" href="{{ route('payments.list') }}">
                            {{ __('Cancel') }}
                        </a>
                    </span>
                </div>

                <div class="card-body">
                    <form method="POST">
                        @csrf

                        <input type="hidden" name="id" value="{{ $model->id }}" />

                        <div class="form-group row">
                            <label for="tax" class="col-md-4 col-form-label text-md-right">{{ __('Tax') }}</label>
                            <div class="col-md-6">
                                <select id="tax" name="tax" class="form-control">
                                    <option>{{ $model->tax->name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="state" class="col-md-4 col-form-label text-md-right">{{ __('State') }}</label>

                            <div class="col-md-6">
                                <select id="state" name="state" class="form-control">
                                    <option>{{ $model->county->state->name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="county" class="col-md-4 col-form-label text-md-right">{{ __('County') }}</label>

                            <div class="col-md-6">
                                <select id="county" name="county" class="form-control">
                                    <option>{{ $model->county->name }} ({{ $rate * 100 }}) %</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                            <div class="col-md-6">
                                <input id="date" type="text" class="form-control" name="date" value="{{ $model->date }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount_taxable" class="col-md-4 col-form-label text-md-right">{{ __('New Taxable Amount') }}</label>

                            <div class="col-md-6">
                                <input id="amount_taxable" type="text" class="form-control @error('amount_taxable') is-invalid @enderror" name="amount_taxable" value="{{ old('amount_taxable') }}">

                                @error('amount_taxable')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount_pay" class="col-md-4 col-form-label text-md-right">{{ __('New Paid Amount') }}</label>

                            <div class="col-md-6">
                                <input id="amount_pay" readonly="" type="text" class="form-control @error('amount_pay') is-invalid @enderror" name="amount_pay" value="{{ old('amount_pay') }}">

                                @error('amount_pay')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('head')
<script src="{{ asset('js/pages/payments.edit.js') }}" defer></script>
<script>
var rate_value = {!! json_encode($rate) !!};
</script>

@endpush
