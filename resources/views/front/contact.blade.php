@include('front.components.header')
<main id="main-conteneur">
    <div class="conteneurContact backGroundFleur" >
        <!--FORMULAIRE-->
        <form id="contactForm" style="display: none" action="{{ route('message') }}" method="POST">
            @csrf
            <h2>Contactez-moi !</h2>
            <div class="containerForm">

                <div>
                    <input type="text" name="prenom" id="prenom" placeholder="Votre prénom" class="firstInput" required>

                    <input type="text" name="nom" id="nom" placeholder="Votre nom" class="firstInput" required>
                </div>

                <input type="text" name="sujet" id="sujet" placeholder="Sujet du message" required>

                <input type="email" name="email" placeholder="Votre email" id="email" required>

                <textarea placeholder = "Indiquez-moi votre message" id="body" name = "message" required rows="5"></textarea>

                <input type="hidden"   name="recaptcha" id="recaptcha" value="">

                <input name="pot" class="visually-hidden" tabindex="-1" autocomplete="off" id="pot">

                <div>
                    <input type="checkbox" name = "newsletter" id="newsletter" value="1">
                    <label for="newsletter"> M'inscrire à la newsletter</label>
                </div>

                <div class="divRGPD">
                    <input required type="checkbox" name="rgpd" id="rgpd" >
                    <label for="rgpd">J'autorise ce site à conserver mes données personnelles transmises via ce formulaire. Aucune exploitation commerciale ne sera faite des données conservées</label>
                </div>
                <button class="background" id="contactBtn">Envoyer</button>
            </div>

            {{-- Fenetre d'erreur --}}
            @if (session('error'))
                <div class="alert alert-success">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Message --}}
            @if(session('message'))
                <span id="message">
                    {{ session('message') }}
                </span>
            @endif

        </form>
    </div>
<script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6LepuxohAAAAAChJ_a-bx9KO4nqIfEw8iCt5Jk3y', {action: 'message'}).then(function(token) {
                document.getElementById('contactForm').style.display = 'block';
                document.getElementById('recaptcha').value = token;
            })
        })
</script>

</main>
@include('front.components.footer')
