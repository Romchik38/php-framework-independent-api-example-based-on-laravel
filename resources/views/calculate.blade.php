@extends('layout')

@section('title', 'Zoo - calculate shipping costs')

@section('content')
    <style>
        .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
        .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
    </style>

    <div class="example-wrapper">
        <h1>Calculate shipping costs</h1>

        <form class="api-calculate-form" action="/api/shipping/calculate" method="post" id="api-calculate-form" name="api-calculate-form">
            <div>
                <label for="{{ $carrier_weight_field }}">Weight(kg):</label>
                <input class="api-calculate-weight" type="number" id="{{ $carrier_weight_field }}" name="{{ $carrier_weight_field }}" min="0" required step="0.001"/>
            </div>
            <div>
                <label for="{{ $carrier_slug_field }}">Carrier:</label>
                <select class="api-calculate-slug" name="{{ $carrier_slug_field }}" required>
                @foreach ($carriers as $carrier)
                    <option value="{{ $carrier->getSlug() }}">{{ $carrier->getName() }}</option>
                @endforeach
                </select>
            </div>
            <div>
                <button class="api-calculate-btn" type="submit">Calculate price</button>
            </div>
            <div class="api-calculate-success_message" style="display:none; color:green"></div>
            <div class="api-calculate-error_message" style="display:none;color:red"></div>
        </form>

        <script type="module" src="/media/js/carrier_calculate_form/index.js" fetchpriority="low"></script>
    </div>
@endsection
