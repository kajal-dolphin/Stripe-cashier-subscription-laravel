@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    You will be charged ${{ number_format($plan->price, 2) }} for {{ $plan->name }} Plan
                </div>

                <div class="card-body">

                    <form id="payment-form" action="{{ route('subscription.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" id="plan" value="{{ $plan->id }}">

                        <div class="row">
                            <div class="col-xl-4 col-lg-4">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" id="card-holder-name" class="form-control" value="" placeholder="Name on the card">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-4 col-lg-4">
                                <div class="form-group">
                                    <label for="">Card details</label>
                                    <div id="card-element"></div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12">
                                <hr>
                                <button type="submit" class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">Purchase</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');

    const elements = stripe.elements()
    const cardElement = elements.create('card')

    cardElement.mount('#card-element')

    const form = document.getElementById('payment-form')
    const cardBtn = document.getElementById('card-button')
    const cardHolderName = document.getElementById('card-holder-name')

    form.addEventListener('submit', async (e) => {
        e.preventDefault()

        cardBtn.disabled = true
        const {
            setupIntent
            , error
        } = await stripe.confirmCardSetup(
            cardBtn.dataset.secret, {
                payment_method: {
                    card: cardElement
                    , billing_details: {
                        name: cardHolderName.value
                    }
                }
            }
        )
        console.log(setupIntent.client_secret);

        if (error) {
            console.log(error);
            // Handle error
        } else if (setupIntent.status === 'requires_action') {
            console.log("go into require_action");
            // Handle 3D Secure authentication
            stripe.handleCardAction(setupIntent.client_secret)
                .then(function(result) {
                    if (result.error) {
                        // Handle error
                    } else {
                        // Authentication successful, submit the form with the setupIntent.payment_method
                        let token = document.createElement('input')
                        token.setAttribute('type', 'hidden')
                        token.setAttribute('name', 'token')
                        token.setAttribute('value', setupIntent.payment_method)
                        form.appendChild(token)
                        form.submit();
                    }
                });
        } else {
            console.log("go into success");
            // Payment is successful, submit the form with the setupIntent.payment_method
            let token = document.createElement('input')
            token.setAttribute('type', 'hidden')
            token.setAttribute('name', 'token')
            token.setAttribute('value', setupIntent.payment_method)
            form.appendChild(token)
            form.submit();
        }
    })

</script>
@endsection
