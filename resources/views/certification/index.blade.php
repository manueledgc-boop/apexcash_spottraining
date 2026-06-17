<x-app-layout>

    <div class="max-w-5xl mx-auto px-6 py-8">

        <div class="bg-slate-900 rounded-xl p-8 border border-slate-700">

            <h1 class="text-3xl font-bold mb-4">
                ApexCash Certification
            </h1>

            @if(session('error'))
                <div class="bg-red-900 text-red-100 p-4 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-900 text-green-100 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(!$certificationUnlocked)

                <div class="text-center py-8">

                    <div class="text-6xl mb-4">🔒</div>

                    <h2 class="text-2xl font-semibold mb-2">
                        Bloqueado por progreso
                    </h2>

                    <p class="text-slate-300">
                        Debes completar la ruta ApexCash antes de acceder
                        al examen de certificación.
                    </p>

                </div>

            @else

                <div class="text-center py-8">

                    <div class="text-6xl mb-4">🎓</div>

                    <h2 class="text-2xl font-semibold mb-4">
                        Examen Final ApexCash
                    </h2>

                    <div class="space-y-2 text-slate-300">

                        <p>75 preguntas totales.</p>

                        <p>15 Preflop</p>
                        <p>15 Flop</p>
                        <p>15 Turn</p>
                        <p>15 River</p>
                        <p>15 Mastery</p>

                        <br>

                        <p>75% mínimo global para aprobar.</p>

                        <p>60% mínimo en cada bloque.</p>

                        <p>
                            Si suspendes deberás esperar
                            7 días antes de volver a presentarte.
                        </p>

                    </div>

                    <form
                        method="POST"
                        action="{{ route('certification.start') }}"
                        class="mt-8"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="px-8 py-4 bg-emerald-600 hover:bg-emerald-500 rounded-lg font-bold"
                        >
                            Comenzar Examen
                        </button>

                    </form>

                </div>

            @endif

            @if($passedAttempt)

                <div class="mt-10 border-t border-slate-700 pt-6">

                    <h3 class="text-xl font-semibold mb-2">
                        Certificación obtenida
                    </h3>

                    <p>
                        Estado:
                        {{ $passedAttempt->resultBadge() }}
                    </p>

                    <p>
                        Código:
                        {{ $passedAttempt->certificate_code }}
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>