<h1>User Updated</h1>

<p>
    Hi {{ $attributes['name'] }},
</p>

<p>
    You profile was updated.
</p>

<ul>
    @if(isset($payload['name']))
        <li>Name: {{ $attributes['name'] }} --> {{ $payload['name'] }}</li>
    @endif

    @if(isset($payload['email']))
        <li>Email: {{ $attributes['email'] }} --> {{ $payload['email'] }}</li>
    @endif

    @if(isset($payload['company']))
        <li>Company: {{ $attributes['company'] }} --> {{ $payload['company'] }}</li>
    @endif

    @if(isset($payload['department']))
        <li>Department: {{ $attributes['department'] }} --> {{ $payload['department'] }}</li>
    @endif

    @if(isset($payload['job_title']))
        <li>Job Title: {{ $attributes['job_title'] }} --> {{ $payload['job_title'] }}</li>
    @endif

    @if(isset($payload['desk']))
        <li>Desk: {{ $attributes['desk'] }} --> {{ $payload['desk'] }}</li>
    @endif

    @if(isset($payload['type']))
        <li>Type: {{ $attributes['type'] }} --> {{ $payload['type'] }}</li>
    @endif

    @if(isset($payload['state']))
        <li>State: {{ $attributes['state'] }} --> {{ $payload['state'] }}</li>
    @endif

    @if(isset($payload['permission_level']))
        <li>Permission Level: {{ $attributes['permission_level'] }} --> {{ $payload['permission_level'] }}</li>
    @endif
</ul>
