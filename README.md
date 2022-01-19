# Message Repository

Repository to store healthcare data

installation

```php
composer require mmerlijn/msg-repo
```

Order helpers

```php
$order->addComment("comment")->addComment("Comment 2");
$order->addItem($orderItem)->addItem($otherOrderItem);
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
            [address] => Array
                (
                    [postcode] => 
                    [city] => 
                    [street] => 
                    [building] => 
                    [building_nr] => 
                    [building_addition] => 
                    [country] => NL
                )

            [address2] => 
            [phones] => Array
                (
                )

            [insurance] => Array
                (
                    [uzovi] => 
                    [policy_nr] => 
                    [company_name] => 
                )

            [ids] => Array
                (
                )

        )

    [order] => Array
        (
            [control] => NW
            [request_nr] => 
            [lab_nr] => 
            [compleet] => 1
            [request_date] => 
            [priority] => 
            [order_status] => 
            [result_status] => 
            [action_code] => 
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

                    [address] => Array
                        (
                            [postcode] => 
                            [city] => 
                            [street] => 
                            [building] => 
                            [building_nr] => 
                            [building_addition] => 
                            [country] => NL
                        )

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

                    [address] => Array
                        (
                            [postcode] => 
                            [city] => 
                            [street] => 
                            [building] => 
                            [building_nr] => 
                            [building_addition] => 
                            [country] => NL
                        )

                )

            [comments] => Array
                (
                )

            [orderItems] => Array
                (
                )

        )

    [sender] => Array
        (
            [name] => 
            [application] => 
            [device] => 
            [facility] => 
        )

    [receiver] => Array
        (
            [name] => 
            [application] => 
            [facility] => 
        )

    [datetime] => 
    [msgType] => Array
        (
            [type] => 
            [trigger] => 
            [structure] => 
        )

    [id] => 
    [security_id] => 
    [processing_id] => 
    [comments] => Array
        (
        )

)
```

