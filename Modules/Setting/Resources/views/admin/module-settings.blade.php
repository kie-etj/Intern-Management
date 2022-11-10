@extends('layouts.master')

@section('content-header')
<h1>
    {{ trans('setting::settings.title.module name settings', ['module' => ucfirst($currentModule)]) }}
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ route('admin.setting.settings.index') }}"><i class="fa fa-cog"></i> {{ trans('setting::settings.breadcrumb.settings') }}</a></li>
    <li class="active"><i class="fa fa-cog"></i> {{ trans('setting::settings.breadcrumb.module settings', ['module' => ucfirst($currentModule)]) }}</li>
</ol>
@stop

@section('content')
{!! Form::open(['route' => ['admin.setting.settings.store'], 'method' => 'post']) !!}
<div class="row">
    <div class="sidebar-nav col-sm-2">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ trans('setting::settings.title.module settings') }}</h3>
            </div>
            <style>
                a.active {
                    text-decoration: none;
                    background-color: #eee;
                }
            </style>
    		<ul class="nav nav-list">
    		    <?php foreach ($modulesWithSettings as $module => $settings): ?>
                    <li>
                        <a href="{{ route('dashboard.module.settings', [$module]) }}"
                            class="{{ $module === $currentModule->getName() ? 'active' : '' }}">
                            {{ ucfirst($module) }}
                        <small class="badge pull-right bg-blue">{{ count($settings) }}</small>
                    </a>
                    </li>
              <?php endforeach; ?>
                <!-- Hanet token -->
                <li>
                    <a style="cursor: pointer" data-toggle="modal" data-target="#modal-hanet">
                        Hanet API
                        <small class="badge pull-right bg-blue">3</small>
                    </a>
                </li>
    		</ul>
    	</div>
    </div>
    <div class="col-md-10">
        <?php if ($translatableSettings): ?>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('core::core.title.translatable fields') }}</h3>
                </div>
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        @include('partials.form-tab-headers')
                        <div class="tab-content">
                            <?php $i = 0; ?>
                            <?php foreach (LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                                <?php $i++; ?>
                                <div class="tab-pane {{ App::getLocale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                                    @include('setting::admin.partials.fields', ['settings' => $translatableSettings])
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($plainSettings): ?>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ trans('core::core.title.non translatable fields') }}</h3>
            </div>
            <div class="box-body">
                @include('setting::admin.partials.fields', ['settings' => $plainSettings])
            </div>
        </div>
        <?php endif; ?>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
            <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.setting.settings.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
        </div>
    </div>
</div>
{!! Form::close() !!}
<!-- Hanet Model -->
<div class="modal fade" id="modal-hanet" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="font-weight: bold;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="modalLabel">Hanet API Update</h3>
            </div>
            {!! Form::open(['route' => ['hanet.token'], 'method' => 'post']) !!}
            <div class="modal-body">
                <div class="box-body">
                        {!! Form::normalInput('hanetToken', 'Token', $errors) !!}

                        {!! Form::normalInput('hanetPlaceID', 'Place ID', $errors) !!}

                        {!! Form::normalInput('hanetDevices', 'Device', $errors) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success pull-left" data-dismiss="modal">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop

@push('js-stack')
<script>
$( document ).ready(function() {
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('input[type="checkbox"]').on('ifChecked', function(){
      $(this).parent().find('input[type=hidden]').remove();
    });

    $('input[type="checkbox"]').on('ifUnchecked', function(){
      var name = $(this).attr('name'),
          input = '<input type="hidden" name="' + name + '" value="0" />';
      $(this).parent().append(input);
    });
});
</script>
<script>
    <?php $data = Session::get('data'); ?>
    const data = <?= json_encode($data) ?>;
    for (const key in data) {
        console.log(key);
        document.getElementById(key).value = data[key];
    }
</script>
@endpush
