## Hi there!

Here are present few main ideas about technical realization of the task.

<p>
About storing data in the DB there were 2 variants:
</p>

- store in one table records about subscriptions, like ``email -> olx_url``
- make two different entities: ``advert`` and ``subscriber``, and store subscriptions in the pivot table, which represents a `many-to-many` relationship

So, here the second variant of realization was chosen, because it is more flexible and able to expand in a case of such need.

Also, there were 2 variants about tracking the price change from OLX:

- use an API from OLX, and create a websocket, so whether there would be an update on OLX side, this application also will be informed
- map exist OLX urls every some amount of time and check a price with recorded earlier

Of course, the first variant is much prettier and does not impact on system performance, but after researching an OLX API, I have not found such opportunity to make websocket connection. 
So, there is a queued job, which runs every 10 minutes and checks all existing OLX urls. In case of noticing a price update on some product, all subscribers will receive an e-mail.
