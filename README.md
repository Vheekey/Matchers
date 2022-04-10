# Matchers

This is a simple module to get similar profiles to the one being searched with parameters and returns search details.

### To Begin
<ul>
    <li>Clone repository - "git clone https://github.com/Vheekey/Matchers.git"</li>
    <li>Run composer install</li>
    <li>Run php artisan migrate --seed</li>
</ul>

<p> You are good to go </p>

### Request URI
<pre> {{url}}/api/match/1 </pre>

### Sample Request
<pre>
    {
        "price":[10,200],
        "area":[10000000000000,null]
    }
</pre>
### Sample Response
<pre>
    [
        {
            "searchProfileId": 1,
            "score": 50,
            "strictMatchesCount": 1,
            "looseMatchesCount": 0
        },
        {
            "searchProfileId": 2,
            "score": 40,
            "strictMatchesCount": 1,
            "looseMatchesCount": 0
        },
        {
            "searchProfileId": 3,
            "score": 0,
            "strictMatchesCount": 0,
            "looseMatchesCount": 0
        },
        {
            "searchProfileId": 4,
            "score": 0,
            "strictMatchesCount": 0,
            "looseMatchesCount": 0
        },
        {
            "searchProfileId": 8,
            "score": 0,
            "strictMatchesCount": 0,
            "looseMatchesCount": 0
        },
        {
            "searchProfileId": 9,
            "score": 0,
            "strictMatchesCount": 0,
            "looseMatchesCount": 0
        },
        {
            "searchProfileId": 10,
            "score": 0,
            "strictMatchesCount": 0,
            "looseMatchesCount": 0
        }
    ]
</pre>
