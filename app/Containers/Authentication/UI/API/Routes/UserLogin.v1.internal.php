<?php

/**
 * @apiGroup           Authentication
 * @apiName            UserLogin
 * @api                {post} /users/login Login a user
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiHeader          Accept application/json (required)
 *
 * @apiParam           {String}     email (required)
 * @apiParam           {String}     password (required)
 *
 * @apiSuccessExample  {json}       Success-Response:
 * HTTP/1.1 200 OK
{
  "data": {
    "id": "owpmaymq",
    "name": "Super Admin",
    "email": "admin@admin.com",
    "confirmed": 0,
    "total_credits": 0,
    "created_at": {
      "date": "2017-01-23 18:40:46.000000",
      "timezone_type": 3,
      "timezone": "UTC"
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
    "updated_at": {
      "date": "2017-01-23 18:40:46.000000",
      "timezone_type": 3,
      "timezone": "UTC"
    },
    "deleted_at": null,
    "roles": {
      "data": [
        {
          "object": "Role",
          "name": "admin",
          "description": "Super Administrator",
          "display_name": null
        }
      ]
    }
  }
}
 *
 * @apiErrorExample  {json}       Error-Response:
{
   "message":"401 Credentials Incorrect.",
   "status_code":401
}
 *
 * @apiErrorExample  {json}       Error-Response:
{
   "message":"Invalid Input.",
   "errors":{
      "email":[
         "The email field is required."
      ]
   },
   "status_code":422
}
 */

$router->post('users/login', [
    'uses' => 'Controller@userLogin',
]);
