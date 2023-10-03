<label for="card-element" class="mt-3">
    Card Details:
</label>
<div id="card-element"><!--Stripe.js injects the Card Element--></div>
<input type="hidden" name="payment_method" id="paymentMethod">
<p id="card-error" role="alert"></p>
<small class="result-message hidden form-text text-muted" role="alert">
    Payment succeeded, see the result in your
    <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
</small>
@section('css')
    <style>
        .result-message {
            line-height: 22px;
            font-size: 16px;
        }

        .result-message a {
            color: rgb(89, 111, 214);
            font-weight: 600;
            text-decoration: none;
        }

        .hidden {
            display: none;
        }

        #card-error {
            color: rgb(105, 115, 134);
            text-align: left;
            font-size: 13px;
            line-height: 17px;
            margin-top: 12px;
        }

        #card-element {
            border-radius: 4px 4px 0 0;
            padding: 12px;
            border: 1px solid rgba(50, 50, 93, 0.1);
            height: 44px;
            width: 100%;
            background: white;
        }
    </style>
@endsection

@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ config('services.stripe.pub_key') }}');
        const elements = stripe.elements();

        const cardElement = elements.create('card');

        const cardHolderName = document.getElementById('card-holder-name');

        const cardButton = document.getElementById('payButton');

        const clientSecret = cardButton.dataset.secret;

        cardElement.mount('#card-element');

        cardElement.addEventListener('change', ({error}) => {
            const displayError = document.getElementById('card-error');
            if (error) {
                displayError.textContent = error.message;
            } else {
                displayError.textContent = '';
            }
        });

        const form = document.getElementById('paymentForm');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            stripe.handleCardSetup(
                clientSecret, cardElement, {
                    payment_method_data: {
                        billing_details: {name: cardHolderName.value}
                    }
                }
            ).then((result) => {
                if (result.error) {
                    // Display "result.error.message" to the user...
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // The card has been verified successfully...
                    const paymentMethod = document.getElementById('paymentMethod');
                    paymentMethod.value = result.setupIntent.payment_method;
                    form.submit();

                }
            });
        });
    </script>

    {{--<script>
        const form = document.getElementById('paymentForm');
        const payButton = document.getElementById('payButton');
        const platformInput = form.querySelector('.platform');
        console.log('hi');
        payButton.addEventListener('click', async (e) => {

            if (platformInput.value === "{{ $platform->id }}") {
                e.preventDefault();
                const {paymentMethod, error} = await stripe.createPaymentMethod(
                    'card', cardElement, {
                        billing_details: {
                            "name": {{auth()->user()->name}},
                            "email": {{auth()->user()->email}},
                        }
                    }
                );

                if (error) {
                    const displayError = document.getElementById('card-error');
                    displayError.textContent = error.message;
                } else {
                    const tokenInput = document.getElementById('paymentMethod');
                    // Send the token to your server.
                    tokenInput.value = paymentMethod.id;
                    alert(paymentMethod.id);
                    form.submit();
                }
            }
        });
    </script>--}}
@endsection

