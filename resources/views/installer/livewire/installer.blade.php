<div
    class="bg-gradient-to-br from-purple-200 to-pink-200 min-h-screen flex items-center justify-center flex-col p-2 sm:p-4">
    <div class="flex mb-8 justify-center text-4xl sm:text-5xl text-purple-900 font-extrabold">
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600">Installer</span>
    </div>

    <div class="bg-white bg-opacity-80 backdrop-blur-lg rounded-3xl shadow-2xl p-4 sm:p-10 w-full max-w-3xl">
        @error('step')
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ $message }}
            </div>
        @enderror

        @foreach ($this->getSteps() as $stepKey => $step)
            @if ($currentStep === $stepKey)
                <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-purple-800">{{ $step->getTitle() }}</h2>
                {{ $step->render() }}
            @endif
        @endforeach

        <div class="mt-10 flex flex-col sm:flex-row justify-between sm:space-x-4">
            <div class="flex-1 order-2 sm:order-1">
                @if ($currentStep !== array_key_first($this->getSteps()))
                    <button wire:click="previousStep"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-full transition duration-300 ease-in-out transform hover:-translate-y-1 w-full">
                        ← Back
                    </button>
                @endif
            </div>

            <div class="flex-1 order-1 sm:order-2 mb-4 sm:mb-0">
                @if ($currentStep !== array_key_last($this->getSteps()))
                    <button wire:click="nextStep"
                        class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-full transition duration-300 ease-in-out transform hover:-translate-y-1 w-full">
                        Next →
                    </button>
                @else
                    <button wire:click="finishInstallation"
                        class="bg-gradient-to-r from-green-400 to-blue-500 hover:from-green-500 hover:to-blue-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-full transition duration-300 ease-in-out transform hover:-translate-y-1 w-full">
                        Complete Installation ✨
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
