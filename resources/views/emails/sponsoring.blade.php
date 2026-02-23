<h1>Nieuw sponsoraanvraag Olijfboom van Licht</h1>

<p><strong>Naam:</strong> {{ $data['name'] }}</p>
<p><strong>E-mailadres:</strong> {{ $data['email'] }}</p>
<p><strong>Telefoonnummer:</strong> {{ $data['phone'] }}</p>

@if (!empty($data['message']))
    <p><strong>Bericht:</strong></p>
    <p>{{ $data['message'] }}</p>
@endif

