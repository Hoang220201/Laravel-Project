<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-5">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-white">
                                {{ __('Sign up to receive emails') }}
                            </h2>

                        </header>
                        <form method="post" action="{{ route('send.email') }}" class="mt-6 space-y-6">
                            @csrf

                            <div class="form-group row">
                                <x-input-label for="name" :value="__('Name')" />
                                    <input id="name" type="text" placeholder="Enter your name" class="form-control @error('name') is-invalid @enderror" name="name" 
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div class="form-group row">
                                <x-input-label for="email" :value="__('Email')" />
                                    <input id="email" type="email" placeholder="Enter your email" class="form-control @error('email') is-invalid @enderror" name="email" 
                                    value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror  
                            </div>
                          
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Sign up') }}</x-primary-button>
                            </div>
                        </form>
                        
                    </section>

            </div>
        </div>
    </div>

</x-app-layout>
