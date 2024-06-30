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
        <form class="form" action="{{ route('FlTools.calc_trl.calculate') }}" method="post">
            @csrf
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        @lang('FlTools::tools.CalcTrl_title')
                        <i class="fas fa-solid fa-calculator ms-auto"></i>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="qnh" class="form-label">@lang('FlTools::tools.QnhCur')</label>
                        <div class="input-group">
                            <input class="form-control" name="qnh" id="qnh" size="5" type="number" placeholder="{{ old('qnh') ?: session('qnh', $qnh) }}" minlength="3" maxlength="4">
                            <span class="input-group-text">Hpa</span>
                        </div>
                        @error('qnh')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="ta" class="form-label">@lang('FlTools::tools.Ta')</label>
                        <div class="input-group">
                            <input class="form-control" name="ta" id="ta" size="5" type="number" placeholder="{{ old('ta') ?: session('ta', $ta) }}" minlength="4" maxlength="5">
                            <span class="input-group-text">Ft</span>
                        </div>
                        @error('ta')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button name="btntrl" type="submit" id="btntrl" class="btn btn-sm btn-success"><i class="fas fa-solid fa-plane me-2"></i> @lang('FlTools::tools.CalcTrlBtn')</button>
                    </div>
                </div>
                <div class="card-footer p-1 text-end">
                    <p>Enhanced by <a href="https://github.com/MichaelPortelas" target="_blank"><strong>Michael.P</strong></a></p>
                </div>
            </div>
        </form>
    </div>
</div>

@if(session('calcTrl'))
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
                                        <td><strong>Altitude 1013 :</strong> {{ session('alt1013') }} Ft</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped text-center">
                                <tbody>
                                    <tr>
                                        <td><strong>FLeq10</strong></td>
                                        <td><strong>TRL</strong></td>
                                        <td><strong>FLeq20</strong></td>
                                    </tr>
                                    <tr>
                                        <td>FL{{ session('flEq10') }}</td>
                                        <td>FL{{ session('trl') }}</td>
                                        <td>FL{{ session('flEq20') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="text-center">
                            <h6><strong>@lang('FlTools::tools.FinalResult') :</strong></h6>
                            <p class="fs-2" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);">@lang('FlTools::tools.TrlResult') <strong>FL{{ session('trl') }}</strong></p>
                        </div>
                    </div>
                    <div class="col"></div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
