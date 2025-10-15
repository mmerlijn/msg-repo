# Message Repository

Repository to store healthcare data

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
Array
(
    [patient] => Array
        (
            [sex] => 
            [name] => Array
                (
                    [initials] => 
                    [lastname] => 
                    [prefix] => 
                    [own_lastname] => 
                    [own_prefix] => 
                    [name] => 
                )

            [dob] => 
            [bsn] => 
            [email] =>
            [address] => Array
                (
                    [postcode] => 
                    [city] => 
                    [street] => 
                    [building] => 
                    [building_nr] => 
                    [building_addition] => 
                    [postbus] => 
                    [country] => NL
                )

            [address2] => 
            [phones] => Array
                (
                )

            [insurance] => 
            [ids] => Array
                (
                )

        )

    [order] => Array
        (
            [control] => N
            [request_nr] => 
            [lab_nr] => 
            [complete] => 1
            [priority] => 
            [order_status] => 
            [where] => 
            [requester] => Array
                (
                    [agbcode] => 
                    [source] => 
                    [name] => Array
                        (
                            [initials] => 
                            [lastname] => 
                            [prefix] => 
                            [own_lastname] => 
                            [own_prefix] => 
                            [name] => 
                        )

                    [address] => 
                    [phone] => 
                    [type] => 
                    [organisation] => 
                )

            [copy_to] => Array
                (
                    [agbcode] => 
                    [source] => 
                    [name] => Array
                        (
                            [initials] => 
                            [lastname] => 
                            [prefix] => 
                            [own_lastname] => 
                            [own_prefix] => 
                            [name] => 
                        )

                    [address] => 
                    [phone] => 
                    [type] => 
                    [organisation] => 
                )

            [dt_of_request] => 
            [dt_of_observation] => 
            [dt_of_observation_end] => 
            [dt_of_analysis] => 
            [results] => Array
                (
                )

            [requests] => Array
                (
                )

            [comments] => Array
                (
                )

        )

    [sender] => Array
        (
            [application] => 
            [device] => 
            [facility] => 
            [contact] => 
        )

    [receiver] => Array
        (
            [contact] => 
            [application] => 
            [device] => 
            [facility] => 
        )

    [datetime] => 2022-01-22 12:08:40
    [msgType] => Array
        (
            [type] => 
            [trigger] => 
            [structure] => 
            [version] => 
        )

    [id] => 
    [security_id] => 
    [processing_id] => 
    [comments] => Array
        (
        )

)
```

