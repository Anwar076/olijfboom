<h1>Nieuwe actie-inzending Olijfboom van Licht</h1>

<p><strong>Naam:</strong> {{ $data['name'] }}</p>
<p><strong>E-mailadres:</strong> {{ $data['email'] }}</p>
<p><strong>Telefoonnummer:</strong> {{ $data['phone'] }}</p>
<p><strong>Naam team / actie:</strong> {{ $data['team_name'] }}</p>

@if (!empty($data['message']))
    <p><strong>Beschrijving:</strong></p>
    <p>{{ $data['message'] }}</p>
@endif

<p><strong>Aantal meegestuurde foto&#39;s:</strong> {{ $photoCount }}</p>

