<?php

return [
    'reason_code' => [
        '00' => "Object activated for the first time",
        '01' => "Requested by you",
        '02' => "Inactivity over time",
        '03' => "This address cannot accept mail or the addressee is unknown",
        '04' => "Negative account balance",
        '05' => "Account under review",
        '06' => "Suspicious activity was identified",
        '07' => "Activity outside the program parameters was identified",
        '08' => "Confirmed fraud was identified",
        '09' => "Matched with an Office of Foreign Assets Control list",
        '10' => "Card was reported lost",
        '11' => "Card information was cloned",
        '12' => "Account or card information was compromised",
        '13' => "Temporary status change while on hold/leave",
        '14' => "Initiated by Marqeta",
        '15' => "Initiated by issuer",
        '16' => "Card expired",
        '17' => "Failed KYC",
        '18' => "Changed to ACTIVE because information was properly validated",
        '19' => "Changed to ACTIVE because account activity was properly validated",
        '20' => "Change occurred prior to the normalization of reason codes",
        '21' => "Initiated by a third party, often a digital wallet provider",
        '22' => "PIN retry limit reached",
        '23' => "Card was reported stolen",
        '24' => "Address issue",
        '25' => "Name issue",
        '26' => "SSN issue",
        '27' => "DOB issue",
        '28' => "Email issue",
        '29' => "Phone issue",
        '30' => "Account/fulfillment mismatch",
        '31' => "Other reason",
    ],
];
