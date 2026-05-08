# API Documentation

## Push Notification Endpoints

### Send

**Endpoint:** `/api/push-notification/send`

This endpoint is used to send push notifications to the specified devices saved in the database.

#### Request Body

- `title` (string) - The title of the push notification.
- `message` (string) - The message content of the push notification.
- `deepLink` (string) - The deep link URL to be opened when the user interacts with the notification.
- `messageId` (number) - Optional. The ID of the message to be sent.

#### Response

Upon successful execution, the API returns a JSON object with a `message` key indicating the status of the operation.

### Create token

This endpoint is used to create a new device token in the database. If the token already exists, it will be skipped and not added again.

**Endpoint:** `/api/push-notification/create`

#### Request Body

- `token` (string) - The device token to be saved in the database.
- `deviceInfo` (string) - Information about the device that the token belongs to.

#### Response

Upon successful execution, the API returns a JSON object with a `message` key indicating the status of the operation.
