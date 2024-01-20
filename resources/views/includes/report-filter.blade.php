<x-form action="{{route('report.index')}}"  method="get" class="mt-3">
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="mb-3">
                <x-label class="text-muted h6" for="from_date">{{ __('Начиная от') }}</x-label>
                <x-input type="date" name="from_date" value="{{ request('from_date') }}" placeholder="{{ __('Начиная от') }}" />
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="mb-3">
                <x-label class="text-muted h6" for="to_date">{{ __('Заканчивая до') }}</x-label>
                <x-input type="date" name="to_date" value="{{ request('to_date') }}" placeholder="{{ __('Заканчивая до') }}" />
            </div>
        </div>

          <div class="col-12 col-md-4">
            <div class="">
                <x-label class="text-muted h6" for="search">{{ __('Жми сюда') }}</x-label>
                <x-button type="submit" class="w-100 btn btn-dark">
                    {{ __('Подсчитать') }}
                </x-button>
            </div>
        </div>
    </div>
</x-form>