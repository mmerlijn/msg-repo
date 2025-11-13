# Message Repository

Repository to store healthcare data V3

installation

```php
composer require mmerlijn/msg-repo
```

Order helpers

```php
$order->addComment("comment")->addComment("Comment 2");
$order->addRequest($request)->addRequest($otherRequest);
$order->addResult($result);
$patient->setName($name)
    ->setAddress($address)
    ->setPhone("0612341234");

$order->getRequestedTestcodes(); //return all requested testcodes as array
$order->filterTestCodes(string|array); //filters requests and results with given test_code
```

Repo to array

```php
$msg->toArray();
```

Compact array (empty values are removed)

```php
$msg->toArray(true);
```

Form array to repo

```php
$msg = new Msg(...$array);
//or
$msg = (new Msg)->fromArray($array);
```

Repository tree

```php
array:10 [
  "patient" => array:12 [
    "sex" => ""
    "name" => array:9 [
      "initials" => ""
      "firstname" => ""
      "lastname" => ""
      "prefix" => ""
      "own_lastname" => ""
      "own_prefix" => ""
      "name" => ""
      "sex" => ""
      "salutation" => ""
    ]
    "dob" => null
    "bsn" => ""
    "address" => array:8 [
      "postcode" => ""
      "city" => ""
      "street" => ""
      "building" => ""
      "building_nr" => ""
      "building_addition" => ""
      "country" => "NL"
      "postbus" => ""
    ]
    "address2" => null
    "phones" => []
    "insurance" => array:5 [
      "uzovi" => ""
      "policy_nr" => ""
      "company_name" => ""
      "phone" => ""
      "address" => array:8 [
        "postcode" => ""
        "city" => ""
        "street" => ""
        "building" => ""
        "building_nr" => ""
        "building_addition" => ""
        "country" => "NL"
        "postbus" => ""
      ]
    ]
    "ids" => []
    "last_requester" => ""
    "email" => null
    "gp" => ""
  ]
  "order" => array:20 [
    "control" => "NEW"
    "request_nr" => ""
    "lab_nr" => ""
    "complete" => true
    "priority" => false
    "start_date" => null
    "order_status" => "F"
    "where" => ""
    "requester" => array:11 [
      "agbcode" => ""
      "name" => array:9 [
        "initials" => ""
        "firstname" => ""
        "lastname" => ""
        "prefix" => ""
        "own_lastname" => ""
        "own_prefix" => ""
        "name" => ""
        "sex" => ""
        "salutation" => ""
      ]
      "source" => ""
      "address" => array:8 [
        "postcode" => ""
        "city" => ""
        "street" => ""
        "building" => ""
        "building_nr" => ""
        "building_addition" => ""
        "country" => "NL"
        "postbus" => ""
      ]
      "phone" => ""
      "type" => ""
      "organisation" => array:6 [
        "name" => ""
        "department" => ""
        "short" => ""
        "agbcode" => null
        "source" => null
        "phone" => ""
      ]
      "application" => ""
      "device" => ""
      "facility" => ""
      "location" => ""
    ]
    "copy_to" => array:11 [
      "agbcode" => ""
      "name" => array:9 [
        "initials" => ""
        "firstname" => ""
        "lastname" => ""
        "prefix" => ""
        "own_lastname" => ""
        "own_prefix" => ""
        "name" => ""
        "sex" => ""
        "salutation" => ""
      ]
      "source" => ""
      "address" => array:8 [
        "postcode" => ""
        "city" => ""
        "street" => ""
        "building" => ""
        "building_nr" => ""
        "building_addition" => ""
        "country" => "NL"
        "postbus" => ""
      ]
      "phone" => ""
      "type" => ""
      "organisation" => array:6 [
        "name" => ""
        "department" => ""
        "short" => ""
        "agbcode" => null
        "source" => null
        "phone" => ""
      ]
      "application" => ""
      "device" => ""
      "facility" => ""
      "location" => ""
    ]
    "entered_by" => array:11 [
      "agbcode" => ""
      "name" => array:9 [
        "initials" => ""
        "firstname" => ""
        "lastname" => ""
        "prefix" => ""
        "own_lastname" => ""
        "own_prefix" => ""
        "name" => ""
        "sex" => ""
        "salutation" => ""
      ]
      "source" => ""
      "address" => array:8 [
        "postcode" => ""
        "city" => ""
        "street" => ""
        "building" => ""
        "building_nr" => ""
        "building_addition" => ""
        "country" => "NL"
        "postbus" => ""
      ]
      "phone" => ""
      "type" => ""
      "organisation" => array:6 [
        "name" => ""
        "department" => ""
        "short" => ""
        "agbcode" => null
        "source" => null
        "phone" => ""
      ]
      "application" => ""
      "device" => ""
      "facility" => ""
      "location" => ""
    ]
    "organisation" => array:6 [
      "name" => ""
      "department" => ""
      "short" => ""
      "agbcode" => null
      "source" => null
      "phone" => ""
    ]
    "dt_of_request" => null
    "dt_of_observation" => null
    "dt_of_observation_end" => null
    "dt_of_analysis" => null
    "results" => []
    "requests" => []
    "comments" => []
    "admit_reason" => array:3 [
      "code" => ""
      "name" => ""
      "source" => ""
    ]
  ]
  "sender" => array:11 [
    "agbcode" => ""
    "name" => array:9 [
      "initials" => ""
      "firstname" => ""
      "lastname" => ""
      "prefix" => ""
      "own_lastname" => ""
      "own_prefix" => ""
      "name" => ""
      "sex" => ""
      "salutation" => ""
    ]
    "source" => ""
    "address" => array:8 [
      "postcode" => ""
      "city" => ""
      "street" => ""
      "building" => ""
      "building_nr" => ""
      "building_addition" => ""
      "country" => "NL"
      "postbus" => ""
    ]
    "phone" => ""
    "type" => ""
    "organisation" => array:6 [
      "name" => ""
      "department" => ""
      "short" => ""
      "agbcode" => null
      "source" => null
      "phone" => ""
    ]
    "application" => ""
    "device" => ""
    "facility" => ""
    "location" => ""
  ]
  "receiver" => array:11 [
    "agbcode" => ""
    "name" => array:9 [
      "initials" => ""
      "firstname" => ""
      "lastname" => ""
      "prefix" => ""
      "own_lastname" => ""
      "own_prefix" => ""
      "name" => ""
      "sex" => ""
      "salutation" => ""
    ]
    "source" => ""
    "address" => array:8 [
      "postcode" => ""
      "city" => ""
      "street" => ""
      "building" => ""
      "building_nr" => ""
      "building_addition" => ""
      "country" => "NL"
      "postbus" => ""
    ]
    "phone" => ""
    "type" => ""
    "organisation" => array:6 [
      "name" => ""
      "department" => ""
      "short" => ""
      "agbcode" => null
      "source" => null
      "phone" => ""
    ]
    "application" => ""
    "device" => ""
    "facility" => ""
    "location" => ""
  ]
  "datetime" => "2025-11-13 19:20:49"
  "msgType" => array:5 [
    "type" => ""
    "trigger" => ""
    "structure" => ""
    "version" => ""
    "charset" => "8859/1"
  ]
  "id" => ""
  "security_id" => ""
  "processing_id" => ""
  "comments" => []
]
```

