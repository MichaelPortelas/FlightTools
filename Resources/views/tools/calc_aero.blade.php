@extends('app')
@section('title', __('common.dashboard'))

@section('content')
<div class="row justify-content-center">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="col-md-10">        
        <form class="form" action="{{ route('FlTools.calc_aero.calculate') }}" method="post">
            @csrf
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        @lang('FlTools::tools.AviationMetricsCalculator')
                        <i class="fas fa-calculator ms-auto"></i>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="indicatedAirspeed" class="form-label">@lang('FlTools::tools.IndicatedAirspeed') *</label>
                                <div class="input-group">                            
                                    <input class="form-control" name="indicatedAirspeed" id="indicatedAirspeed" type="number" value="{{ old('indicatedAirspeed', session('indicatedAirspeed', $indicatedAirspeed)) }}" maxlength="3">
                                    <span class="input-group-text">Kts</span>
                                </div>
                                @error('indicatedAirspeed')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="altitude" class="form-label">@lang('FlTools::tools.Altitude') *</label>
                                <div class="input-group">                            
                                    <input class="form-control" name="altitude" id="altitude" type="number" value="{{ old('altitude', session('altitude', $altitude)) }}" maxlength="3">
                                    <span class="input-group-text">Ft</span>
                                </div>
                                @error('altitude')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="magneticHeading" class="form-label">@lang('FlTools::tools.MagneticHeading') *</label>
                                <div class="input-group">
                                    <input class="form-control" name="magneticHeading" id="magneticHeading" type="number" value="{{ old('magneticHeading', session('magneticHeading', $magneticHeading)) }}" maxlength="3">
                                    <span class="input-group-text">°</span>
                                </div>
                                @error('magneticHeading')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="distance" class="form-label">@lang('FlTools::tools.Distance') *</label>
                                <div class="input-group">
                                    <input class="form-control" name="distance" id="distance" type="number" value="{{ old('distance', session('distance', $distance)) }}" maxlength="5">
                                    <span class="input-group-text">Nm</span>
                                </div>
                                @error('distance')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="windOrigin" class="form-label">@lang('FlTools::tools.WindOrigin') *</label>
                                <div class="input-group">
                                    <input class="form-control" name="windOrigin" id="windOrigin" type="number" value="{{ old('windOrigin', session('windOrigin', $windOrigin)) }}" maxlength="3">
                                    <span class="input-group-text">°</span>
                                </div>
                                @error('windOrigin')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="windSpeed" class="form-label">@lang('FlTools::tools.WindSpeed') *</label>
                                <div class="input-group">
                                    <input class="form-control" name="windSpeed" id="windSpeed" type="number" value="{{ old('windSpeed', session('windSpeed', $windSpeed)) }}" maxlength="3">
                                    <span class="input-group-text">Kts</span>
                                </div>
                                @error('windSpeed')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="temperature" class="form-label">@lang('FlTools::tools.Temperature') *</label>
                                <div class="input-group">
                                    <input class="form-control" name="temperature" id="temperature" type="number" value="{{ old('temperature', session('temperature', $temperature)) }}" maxlength="2">
                                    <span class="input-group-text">°C</span>
                                </div>
                                @error('temperature')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-text mb-3">* @lang('FlTools::tools.RequiredFields')</div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plane me-2"></i> @lang('FlTools::tools.CalculateMetrics')
                        </button>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <p class="mb-0">Enhanced by <a href="https://github.com/MichaelPortelas" target="_blank"><strong>Michael.P</strong></a></p>
                </div>
            </div>
        </form>
    </div>
</div>

@if(session('calcAero'))
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0 d-flex align-items-center">@lang('FlTools::tools.AviationMetricsResults')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $results = [
                            ['label' => __('FlTools::tools.TrueAirspeed'), 'value' => session('trueAirspeed'), 'unit' => 'Kts'],                            
                            ['label' => __('FlTools::tools.BaseFactor'), 'value' => session('baseFactor'), 'unit' => session('baseFactorUnit')],
                            ['label' => __('FlTools::tools.NoWindTime'), 'value' => session('noWindTime'), 'unit' => 'Min'],
                            ['label' => __('FlTools::tools.WindAngle'), 'value' => session('windAngle')['angle'], 'unit' => '°'],
                            ['label' => __('FlTools::tools.EffectiveWind'), 'value' => session('effectiveWind'), 'unit' => 'Kts'],
                            ['label' => __('FlTools::tools.MaximumDrift'), 'value' => session('maximumDrift'), 'unit' => '°'],
                            ['label' => __('FlTools::tools.SineOfWindAngle'), 'value' => session('sineOfWindAngle')['sine'], 'unit' => ''],
                            ['label' => __('FlTools::tools.Drift'), 'value' => session('drift'), 'unit' => '°'],
                            ['label' => __('FlTools::tools.GroundSpeed'), 'value' => session('groundSpeed'), 'unit' => 'Kts'],
                            ['label' => __('FlTools::tools.NewBaseFactor'), 'value' => session('newBaseFactor'), 'unit' => session('newBaseFactorUnit')],
                            ['label' => __('FlTools::tools.WindAffectedTime'), 'value' => session('windAffectedTime'), 'unit' => 'Min'],
                        ];
                    @endphp
                    
                    @foreach ($results as $result)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column justify-content-center text-center">
                                    <h5 class="card-title">{{ $result['label'] }}</h5>
                                    <div class="display-4">
                                        {{ $result['value'] }}
                                        @if($result['unit'])
                                            <span class="text-muted">{{ $result['unit'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
