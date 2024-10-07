<div class="my-4">
    @if (is_array($getState()))
        <div>
            @foreach ($getState() as $key => $item)
                <div class="flex justifiy-start gap-4">
                    @php
                        $language = Raakkan\OnlyLaravel\Translation\Models\Language::getDefaultLanguage();
                    @endphp

                    @if ($key == $language->locale)
                        <div>{{ $item }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
