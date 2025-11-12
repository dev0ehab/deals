@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{--@bsMultilangualFormTabs--}}
{{ BsForm::text('name')->required() }}
{{--@endBsMultilangualFormTabs--}}

<div class="form-group col-12">
    <h5>@lang('roles::roles.attributes.permissions')</h5>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>@lang('roles::roles.attributes.model')</th>
            <th>@lang('roles::roles.attributes.permissions')</th>
        </tr>
        </thead>
        <tbody>

        @php
            $config = Config::get('laratrust_seeder.roles_structure.super_admin');
            $mapPermission = collect(config('laratrust_seeder.permissions_map'));
        @endphp

        @foreach ($config as $key => $modules)
            <tr>
                <td>@lang('roles::roles.models.' . $key)</td>
                <td>
                    <select name="permissions[]" class="form-control selectpicker" data-live-search="true" data-actions-box="true" multiple>
                        @foreach (explode(',', $modules) as $p => $perm)
                            @php
                                $permissionValue = $mapPermission->get($perm)
                            @endphp
                            @if($permissionValue)
                                <option
                                    value="{{ $permissionValue . '_' . $key }}"
                                    @isset($role)
                                    @if($role->hasPermission($permissionValue . '_' . $key)) selected @endif
                                    @endisset
                                >@lang('roles::roles.permission_maps.' . $permissionValue)</option>
                            @endif
                        @endforeach
                    </select>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
</div>
