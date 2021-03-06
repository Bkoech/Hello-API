<?php

/**
 * @apiGroup           RolePermission
 * @apiName            listAllRoles
 * @api                {get} /roles List all Roles
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiHeader          Accept application/json
 * @apiHeader          Authorization Bearer {User-Token}
 *
 * @apiSuccessExample  {json}       Success-Response:
 * HTTP/1.1 200 OK
{
  "data": [
    {
      "object": "Role",
      "name": "admin",
      "description": "Super Administrator",
      "display_name": null,
      "permissions": {
        "data": [
          {
            "object": "Permission",
            "name": "update-user",
            "description": null,
            "display_name": null
          },
          {
            "object": "Permission",
            "name": "delete-item",
            "description": null,
            "display_name": null
          }
        ]
      }
    },
    {
      "object": "Role",
      "name": "client",
      "description": "Normal Client",
      "display_name": null,
      "permissions": {
        "data": [
          {
            "object": "Permission",
            "name": "update-user",
            "description": null,
            "display_name": null
          }
        ]
      }
    },
    {
      "object": "Role",
      "name": "developer",
      "description": "A developer account, has access to the API",
      "display_name": null,
      "permissions": {
        "data": [
          {
            "object": "Permission",
            "name": "create-applications",
            "description": "Create Application to gain third party access using special token",
            "display_name": null
          }
        ]
      }
    },
    {
      "object": "Role",
      "name": "player",
      "description": null,
      "display_name": null,
      "permissions": {
        "data": [
          {
            "object": "Permission",
            "name": "access secret info",
            "description": null,
            "display_name": null
          }
        ]
      }
    }
  ]
}
 */

$router->get('roles', [
    'uses'       => 'Controller@listAllRoles',
    'middleware' => [
        'api.auth',
    ],
]);
