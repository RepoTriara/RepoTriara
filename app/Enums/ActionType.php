<?php
namespace App\Enums;

class ActionType
{
    // Acciones de Sesión
    public const LOGIN = 1;
    public const LOGOUT = 2;

    // Acciones de Archivos
    public const FILE_UPLOAD = 10;
    public const FILE_DOWNLOAD = 11;
    public const FILE_ASSIGN = 12;
    public const FILE_UPDATE = 13;
    public const FILE_DELETE = 14;

    // Acciones de Usuarios
    public const USER_CREATE = 20;
    public const USER_UPDATE = 21;
    public const USER_DELETE = 22;
}
