@if (count($service->SubServices) > 0)
    <div class="form-group">
        <label for="{{ $service->id }}">{{ $service->translate($code)->name }}</label>
        <select class="form-control" name="services[{{ $service->id }}]" id="{{ $service->id }}"
            onchange="getChild(this)">
            <option value="0">{{ __('Select one') }}</option>
            @forelse ($service->SubServices as $subService)
                <option value="{{ $subService->id }}">
                    {{ $subService->translate($code)->name }}
                </option>
            @empty
            @endforelse
        </select>
    </div>
@endif
