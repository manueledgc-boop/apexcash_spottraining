<x-app-layout>

<link href="{{ asset('assets/css/apexcash-dashboard.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/apexcash-dashboard-polish.css') }}" rel="stylesheet">

<main class="dashboard-page">

    <section class="dashboard-hero dashboard-hero-v2">

        <div class="dashboard-hero-main">

            <span class="dashboard-badge">
                🚀 Founder Members Program 2026
            </span>

            <h1>Solicitud Founder Member</h1>

            <p>

                Estás a punto de solicitar acceso al programa Founder Members.

                Estamos seleccionando personalmente a los primeros jugadores que
                participarán en el lanzamiento oficial de ApexCash Trainer.

            </p>

            <div class="dashboard-next-goal">

                <span>Lanzamiento oficial</span>

                <strong>1 Septiembre 2026</strong>

            </div>

        </div>

    </section>

    <section class="dashboard-grid">

        <article class="dashboard-card">

            <span>Formulario</span>

            <h2>Queremos conocerte</h2>

            <p>

                No buscamos únicamente buenos jugadores.

                Buscamos personas comprometidas que quieran ayudarnos
                a construir la mejor plataforma de entrenamiento de poker.

            </p>

            <form method="POST" action="{{ route('founder.store') }}" class="founder-form">

                @csrf

                <div class="founder-form-group">

                    <label>País</label>

                    <input
                        type="text"
                        name="country"
                        value="{{ old('country') }}"
                    >

                </div>

                <div class="founder-form-group">

                    <label>¿Cuánto tiempo llevas jugando?</label>

                    <select name="poker_experience">

                        <option value="">Selecciona...</option>

                        <option value="Menos de 1 año">Menos de 1 año</option>

                        <option value="1-3 años">1-3 años</option>

                        <option value="3-5 años">3-5 años</option>

                        <option value="Más de 5 años">Más de 5 años</option>

                    </select>

                </div>

                <div class="founder-form-group">

                    <label>¿Qué modalidad juegas principalmente?</label>

                    <select name="main_format">

                        <option value="">Selecciona...</option>

                        <option>Cash Games</option>

                        <option>MTT</option>

                        <option>Spin & Go</option>

                        <option>PLO</option>

                        <option>Varias</option>

                    </select>

                </div>

                <div class="founder-form-group">

                    <label>Nivel habitual</label>

                    <input
                        type="text"
                        name="usual_level"
                        value="{{ old('usual_level') }}"
                        placeholder="Ejemplo: NL10, NL25, MTT 10€, etc."
                    >

                </div>

                <div class="founder-form-group">

                    <label>

                        ¿Por qué quieres formar parte del programa Founder Members?

                    </label>

                    <textarea
                        name="motivation"
                        rows="6"
                    >{{ old('motivation') }}</textarea>

                </div>

                <div class="founder-form-group">

                    <label>

                        ¿Qué esperas de ApexCash?

                    </label>

                    <textarea
                        name="expectations"
                        rows="5"
                    >{{ old('expectations') }}</textarea>

                </div>

                <div class="founder-form-group">

                    <label>

                        ¿Estarías dispuesto a enviarnos sugerencias y ayudarnos a mejorar la plataforma?

                    </label>

                    <select name="willing_to_give_feedback">

                        <option value="1">

                            Sí

                        </option>

                        <option value="0">

                            No

                        </option>

                    </select>

                </div>

                <button class="apex-btn apex-btn-primary founder-submit" type="submit">
                    🚀 Enviar solicitud Founder
                </button>

            </form>

        </article>

        <article class="dashboard-card active">

            <span>Founder Members</span>

            <h2>¿Qué obtendrás?</h2>

            <ul class="founder-benefit-list">

                <li>✅ Acceso anticipado a ApexCash Premium.</li>

                <li>🏅 Badge permanente Founder Member 2026.</li>

                <li>🚀 Acceso a nuevas funciones antes que nadie.</li>

                <li>💡 Participación en decisiones del proyecto.</li>

                <li>📈 Ayudarás a construir ApexCash Trainer.</li>

                <li>🎁 Ventajas exclusivas cuando llegue el lanzamiento comercial.</li>

            </ul>

        </article>

    </section>

</main>

</x-app-layout>