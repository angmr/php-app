<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Department",
 * description="Operations about Department Collection",
 * )
 * 
 *  @OA\Tag(
 *     name="Subdepartment",
 *     description="Operations about Subdepartment collection",
 * )
 * @OA\Tag(
 *     name="Subdepartment",
 *     description="Operations about Subdepartment field in Department collection",
 * )
 * @OA\Tag(
 *     name="Announcement",
 *     description="Operations about Announcement collection",
 * )
 * @OA\Tag(
 *     name="Categories",
 *     description="Operations about Categories field in Department collection",
 * )
 * @OA\Tag(
 *     name="Roles",
 *     description="Operations about Roles field in User collection",
 * )
 * @OA\Tag(
 *     name="Subscription",
 *     description="Operations about Subscription field in User collection",
 * )
 * @OA\Tag(
 *     name="User",
 *     description="Operations about User collection",
 * )
 * @OA\Tag(
 *     name="UserCategory",
 *     description="Operations about UserCategory collection",
 * )
 * 
 * @OA\Info(
 *     version="1.0",
 *     title="API for App Announcements",
 *     description="Announcements API"
 * )
 * 
 * @OA\Server(
 *     url="https://cdng-announcements-app.herokuapp.com",
 *     description="API Server")
 * 
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         in="header",
 *         scheme="bearer",
 *         bearerFormat="JWT",
 *         name="Authorization",
 *     ),
 *     @OA\Attachable
 * )
 */

Class OpenApiSpec{}

?>