@extends('installer::layouts.app')

@section('template_title')
    {{ trans('installer::installer.environment.wizard.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-magic fa-fw" aria-hidden="true"></i>
    {!! trans('installer::installer.environment.wizard.title') !!}
@endsection

@section('container')
    <div class="tabs tabs-full">

        <input id="tab1" type="radio" name="tabs" class="tab-input" checked/>
        <label for="tab1" class="tab-label">
            <i class="fa fa-cog fa-2x fa-fw" aria-hidden="true"></i>
            <br/>
            {{ trans('installer::installer.environment.wizard.tabs.environment') }}
        </label>

        <input id="tab2" type="radio" name="tabs" class="tab-input"/>
        <label for="tab2" class="tab-label">
            <i class="fa fa-database fa-2x fa-fw" aria-hidden="true"></i>
            <br/>
            {{ trans('installer::installer.environment.wizard.tabs.database') }}
        </label>

        <input id="tab3" type="radio" name="tabs" class="tab-input"/>
        <label for="tab3" class="tab-label">
            <i class="fa fa-cogs fa-2x fa-fw" aria-hidden="true"></i>
            <br/>
            {{ trans('installer::installer.environment.wizard.tabs.application') }}
        </label>

        <input id="tab4" type="radio" name="tabs" class="tab-input"/>
        <label for="tab4" class="tab-label">
            <i class="fa fa-cogs fa-2x fa-fw" aria-hidden="true"></i>
            <br/>
            {{ trans('installer::installer.environment.wizard.tabs.style') }}
        </label>

        {{--        <input id="tab5" type="radio" name="tabs" class="tab-input"/>--}}
        {{--        <label for="tab5" class="tab-label">--}}
        {{--            <i class="fa fa-user fa-2x fa-fw" aria-hidden="true"></i>--}}
        {{--            <br/>--}}
        {{--            {{ trans('installer::installer.environment.wizard.tabs.admin') }}--}}
        {{--        </label>--}}

        <form method="post" action="{{ route('installer.environmentSaveWizard') }}" class="tabs-wrap">
            @csrf
            <div class="tab" id="tab1content">
                @include('installer::environment.partials.environment')
            </div>
            <div class="tab" id="tab2content">
                @include('installer::environment.partials.database')
            </div>
            <div class="tab" id="tab3content">
                @include('installer::environment.partials.application')
            </div>
            <div class="tab" id="tab4content">
                @include('installer::environment.partials.style')
            </div>
            {{--            <div class="tab" id="tab5content">--}}
            {{--                @include('installer::environment.partials.admin')--}}
            {{--            </div>--}}
        </form>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function checkEnvironment(val) {
            var element = document.getElementById('environment_text_input');
            if (val == 'other') {
                element.style.display = 'block';
            } else {
                element.style.display = 'none';
            }
        }

        function showDatabaseSettings() {
            document.getElementById('tab2').checked = true;
        }

        function showApplicationSettings() {
            document.getElementById('tab3').checked = true;
        }

        function showStyleSettings() {
            document.getElementById('tab4').checked = true;
        }

        function showAdminSettings() {
            document.getElementById('tab5').checked = true;
        }
    </script>
@endsection
