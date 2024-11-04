<?php

namespace Raakkan\OnlyLaravel\Admin\Forms\Components;

use Illuminate\Support\Facades\Blade;

class ImageUpload extends Field
{
    protected ?string $wireModel = '';
    
    protected ?string $accept = 'image/*';
    
    protected bool $multiple = false;
    
    protected ?int $maxSize = null;
    protected ?string $previewUrl = null;
    protected ?string $uploadFolder = null;
    
    public static function make(string $name): static
    {
        return new static($name);
    }
    
    public function wireModel(string $wireModel): static
    {
        $this->wireModel = $wireModel;
        
        return $this;
    }
    
    public function accept(string $accept): static
    {
        $this->accept = $accept;
        
        return $this;
    }
    
    public function multiple(bool $multiple = true): static
    {
        $this->multiple = $multiple;
        
        return $this;
    }
    
    public function maxSize(int $sizeMB): static
    {
        $this->maxSize = $sizeMB;
        
        return $this;
    }

    public function previewUrl(string $previewUrl): static
    {
        $this->previewUrl = $previewUrl;
        
        return $this;
    }

    public function uploadFolder(string $folder): static
    {
        $this->uploadFolder = $folder;
        
        return $this;
    }

    public function getUploadFolder(): string|null
    {
        return $this->uploadFolder;
    }
    
    public function render(): string
    {
        return Blade::render(<<<'blade'
            <div x-data="{
                isUploading: false,
                progress: 0,
                previewUrl: '{{ $previewUrl }}',
            }" class="space-y-2" @image-removed.window="$event.detail.key === '{{ $name }}' ? previewUrl = '' : null">
                <div class="flex justify-between items-center">
                    <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                    <button 
                        x-show="previewUrl"
                        type="button" 
                        wire:click="removeImage('{{ $name }}')"
                        class="text-sm text-red-600 hover:text-red-800"
                    >
                        Remove
                    </button>
                </div>
                
                <input type="file" 
                    wire:model="{{ $wireModel }}"
                    accept="{{ $accept }}"
                    class="hidden"
                    id="{{ $wireModel }}"
                    {{ $multiple ? 'multiple' : '' }}
                    {{ $maxSize ? 'max="' . ($maxSize * 1024) . '"' : '' }}
                    x-on:change="previewUrl = URL.createObjectURL($event.target.files[0])"
                >
                
                <label for="{{ $wireModel }}" 
                    class="cursor-pointer block relative w-full h-40 border-2 border-gray-300 border-dashed rounded-lg overflow-hidden"
                    x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false; progress = 0"
                    x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                >
                    <template x-if="previewUrl">
                        <img :src="previewUrl" class="w-full h-full object-cover" alt="Preview image"/>
                    </template>

                    <template x-if="!previewUrl">
                        <div class="flex items-center justify-center w-full h-full text-gray-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </template>

                    <!-- Loading Overlay -->
                    <div x-show="isUploading" 
                        class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                        <div class="text-center">
                            <div class="mb-2 text-gray-700" x-text="`${progress}%`"></div>
                            <div class="w-32 bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" 
                                    :style="`width: ${progress}%`">
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
                
                @error($wireModel)
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        blade, [
            'label' => $this->label,
            'name' => $this->name,
            'required' => $this->required,
            'helperText' => $this->helperText,
            'accept' => $this->accept,
            'multiple' => $this->multiple,
            'maxSize' => $this->maxSize,
            'previewUrl' => $this->previewUrl,
            'wireModel' => $this->wireModel,
        ]);
    }
}