@extends('app')
@section('title', __('common.dashboard'))

@section('content')
<div class="row justify-content-center">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="col-md-6">        
        <form class="form" action="{{ route('FlTools.calc_tod.calculate') }}" method="post">
            @csrf
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        @lang('FlTools::tools.CalcTod_title')
                        <i class="fas fa-solid fa-calculator ms-auto"></i>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="actfl" class="form-label">@lang('FlTools::tools.Actfl')</label>
                        <div class="input-group">
                            <span class="input-group-text">FL</span>
                            <input class="form-control" name="actfl" id="actfl" size="5" type="number" placeholder="{{ old('actfl') ?: session('actfl', $actfl) }}" minlength="1" maxlength="3">
                        </div>
                        @error('actfl')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="fixfl" class="form-label">@lang('FlTools::tools.Fixfl')</label>
                        <div class="input-group">
                            <span class="input-group-text">FL</span>
                            <input class="form-control" name="fixfl" id="fixfl" size="5" type="number" placeholder="{{ old('fixfl') ?: session('fixfl', $fixfl) }}" minlength="1" maxlength="3">
                        </div>
                        @error('fixfl')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="gspeed" class="form-label">@lang('FlTools::tools.Gspeed')</label>
                        <div class="input-group">
                            <input class="form-control" name="gspeed" id="gspeed" size="5" type="number" placeholder="{{ old('gspeed') ?: session('gspeed', $gspeed) }}" minlength="2" maxlength="3">
                            <span class="input-group-text">Kt</span>
                        </div>
                        @error('gspeed')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button name="btntrl" type="submit" id="btntod" class="btn btn-sm btn-success"><i class="fas fa-solid fa-plane me-2"></i> @lang('FlTools::tools.CalcTodBtn')</button>
                    </div>
                </div>
                <div class="card-footer p-1 text-end">
                    <p>Enhanced by <a href="https://github.com/MichaelPortelas" target="_blank"><strong>Michael.P</strong></a></p>
                </div>
            </div>
        </form>
    </div>
</div>

@if(session('calcTod'))
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0 text-center">@lang('FlTools::tools.Results')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col"></div> 
                    <div class="col-md-6"> 
                        <div class="table-responsive">
                            <table class="table table-sm table-striped text-center">
                                <tbody>
                                    <tr>
                                        <td><strong>@lang('FlTools::tools.TodDist')</strong></td>
                                        <td><strong>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</strong></td>
                                        <td><strong>@lang('FlTools::tools.TodVSpeed')</strong></td>
                                    </tr>
                                    <tr>
                                        <td>{{ session('tod') }} nm</td>
                                        <td>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</td>
                                        <td>- {{ session('vSpeed') }} fpm</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>                        
                    </div>
                    <div class="col"></div> 
                </div>
                <div class="row">
                    <div class="text-center">
                        <h6><strong>@lang('FlTools::tools.FinalResult') :</strong></h6>
                        <p class="fs-3" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);">
                            {!! __('FlTools::tools.TodResult', ['gspeed' => session('gspeed'), 'tod' => session('tod'), 'vSpeed' => session('vSpeed'), 'fixfl' => session('fixfl'), 'actfl' => session('actfl')]) !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
