

    Reference

Messages
Introduction

The MessageMedia Messages API provides a number of endpoints for building powerful two-way messaging applications. The Messages API provides access to three main resources:

    Messages - Messages delivered from an application to a handset.

    Delivery Reports - Real time reports on the delivery status of a message. As a message is processed, it's status may change several times before it is finally delivered to a handset.

    Replies - Messages sent from a handset to an application. These messages are typically a reply to a previously sent message.

    Note: MMS and TTS are only available in the APAC region.

Message Flow

Run in Postman
Reference
Base URI

The API uses the following base URI

For APAC instances https://api.messagemedia.com

For EU instances https://eu.app.api.sinch.com
Authentication

All requests to the MessageMedia REST API must be authenticated, this can either be done using Basic Authentication or by signing with a HMAC signature.
Credentials

To access the API, an API key and secret are required. Sign up for a free trial here to get access: https://hub.messagemedia.com/register.
Basic Authentication

Every request requires an Authorization header in the following format:

Authorization: Basic Base64(api_key:api_secret)

Where the header consists of the Basic keyword followed by your Basic Authentication api_key and api_secret that you have been supplied by support, seperated with a colon (:) which is then Base64 encoded.
Example request with Basic Authentication

POST /v1/messages HTTP/1.1
Host: api.messagemedia.com
Accept: application/json
Content-Type: application/json
Authorization: Basic dGhpc2lzYWtleTp0aGlzaXNhc2VjcmV0Zm9ybW1iYXNpY2F1dGhyZXN0YXBp
{
  "messages": [
    {
      "content": "Hello World",
      "destination_number": "+61491570156",
      "format": "SMS"
    }
  ]
}

Note: spaces are used as indentation in the body of the above request.
HMAC Authentication

Every request requires an Authorization header in the following formats:

For a request with a request body:

Authorization: hmac username="<API KEY>", algorithm="hmac-sha1", headers="Date Content-MD5 request-line", signature="<SIGNATURE>"

For a request without a request body:

Authorization: hmac username="<API KEY>", algorithm="hmac-sha1", headers="Date request-line", signature="<SIGNATURE>"

To create this header
Step 1

Add a Date header to the request using the current date time in RFC7231 Section 7.1.1.2 format
Step 2

If the request has a body, add a header called Content-MD5 where the value of this header is an MD5 hash of the request body, otherwise this header is not required
Step 3

Create a signing string by concatenating the Date header, the Content-MD5 header (if set) and the request line with line breaks:

Date: Sat, 30 Jul 2016 05:13:23 GMT\nContent-MD5: 10fd4feab20d38432480c07301e49616\nPOST /v1/messages HTTP/1.1

or

Date: Sat, 30 Jul 2016 05:13:23 GMT\nGET /v1/messages/404b941b-2a29-469f-b114-9ea3e16bbe18 HTTP/1.1

Step 4

Create a SHA1 HMAC hash using the signing string and the secret key (both converted to bytes using UTF-8) HMAC-SHA1(signing string, secret)
Step 5

Base64 encode the HMAC hash and include it as the signature in the Authorization header
Example request with body

POST /v1/messages HTTP/1.1
Host: api.messagemedia.com
Accept: application/json
Content-Type: application/json
Date: Sat, 30 Jul 2016 05:18:52 GMT
Authorization: hmac username="uCXUdoogNfCsehEClbO2", algorithm="hmac-sha1", headers="Date Content-MD5 request-line", signature="Ia4G5lkhH/3NDYpix+8ZHUnp6bA="
Content-MD5: 5407644fa83bec240dede971307e0cad
Content-Length: 133
{
  "messages": [
    {
      "content": "Hello World",
      "destination_number": "+61491570156",
      "format": "SMS"
    }
  ]
}

Note: spaces are used as indentation in the body of the above request.
Example request without body

GET /v1/messages/404b941b-2a29-469f-b114-9ea3e16bbe18 HTTP/1.1
Host: api.messagemedia.com
Accept: application/json
Date: Sat, 30 Jul 2016 05:18:52 GMT
Authorization: hmac username="uCXUdoogNfCsehEClbO2", algorithm="hmac-sha1", headers="Date request-line", signature="NTUwMjUwNTVmZGYzZTIxODMyYjc1ZmM3M2EwZWQ1NzA3NzA4ZTZjNw=="

Sub-accounts
Performing actions on behalf of sub-accounts

Using API keys at the parent account level, you can perform actions on behalf of a sub-account.

This feature is supported by the Messages, Replies, Delivery Reports and Webhooks APIs.

To do this include a header key Account with the sub-account ID as the value. For example: Account: mySubAccount

Example request with Sending from sub-accounts

  POST /v1/messages HTTP/1.1
  Host: api.messagemedia.com
  Accept: application/json
  Content-Type: application/json
  Authorization: Basic dGhpc2lzYWtleTp0aGlzaXNhc2VjcmV0Zm9ybW1iYXNpY2F1dGhyZXN0YXBp
  Account: SubAccount
  {
    "messages": [
      {
        "content": "Hello World",
        "destination_number": "+61491570156",
        “delivery_report”: true
      }
    ]
  } 

Messages
/v1/messages
Send messages

Submit one or more (up to 100 per request) SMS, MMS, or text to voice messages for delivery.

The most basic message has the following structure:

{
    "messages": [
        {
            "content": "My first message!",
            "destination_number": "+61491570156"
        }
    ]
}

More advanced delivery features can be specified by setting the following properties in a message:

    callback_url A URL can be included with each message to which Webhooks will be pushed to via a HTTP POST request. Webhooks will be sent if and when the status of the message changes as it is processed (if the delivery report property of the request is set to true) and when replies are received. Specifying a callback URL is optional.

    content The content of the message. This can be a Unicode string, up to 5,000 characters long. Message content is required.

    delivery_report Delivery reports can be requested with each message. If delivery reports are requested, a webhook will be submitted to the callback_url property specified for the message (or to the webhooks specified for the account) every time the status of the message changes as it is processed. The current status of the message can also be retrieved via the Delivery Reports endpoint of the Messages API. Delivery reports are optional and by default will not be requested.

    destination_number The destination number the message should be delivered to. This should be specified in E.164 international format. For information on E.164, please refer to http://en.wikipedia.org/wiki/E.164. A destination number is required.

    format The format specifies which format the message will be sent as, SMS (text message), MMS (multimedia message) or TTS (text to speech). With TTS format, we will call the destination number and read out the message using a computer generated voice. Specifying a format is optional, by default SMS will be used.

    source_number_type If a source number is specified, the type of source number may also be specified. This is recommended when using a source address type that is not an internationally formatted number, available options are INTERNATIONAL, ALPHANUMERIC or SHORTCODE. Specifying a source number type is only valid when the source_number parameter is specified and is optional. If a source number is specified and no source number type is specified, the source number type will be inferred from the source number, however this may be inaccurate.

    source_number[optional] Specify a source number to be used. Refer to the section below for more information on source numbers.
    ⚠️ The number or sender ID must be registered to your account (from 1-Mar-2024).
    Source number (sender ID)

    There are several options for the number or sender ID that will show as the source of an outbound message. Some things to note:
    • If you do not specify a source number, the message will be sent with the default number for your account.
    • The default may be a number you have purchased from us - such as a dedicated number, a 10-digit longcode or toll-free number (US/CA), or a shortcode. Log into the web portal to manage your numbers.
    • If your account has multiple numbers, you can specify which source number to use in the request.
    • If your account does not have a number, your message may be sent using our shared number pool (in certain countries only)
    • Alpha tag: In some countries (AU, GB, some others), you may be able to send using an alpha tag - text that represents your brand of business. Before using an alpha tag, you must register it in the Numbers section of the web portal.
    • Other numbers: You may use numbers that you own as the source number, but you must register them in the Numbers section of the web portal to confirm you have a right to use the number.
    If you need to register a large number of source numbers/sender IDs, consider using our Source Address API
    ⚠️ If you specify a source_number that is not registered to your account, the message may fail to send, or may be sent with an alternative number.

    media The media is used to specify a list of URLs of the media file(s) that you are trying to send. Supported file formats include png, jpeg and gif. format parameter must be set to MMS for this to work.

    subject The subject field is used to denote subject of the MMS message and has a maximum size of 64 characters long. Specifying a subject is optional.

    scheduled A message can be scheduled for delivery in the future by setting the scheduled property. The scheduled property expects a date time specified in ISO 8601 format. The scheduled time must be provided in UTC and is optional. If no scheduled property is set, the message will be delivered immediately.

    message_expiry_timestamp A message expiry timestamp can be provided to specify the latest time at which the message should be delivered. If the message cannot be delivered before the specified message expiry timestamp elapses, the message will be discarded. Specifying a message expiry timestamp is optional.

    metadata Metadata can be included with the message which will then be included with any delivery reports or replies matched to the message. This can be used to create powerful two-way messaging applications without having to store persistent data in the application. Up to 10 key / value metadata data pairs can be specified in a message. Each key can be up to 100 characters long, and each value up to 256 characters long. Specifying metadata for a message is optional.

The response body of a successful POST request to the messages endpoint will include a messages property which contains a list of all messages submitted. The list of messages submitted will reflect the list of messages included in the request, but each message will also contain two new properties, message_id and status. The returned message ID will be a 36 character UUID which can be used to check the status of the message via the Get Message Status endpoint. The status of the message which reflect the status of the message at submission time which will always be queued. See the Delivery Reports section of this documentation for more information on message statuses.

Note: when sending multiple messages in a request, all messages must be valid for the request to be successful. If any messages in the request are invalid, no messages will be sent.
/v1/messages/messageId
Get message status

Retrieve the current status of a message using the message ID returned in the send messages end point.

A successful request to the get message status endpoint will return a response body as follows:

{
    "format": "SMS",
    "content": "My first message!",
    "metadata": {
        "myKey": "myValue",
        "anotherKey": "anotherValue"
    },
    "message_id": "877c19ef-fa2e-4cec-827a-e1df9b5509f7",
    "callback_url": "https://my.callback.url.com",
    "delivery_report": true,
    "destination_number": "+61401760575",
    "scheduled": "2016-11-03T11:49:02.807Z",
    "source_number": "+61491570157",
    "source_number_type": "INTERNATIONAL",
    "message_expiry_timestamp": "2016-11-03T11:49:02.807Z",
    "status": "enroute"
}

The status property of the response indicates the current status of the message. See the Delivery Reports section of this documentation for more information on message statuses. The expiry date for getting an entity is 45 days.

Note: If an invalid or non existent message ID parameter is specified in the request, then a HTTP 404 Not Found response will be returned
Cancel scheduled message

Cancel a scheduled message that has not yet been delivered.

A scheduled message can be cancelled by updating the status of a message from scheduled to cancelled. This is done by submitting a PUT request to the messages endpoint using the message ID as a parameter (the same endpoint used above to retrieve the status of a message).

The body of the request simply needs to contain a status property with the value set to cancelled. The expiry date for getting an entity is 45 days.

{
    "status": "cancelled"
}

Note: Only messages with a status of scheduled can be cancelled. If an invalid or non existent message ID parameter is specified in the request, then a HTTP 404 Not Found response will be returned
Replies
/v1/replies
Check replies

Check for any replies that have been received.

Replies are messages that have been sent from a handset in response to a message sent by an application or messages that have been sent from a handset to a inbound number associated with an account, known as a dedicated inbound number (contact support@messagemedia.com for more information on dedicated inbound numbers).

Each request to the check replies endpoint will return any replies received that have not yet been confirmed using the confirm replies endpoint. A response from the check replies endpoint will have the following structure:

{
    "replies": [
        {
            "metadata": {
                "myKey": "myValue",
                "anotherKey": "anotherValue"
            },
            "message_id": "877c19ef-fa2e-4cec-827a-e1df9b5509f7",
            "reply_id": "a175e797-2b54-468b-9850-41a3eab32f74",
            "date_received": "2016-12-07T08:43:00.850Z",
            "callback_url": "https://my.callback.url.com",
            "destination_number": "+61491570156",
            "source_number": "+61491570157",
            "vendor_account_id": {
                "vendor_id": "MessageMedia",
                "account_id": "MyAccount"
            },
            "content": "My first reply!"
        },
        {
            "metadata": {
                "myKey": "myValue",
                "anotherKey": "anotherValue"
            },
            "message_id": "8f2f5927-2e16-4f1c-bd43-47dbe2a77ae4",
            "reply_id": "3d8d53d8-01d3-45dd-8cfa-4dfc81600f7f",
            "date_received": "2016-12-07T08:43:00.850Z",
            "callback_url": "https://my.callback.url.com",
            "destination_number": "+61491570157",
            "source_number": "+61491570158",
            "vendor_account_id": {
                "vendor_id": "MessageMedia",
                "account_id": "MyAccount"
            },
            "content": "My second reply!"
        }
    ]
}

Each reply will contain details about the reply message, as well as details of the message the reply was sent in response to, including any metadata specified. Every reply will have a reply ID to be used with the confirm replies endpoint.

Note: The source number and destination number properties in a reply are the inverse of those specified in the message the reply is in response to. The source number of the reply message is the same as the destination number of the original message, and the destination number of the reply message is the same as the source number of the original message. If a source number wasn't specified in the original message, then the destination number property will not be present in the reply message.

Subsequent requests to the check replies endpoint will return the same reply messages and a maximum of 100 replies will be returned in each request. Applications should use the confirm replies endpoint in the following pattern so that replies that have been processed are no longer returned in subsequent check replies requests. The expiry date for getting an entity is 45 days.

    Call check replies endpoint
    Process each reply message
    Confirm all processed reply messages using the confirm replies endpoint

Note: It is recommended to use the Webhooks feature to receive reply messages rather than polling the check replies endpoint.
/v1/replies/confirmed
Confirm replies as received

Mark a reply message as confirmed so it is no longer returned in check replies requests.

The confirm replies endpoint is intended to be used in conjunction with the check replies endpoint to allow for robust processing of reply messages. Once one or more reply messages have been processed they can then be confirmed using the confirm replies endpoint so they are no longer returned in subsequent check replies requests.

The confirm replies endpoint takes a list of reply IDs as follows:

{
    "reply_ids": [
        "011dcead-6988-4ad6-a1c7-6b6c68ea628d",
        "3487b3fa-6586-4979-a233-2d1b095c7718",
        "ba28e94b-c83d-4759-98e7-ff9c7edb87a1"
    ]
}

The expiry date for getting an entity is 45 days. Up to 100 replies can be confirmed in a single confirm replies request.
Delivery Reports

If a callback URL is specified in the submit message request, then changes to the message status, replies received in response to the message or delivery reports received for the message will be pushed via a HTTP POST request. An alternative to delivery reports via callbacks is custom webhooks using the webhooks management API.

All notifications are JSON encoded and the request expects to receive a response in the HTTP 200 range. If a valid response isn't received the request will be retried in an exponentially backing off fashion.

Delivery Reports may carry an additional charge. For pricing, please contact your Account Manager or Support Team (support@messagemedia.com).

For delivery reports or changes in the status of a message, the POST request to the specified URL will be as follows:

Note, multiple delivery report notifications will be recieved for a single message.

{
  "callback_url":"http://mockbin.org/bin/ac52ebd4-eca1-4c86-bf38-4dce79633906",
  "delivery_report_id":"693e87f2-a553-4281-9ffe-ddf04cbc4bf3",
  "source_number":"+61491570156",
  "date_received":"2016-11-03T11:49:02.807Z",
  "status":"delivered",
  "delay":0,
  "submitted_date":"2016-11-03T11:49:01.551Z",
  "original_text":"Hello world!",
  "message_id":"389dc1a8-62a4-4110-ba61-af94806c006f",
  "vendor_account_id":{
    "vendor_id":"MessageMedia",
    "account_id":"MyAccount"
  },
  "error_code":"220",
  "metadata":{
    "key":"value"
  }
}

The properties included in the notification are as follows:

    Callback URL: The URL specified as the callback URL in the original submit message request.

    Delivery Report ID: A unique ID for the delivery report that this notification represents.

    Source Number: The destination address of the original message.

    Date Received: The date and time at which this notification was generated in UTC.

    Status: The status of the message as indicated by this delivery report. The status field can be one of the following values:
        enroute: Message has been received by the gateway and is being processed (or waiting to be processed).
        submitted: Message has been submitted to a provider/carrier for delivery.
        delivered: Message delivery has been confirmed by the provider, including to the handset (where possible).
        expired: The message has expired.
        rejected: The message will not be delivered - permanent failure. Reasons may include usage limit exceeded, insufficient credit, number blocked, or content filtered
        failed: The message has failed. Reasons may include no active routes to destination or undeliverable by downstream provider.

    Delay: Deprecated, no longer in use

    Submitted Date: Date time status of the message changed in UTC. For a delivered DR this may indicate the time at which the message was received on the handset.

    Original Text: Text of the original message.

    Message ID: ID of the original message.

    Vendor Account ID: The account used to submit the original message. The vendor will always be MessageMedia

    Metadata: Any metadata that was included in the original submit message request.

    Error Code: A status code which provides additional information about the message status:
        101: Message being processed by the gateway.
        102: Message is being rerouted to a different provider after failing via the first provider.
        151: Message held for screening.
        200: Message submitted to downstream provider for delivery.
        210: Message accepted by downstream provider.
        211: Message is enroute for delivery by provider.
        212: Message submitted. Delivery pending.
        213: Message scheduled for delivery by downstream provider.
        220: Message delivered.
        221: Message delivered to the handset.
        320: Message validity period has expired (prior to submission).
        401: Message validity period has expired (before delivery).
        301: Usage threshold reached. Message discarded.
        302: Destination address blocked. Message discarded.
        303: Source address blocked. Message discarded.
        304: Message dropped. Contact support.
        305: Message discarded due to duplicate detection.
        402: Message rejected by downstream provider.
        403: Message skipped by downstream provider.
        410: Invalid source address.
        411: Invalid destination address.
        412: Destination address blocked.
        413: SMS service unavailable on destination.
        414: Destination unreachable.
        330: Gateway failure.
        331: Message discarded.
        332: No available route to destination.
        333: Source address unsupported for this destination.
        400: Message failed; undeliverable.
        405: Message cancelled or deleted by provider.

/v1/delivery_reports
Check delivery reports

Check for any delivery reports that have been received.

Delivery reports are a notification of the change in status of a message as it is being processed.

Each request to the check delivery reports endpoint will return any delivery reports received that have not yet been confirmed using the confirm delivery reports endpoint. A response from the check delivery reports endpoint will have the following structure:

{
    "delivery_reports": [
        {
            "callback_url": "https://my.callback.url.com",
            "delivery_report_id": "01e1fa0a-6e27-4945-9cdb-18644b4de043",
            "source_number": "+61491570157",
            "date_received": "2017-05-20T06:30:37.642Z",
            "status": "enroute",
            "delay": 0,
            "submitted_date": "2017-05-20T06:30:37.639Z",
            "original_text": "My first message!",
            "message_id": "d781dcab-d9d8-4fb2-9e03-872f07ae94ba",
            "vendor_account_id": {
                "vendor_id": "MessageMedia",
                "account_id": "MyAccount"
            },
            "metadata": {
                "myKey": "myValue",
                "anotherKey": "anotherValue"
            }
        },
        {
            "callback_url": "https://my.callback.url.com",
            "delivery_report_id": "0edf9022-7ccc-43e6-acab-480e93e98c1b",
            "source_number": "+61491570158",
            "date_received": "2017-05-21T01:46:42.579Z",
            "status": "enroute",
            "delay": 0,
            "submitted_date": "2017-05-21T01:46:42.574Z",
            "original_text": "My second message!",
            "message_id": "fbb3b3f5-b702-4d8b-ab44-65b2ee39a281",
            "vendor_account_id": {
                "vendor_id": "MessageMedia",
                "account_id": "MyAccount"
            },
            "metadata": {
                "myKey": "myValue",
                "anotherKey": "anotherValue"
            }
        }
    ]
}

Each delivery report will contain details about the message, including any metadata specified and the new status of the message (as each delivery report indicates a change in status of a message) and the timestamp at which the status changed. Every delivery report will have a unique delivery report ID for use with the confirm delivery reports endpoint.

Note: The source number and destination number properties in a delivery report are the inverse of those specified in the message that the delivery report relates to. The source number of the delivery report is the destination number of the original message.

Subsequent requests to the check delivery reports endpoint will return the same delivery reports and a maximum of 100 delivery reports will be returned in each request. Applications should use the confirm delivery reports endpoint in the following pattern so that delivery reports that have been processed are no longer returned in subsequent check delivery reports requests. The expiry date for getting an entity is 45 days.

    Call check delivery reports endpoint
    Process each delivery report
    Confirm all processed delivery reports using the confirm delivery reports endpoint

Note: It is recommended to use the Webhooks feature to receive delivery reports rather than polling the check delivery reports endpoint.
/v1/delivery_reports/confirmed
Confirm delivery reports as received

Mark a delivery report as confirmed so it is no longer return in check delivery reports requests.

The confirm delivery reports endpoint is intended to be used in conjunction with the check delivery reports endpoint to allow for robust processing of delivery reports. Once one or more delivery reports have been processed, they can then be confirmed using the confirm delivery reports endpoint so they are no longer returned in subsequent check delivery reports requests.

The confirm delivery reports endpoint takes a list of delivery report IDs as follows:

{
    "delivery_report_ids": [
        "011dcead-6988-4ad6-a1c7-6b6c68ea628d",
        "3487b3fa-6586-4979-a233-2d1b095c7718",
        "ba28e94b-c83d-4759-98e7-ff9c7edb87a1"
    ]
}

The expiry date for getting an entity is 45 days. Up to 100 delivery reports can be confirmed in a single confirm delivery reports request.
Webhooks

The MessageMedia REST API provides HTTP Webhooks for notifications related to messages sent via the REST API.
Notifications

If a callback URL is specified in the submit message request, then changes to the message status, replies received in response to the message or delivery reports received for the message will be pushed via a HTTP POST request.
Format

All notifications are JSON encoded and the request expects to receive a response in the HTTP 200 range. If a valid response isn't received the request will be retried in an exponentially backing off fashion.
Delivery Reports

For delivery reports or changes in the status of a message, the POST request to the specified URL will be as follows: Note, multiple delivery report notifications will be recieved for a single message.

{
   "callback_url":"http://mockbin.org/bin/ac52ebd4-eca1-4c86-bf38-4dce79633906",
   "delivery_report_id":"693e87f2-a553-4281-9ffe-ddf04cbc4bf3",
   "source_number":"+61491570156",
   "date_received":"2016-11-03T11:49:02.807Z",
   "status":"delivered",
   "delay":0,
   "submitted_date":"2016-11-03T11:49:01.551Z",
   "original_text":"Hello world!",
   "message_id":"389dc1a8-62a4-4110-ba61-af94806c006f",
   "vendor_account_id":{
      "vendor_id":"MessageMedia",
      "account_id":"MyAccount"
   },
   "error_code":"220",
   "metadata":{
      "key":"value"
   }
}

The properties included in the notification will be per the properties listed in the Delivery Reports documentation above.
SMS Replies

For SMS replies, the POST request to the specified URL will be as follows:

{
   "callback_url":"http://mockbin.org/bin/ac52ebd4-eca1-4c86-bf38-4dce79633906",
   "source_number":"+61491570156",
   "destination_number":"+61491570157",
   "message_id":"b7058638-7650-4bb3-bff3-3d0e1be767a1",
   "date_received":"2016-11-03T12:08:33.818Z",
   "metadata":{
      "key":"value"
   },
   "reply_id":"c7651312-db72-4582-90b3-975578936dcc",
   "vendor_account_id":{
      "vendor_id":"MessageMedia",
      "account_id":"MyAccount"
   },
   "content":"Hello back"
}

The properties included in the Webhooks are as follows:

    Callback URL: The URL specified as the callback URL in the original submit message request.

    Source Number: The destination address of the original message.

    Destination Number: The address to which the reply was sent to, the source address of the original message.

    Message ID: ID of the original message.

    Date Received: The date and time at which the reply was received by the MessageMedia gateway in UTC.

    Metadata: Any metadata that was included in the original submit message request.

    Reply ID: A unique ID for the reply that this notification represents.

    Vendor Account ID: The account used to submit the original message. The vendor will always be MessageMedia

    Content: The content of the reply.

MMS Replies

When Inbound MMS is enabled, the POST request to the specified URL will be as follows and contains additional parameters:

{
   "callback_url":"http://mockbin.org/bin/ac52ebd4-eca1-4c86-bf38-4dce79633906",
   "source_number":"+61491570156",
   "destination_number":"+61491570157",
   "message_id":"b7058638-7650-4bb3-bff3-3d0e1be767a1",
   "date_received":"2016-11-03T12:08:33.818Z",
   "metadata":{
      "key":"value"
   },
   "reply_id":"c7651312-db72-4582-90b3-975578936dcc",
   "vendor_account_id":{
      "vendor_id":"MessageMedia",
      "account_id":"MyAccount"
   },
   "content":"Hello back",
   "attachments": [
      {
            "content_type": "image/jpeg",
            "content": "<base 64 encoded attachment>",
            "original_name": "image000000.jpg"
      },
      {
        "content_type": "image/gif",
        "content": "<base 64 encoded attachment>",
        "original_name": "gif0001.jpg"
      }
   ]
}

The additional properties included in these Webhooks are as follows:

    Attachments: A list containing all the attachments that were included in the reply. This field is present only if you have enabled Inbound MMS in your account and the reply contains attachments.

    Attachments - Content Type: The MIME type associated with this attachment.

    Attachments - Content: The attachment Base64 encoded.

    Attachments - Original Name: The name of the attachment

Inbound MMS

Inbound MMS is required to be enabled on your account before you can process MMS replies via Webhooks. Please speak to your account manager, or our sales team for pricing and setup information.
Customised Webhooks

Custom Webhooks can be configured at an account level. The request method, URL, body and headers can all be customised. Please contact support for more information.
Features
De-Duplication

De-Duplication helps you avoid having to undertake data cleansing before commencing send outs. It automatically detects and withholds messages deemed to be duplicates through the use of a 24-hour window – if a message is sent to the same number with the same content within a 24hr period, the subsequent message(s) will be withheld and rejected. To enable this, you don't need to make any changes to your application, just an account configuration change by MessageMedia's support team.
Social Sending

Social Sending permits messages to be sent only during sociable hours - i.e. 8am to 6pm (based on your accounts local time zone - not local time). Messages sent outside of these hours are scheduled to be released during the next social time period. This feature helps businesses avoid send-outs during a time that would be deemed unsuitable by the customer. To enable this, you don't need to make any changes to your application, just an account configuration change by MessageMedia's support team.
Familiar Sender

Familiar Sender ensures all communication sent to a customer are from the same phone number. This allows businesses to build trust and familiarity with their customers and not confuse them by changing outgoing numbers. To enable this, you don't need to make any changes to your application, just an account configuration change by MessageMedia's support team.
Character Converter

Characters in a message may not always fall within the GSM-7 supported character set, and when this occurs all outbound messages will be encoded using UCS-2 leading to the customer being double-charged for the SMS. Character Converter can help you avoid being double-charged for your SMS by converting all characters into the GSM-7 format ensuring you always get the maximum characters into an SMS. Bear in my mind, this will downgrade all your Unicode characters so for instance, your emojis will be translated into a string of unknown characters (eg: �). To enable this, you don't need to make any changes to your application, just an account configuration change by MessageMedia's support team.
Messages
/
/v1/messages/{messageId}
/
Cancel scheduled message
PUThttps://api.messagemedia.com/v1/messages/messageId
Parameters

    messageId
    String

Request

    Headers
    Content-Type:application/json
    Accept:application/json

BodyShow JSON Schema

{
  "status": "cancelled"
}

Response

Message status updated successfully
200

    Headers
    Content-Type:application/json

Request

    Headers
    Content-Type:application/json
    Accept:application/json

Response

Bad request
400

    Headers
    Content-Type:application/json

BodyShow JSON Schema

{
  "message": "Message is not currently scheduled"
}

Response

Unauthorised
403

    Headers
    Content-Type:application/json

BodyShow JSON Schema

{
  "message": "Invalid authentication credentials"
}

Response

Resource not found
404

    Headers
    Content-Type:application/json

BodyShow JSON Schema

{
  "message": "Resource not found"
}

