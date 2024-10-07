<?php

namespace Inventory\Helpers;

class Authorization
{
    private static $roleHierarchy = [
        'admin' => ['manager', 'employee'],
        'manager' => ['employee'],
        'employee' => []
    ];

    private static $permissions = [
        'viewDashboard' => ['admin', 'manager'],
        'manageUsers' => ['admin'],
        'manageProducts' => ['admin', 'manager'],
        'viewProducts' => ['admin', 'manager', 'employee'],
        'manageCategories' => ['admin', 'manager'],
        'viewCategories' => ['admin', 'manager', 'employee'],
        'manageCustomers' => ['admin', 'manager'],
        'viewCustomers' => ['admin', 'manager', 'employee'],
        'manageOrders' => ['admin', 'manager'],
        'viewOrders' => ['admin', 'manager', 'employee'],
        'viewDiscounts' => ['admin', 'manager'],
        'createDiscounts' => ['admin', 'manager'],
        'viewInventory' => ['admin', 'admin', 'manager', 'employee'],
        'manageDiscounts' => ['admin', 'manager'],
        'viewSuppliers' => ['admin', 'manager'],
        'manageSuppliers' => ['admin', 'manager'],
        'createOrders' => ['admin', 'manager', 'employee']
    ];

    public static function hasPermission($userRole, $permission)
    {
        if (!isset(self::$permissions[$permission])) {
            return false;
        }

        $allowedRoles = self::$permissions[$permission];

        if (in_array($userRole, $allowedRoles)) {
            return true;
        }

        foreach (self::$roleHierarchy[$userRole] ?? [] as $inheritedRole) {
            if (in_array($inheritedRole, $allowedRoles)) {
                return true;
            }
        }

        return false;
    }

    public static function requirePermission($permission)
    {
        $user = Auth::getUser();
        error_log("User: " . print_r($user, true));
        error_log("Required permission: " . $permission);
        error_log("Has permission: " . (self::hasPermission($user['role'], $permission) ? 'Yes' : 'No'));
        
        if (!$user || !self::hasPermission($user['role'], $permission)) {
            http_response_code(403);
            echo "Zugriff verweigert";
            exit;
        }
    }

    public static function isAuthorized($userRole, $resource)
    {
        switch ($resource) {
            case 'products':
                return self::hasPermission($userRole, 'viewProducts');
            case 'categories':
                return self::hasPermission($userRole, 'viewCategories');
            case 'customers':
                return self::hasPermission($userRole, 'viewCustomers');
            case 'orders':
                return self::hasPermission($userRole, 'viewOrders');
            case 'users':
                return self::hasPermission($userRole, 'manageUsers');
            default:
                return false;
        }
    }
}