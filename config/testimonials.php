<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Homepage community quotes
    |--------------------------------------------------------------------------
    |
    | Add genuine quotes in the order they should appear. Each entry needs a
    | quote and a name. The role and original source URL are optional.
    | The homepage section stays hidden while this list is empty.
    |
    | Example structure (replace the placeholders before adding an entry):
    |
    | [
    |     'quote' => 'The person\'s exact words.',
    |     'name' => 'Full name',
    |     'role' => 'Role or company',
    |     'source' => 'https://example.com/original-quote',
    | ],
    |
    */

    // Recovered from the Magewire V1 README on 15 March 2023. Role descriptions
    // reflect that snapshot; quote wording is preserved with line breaks joined.
    'quotes' => [
        [
            'quote' => 'This is a game-changing tool! You can build practically anything with almost no javascript. It saves a significant amount of time and is incredibly easy to work with. It\'s not a matter of whether you should use it, you simply must use it.',
            'name' => 'Marcus Venghaus',
            'role' => 'Freelance Developer & Magewire contributor',
            'source' => 'https://github.com/magewirephp/magewire/blob/30d9ad4236c697c171475b69dde3a6c809acc8a5/README.md?plain=1#L37-L41',
        ],
        [
            'quote' => 'Magewire is like magic sauce that can save a ton of time implementing features! It’s great to see more tools from the Laravel ecosystem being made available within Magento - thanks Willem!',
            'name' => 'Vinai Kopp',
            'role' => 'Technical Director and Partner · Hyvä Themes',
            'source' => 'https://github.com/magewirephp/magewire/blob/30d9ad4236c697c171475b69dde3a6c809acc8a5/README.md?plain=1#L43-L46',
        ],
        [
            'quote' => 'Magewire is one of my favourite tools! It even makes frontend morons like me capable of dynamic UIs! More people should check it out.',
            'name' => 'Kiel Pykett',
            'role' => 'Technical Lead Magento Developer · Fisheye',
            'source' => 'https://github.com/magewirephp/magewire/blob/30d9ad4236c697c171475b69dde3a6c809acc8a5/README.md?plain=1#L54-L57',
        ],
        [
            'quote' => 'Magewire is an awesome tool for Magento developers to build great interactive frontend features. It brings the backend closer to the frontend and speeds up development times. We are now using Magewire in all our projects where it makes sense to do so. I highly recommend it to Magento developers.',
            'name' => 'Ryan Copeland',
            'role' => 'Founder, Solution Architect & Developer · Foundation Commerce',
            'source' => 'https://github.com/magewirephp/magewire/blob/30d9ad4236c697c171475b69dde3a6c809acc8a5/README.md?plain=1#L59-L63',
        ],
    ],
];
