@extends("layouts.default")

@section("title", "Register")

@section("content")

    <div class="register">
        <div class="container">
            <div class="info">
                <div class="form">
                    <h2>Registratieformulier</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <p>
                            Hallo! Ik ben
                            <input type="text" id="name" name="name"
                                   class="bg-indigo-100 text-purple-400 px-2 py-2 rounded-xl outline-none focus:ring-2 focus:ring-indigo-300 w-auto"
                                   placeholder="Jeroen de Beer" required>
                            . Ik doe de opleiding informatica met een
                            <select id="major" name="major"
                                    class="bg-indigo-100 text-purple-400 px-2 py-2 rounded-xl outline-none focus:ring-2 focus:ring-indigo-300 w-auto"
                                    required>
                                <option value="SO">SO</option>
                                <option value="BI">BI</option>
                            </select>
                            major aan Avans Hogeschool in 's-Hertogenbosch.<br />
                            Ik ben te bereiken via
                            <input type="email" id="email" name="email"
                                   class="bg-indigo-100 text-purple-400 px-2 py-2 rounded-xl outline-none focus:ring-2 focus:ring-indigo-300 w-auto"
                                   placeholder="naam@domein.com" required>
                            of telefonisch via
                            <input type="tel" id="phone" name="phone"
                                   class="bg-indigo-100 text-purple-400 px-2 py-2 rounded-xl outline-none focus:ring-2 focus:ring-indigo-300 w-auto"
                                   placeholder="+31 00 00000000" required>
                            .<br />
                            Ik hoop snel mee te kunnen doen aan alle leuke activiteiten die op de planning staan!
                        </p>

                        <p>
                            Wachtwoord: <br/>
                            <input type="password" id="password" name="password"
                                   class="bg-indigo-100 text-purple-400 px-2 py-2 rounded-xl outline-none focus:ring-2 focus:ring-indigo-300 w-auto"
                                   required>
                            <br/>
                            Herhaal wachtwoord: <br/>
                            <input type="password" id="confirm_password" name="password_confirmation"
                                   class="bg-indigo-100 text-purple-400 px-2 py-2 rounded-xl outline-none focus:ring-2 focus:ring-indigo-300 w-auto"
                                   required>
                        </p>

                        <p>
                            <input type="checkbox" class="labeled" name="privacy" id="privacy" required />
                            Daarnaast ga ik uiteraard akkoord met het privacybeleid.<br />
                        </p>

                        <button type="submit"
                                class="btn btn-primary px-4 py-2 rounded-xl">
                            Registreren
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
