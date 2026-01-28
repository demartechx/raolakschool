<x-app-layout>
    <x-slot name="header">
        <h2 class="font-medium text-xl text-zinc-100 tracking-tight">
            {{ __('Academics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-zinc-900/50 overflow-hidden shadow-sm sm:rounded-2xl border border-zinc-800/80 backdrop-blur-sm">
                <div class="p-8 md:p-10">

                    <div class="mb-10 text-center">
                        <h1 class="text-3xl font-light tracking-tighter text-white mb-2">2026 Academic Session</h1>
                        <p class="text-zinc-400">Secure your spot in the next cohort.</p>
                    </div>

                    <!-- Admission Information -->
                    <div class="mb-10 p-8 bg-zinc-950/50 rounded-xl border border-zinc-800/50">
                        <h3 class="text-lg font-medium text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Admission Details
                        </h3>
                        <ul class="space-y-4 text-sm text-zinc-300">
                            <li class="flex items-start gap-4">
                                <div class="mt-1 w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></div>
                                <span class="leading-relaxed"><strong class="text-white font-medium">Status:</strong>
                                    Admission is currently ongoing (Tuition Free).</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 w-1.5 h-1.5 rounded-full bg-zinc-600 shrink-0"></div>
                                <span class="leading-relaxed"><strong class="text-white font-medium">Duration:</strong>
                                    Program runs from February to December 2026.</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 w-1.5 h-1.5 rounded-full bg-zinc-600 shrink-0"></div>
                                <span class="leading-relaxed"><strong class="text-white font-medium">Application
                                        Fee:</strong> ₦25,000 (One-time payment).</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 w-1.5 h-1.5 rounded-full bg-zinc-600 shrink-0"></div>
                                <span class="leading-relaxed"><strong class="text-white font-medium">Courses:</strong>
                                    Choose between Graphics Design or Programming.</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></div>
                                <span class="leading-relaxed"><strong class="text-white font-medium">Capacity:</strong>
                                    Limited to <strong class="text-white">30 students</strong> per course.</span>
                            </li>
                            <li class="flex items-start gap-4 pt-4 border-t border-zinc-800/50 mt-4">
                                <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                                <span class="text-yellow-500/90 font-medium">Please ensure your wallet is funded with at
                                    least ₦25,000 before applying.</span>
                            </li>
                        </ul>
                    </div>

                    @if(Auth::user()->enrollment)
                        @if(Auth::user()->enrollment->status === 'admitted')
                            <div class="mt-8 p-12 bg-emerald-950/20 border border-emerald-500/20 rounded-2xl text-center">
                                <div
                                    class="w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-medium text-white mb-2 tracking-tight">Congratulations!</h3>
                                <p class="text-zinc-300 max-w-md mx-auto mb-2">You have been <span
                                        class="text-emerald-400 font-bold">admitted</span> into the program.</p>
                                <p class="text-emerald-400 font-medium">Classes start on <strong>
                                        @if(Auth::user()->enrollment->course === 'Programming')
                                            February 5th at 1:30 PM
                                        @else
                                            February 6th at 10:00 AM
                                        @endif
                                    </strong>.</p>

                                <a href="{{ route('dashboard') }}"
                                    class="inline-block mt-8 text-sm text-zinc-400 hover:text-white transition-colors border-b border-zinc-700 hover:border-zinc-500 pb-0.5">Go
                                    to Dashboard</a>
                            </div>
                        @elseif(Auth::user()->enrollment->status === 'rejected')
                            <div class="mt-8 p-12 bg-red-950/20 border border-red-500/20 rounded-2xl text-center">
                                <div class="w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-medium text-white mb-2 tracking-tight">Application Declined</h3>
                                <p class="text-zinc-300 max-w-md mx-auto">We regret to inform you that your application was
                                    <span class="text-red-400 font-bold">not successful</span> this time.
                                </p>
                                <p class="text-zinc-400 mt-2">Please try again next year.</p>

                                <a href="{{ route('dashboard') }}"
                                    class="inline-block mt-8 text-sm text-zinc-400 hover:text-white transition-colors border-b border-zinc-700 hover:border-zinc-500 pb-0.5">Return
                                    to Dashboard</a>
                            </div>
                        @else
                            <div class="mt-8 p-12 bg-zinc-950/30 border border-zinc-800/50 rounded-2xl text-center">
                                <div
                                    class="w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-medium text-white mb-2 tracking-tight">Application Received</h3>
                                <p class="text-zinc-400 max-w-md mx-auto">Your admission status is currently <span
                                        class="text-yellow-500">pending</span>. Please observe your dashboard for updates.</p>

                                <a href="{{ route('dashboard') }}"
                                    class="inline-block mt-8 text-sm text-zinc-400 hover:text-white transition-colors border-b border-zinc-700 hover:border-zinc-500 pb-0.5">Return
                                    to Overview</a>
                            </div>
                        @endif
                    @else
                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
                                <ul class="list-disc list-inside text-sm text-red-400 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(now()->greaterThanOrEqualTo('2026-02-10'))
                            <div class="mt-8 p-12 bg-red-950/20 border border-red-500/20 rounded-2xl text-center">
                                <div class="w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-medium text-white mb-2 tracking-tight">Registration Closed</h3>
                                <p class="text-zinc-300 max-w-md mx-auto">We are no longer accepting applications for the 2026
                                    academic session as the deadline has passed.</p>
                                <p class="text-zinc-400 mt-2">Please check back later for the next cohort.</p>

                                <a href="{{ route('dashboard') }}"
                                    class="inline-block mt-8 text-sm text-zinc-400 hover:text-white transition-colors border-b border-zinc-700 hover:border-zinc-500 pb-0.5">Return
                                    to Dashboard</a>
                            </div>
                        @else
                            <!-- Enrollment Form -->
                            <form method="POST" action="{{ route('student.enroll.store') }}" class="max-w-xl mx-auto">
                                @csrf

                                <div class="mb-8">
                                    <label for="course" class="block text-sm font-medium text-zinc-400 mb-2">Select
                                        Course</label>
                                    <div class="relative">
                                        <select id="course" name="course"
                                            class="w-full appearance-none bg-zinc-950 border border-zinc-700 rounded-lg py-4 px-5 text-white focus:border-white focus:ring-0 focus:outline-none transition-colors cursor-pointer"
                                            required>
                                            <option value="" disabled selected>Choose a course...</option>
                                            <option value="Graphics Design" {{ $graphicsCount >= 30 ? 'disabled' : '' }}>
                                                Graphics Design ({{ $graphicsCount }}/30)
                                                {{ $graphicsCount >= 30 ? '— [FULL]' : '' }}
                                            </option>
                                            <option value="Programming" {{ $programmingCount >= 30 ? 'disabled' : '' }}>
                                                Programming ({{ $programmingCount }}/30)
                                                {{ $programmingCount >= 30 ? '— [FULL]' : '' }}
                                            </option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-zinc-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-center">
                                    <button type="submit"
                                        class="w-full py-4 bg-white text-black font-bold text-base rounded-xl hover:bg-zinc-200 transition-colors shadow-lg shadow-white/5">
                                        Submit Application (₦25,000)
                                    </button>
                                </div>
                            </form>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>