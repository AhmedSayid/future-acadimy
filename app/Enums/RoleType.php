<?php

namespace App\Enums;

/**
 * Class OrderStatus
 *
 * @method static string all()
 * @method static string|null nameFor($value)
 * @method static array toArray()
 * @method static array forApi()
 * @method static string slug(int $value)
 */
class RoleType extends Base
{
    public const ADMIN      = 'admin';
    public const STUDENT    = 'student';
    public const TEACHER    = 'teacher';
    public const MOD        = 'mod';
}
