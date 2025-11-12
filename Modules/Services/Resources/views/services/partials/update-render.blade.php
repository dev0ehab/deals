@isset($product)
    @if (count($product->SubServices) > 0)
        @forelse ($product->SubServices as $subService)
            <div class='sub' id="sub{{ $subService->parentService->parent->id ?? "" }}" data-step="{{ $subService->parentService->parent->id ?? "" }}">
                <div class="form-group">
                    <label for="{{ $subService->parentService->id }}">{{ $subService->parentService->name }}</label>
                    <select class="form-control" name="services[{{ $subService->parentService->id }}]"
                        id="{{ $subService->parentService->id }}" onchange="getChild(this)">
                        <option value="0">{{ __('Select one') }}</option>
                        @forelse ($subService->parentService->subServices as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $subService->child ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
        @empty
        @endforelse
    @endif
@endisset
