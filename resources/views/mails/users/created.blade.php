<h1>Account Created</h1>

<p>
    Hi {{ $user->name }},
</p>

<p>
    You account is create, please use the following credentials to login.
</p>

<ul>
    <li>Email: {{ $user->email }}</li>
    <li>Password: {{ $password }}</li>
</ul>

<strong>Important: please update your password ASAP.</strong>
