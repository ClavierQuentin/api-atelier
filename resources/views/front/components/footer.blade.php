<footer>
    <!------------------------------INSCRIPTION NEWSLETTER----------------------------------------------->
    <div class="banniereReseaux whiteFont">
        <div class="emailContainer" style="display: none" id="emailContainer">
            <form id="newsletterForm" action="{{ route('email') }}" method="POST">
                @csrf
                <input name="pot" class="visually-hidden" tabindex="-1" autocomplete="off" id="pot">
                <input type="email" name="email" id="email" placeholder="Votre adresse email">
                <input type="hidden" name="recaptcha" id="recaptcha">
                <button>S'inscrire à la newsletter</button>
                {{-- Message --}}
                @if(session('message'))
                    <span id="msg">
                        {{ session('message') }}
                    </span>
                @endif
            </form>
        </div>

        <!------------------------------PARTIE RESEAU SOCIAUX----------------------------------------------->
        <h4>Suivez-nous</h4>
        <a class="liens whiteFont" href="https://www.facebook.com/atelierginette" target="_blank">Facebook</a>
        <a class="liens whiteFont" href="https://www.instagram.com/atelier_ginette/" target="_blank">Instagram</a>
        <a class="liens whiteFont" href="{{ route('contact') }}">Ecrivez-nous</a>
    </div>
    <!-------------------------PARTIE CGV---------------------------------------->
    <!-- Partie mise en place pour une futur vente en ligne -->
    <div class="banniereCGV">
      <!--  <a href="#">Livraisons et retours</a>-->
       <!-- <a href="#">Mentions légales</a>-->
       <!-- <a href="#">Conditions générales de vente</a>-->
    </div>
</footer>
<!--PROGRAMME POUR LE MENU ET BOUTON PANIER-->
<script src="{{ asset('js/script.js') }}" defer></script>

<script>
grecaptcha.ready(function() {
    grecaptcha.execute('6LepuxohAAAAAChJ_a-bx9KO4nqIfEw8iCt5Jk3y', {action: 'message'}).then(function(token) {
        document.getElementById('emailContainer').style.display = 'block';
        document.getElementById('recaptcha').value = token;
    })
})
</script>


</body>
</html>
