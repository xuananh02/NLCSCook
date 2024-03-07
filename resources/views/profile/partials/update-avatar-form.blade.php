<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Ảnh Đại Diện') }}
        </h2>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" enctype="multipart/form-data" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <img src="{{ Auth::user()->pathAvatar }}" alt="Current Avatar" class="w-20 h-20 rounded-full">
        </div>


        <div>
            <x-input-label for="upload" :value="__('Avatar')" />
            <input multiple type="file" id="upload" name="upload" type="text" class="mt-1 block w-full"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('upload')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Lưu') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Lưu.') }}</p>
            @endif
        </div>
    </form>
</section>
