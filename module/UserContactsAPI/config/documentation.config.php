<?php
return [
    'UserContactsAPI\\V1\\Rest\\UserContacts\\Controller' => [
        'collection' => [
            'PUT' => [
                'request' => '{
   "phone_number": "phone number of user",
   "address": "users address"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/company/users/:userid/contacts"
       },
       "first": {
           "href": "/company/users/:userid/contacts?page={page}"
       },
       "prev": {
           "href": "/company/users/:userid/contacts?page={page}"
       },
       "next": {
           "href": "/company/users/:userid/contacts?page={page}"
       },
       "last": {
           "href": "/company/users/:userid/contacts?page={page}"
       }
   }
   "_embedded": {
       "user_contacts": [
           {
               "_links": {
                   "self": {
                       "href": "/company/users/:userid/contacts[/:user_contacts_id]"
                   }
               }
              "phone_number": "phone number of user",
              "address": "users address"
           }
       ]
   }
}',
            ],
        ],
    ],
];
