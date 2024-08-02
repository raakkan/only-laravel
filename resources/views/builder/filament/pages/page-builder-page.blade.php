<div>
    {{ Vite::useHotFile(storage_path('vite.hot'))->useBuildDirectory('build')->withEntryPoints(['resources/css/base.css', 'resources/js/page-builder.ts']) }}
    <div class="mt-4 flex flex-wrap w-full">
        @php
            $builder = $this->getPageBuilder();
        @endphp

        <div class="w-full md:w-1/4">
            <div class="bg-white shadow p-4 mr-2 cursor-move h" draggable="true"
                x-on:dragstart="event.dataTransfer.setData('text/plain', JSON.stringify({
        name: 'div',
        label: 'Div',
        type: 'block'
    }))">
                block
            </div>

        </div>

        <div class="space-y-2 w-full md:w-3/4">
            @if ($builder->hasHeader())
                <livewire:theme::builder.livewire.block :block="[
                    'name' => 'header',
                    'label' => 'Header',
                    'type' => 'block',
                ]" :key="'header'" />
            @endif
        </div>
        <button wire:click="save">Save</button>

        {{-- <div class="w-full md:w-3/4">
            <div class="space-y-2">
                @if ($builder->hasHeader())
                    @livewire('theme::builder.livewire.block', key('header'))
                @endif
            </div>

            @if ($builder->hasHeroSection())
                <div class="bg-white shadow mt-4">
                    <x-themes-manager::builder.header title="Hero section" />
                </div>
            @endif

            @if ($builder->hasSidebar())
                @php
                    $sidebar = $builder->getSidebar();
                @endphp

                @if ($sidebar === 'left')
                    <div class="flex flex-wrap w-full mt-4">
                        <div class="w-full md:w-1/4">
                            <aside class="bg-white shadow">
                                <x-themes-manager::builder.header title="Sidebar" />
                            </aside>
                        </div>
                        <div class="w-full md:w-3/4 pl-2">
                            <div class="bg-white shadow">
                                <x-themes-manager::builder.header title="Content" />
                            </div>
                        </div>
                    </div>
                @endif

                @if ($sidebar === 'right')
                    <div class="flex flex-wrap w-full mt-4">
                        <div class="w-full md:w-3/4 pr-2">
                            <div class="bg-white shadow">
                                <x-themes-manager::builder.header title="Content" />
                            </div>
                        </div>
                        <div class="w-full md:w-1/4">
                            <aside class="bg-white shadow">
                                <x-themes-manager::builder.header title="Sidebar" />
                            </aside>
                        </div>
                    </div>
                @endif
            @else
                <div class="bg-white shadow mt-4">
                    <x-themes-manager::builder.header title="Content" />
                </div>
            @endif

            @if ($builder->hasCallToAction())
                <div class="bg-white shadow mt-4">
                    <x-themes-manager::builder.header title="Call to action" />
                </div>
            @endif

            @if ($builder->hasFooter())
                <div class="bg-white shadow mt-4">
                    <x-themes-manager::builder.header title="Footer" />
                </div>
            @endif
        </div> --}}
    </div>
</div>
