<x-auth-layout>
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md py-14 px-8 bg-white border border-gray-100 shadow-none md:shadow-sm overflow-hidden rounded-sm">
            <div class="flex flex-row items-center justify-center mb-8">
                <div class="flex items-center">
                    <div class="flex items-center justify-center">
                        <div class=" flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-gray-600 fa-xl"></i>
                        </div>
                    </div>
                    <div class="ml-1 flex flex-row items-center">
                        <span class="text-lg font-semibold text-gray-600">Praktikum</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-6">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="off"
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm  text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('email') border-red-500 @enderror" placeholder="Email">
                    @error('email')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <input type="password" name="password" id="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm text-sm transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:shadow-outline @error('password') border-red-500 @enderror" placeholder="Password">
                    @error('password')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="mr-2">
                        <label for="remember" class="text-sm text-gray-600">Remember me</label>
                    </div>
                </div>

                <div class="flex flex-col space-y-4">
                    <button type="submit"
                        class="bg-blue-500 text-white cursor-pointer hover:bg-blue-600 font-medium transition-all duration-300 text-sm py-2 px-2 rounded focus:outline-none focus:shadow-outline w-full">
                        Login
                    </button>

                    <p class="text-center text-gray-600 text-sm">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">Register</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-auth-layout>